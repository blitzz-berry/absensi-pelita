<div class="space-y-4">
    <x-ui.section-title title="Pengajuan Izin/Sakit" subtitle="Pilih jenis pengajuan lalu isi periode." />

    @if (session('success'))
        <x-ui.card class="border border-emerald-100 bg-emerald-50 text-xs font-semibold text-emerald-700">
            {{ session('success') }}
        </x-ui.card>
    @endif

    @if (session('error'))
        <x-ui.card class="border border-rose-100 bg-rose-50 text-xs font-semibold text-rose-700">
            {{ session('error') }}
        </x-ui.card>
    @endif

    @if ($errors->any())
        <x-ui.card class="border border-rose-100 bg-rose-50 text-xs font-semibold text-rose-700">
            {{ $errors->first() }}
        </x-ui.card>
    @endif

    <div class="inline-flex rounded-full bg-slate-100 p-1">
        <button type="button" wire:click="setTab('izin')" class="rounded-full px-4 py-2 text-[11px] font-semibold {{ $tab === 'izin' ? 'bg-white text-slate-900 shadow-soft' : 'text-slate-500' }}">
            IZIN
        </button>
        <button type="button" wire:click="setTab('sakit')" class="rounded-full px-4 py-2 text-[11px] font-semibold {{ $tab === 'sakit' ? 'bg-white text-slate-900 shadow-soft' : 'text-slate-500' }}">
            SAKIT
        </button>
    </div>

    <x-ui.card class="animate-fade-up">
        <form method="POST" action="{{ route('guru.izin.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="hidden" name="jenis_pengajuan" value="{{ $tab }}">

            <div>
                <label class="text-xs font-semibold text-slate-600">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Alasan</label>
                <textarea name="alasan" rows="3" required
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none"
                    placeholder="Tuliskan alasan singkat">{{ old('alasan') }}</textarea>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Bukti (opsional)</label>
                <input type="file" name="bukti_file" class="mt-1 w-full rounded-xl border border-dashed border-slate-200 bg-slate-50 px-3 py-2 text-[11px] text-slate-500">
            </div>

            <button type="submit" class="w-full rounded-[16px] bg-[color:var(--color-primary)] px-4 py-3 text-xs font-semibold text-white shadow-soft">
                Kirim Pengajuan
            </button>
        </form>
    </x-ui.card>

    <x-ui.card class="border border-slate-100 bg-white/95">
        <div class="text-xs font-semibold text-slate-700">Panduan Pengajuan</div>
        <ul class="mt-2 space-y-1 text-xs text-slate-500">
            <li>- Isi tanggal mulai dan selesai sesuai kebutuhan.</li>
            <li>- Jelaskan alasan singkat agar cepat diproses.</li>
            <li>- Lampirkan bukti pendukung jika ada.</li>
        </ul>
    </x-ui.card>

    @php
        $statusVariant = function (?string $status) {
            return match ($status) {
                'disetujui' => 'success',
                'ditolak' => 'danger',
                'diajukan' => 'warning',
                'sakit' => 'info',
                default => 'neutral',
            };
        };
    @endphp

    <div class="flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-900">Riwayat Pengajuan</h3>
        <span class="text-xs text-slate-400">{{ $pengajuanIzin->total() }} data</span>
    </div>

    <div class="space-y-3">
        @forelse ($pengajuanIzin as $izin)
            <x-ui.card class="space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-xs text-slate-400">Jenis</div>
                        <div class="text-sm font-semibold text-slate-900">{{ ucfirst($izin->jenis ?? '-') }}</div>
                    </div>
                    <x-ui.badge :variant="$statusVariant($izin->status)">
                        {{ ucfirst($izin->status ?? 'diajukan') }}
                    </x-ui.badge>
                </div>
                <div class="grid grid-cols-2 gap-3 text-xs text-slate-600">
                    <div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Mulai</div>
                        <div class="mt-1 font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }}
                        </div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Selesai</div>
                        <div class="mt-1 font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="rounded-[12px] bg-slate-50 px-3 py-2 text-xs text-slate-600">
                    <div class="text-[10px] uppercase tracking-wide text-slate-400">Alasan</div>
                    <div class="mt-1 text-slate-700">{{ $izin->alasan ?? '-' }}</div>
                </div>
                @if ($izin->catatan_admin || $izin->admin_notes)
                    <div class="rounded-[12px] bg-amber-50 px-3 py-2 text-xs text-amber-700">
                        <div class="text-[10px] uppercase tracking-wide text-amber-500">Catatan Admin</div>
                        <div class="mt-1">{{ $izin->catatan_admin ?? $izin->admin_notes }}</div>
                    </div>
                @endif
                @if ($izin->bukti_file)
                    <a href="{{ asset('storage/izin_files/' . $izin->bukti_file) }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[color:var(--color-primary)]"
                        target="_blank" rel="noopener">
                        Lihat Bukti
                    </a>
                @endif
                <div class="text-[10px] text-slate-400">
                    Diajukan {{ \Carbon\Carbon::parse($izin->created_at)->diffForHumans() }}
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="text-center text-xs text-slate-400">Belum ada pengajuan izin.</x-ui.card>
        @endforelse
    </div>

    <div class="mt-2">
        {{ $pengajuanIzin->links() }}
    </div>
</div>
