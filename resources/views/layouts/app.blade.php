<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
@endphp
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" >
    
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-6 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-sky-700 text-sm font-semibold text-white">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo médical" style="width:120px;">
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-slate-900">{{ __('MediCab') }}</span>
                        <span class="block text-xs text-slate-500">{{ __('Gestion medicale intelligente') }}</span>
                    </span>
                </a>

                <div class="flex items-center gap-3">
                    <div class="flex items-center rounded-md border border-slate-300 bg-white p-1 text-sm">
                        @foreach (['fr' => 'FR', 'en' => 'EN', 'ar' => 'AR'] as $code => $label)
                            <a
                                href="{{ route('locale.switch', $code) }}"
                                class="rounded px-3 py-1.5 font-medium {{ $locale === $code ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}"
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            {{ __('Tableau de bord') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                                {{ __('Deconnexion') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            {{ __('Connexion') }}
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600">
                            {{ __('Inscription') }}
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="px-6 py-8">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
