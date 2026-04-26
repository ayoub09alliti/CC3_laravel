@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $baseClasses = 'group inline-flex items-center justify-center gap-2 rounded-2xl border font-medium transition duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-sky-500/30 focus:ring-offset-2';

    $sizeClasses = match ($size) {
        'sm' => 'px-3.5 py-2 text-sm',
        'lg' => 'px-5 py-3 text-sm',
        default => 'px-4 py-2.5 text-sm',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'border-slate-200 bg-white text-slate-700 shadow-sm hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50',
        'dark' => 'border-slate-900 bg-slate-900 text-white shadow-lg shadow-slate-900/10 hover:-translate-y-0.5 hover:bg-slate-800',
        'success' => 'border-emerald-600 bg-emerald-600 text-white shadow-lg shadow-emerald-600/20 hover:-translate-y-0.5 hover:bg-emerald-500',
        'danger' => 'border-rose-600 bg-rose-600 text-white shadow-lg shadow-rose-600/20 hover:-translate-y-0.5 hover:bg-rose-500',
        'ghost' => 'border-transparent bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900',
        default => 'border-sky-600 bg-sky-600 text-white shadow-lg shadow-sky-600/20 hover:-translate-y-0.5 hover:bg-sky-500',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$baseClasses, $sizeClasses, $variantClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class([$baseClasses, $sizeClasses, $variantClasses]) }}>
        {{ $slot }}
    </button>
@endif
