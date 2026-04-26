@extends('layouts.app', ['title' => __('Tableau de bord admin')])

@section('content')
    <section class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-rose-700">{{ __('Admin') }}</p>
                <h1 class="mt-2 text-3xl font-semibold">{{ __('Bienvenue :name', ['name' => auth()->user()->name]) }}</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    {{ __('Deconnexion') }}
                </button>
            </form>
        </div>

        <dl class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">{{ __('Email') }}</dt>
                <dd class="mt-1 font-medium">{{ auth()->user()->email }}</dd>
            </div>
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">{{ __('Role') }}</dt>
                <dd class="mt-1 font-medium">{{ __('Admin') }}</dd>
            </div>
            
        </dl>

        <div class="mt-8">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('appointments.index') }}" class="inline-flex rounded-md bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600">
                    {{ __('Administrer les rendez-vous') }}
                </a>
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_PATIENT) }}" class="inline-flex rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                    {{ __('Gerer les patients') }}
                </a>
                <a href="{{ route('admin.users.index', \App\Models\User::ROLE_DOCTOR) }}" class="inline-flex rounded-md bg-emerald-700 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600">
                    {{ __('Gerer les medecins') }}
                </a>
            </div>
        </div>
    </section>
@endsection
