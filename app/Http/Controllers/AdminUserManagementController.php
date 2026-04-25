<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminUserManagementController extends Controller
{
    public function index(string $role)
    {
        $role = $this->resolveRole($role);

        $users = User::query()
            ->where('role', $role)
            ->orderBy('name')
            ->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
            'role' => $role,
            'pageTitle' => $role === User::ROLE_PATIENT ? 'Gestion des patients' : 'Gestion des medecins',
        ]);
    }

    public function store(Request $request, string $role)
    {
        $role = $this->resolveRole($role);
        $validated = $this->validateUser($request, $role);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $role,
            'phone' => $validated['phone'] ?? null,
            'specialty' => $role === User::ROLE_DOCTOR ? ($validated['specialty'] ?? null) : null,
            'bio' => $validated['bio'] ?? null,
        ]);

        return redirect()
            ->route('admin.users.index', $role)
            ->with('success', $role === User::ROLE_PATIENT ? 'Patient cree avec succes.' : 'Medecin cree avec succes.');
    }

    public function update(Request $request, string $role, User $user)
    {
        $role = $this->resolveRole($role);
        $this->ensureMatchingRole($user, $role);

        $validated = $this->validateUser($request, $role, $user);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialty' => $role === User::ROLE_DOCTOR ? ($validated['specialty'] ?? null) : null,
            'bio' => $validated['bio'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index', $role)
            ->with('success', $role === User::ROLE_PATIENT ? 'Patient mis a jour avec succes.' : 'Medecin mis a jour avec succes.');
    }

    public function destroy(string $role, User $user)
    {
        $role = $this->resolveRole($role);
        $this->ensureMatchingRole($user, $role);

        $user->delete();

        return redirect()
            ->route('admin.users.index', $role)
            ->with('success', $role === User::ROLE_PATIENT ? 'Patient supprime avec succes.' : 'Medecin supprime avec succes.');
    }

    protected function validateUser(Request $request, string $role, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'confirmed', Password::defaults()]
            : ['required', 'confirmed', Password::defaults()];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => $passwordRules,
        ];

        if ($role === User::ROLE_DOCTOR) {
            $rules['specialty'] = ['required', 'string', 'max:255'];
        }

        return $request->validate($rules);
    }

    protected function resolveRole(string $role): string
    {
        return match ($role) {
            User::ROLE_PATIENT, User::ROLE_DOCTOR => $role,
            default => abort(404),
        };
    }

    protected function ensureMatchingRole(User $user, string $role): void
    {
        abort_if($user->role !== $role, 404);
    }
}
