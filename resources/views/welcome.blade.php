@extends('layouts.app', ['title' => __('MediCab | Plateforme de gestion medicale')])

@section('content')
    <section class="overflow-hidden rounded-lg bg-slate-900 text-white">
        <div class="grid min-h-[36rem] lg:grid-cols-[1.1fr_1fr]">
            <div class="flex flex-col justify-center px-8 py-12 md:px-12 lg:px-16">
                <p class="text-sm font-medium uppercase tracking-wide text-sky-300">{{ __('Projet Laravel de gestion medicale') }}</p>
                <h1 class="mt-4 max-w-2xl text-4xl font-semibold leading-tight md:text-5xl">{{ __('Centralisez patients, medecins et rendez-vous dans une seule interface claire.') }}</h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-slate-300">
                    {{ __('MediCab est une application web multilingue qui simplifie l organisation du parcours patient, la gestion des comptes par role et le suivi des rendez-vous avec notifications par email.') }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-sky-600 px-5 py-3 text-sm font-medium text-white hover:bg-sky-500">
                            {{ __('Acceder au tableau de bord') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-md bg-sky-600 px-5 py-3 text-sm font-medium text-white hover:bg-sky-500">
                            {{ __('Creer un compte') }}
                        </a>
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-600 px-5 py-3 text-sm font-medium text-slate-100 hover:bg-slate-800">
                            {{ __('Se connecter') }}
                        </a>
                    @endauth
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold">{{ __('3 roles') }}</p>
                        <p class="mt-1 text-sm text-slate-300">{{ __('admin, medecin et patient avec acces separe') }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold">{{ __('3 langues') }}</p>
                        <p class="mt-1 text-sm text-slate-300">{{ __('francais, english et العربية') }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold">{{ __('100% web') }}</p>
                        <p class="mt-1 text-sm text-slate-300">{{ __('prise de rendez-vous et suivi centralises') }}</p>
                    </div>
                </div>
            </div>

            <div class="relative min-h-[24rem]">
                <img src="{{ asset('images/landing-hero.png') }}" alt="{{ __('Interface medicale moderne') }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-slate-950/10 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 rounded-lg bg-white/95 p-5 text-slate-900 shadow-xl backdrop-blur">
                    <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ __('Apercu du projet') }}</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-slate-500">{{ __('Modules') }}</p>
                            <p class="mt-1 font-medium">{{ __('Authentification, dashboards, rendez-vous, gestion admin') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">{{ __('Experience') }}</p>
                            <p class="mt-1 font-medium">{{ __('Formulaires en modales, confirmations rapides, emails automatiques') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium uppercase tracking-wide text-sky-700">{{ __('Patients') }}</p>
            <h2 class="mt-3 text-2xl font-semibold">{{ __('Demande de rendez-vous simple et rassurante') }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('Les patients peuvent creer un rendez-vous en quelques champs, suivre le statut de leur demande et recevoir un email des qu un rendez-vous est confirme.') }}</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium uppercase tracking-wide text-emerald-700">{{ __('Medecins') }}</p>
            <h2 class="mt-3 text-2xl font-semibold">{{ __('Validation rapide et vue ciblee') }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('Les medecins consultent uniquement leurs rendez-vous, acceptent les demandes en un clic et gardent une vue utile sur leur activite du jour.') }}</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium uppercase tracking-wide text-rose-700">{{ __('Administration') }}</p>
            <h2 class="mt-3 text-2xl font-semibold">{{ __('Pilotage central du systeme') }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('L administrateur gere les medecins, les patients et les rendez-vous depuis une interface unique avec des formulaires modaux plus fluides.') }}</p>
        </div>
    </section>

    <section class="mt-8 rounded-lg bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_1fr]">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-slate-500">{{ __('Fonctionnalites') }}</p>
                <h2 class="mt-3 text-3xl font-semibold">{{ __('Une base solide pour un projet medical academique ou evolutif') }}</h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600">{{ __('Cette version met l accent sur la clarte des parcours, la separation des roles et une interface compatible avec trois langues, y compris un affichage adapte a l arabe.') }}</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ([
                    __('Authentification securisee'),
                    __('Gestion des comptes par role'),
                    __('Rendez-vous avec statut pending confirmed cancelled'),
                    __('Confirmation rapide depuis la liste'),
                    __('Emails de notification'),
                    __('Interface FR EN AR'),
                ] as $feature)
                    <div class="rounded-lg bg-slate-50 p-4 ring-1 ring-slate-200">
                        <p class="text-sm font-medium text-slate-800">{{ $feature }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
