@props([
    'variant' => 'success',
])

@php
    $variantClasses = match ($variant) {
        'danger' => 'border-rose-200 bg-rose-50 text-rose-700',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
        default => 'border-emerald-200 bg-emerald-50 text-emerald-700',
    };
@endphp

<div {{ $attributes->class(["rounded-2xl border px-4 py-3 text-sm shadow-sm", $variantClasses]) }}>
    {{ $slot }}
</div>
