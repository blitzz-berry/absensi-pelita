@props([
    'href',
    'label',
    'active' => false,
    'badge' => null,
])

@php
    $activeClass = $active ? 'text-[color:var(--color-primary)]' : 'text-slate-400';
    $labelClass = $active ? 'text-[color:var(--color-primary)]' : 'text-slate-400';
@endphp

<a href="{{ $href }}" class="relative flex flex-col items-center gap-1 rounded-full px-2 py-1 text-center">
    <span class="{{ $activeClass }}">
        {{ $slot }}
    </span>
    @if ($badge)
        <span class="absolute -top-1 right-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-rose-500 px-1 text-[9px] font-semibold text-white">
            {{ $badge }}
        </span>
    @endif
    <span class="text-[10px] font-semibold {{ $labelClass }}">{{ $label }}</span>
</a>
