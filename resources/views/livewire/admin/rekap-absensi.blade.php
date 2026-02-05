<div class="space-y-4">
    <x-ui.section-title title="Rekap Absensi" subtitle="Pantau absensi harian dan export laporan." />

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

    <x-ui.card class="space-y-4">
        <div>
            <div class="text-sm font-semibold text-slate-900">Filter Harian</div>
            <div class="mt-2">
                <label class="text-xs font-semibold text-slate-500">Tanggal</label>
                <input type="date" wire:model.lazy="tanggal"
                    class="mt-1 w-full rounded-[12px] border border-slate-200 px-3 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
            </div>
        </div>

        <div class="border-t border-slate-100 pt-3">
            <div class="text-sm font-semibold text-slate-900">Export Bulanan</div>
            @php
                $yearNow = now()->year;
                $years = range($yearNow - 5, $yearNow + 2);
                $months = [
                    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
                    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
                ];
            @endphp
            <div class="mt-2 grid grid-cols-2 gap-2">
                <div>
                    <label class="text-xs font-semibold text-slate-500">Bulan</label>
                    <select wire:model="bulanExport"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-2 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
                        @foreach ($months as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500">Tahun</label>
                    <select wire:model="tahunExport"
                        class="mt-1 w-full rounded-[12px] border border-slate-200 px-2 py-2 text-xs focus:border-[color:var(--color-primary)] focus:outline-none">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <form method="POST" action="{{ route('admin.rekap-absensi.export.excel.global') }}">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulanExport }}">
                    <input type="hidden" name="tahun" value="{{ $tahunExport }}">
                    <button type="submit" class="w-full rounded-[14px] bg-emerald-500 px-3 py-2 text-xs font-semibold text-white">
                        Export Rekap
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.rekap-absensi.export.gaji.excel.global') }}">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulanExport }}">
                    <input type="hidden" name="tahun" value="{{ $tahunExport }}">
                    <button type="submit" class="w-full rounded-[14px] bg-indigo-500 px-3 py-2 text-xs font-semibold text-white">
                        Export Gaji
                    </button>
                </form>
            </div>
        </div>
    </x-ui.card>

    <div class="grid grid-cols-2 gap-3">
        <x-ui.stat-card label="Hadir" :value="$dailyHadir" accent="var(--color-success)" />
        <x-ui.stat-card label="Terlambat" :value="$dailyTerlambat" accent="var(--color-warning)" />
        <x-ui.stat-card label="Izin" :value="$dailyIzin" accent="var(--color-primary)" />
        <x-ui.stat-card label="Sakit" :value="$dailySakit" accent="var(--color-danger)" />
        <x-ui.stat-card label="Alpha" :value="$dailyAlpha" accent="#94a3b8" />
    </div>

    @php
        $statusVariant = function (?string $status) {
            return match ($status) {
                'hadir' => 'success',
                'terlambat' => 'warning',
                'izin' => 'info',
                'sakit' => 'danger',
                'alpha' => 'neutral',
                default => 'neutral',
            };
        };
    @endphp

    <x-ui.table-card :title="'Rekap Harian - ' . \Carbon\Carbon::parse($tanggal)->format('d M Y')">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] uppercase tracking-wide text-slate-400">
                    <th class="pb-2">Nama Guru</th>
                    <th class="pb-2">Nomor ID</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Jam Masuk</th>
                    <th class="pb-2">Jam Pulang</th>
                    <th class="pb-2">Lokasi Masuk</th>
                    <th class="pb-2">Lokasi Pulang</th>
                    <th class="pb-2">Export</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @forelse ($guru as $guruItem)
                    @php
                        $absensiGuru = $absensiHarian->get($guruItem->id);
                    @endphp
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ $guruItem->nama ?? 'N/A' }}</td>
                        <td class="py-2">{{ $guruItem->nomor_id ?? '-' }}</td>
                        <td class="py-2">
                            @if ($absensiGuru)
                                <x-ui.badge :variant="$statusVariant($absensiGuru->status)">
                                    {{ ucfirst($absensiGuru->status ?? '-') }}
                                </x-ui.badge>
                            @else
                                <x-ui.badge variant="neutral">Belum Absen</x-ui.badge>
                            @endif
                        </td>
                        <td class="py-2">{{ $absensiGuru->jam_masuk ?? '-' }}</td>
                        <td class="py-2">{{ $absensiGuru->jam_pulang ?? '-' }}</td>
                        <td class="py-2 text-[10px] text-slate-500">
                            {{ $absensiGuru->lokasi_masuk ?? '-' }}
                        </td>
                        <td class="py-2 text-[10px] text-slate-500">
                            {{ $absensiGuru->lokasi_pulang ?? '-' }}
                        </td>
                        <td class="py-2">
                            <a href="{{ route('admin.rekap-absensi.export.excel', ['user_id' => $guruItem->id]) }}?tanggal={{ $tanggal }}"
                                class="inline-flex items-center rounded-[10px] border border-emerald-200 bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">
                                Excel
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-100">
                        <td colspan="8" class="py-3 text-center text-xs text-slate-400">Data guru belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-ui.table-card>

    <div class="mt-2">
        {{ $guru->links() }}
    </div>

    <x-ui.section-title title="Ringkasan Periode" subtitle="Statistik kehadiran bulanan dan mingguan." />

    <x-ui.card class="animate-fade-up">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-[11px] uppercase tracking-wide text-slate-500">Rentang Tanggal</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $rangeStart->format('d M Y') }} - {{ $rangeEnd->format('d M Y') }}
                </div>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-500">Periode 15-16</span>
        </div>
    </x-ui.card>

    <div class="grid grid-cols-2 gap-3">
        <x-ui.stat-card label="Total Guru" :value="$totalGuru" accent="var(--color-primary)" />
        <x-ui.stat-card label="Hadir" :value="$monthlyHadir" accent="var(--color-success)" />
        <x-ui.stat-card label="Izin/Sakit" :value="$monthlyIzinSakit" accent="var(--color-warning)" />
        <x-ui.stat-card label="Terlambat" :value="$monthlyTerlambat" accent="var(--color-danger)" />
    </div>

    @php
        $maxCount = max(1, $weekly->max('count'));
        $percent = $attendancePercent;
        $circumference = 2 * pi() * 28;
        $dash = ($percent / 100) * $circumference;
    @endphp

    <x-ui.card>
        <div class="text-sm font-semibold text-slate-900">Statistik Kehadiran Minggu Ini</div>
        <div class="mt-4 grid grid-cols-[1fr_auto] gap-4">
            <div class="flex items-end gap-2">
                @foreach ($weekly as $day)
                    @php
                        $height = $day['count'] > 0 ? max(18, ($day['count'] / $maxCount) * 64) : 10;
                    @endphp
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="w-full rounded-full bg-slate-100">
                            <div class="rounded-full bg-[color:var(--color-primary)]" style="height: {{ $height }}px;"></div>
                        </div>
                        <span class="text-[10px] text-slate-400">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col items-center justify-center">
                <svg viewBox="0 0 80 80" class="h-20 w-20">
                    <circle cx="40" cy="40" r="28" fill="none" stroke="#e2e8f0" stroke-width="10"></circle>
                    <circle cx="40" cy="40" r="28" fill="none" stroke="var(--color-primary)" stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $dash }} {{ $circumference }}"
                        transform="rotate(-90 40 40)"></circle>
                </svg>
                <div class="mt-2 text-sm font-semibold text-slate-900">{{ $attendancePercent }}%</div>
                <div class="text-[10px] text-slate-400">Kehadiran</div>
            </div>
        </div>
    </x-ui.card>
</div>
