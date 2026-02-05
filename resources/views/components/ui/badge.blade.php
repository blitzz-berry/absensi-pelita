@props([
    'variant' => 'neutral',
])

@php
    $classes = match ($variant) {
        'success' => 'bg-emerald-100 text-emerald-700',
        'danger' => 'bg-rose-100 text-rose-700',
        'warning' => 'bg-orange-100 text-orange-700',
        'info' => 'bg-sky-100 text-sky-700',
        default => 'bg-slate-100 text-slate-600',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold {$classes}"]) }}>
    {{ $slot }}
</span>
