@extends('layouts.app', ['title' => 'Connexion'])

@section('content')
    <div class="mx-auto max-w-md rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-semibold">Connexion</h1>
        <p class="mt-2 text-sm text-slate-600">Connectez-vous avec votre compte pour acceder a votre espace.</p>

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Mot de passe</label>
                <input id="password" name="password" type="password" required class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 outline-none ring-0 focus:border-sky-500">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300">
                <span>Se souvenir de moi</span>
            </label>

            <button type="submit" class="w-full rounded-md bg-slate-900 px-4 py-2 font-medium text-white transition hover:bg-slate-700">
                Se connecter
            </button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-medium text-sky-700 hover:text-sky-600">Creer un compte patient</a>
        </p>
    </div>
@endsection
