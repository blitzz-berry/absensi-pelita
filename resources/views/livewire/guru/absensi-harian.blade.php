<div class="space-y-4">
    <x-ui.section-title title="Absensi Harian" subtitle="Pantau daftar kehadiran minggu ini." />

    <x-ui.card class="animate-fade-up">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-[11px] uppercase tracking-wide text-slate-500">Rentang Tanggal</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $rangeStart->format('d M Y') }} - {{ $rangeEnd->format('d M Y') }}
                </div>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-500">7 Hari</span>
        </div>
    </x-ui.card>

    @php
        $dayNames = [
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu',
        ];
    @endphp

    <x-ui.table-card title="Daftar Kehadiran">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] uppercase tracking-wide text-slate-400">
                    <th class="pb-2">Tanggal</th>
                    <th class="pb-2">Hari</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @foreach ($days as $day)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ $day->format('d M Y') }}</td>
                        <td class="py-2">{{ $dayNames[$day->format('D')] ?? $day->format('D') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-ui.table-card>

    <a href="{{ route('guru.riwayat.kehadiran') }}" class="inline-flex items-center text-xs font-semibold text-[color:var(--color-primary)]">
        Lihat Riwayat Kehadiran &gt;
    </a>
</div>
