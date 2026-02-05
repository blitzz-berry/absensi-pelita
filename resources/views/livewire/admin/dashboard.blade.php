<div class="space-y-4">
    <x-ui.section-title title="Selamat Datang, Admin Sekolah" subtitle="Ringkasan cepat absensi hari ini." />

    <x-ui.card class="flex items-center justify-between">
        <div>
            <div class="text-sm font-semibold text-slate-900">Lokasi Kehadiran</div>
            <div class="mt-1 text-xs text-slate-500">Pantau peta lokasi absensi guru terbaru.</div>
        </div>
        <a href="{{ route('admin.peta-kehadiran') }}"
            class="inline-flex items-center gap-2 rounded-[14px] bg-[color:var(--color-primary)] px-4 py-2 text-xs font-semibold text-white shadow-soft">
            Lihat
        </a>
    </x-ui.card>

    <div class="grid grid-cols-2 gap-3">
        <x-ui.stat-card label="Total Guru" :value="$totalGuru" accent="var(--color-primary)" class="animate-fade-up" />
        <x-ui.stat-card label="Hadir Hari Ini" :value="$hadirHariIni" accent="var(--color-success)" class="animate-fade-up stagger-1" />
        <x-ui.stat-card label="Izin/Sakit" :value="$izinSakitHariIni" accent="var(--color-warning)" class="animate-fade-up stagger-2" />
        <x-ui.stat-card label="Terlambat" :value="$terlambatHariIni" accent="var(--color-danger)" class="animate-fade-up stagger-3" />
    </div>

    @php
        $maxCount = max(1, $weekly->max('count'));
        $percent = $attendancePercent;
        $circumference = 2 * pi() * 28;
        $dash = ($percent / 100) * $circumference;
    @endphp

    <div class="grid gap-3">
        <x-ui.card>
            <div class="text-sm font-semibold text-slate-900">Kehadiran Minggu Ini</div>
            <div class="mt-4 flex items-end gap-2">
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
        </x-ui.card>

        <x-ui.card>
            <div class="text-sm font-semibold text-slate-900">Persentase Kehadiran</div>
            <div class="mt-4 flex items-center gap-4">
                <svg viewBox="0 0 80 80" class="h-20 w-20">
                    <circle cx="40" cy="40" r="28" fill="none" stroke="#e2e8f0" stroke-width="10"></circle>
                    <circle cx="40" cy="40" r="28" fill="none" stroke="var(--color-primary)" stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $dash }} {{ $circumference }}"
                        transform="rotate(-90 40 40)"></circle>
                </svg>
                <div>
                    <div class="text-2xl font-semibold text-slate-900">{{ $attendancePercent }}%</div>
                    <div class="text-xs text-slate-500">Kehadiran rata-rata</div>
                </div>
            </div>
        </x-ui.card>
    </div>
</div>
