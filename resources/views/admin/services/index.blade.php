@extends('layouts.app', ['title' => $pageTitle])

@section('content')
    @php
        $resourceLabel = __('service');
        $resourceLabelPlural = __('services');
        $activeServices = $services->getCollection()->where('is_active', true)->count();
        $inactiveServices = $services->getCollection()->where('is_active', false)->count();
    @endphp

    <section class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-slate-500">{{ __('Administration') }}</p>
                <h1 class="mt-1 text-3xl font-semibold">{{ $pageTitle }}</h1>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('appointments.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ __('Rendez-vous') }}
                </a>
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_DOCTOR) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ __('Medecins') }}
                </a>
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_PATIENT) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ __('Patients') }}
                </a>
                <a href="{{ route('admin.services.index') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    {{ __('Services') }}
                </a>
                <button type="button" class="rounded-md bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600" data-modal-open="create-service-modal">
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
                <p class="mt-2 text-2xl font-semibold">{{ $services->total() }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Actifs sur cette page') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $activeServices }}</p>
            </div>
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm text-slate-500">{{ __('Inactifs sur cette page') }}</p>
                <p class="mt-2 text-2xl font-semibold">{{ $inactiveServices }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm font-medium text-slate-600">
                            <th class="px-4 py-3">{{ __('Nom') }}</th>
                            <th class="px-4 py-3">{{ __('Description') }}</th>
                            <th class="px-4 py-3">{{ __('Duree') }}</th>
                            <th class="px-4 py-3">{{ __('Prix') }}</th>
                            <th class="px-4 py-3">{{ __('Actif') }}</th>
                            <th class="px-4 py-3">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($services as $service)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white" style="background-color: {{ $service->color }};">
                                            @include('admin.services.partials.service-icon', ['icon' => $service->icon])
                                        </span>
                                        <span>{{ $service->name }}</span>
                                    </div>
                                </td>
                                <td class="max-w-xs px-4 py-3 truncate">{{ $service->description ?: '-' }}</td>
                                <td class="px-4 py-3">{{ $service->duration }} {{ __('min') }}</td>
                                <td class="px-4 py-3 font-medium">{{ number_format($service->price, 2) }} {{ __('DH') }}</td>
                                <td class="px-4 py-3">
                                    @if ($service->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800">
                                            {{ __('Actif') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                            {{ __('Inactif') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            type="button"
                                            class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                            data-modal-open="edit-service-modal-{{ $service->id }}"
                                        >
                                            {{ __('Modifier') }}
                                        </button>
                                        <button
                                            type="button"
                                            class="rounded-md border border-rose-200 px-3 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-50"
                                            data-modal-open="delete-service-modal-{{ $service->id }}"
                                        >
                                            {{ __('Supprimer') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                    {{ __('Aucun service trouve.') }}
                                    <div class="mt-4">
                                        <button type="button" class="rounded-md bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600" data-modal-open="create-service-modal">
                                            {{ __('Creer le premier service') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $services->links() }}
        </div>
    </section>

    @include('admin.services.partials.modal', [
        'modalId' => 'create-service-modal',
        'title' => __('Nouveau service'),
        'action' => route('admin.services.store'),
        'method' => 'POST',
        'submitLabel' => __('Creer'),
        'serviceModel' => null,
    ])

    @foreach ($services as $service)
        @include('admin.services.partials.modal', [
            'modalId' => 'edit-service-modal-' . $service->id,
            'title' => __('Modifier le service'),
            'action' => route('admin.services.update', $service),
            'method' => 'PUT',
            'submitLabel' => __('Mettre a jour'),
            'serviceModel' => $service,
        ])

        @include('components.ui.confirm-delete-modal', [
            'modalId' => 'delete-service-modal-' . $service->id,
            'title' => __('Supprimer :resource', ['resource' => __('service')]),
            'message' => __('Etes-vous sur de vouloir supprimer ce service ?'),
            'action' => route('admin.services.destroy', $service),
        ])
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
                        closeModal(modal.id);
                    }
                });
            });

            @if ($errors->any() && old('modal_target'))
                openModal(@js(old('modal_target')));
            @endif
        });
    </script>
@endsection
