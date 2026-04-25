@extends('layouts.app', ['title' => 'Dashboard Patient'])

@section('content')
    <section class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-sky-700">Patient</p>
                <h1 class="mt-2 text-3xl font-semibold">Bienvenue {{ auth()->user()->name }}</h1>
                <p class="mt-3 text-slate-600">Votre espace patient est protege par le middleware de role.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    Deconnexion
                </button>
            </form>
        </div>

        <dl class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">Email</dt>
                <dd class="mt-1 font-medium">{{ auth()->user()->email }}</dd>
            </div>
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">Role</dt>
                <dd class="mt-1 font-medium">{{ auth()->user()->role }}</dd>
            </div>
            <div class="rounded-lg bg-slate-50 p-4">
                <dt class="text-sm text-slate-500">Acces</dt>
                <dd class="mt-1 font-medium">Routes patient uniquement</dd>
            </div>
        </dl>

        <div class="mt-8">
            <a href="{{ route('appointments.index') }}" class="inline-flex rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                Gerer mes rendez-vous
            </a>
        </div>
    </section>
@endsection
