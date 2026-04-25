@extends('layouts.app', ['title' => 'Modifier un rendez-vous'])

@section('content')
    <section class="mx-auto max-w-4xl rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="mb-8">
            <p class="text-sm font-medium uppercase tracking-wide text-sky-700">Edition</p>
            <h1 class="mt-1 text-3xl font-semibold">Modifier le rendez-vous</h1>
            <p class="mt-2 text-sm text-slate-600">Mettez a jour la date, le service, le medecin ou le statut.</p>
        </div>

        <form method="POST" action="{{ route('appointments.update', $appointment) }}">
            @csrf
            @method('PUT')
            @include('appointments._form')
        </form>
    </section>
@endsection
