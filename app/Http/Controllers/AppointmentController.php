<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Appointment::with(['patient', 'doctor', 'service'])
            ->when(! $user->isAdmin(), function ($builder) use ($user) {
                if ($user->isDoctor()) {
                    $builder->where('doctor_id', $user->id);
                } else {
                    $builder->where('patient_id', $user->id);
                }
            });

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();

            $query->where(function ($builder) use ($search) {
                $builder->whereHas('patient', fn ($patientQuery) => $patientQuery->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('doctor', fn ($doctorQuery) => $doctorQuery->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('service', fn ($serviceQuery) => $serviceQuery->where('name', 'like', "%{$search}%"))
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date('date'));
        }

        $appointments = $query
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time')
            ->paginate(10);

        $statsQuery = Appointment::query();

        if (! $user->isAdmin()) {
            if ($user->isDoctor()) {
                $statsQuery->where('doctor_id', $user->id);
            } else {
                $statsQuery->where('patient_id', $user->id);
            }
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'confirmed' => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'today' => (clone $statsQuery)->whereDate('appointment_date', today())->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }

    public function create()
    {
        $doctors = User::doctors()->get();
        $services = Service::active()->get();
        $patients = User::patients()->get();

        return view('appointments.create', compact('doctors', 'services', 'patients'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $this->validateAppointment($request, $user);

        $appointment = Appointment::create([
            'patient_id' => $this->resolvePatientId($request, $user),
            'doctor_id' => $validated['doctor_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['date'],
            'appointment_time' => $validated['time'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Rendez-vous cree avec succes.');
    }

    public function edit(Appointment $appointment)
    {
        $this->ensureUserCanAccess($appointment);

        $doctors = User::doctors()->orderBy('name')->get();
        $services = Service::active()->orderBy('name')->get();
        $patients = User::patients()->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'doctors', 'services', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->ensureUserCanAccess($appointment);

        $user = Auth::user();
        $validated = $this->validateAppointment($request, $user, $appointment);

        $appointment->update([
            'patient_id' => $this->resolvePatientId($request, $user, $appointment),
            'doctor_id' => $validated['doctor_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['date'],
            'appointment_time' => $validated['time'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Rendez-vous modifie avec succes.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->ensureUserCanAccess($appointment);

        if (! Auth::user()->isAdmin()) {
            $appointment->update(['status' => 'cancelled']);

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Le rendez-vous a ete annule.');
        }

        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Rendez-vous supprime avec succes.');
    }

    public function cancel(Appointment $appointment)
    {
        $this->ensureUserCanAccess($appointment);

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Le rendez-vous a ete annule.');
    }

    protected function validateAppointment(Request $request, User $user, ?Appointment $appointment = null): array
    {
        $statuses = ['pending', 'confirmed', 'cancelled'];

        if ($user->isAdmin()) {
            $patientRule = ['required', Rule::exists('users', 'id')->where('role', User::ROLE_PATIENT)];
        } elseif ($user->isDoctor()) {
            $patientRule = ['required', Rule::exists('users', 'id')->where('role', User::ROLE_PATIENT)];
        } else {
            $patientRule = ['nullable'];
        }

        $dateRule = $appointment ? ['required', 'date'] : ['required', 'date', 'after_or_equal:today'];

        return $request->validate([
            'patient_id' => $patientRule,
            'doctor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_DOCTOR)],
            'service_id' => ['required', Rule::exists('services', 'id')],
            'date' => $dateRule,
            'time' => ['required', 'date_format:H:i'],
            'status' => ['required', Rule::in($statuses)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    protected function resolvePatientId(Request $request, User $user, ?Appointment $appointment = null): int
    {
        if ($user->isAdmin()) {
            return (int) $request->integer('patient_id');
        }

        if ($user->isDoctor()) {
            return (int) $request->integer('patient_id');
        }

        return $user->id;
    }

    protected function ensureUserCanAccess(Appointment $appointment): void
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isDoctor() && $appointment->doctor_id === $user->id) {
            return;
        }

        if ($user->isPatient() && $appointment->patient_id === $user->id) {
            return;
        }

        abort(403);
    }
}
