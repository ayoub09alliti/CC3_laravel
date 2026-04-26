@php
    $isEdit = isset($appointment);
    $currentUser = auth()->user();
@endphp

<div class="grid gap-6 md:grid-cols-2">
    @if ($currentUser->isAdmin() || $currentUser->isDoctor())
        <div class="md:col-span-2">
            <label for="patient_id" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Patient') }}</label>
            <select id="patient_id" name="patient_id" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
                <option value="">{{ __('Selectionner un patient') }}</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id ?? '') == $patient->id)>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
            @error('patient_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label for="doctor_id" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Medecin') }}</label>
        <select id="doctor_id" name="doctor_id" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
            <option value="">{{ __('Selectionner un medecin') }}</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected(old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id)>
                    {{ $doctor->name }}@if($doctor->specialty) - {{ $doctor->specialty }}@endif
                </option>
            @endforeach
        </select>
        @error('doctor_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="service_id" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Service') }}</label>
        <select id="service_id" name="service_id" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
            <option value="">{{ __('Selectionner un service') }}</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected(old('service_id', $appointment->service_id ?? '') == $service->id)>
                    {{ $service->name }}
                </option>
            @endforeach
        </select>
        @error('service_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="date" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Date') }}</label>
        <input id="date" name="date" type="date" value="{{ old('date', isset($appointment) ? $appointment->appointment_date->format('Y-m-d') : '') }}" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
        @error('date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="time" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Heure') }}</label>
        <input id="time" name="time" type="time" value="{{ old('time', $appointment->appointment_time ?? '') }}" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
        @error('time')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($currentUser->isPatient())
        <input type="hidden" name="status" value="pending">
    @else
        <div>
            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Statut') }}</label>
            <select id="status" name="status" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">
                @foreach (['pending' => __('En attente'), 'confirmed' => __('Confirme'), 'cancelled' => __('Annule')] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $appointment->status ?? 'pending') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="md:col-span-2">
        <label for="notes" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Notes') }}</label>
        <textarea id="notes" name="notes" rows="4" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 focus:border-sky-500 focus:outline-none">{{ old('notes', $appointment->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 font-medium text-white hover:bg-slate-700">
        {{ $isEdit ? __('Mettre a jour') : __('Creer le rendez-vous') }}
    </button>
    <a href="{{ route('appointments.index') }}" class="rounded-md border border-slate-300 px-4 py-2 font-medium text-slate-700 hover:bg-slate-50">
        {{ __('Retour') }}
    </a>
</div>
