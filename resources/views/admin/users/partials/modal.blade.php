@php
    $isEdit = $userModel !== null;
    $isDoctor = $role === \App\Models\User::ROLE_DOCTOR;
@endphp

<div id="{{ $modalId }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4" data-modal>
    <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">{{ $title }}</h2>
                <p class="mt-2 text-sm text-slate-600">
                    {{ $isDoctor ? __('Renseignez les informations du medecin.') : __('Renseignez les informations du patient.') }}
                </p>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" data-modal-close="{{ $modalId }}" aria-label="{{ __('Fermer') }}">
                X
            </button>
        </div>

        <form method="POST" action="{{ $action }}" class="mt-6 space-y-4">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <input type="hidden" name="modal_target" value="{{ $modalId }}">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-name">{{ __('Nom') }}</label>
                    <input id="{{ $modalId }}-name" name="name" type="text" value="{{ old('name', $userModel?->name) }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-email">{{ __('Email') }}</label>
                    <input id="{{ $modalId }}-email" name="email" type="email" value="{{ old('email', $userModel?->email) }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-phone">{{ __('Telephone') }}</label>
                    <input id="{{ $modalId }}-phone" name="phone" type="text" value="{{ old('phone', $userModel?->phone) }}" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                @if ($isDoctor)
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-specialty">{{ __('Specialite') }}</label>
                        <input id="{{ $modalId }}-specialty" name="specialty" type="text" value="{{ old('specialty', $userModel?->specialty) }}" required class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                    </div>
                @endif

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-password">{{ __('Mot de passe') }} {{ $isEdit ? __('(laisser vide pour conserver)') : '' }}</label>
                    <input id="{{ $modalId }}-password" name="password" type="password" {{ $isEdit ? '' : 'required' }} class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-password_confirmation">{{ __('Confirmation') }}</label>
                    <input id="{{ $modalId }}-password_confirmation" name="password_confirmation" type="password" {{ $isEdit ? '' : 'required' }} class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700" for="{{ $modalId }}-bio">{{ __('Bio') }}</label>
                <textarea id="{{ $modalId }}-bio" name="bio" rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">{{ old('bio', $userModel?->bio) }}</textarea>
            </div>

            @if ($errors->any() && old('modal_target') === $modalId)
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-end gap-3">
                <button type="button" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50" data-modal-close="{{ $modalId }}">
                    {{ __('Annuler') }}
                </button>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>
