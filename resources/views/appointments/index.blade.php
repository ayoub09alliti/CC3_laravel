@extends('layouts.app', ['title' => 'Rendez-vous'])

@section('content')
    <section class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">Gestion</p>
                <h1 class="mt-1 text-3xl font-semibold">Rendez-vous</h1>
                <p class="mt-2 text-sm text-slate-600">Liste, creation, modification et annulation des rendez-vous.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Dashboard
                </a>
                <a href="{{ route('appointments.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    Nouveau rendez-vous
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">Total</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">En attente</p>
                <p class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">Confirmes</p>
                <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $stats['confirmed'] }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">Aujourd'hui</p>
                <p class="mt-2 text-2xl font-semibold text-sky-600">{{ $stats['today'] }}</p>
            </div>
        </div>

        <form method="GET" action="{{ route('appointments.index') }}" class="grid gap-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200 md:grid-cols-[2fr_1fr_1fr_auto]">
            <div>
                <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Recherche</label>
                <input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="Patient, medecin, service, statut" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Statut</label>
                <select id="status" name="status" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
                    <option value="">Tous</option>
                    <option value="pending" @selected(request('status') === 'pending')>En attente</option>
                    <option value="confirmed" @selected(request('status') === 'confirmed')>Confirme</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Annule</option>
                </select>
            </div>
            <div>
                <label for="date" class="mb-1 block text-sm font-medium text-slate-700">Date</label>
                <input id="date" name="date" type="date" value="{{ request('date') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                    Filtrer
                </button>
                <a href="{{ route('appointments.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm font-medium text-slate-600">
                            <th class="px-4 py-3">Patient</th>
                            <th class="px-4 py-3">Medecin</th>
                            <th class="px-4 py-3">Service</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Heure</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Actions</th>
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
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('appointments.edit', $appointment) }}" class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            Modifier
                                        </a>

                                        @if ($appointment->status !== 'cancelled')
                                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-md border border-rose-200 px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50">
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Confirmer cette action ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Aucun rendez-vous trouve.
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
@endsection
