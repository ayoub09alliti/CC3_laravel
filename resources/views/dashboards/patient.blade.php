@extends('layouts.app', ['title' => __('Tableau de bord patient')])

@section('content')
    <section class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ __('Patient') }}</p>
                <h1 class="mt-2 text-3xl font-semibold">{{ __('Bienvenue :name', ['name' => auth()->user()->name]) }}</h1>

            </div>

            
        </div>

        <dl class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">{{ __('Email') }}</dt>
                <dd class="mt-1 font-medium">{{ auth()->user()->email }}</dd>
            </div>
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">{{ __('Role') }}</dt>
                <dd class="mt-1 font-medium">{{ __('Patient') }}</dd>
            </div>
            
        </dl>

        <div class="mt-8">
            <a href="{{ route('appointments.index') }}" class="inline-flex rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                {{ __('Gerer mes rendez-vous') }}
            </a>
        </div>
    </section>
@endsection
