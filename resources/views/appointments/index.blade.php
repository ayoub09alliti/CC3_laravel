@extends('layouts.app', ['title' => __('Rendez-vous')])

@section('content')
    <section class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ __('Gestion') }}</p>
                <h1 class="mt-1 text-3xl font-semibold">{{ __('Rendez-vous') }}</h1>
                <p class="mt-2 text-sm text-slate-600">{{ __('Liste, creation, modification et annulation des rendez-vous.') }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ __('Tableau de bord') }}
                </a>
                <button type="button" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700" data-modal-open="create-appointment-modal">
                    {{ __('Nouveau rendez-vous') }}
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Total') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('En attente') }}</p>
                <p class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Confirmes') }}</p>
                <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $stats['confirmed'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Aujourd hui') }}</p>
                <p class="mt-2 text-2xl font-semibold text-sky-600">{{ $stats['today'] }}</p>
            </div>
        </div>

        <form method="GET" action="{{ route('appointments.index') }}" class="grid gap-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200 md:grid-cols-[2fr_1fr_1fr_auto]">
            <div>
                <label for="search" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Recherche') }}</label>
                <input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="{{ __('Patient, medecin, service, statut') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label for="status" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Statut') }}</label>
                <select id="status" name="status" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                    <option value="">{{ __('Tous') }}</option>
                    <option value="pending" @selected(request('status') === 'pending')>{{ __('En attente') }}</option>
                    <option value="confirmed" @selected(request('status') === 'confirmed')>{{ __('Confirme') }}</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>{{ __('Annule') }}</option>
                </select>
            </div>
            <div>
                <label for="date" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Date') }}</label>
                <input id="date" name="date" type="date" value="{{ request('date') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                    {{ __('Filtrer') }}
                </button>
                <a href="{{ route('appointments.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ __('Reset') }}
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm font-medium text-slate-600">
                            <th class="px-4 py-3">{{ __('Patient') }}</th>
                            <th class="px-4 py-3">{{ __('Medecin') }}</th>
                            <th class="px-4 py-3">{{ __('Service') }}</th>
                            <th class="px-4 py-3">{{ __('Date') }}</th>
                            <th class="px-4 py-3">{{ __('Heure') }}</th>
                            <th class="px-4 py-3">{{ __('Statut') }}</th>
                            <th class="px-4 py-3">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($appointments as $appointment)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">{{ $appointment->patient->name }}</td>
                                <td class="px-4 py-3">{{ $appointment->doctor->name }}</td>
                                <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                                <td class="px-4 py-3">{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Illuminate\Support\Str::of($appointment->appointment_time)->limit(5, '') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = match ($appointment->status) {
                                            'confirmed' => 'bg-emerald-100 text-emerald-700',
                                            'cancelled' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                                        {{ match ($appointment->status) {
                                            'pending' => __('En attente'),
                                            'confirmed' => __('Confirme'),
                                            'cancelled' => __('Annule'),
                                            default => ucfirst($appointment->status),
                                        } }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        @if (! auth()->user()->isPatient() && $appointment->status === 'pending')
                                            <form method="POST" action="{{ route('appointments.confirm', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-emerald-200 text-emerald-700 hover:bg-emerald-50"
                                                    title="{{ __('Accepter') }}"
                                                    aria-label="{{ __('Accepter le rendez-vous') }}"
                                                >
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M20 6 9 17l-5-5" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if (! auth()->user()->isPatient())
                                            <button
                                                type="button"
                                                class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                                data-modal-open="edit-appointment-modal-{{ $appointment->id }}"
                                            >
                                                {{ __('Modifier') }}
                                            </button>
                                        @endif

                                        @if ($appointment->status !== 'cancelled')
                                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-rose-200 text-rose-700 hover:bg-rose-50"
                                                    title="{{ __('Annuler') }}"
                                                    aria-label="{{ __('Annuler le rendez-vous') }}"
                                                >
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M18 6 6 18" />
                                                        <path d="m6 6 12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Confirmer cette action ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                                {{ __('Supprimer') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                    {{ __('Aucun rendez-vous trouve.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $appointments->withQueryString()->links() }}
        </div>
    </section>

    @include('appointments.partials.modal', [
        'modalId' => 'create-appointment-modal',
        'eyebrow' => __('Creation'),
        'title' => __('Nouveau rendez-vous'),
        'description' => __('Renseignez les informations du rendez-vous puis enregistrez.'),
        'action' => route('appointments.store'),
        'method' => 'POST',
    ])

    @if (! auth()->user()->isPatient())
        @foreach ($appointments as $appointment)
            @include('appointments.partials.modal', [
                'modalId' => 'edit-appointment-modal-' . $appointment->id,
                'eyebrow' => __('Edition'),
                'title' => __('Modifier le rendez-vous'),
                'description' => __('Mettez a jour la date, le service, le medecin ou le statut.'),
                'action' => route('appointments.update', $appointment),
                'method' => 'PUT',
                'appointment' => $appointment,
            ])
        @endforeach

        @if ($editingAppointment && ! $appointments->getCollection()->contains('id', $editingAppointment->id))
            @include('appointments.partials.modal', [
                'modalId' => 'edit-appointment-modal-' . $editingAppointment->id,
                'eyebrow' => __('Edition'),
                'title' => __('Modifier le rendez-vous'),
                'description' => __('Mettez a jour la date, le service, le medecin ou le statut.'),
                'action' => route('appointments.update', $editingAppointment),
                'method' => 'PUT',
                'appointment' => $editingAppointment,
            ])
        @endif
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            document.querySelectorAll('[data-modal-open]').forEach((button) => {
                button.addEventListener('click', () => openModal(button.dataset.modalOpen));
            });

            document.querySelectorAll('[data-modal-close]').forEach((button) => {
                button.addEventListener('click', () => closeModal(button.dataset.modalClose));
            });

            document.querySelectorAll('[data-modal]').forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal(modal.id);
                    }
                });
            });

            @if ($errors->any() && old('modal_target'))
                openModal(@js(old('modal_target')));
            @elseif (request('modal') === 'create')
                openModal('create-appointment-modal');
            @elseif (request('modal') === 'edit' && $editingAppointment)
                openModal(@js('edit-appointment-modal-' . $editingAppointment->id));
            @endif
        });
    </script>
@endsection
