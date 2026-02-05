<div class="space-y-4">
    <x-ui.section-title title="Pengajuan Izin" subtitle="Review izin guru dengan tampilan rapi." />

    <div class="grid grid-cols-2 gap-3">
        <x-ui.stat-card label="Diajukan" :value="$stats->get('diajukan', 0)" accent="var(--color-warning)" />
        <x-ui.stat-card label="Disetujui" :value="$stats->get('disetujui', 0)" accent="var(--color-success)" />
        <x-ui.stat-card label="Ditolak" :value="$stats->get('ditolak', 0)" accent="var(--color-danger)" />
    </div>

    @php
        $statusVariant = function (?string $status) {
            return match ($status) {
                'disetujui' => 'success',
                'ditolak' => 'danger',
                'diajukan' => 'warning',
                default => 'neutral',
            };
        };
    @endphp

    <div class="space-y-3">
        @forelse ($pengajuan as $izin)
            <x-ui.card class="space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">{{ $izin->user?->nama ?? 'Guru' }}</div>
                        <div class="text-xs text-slate-500">{{ $izin->user?->nomor_id ?? '-' }}</div>
                    </div>
                    <x-ui.badge :variant="$statusVariant($izin->status)">
                        {{ ucfirst($izin->status ?? 'diajukan') }}
                    </x-ui.badge>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs text-slate-600">
                    <div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Jenis</div>
                        <div class="mt-1 font-semibold text-slate-800">{{ ucfirst($izin->jenis ?? '-') }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase tracking-wide text-slate-400">Periode</div>
                        <div class="mt-1 font-semibold text-slate-800">
                            {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="rounded-[12px] bg-slate-50 px-3 py-2 text-xs text-slate-600">
                    <div class="text-[10px] uppercase tracking-wide text-slate-400">Alasan</div>
                    <div class="mt-1 text-slate-700">{{ $izin->alasan ?? '-' }}</div>
                </div>

                @if ($izin->approved_by)
                    <div class="text-[11px] font-semibold text-slate-600">
                        @if ($izin->status === 'disetujui')
                            Disetujui oleh {{ $izin->approvedBy?->nama ?? $izin->approvedBy?->name ?? 'Admin' }}
                        @elseif ($izin->status === 'ditolak')
                            Ditolak oleh {{ $izin->approvedBy?->nama ?? $izin->approvedBy?->name ?? 'Admin' }}
                        @endif
                    </div>
                @endif

                @if ($izin->bukti_file)
                    @php
                        $buktiUrl = route('admin.pengajuan-izin.bukti', $izin->bukti_file);
                        $buktiExt = strtolower(pathinfo($izin->bukti_file, PATHINFO_EXTENSION));
                    @endphp
                    <button type="button"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[color:var(--color-primary)]"
                        data-bukti-url="{{ $buktiUrl }}"
                        data-bukti-ext="{{ $buktiExt }}"
                        data-bukti-name="{{ $izin->bukti_file }}">
                        Lihat Bukti
                    </button>
                @endif

                <div class="flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        Diajukan {{ \Carbon\Carbon::parse($izin->created_at)->diffForHumans() }}
                    </div>
                    @if ($izin->status === 'diajukan')
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.pengajuan-izin.status', $izin->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit" class="rounded-[10px] bg-emerald-500 px-3 py-1.5 text-[11px] font-semibold text-white">
                                    Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.pengajuan-izin.status', $izin->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="rounded-[10px] bg-rose-500 px-3 py-1.5 text-[11px] font-semibold text-white">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="text-center text-xs text-slate-400">Belum ada pengajuan izin.</x-ui.card>
        @endforelse
    </div>

    <div class="mt-2">
        {{ $pengajuan->links() }}
    </div>

    <div id="bukti-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" data-bukti-close></div>
        <div class="relative mx-auto mt-10 w-[min(94vw,520px)] px-3">
            <div class="rounded-[22px] border border-white/80 bg-white p-4 shadow-card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Bukti Izin</div>
                        <div id="bukti-meta" class="text-[11px] text-slate-500"></div>
                    </div>
                    <button type="button" class="rounded-full border border-slate-200 px-2.5 py-1 text-[11px] font-semibold text-slate-500" data-bukti-close>
                        Tutup
                    </button>
                </div>
                <div class="mt-4 space-y-3">
                    <div class="rounded-[16px] border border-slate-200 bg-slate-50 p-2">
                        <div id="bukti-image-wrapper" class="hidden">
                            <div class="flex max-h-[55vh] min-h-[240px] items-center justify-center">
                                <img id="bukti-image" src="" alt="Bukti Izin" class="max-h-[52vh] max-w-full rounded-xl object-contain">
                            </div>
                        </div>
                        <div id="bukti-pdf-wrapper" class="hidden">
                            <iframe id="bukti-pdf" src="" class="h-[55vh] w-full rounded-xl bg-white"></iframe>
                        </div>
                    </div>
                    <a id="bukti-link" href="#" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[color:var(--color-primary)]">
                        Buka di Tab Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const modal = document.getElementById('bukti-modal');
        if (!modal) {
            return;
        }

        const imageWrapper = document.getElementById('bukti-image-wrapper');
        const image = document.getElementById('bukti-image');
        const pdfWrapper = document.getElementById('bukti-pdf-wrapper');
        const pdf = document.getElementById('bukti-pdf');
        const link = document.getElementById('bukti-link');

        function openModal(url, ext, name) {
            if (!url) {
                return;
            }

            const isPdf = (ext || '').toLowerCase() === 'pdf';
            imageWrapper.classList.toggle('hidden', isPdf);
            pdfWrapper.classList.toggle('hidden', !isPdf);

            if (isPdf) {
                pdf.src = url;
                image.src = '';
            } else {
                image.src = url;
                pdf.src = '';
            }

            link.href = url;
            link.textContent = name ? `Buka ${name}` : 'Buka di Tab Baru';

            const meta = document.getElementById('bukti-meta');
            if (meta) {
                const label = isPdf ? 'PDF' : 'Gambar';
                meta.textContent = name ? `${label} - ${name}` : label;
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            image.src = '';
            pdf.src = '';
        }

        document.querySelectorAll('[data-bukti-url]').forEach((button) => {
            button.addEventListener('click', () => {
                openModal(button.dataset.buktiUrl, button.dataset.buktiExt, button.dataset.buktiName);
            });
        });

        modal.querySelectorAll('[data-bukti-close]').forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    })();
</script>
@endpush
