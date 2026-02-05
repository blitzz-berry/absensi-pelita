@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
    @if ($subtitle)
        <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
