<div class="space-y-4">
    <div class="flex items-center justify-between">
        <x-ui.section-title title="Notifikasi" subtitle="Info terbaru buat kamu." class="mb-0" />
        <span class="rounded-full bg-rose-500 px-2 py-1 text-[10px] font-semibold text-white">
            {{ $notifications->count() }}
        </span>
    </div>

    <div>
        <input type="text" wire:model.debounce.300ms="search" placeholder="Cari notifikasi..."
            class="w-full rounded-[14px] border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600 shadow-soft focus:border-[color:var(--color-primary)] focus:outline-none">
    </div>

    <div class="space-y-3">
        @php
            $palette = ['bg-sky-100 text-sky-600', 'bg-emerald-100 text-emerald-600', 'bg-orange-100 text-orange-600'];
        @endphp
        @forelse ($notifications as $index => $notification)
            @php
                $color = $palette[$index % count($palette)];
            @endphp
            <x-ui.card class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $color }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-slate-900">{{ $notification->title ?? 'Notifikasi Baru' }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $notification->message ?? 'Detail notifikasi belum tersedia.' }}</div>
                    <div class="mt-2 text-[10px] text-slate-400">
                        {{ $notification->created_at?->diffForHumans() ?? 'baru saja' }}
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="text-center text-xs text-slate-400">Belum ada notifikasi.</x-ui.card>
        @endforelse
    </div>
</div>
