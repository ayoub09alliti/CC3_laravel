@extends('layouts.app', ['title' => 'Inscription'])

@section('content')
    <div class="mx-auto max-w-md rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-semibold">Inscription</h1>
        <p class="mt-2 text-sm text-slate-600">La creation publique d'un compte cree un profil `patient`.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nom complet</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Mot de passe</label>
                <input id="password" name="password" type="password" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Confirmation</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
            </div>

            <button type="submit" class="w-full rounded-md bg-sky-700 px-4 py-2 font-medium text-white transition hover:bg-sky-600">
                Creer le compte
            </button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Deja inscrit ?
            <a href="{{ route('login') }}" class="font-medium text-slate-900 hover:text-slate-700">Se connecter</a>
        </p>
    </div>
@endsection
