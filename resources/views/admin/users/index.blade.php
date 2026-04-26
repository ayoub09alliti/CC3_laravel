@extends('layouts.app', ['title' => $pageTitle])

@section('content')
    @php
        $isDoctor = $role === \App\Models\User::ROLE_DOCTOR;
        $resourceLabel = $isDoctor ? __('medecin') : __('patient');
        $resourceLabelPlural = $isDoctor ? __('medecins') : __('patients');
    @endphp

    <section class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-slate-500">{{ __('Administration') }}</p>
                <h1 class="mt-1 text-3xl font-semibold">{{ $pageTitle }}</h1>
                <p class="mt-2 text-sm text-slate-600">{{ __('Creation, modification et suppression des :resource depuis l espace admin.', ['resource' => $resourceLabelPlural]) }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
               
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_PATIENT) }}" class="rounded-md px-4 py-2 text-sm font-medium {{ $isDoctor ? 'border border-slate-300 text-slate-700 hover:bg-slate-50' : 'bg-sky-700 text-white hover:bg-sky-600' }}">
                    {{ __('Patients') }}
                </a>
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_DOCTOR) }}" class="rounded-md px-4 py-2 text-sm font-medium {{ $isDoctor ? 'bg-emerald-700 text-white hover:bg-emerald-600' : 'border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
                    {{ __('Medecins') }}
                </a>
                <button type="button" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700" data-modal-open="create-user-modal">
                    {{ __('Nouveau :resource', ['resource' => $resourceLabel]) }}
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Total') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $users->total() }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Page courante') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $users->currentPage() }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Affiches') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $users->count() }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm font-medium text-slate-600">
                            <th class="px-4 py-3">{{ __('Nom') }}</th>
                            <th class="px-4 py-3">{{ __('Email') }}</th>
                            <th class="px-4 py-3">{{ __('Telephone') }}</th>
                            @if ($isDoctor)
                                <th class="px-4 py-3">{{ __('Specialite') }}</th>
                            @endif
                            <th class="px-4 py-3">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->phone ?: '-' }}</td>
                                @if ($isDoctor)
                                    <td class="px-4 py-3">{{ $user->specialty ?: __('Non renseignee') }}</td>
                                @endif
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            type="button"
                                            class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                            data-modal-open="edit-user-modal-{{ $user->id }}"
                                        >
                                            {{ __('Modifier') }}
                                        </button>
                                        <button
                                            type="button"
                                            class="rounded-md border border-rose-200 px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50"
                                            data-modal-open="delete-user-modal-{{ $user->id }}"
                                        >
                                            {{ __('Supprimer') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isDoctor ? 5 : 4 }}" class="px-4 py-8 text-center text-sm text-slate-500">
                                    {{ __('Aucun :resource trouve.', ['resource' => $resourceLabel]) }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $users->links() }}
        </div>
    </section>

    @include('admin.users.partials.modal', [
        'modalId' => 'create-user-modal',
        'title' => __('Nouveau :resource', ['resource' => $resourceLabel]),
        'action' => route('admin.users.store', $role),
        'method' => 'POST',
        'role' => $role,
        'submitLabel' => __('Creer'),
        'userModel' => null,
        'errorsBagKey' => 'create',
    ])

    @foreach ($users as $user)
        @include('admin.users.partials.modal', [
            'modalId' => 'edit-user-modal-' . $user->id,
            'title' => __('Modifier :resource', ['resource' => $resourceLabel]),
            'action' => route('admin.users.update', [$role, $user]),
            'method' => 'PUT',
            'role' => $role,
            'submitLabel' => __('Mettre a jour'),
            'userModel' => $user,
            'errorsBagKey' => 'edit-' . $user->id,
        ])

        <div id="delete-user-modal-{{ $user->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4" data-modal>
            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('Supprimer :resource', ['resource' => $resourceLabel]) }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ __('Cette action supprimera le compte de :name.', ['name' => $user->name]) }}</p>
                    </div>
                    <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" data-modal-close="delete-user-modal-{{ $user->id }}" aria-label="{{ __('Fermer') }}">
                        X
                    </button>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50" data-modal-close="delete-user-modal-{{ $user->id }}">
                        {{ __('Annuler') }}
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', [$role, $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600">
                            {{ __('Supprimer') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

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
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            });

            @if ($errors->any() && old('modal_target'))
                openModal(@js(old('modal_target')));
            @endif
        });
    </script>
@endsection
