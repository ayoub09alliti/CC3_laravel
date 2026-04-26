@extends('layouts.app', ['title' => __('Creer un rendez-vous')])

@section('content')
    <section class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="mb-8">
            <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ __('Creation') }}</p>
            <h1 class="mt-1 text-3xl font-semibold">{{ __('Nouveau rendez-vous') }}</h1>
            <p class="mt-2 text-sm text-slate-600">{{ __('Renseignez les informations du rendez-vous puis enregistrez.') }}</p>
        </div>

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            @include('appointments._form')
        </form>
    </section>
@endsection
