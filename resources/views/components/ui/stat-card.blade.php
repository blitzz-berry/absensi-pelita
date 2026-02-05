@props([
    'label',
    'value',
    'accent' => 'var(--color-primary)',
])

<div {{ $attributes->merge(['class' => 'rounded-[18px] border border-slate-100 bg-white p-4 shadow-soft']) }}>
    <div class="flex items-start gap-3">
        <div class="mt-1 h-full w-1 rounded-full" style="background-color: {{ $accent }};"></div>
        <div>
            <div class="text-[11px] uppercase tracking-wide text-slate-500">{{ $label }}</div>
            <div class="mt-1 text-2xl font-semibold text-slate-900">{{ $value }}</div>
            {{ $slot }}
        </div>
    </div>
</div>
