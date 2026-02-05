<?php

namespace App\Livewire\Admin;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RekapAbsensi extends Component
{
    use WithPagination;

    public string $tanggal = '';
    public string $bulanExport = '';
    public string $tahunExport = '';

    protected $paginationTheme = 'tailwind';

    public function mount(): void
    {
        $now = Carbon::now('Asia/Jakarta');
        $this->tanggal = $now->toDateString();
        $this->bulanExport = $now->format('m');
        $this->tahunExport = $now->format('Y');
    }

    public function updatingTanggal(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $now = Carbon::now('Asia/Jakarta');
        $periodMonth = (int) ($this->bulanExport ?: $now->format('m'));
        $periodYear = (int) ($this->tahunExport ?: $now->format('Y'));
        $rangeStart = Carbon::create($periodYear, $periodMonth, 15, 0, 0, 0, 'Asia/Jakarta');
        $rangeEnd = $rangeStart->copy()->addMonthNoOverflow()->setDay(16)->endOfDay();

        $tanggal = $this->tanggal ?: $now->toDateString();

        $guru = User::where('role', 'guru')
            ->orderBy('nama')
            ->paginate(10);

        $absensiHarianCollection = Absensi::whereDate('tanggal', $tanggal)->get();
        $absensiHarian = $absensiHarianCollection
            ->whereIn('user_id', $guru->pluck('id'))
            ->keyBy('user_id');

        $totalGuru = User::where('role', 'guru')->count();

        $dailyHadir = $absensiHarianCollection->where('status', 'hadir')->count();
        $dailyTerlambat = $absensiHarianCollection->where('status', 'terlambat')->count();
        $dailyIzin = $absensiHarianCollection->where('status', 'izin')->count();
        $dailySakit = $absensiHarianCollection->where('status', 'sakit')->count();
        $dailyAlphaRecorded = $absensiHarianCollection->where('status', 'alpha')->count();
        $dailyAlphaMissing = max(0, $totalGuru - $absensiHarianCollection->count());
        $dailyAlpha = $dailyAlphaRecorded + $dailyAlphaMissing;

        $baseQuery = Absensi::whereBetween('tanggal', [$rangeStart->toDateString(), $rangeEnd->toDateString()]);
        $monthlyHadir = (clone $baseQuery)->where('status', 'hadir')->count();
        $monthlyIzinSakit = (clone $baseQuery)->whereIn('status', ['izin', 'sakit'])->count();
        $monthlyTerlambat = (clone $baseQuery)->where('status', 'terlambat')->count();

        $attendancePercent = $totalGuru > 0
            ? min(100, round((($monthlyHadir + $monthlyTerlambat) / $totalGuru) * 100))
            : 0;

        $weekly = collect(range(6, 0))->map(function ($offset) use ($rangeEnd) {
            $date = $rangeEnd->copy()->subDays($offset);
            $count = Absensi::whereDate('tanggal', $date->toDateString())
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();

            return [
                'label' => $date->format('D'),
                'count' => $count,
            ];
        });

        return view('livewire.admin.rekap-absensi', [
            'rangeStart' => $rangeStart,
            'rangeEnd' => $rangeEnd,
            'totalGuru' => $totalGuru,
            'monthlyHadir' => $monthlyHadir,
            'monthlyIzinSakit' => $monthlyIzinSakit,
            'monthlyTerlambat' => $monthlyTerlambat,
            'attendancePercent' => $attendancePercent,
            'weekly' => $weekly,
            'tanggal' => $tanggal,
            'guru' => $guru,
            'absensiHarian' => $absensiHarian,
            'dailyHadir' => $dailyHadir,
            'dailyTerlambat' => $dailyTerlambat,
            'dailyIzin' => $dailyIzin,
            'dailySakit' => $dailySakit,
            'dailyAlpha' => $dailyAlpha,
        ])->layout('layouts.mobile-app', [
            'title' => 'Rekap Absensi',
        ]);
    }
}
