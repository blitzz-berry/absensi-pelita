@props([
    'title',
    'action' => null,
])

<x-ui.card>
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-900">{{ $title }}</h3>
        @if ($action)
            <span class="text-xs font-semibold text-[color:var(--color-primary)]">{{ $action }}</span>
        @endif
    </div>
    <div class="mt-3 overflow-x-auto">
        {{ $slot }}
    </div>
</x-ui.card>
