@props([
    'padding' => 'md',
    'tone' => 'default',
])

@php
    $paddingClasses = match ($padding) {
        'sm' => 'p-4',
        'lg' => 'p-8',
        default => 'p-6',
    };

    $toneClasses = match ($tone) {
        'dark' => 'border border-slate-800/80 bg-slate-950 text-white shadow-2xl shadow-slate-950/20',
        'soft' => 'border border-slate-200/80 bg-white/85 backdrop-blur shadow-xl shadow-slate-200/50',
        default => 'border border-slate-200/80 bg-white shadow-sm shadow-slate-200/60',
    };
@endphp

<div {{ $attributes->class(['rounded-[28px]', $paddingClasses, $toneClasses]) }}>
    {{ $slot }}
</div>
