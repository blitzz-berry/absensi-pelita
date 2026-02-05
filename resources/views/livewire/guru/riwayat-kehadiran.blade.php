<div class="space-y-4">
    <x-ui.section-title
        title="Riwayat Kehadiran"
        :subtitle="'Ringkasan ' . $rangeStart->format('d M') . ' - ' . $rangeEnd->format('d M Y')"
    />

    <div class="grid grid-cols-2 gap-3">
        <x-ui.stat-card label="Hadir" :value="$counts['hadir']" accent="var(--color-success)" class="animate-fade-up" />
        <x-ui.stat-card label="Terlambat" :value="$counts['terlambat']" accent="var(--color-warning)" class="animate-fade-up stagger-1" />
        <x-ui.stat-card label="Izin" :value="$counts['izin']" accent="var(--color-primary)" class="animate-fade-up stagger-2" />
        <x-ui.stat-card label="Sakit" :value="$counts['sakit']" accent="var(--color-danger)" class="animate-fade-up stagger-3" />
    </div>

    @php
        $statusVariant = function (?string $status) {
            return match ($status) {
                'hadir' => 'success',
                'terlambat' => 'warning',
                'izin' => 'info',
                'sakit' => 'danger',
                default => 'neutral',
            };
        };
    @endphp

    <x-ui.table-card title="Riwayat Absensi Terakhir">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] uppercase tracking-wide text-slate-400">
                    <th class="pb-2">Tanggal</th>
                    <th class="pb-2">Jam Masuk</th>
                    <th class="pb-2">Status</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @forelse ($riwayat as $absen)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                        <td class="py-2">{{ $absen->jam_masuk ? substr($absen->jam_masuk, 0, 5) : '-' }}</td>
                        <td class="py-2">
                            <x-ui.badge :variant="$statusVariant($absen->status)">
                                {{ ucfirst($absen->status ?? '-') }}
                            </x-ui.badge>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-100">
                        <td colspan="3" class="py-3 text-center text-xs text-slate-400">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-ui.table-card>
</div>
