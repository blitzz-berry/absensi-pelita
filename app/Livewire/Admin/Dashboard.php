<?php

namespace App\Livewire\Admin;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $totalGuru = User::where('role', 'guru')->count();
        $hadirHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $izinSakitHariIni = Absensi::whereDate('tanggal', $today)->whereIn('status', ['izin', 'sakit'])->count();
        $terlambatHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'terlambat')->count();

        $weekly = collect(range(6, 0))->map(function ($offset) {
            $date = Carbon::now('Asia/Jakarta')->subDays($offset);
            $count = Absensi::whereDate('tanggal', $date->toDateString())
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();

            return [
                'label' => $date->format('D'),
                'count' => $count,
            ];
        });

        $attendancePercent = $totalGuru > 0
            ? min(100, round((($hadirHariIni + $terlambatHariIni) / $totalGuru) * 100))
            : 0;

        return view('livewire.admin.dashboard', [
            'totalGuru' => $totalGuru,
            'hadirHariIni' => $hadirHariIni,
            'izinSakitHariIni' => $izinSakitHariIni,
            'terlambatHariIni' => $terlambatHariIni,
            'weekly' => $weekly,
            'attendancePercent' => $attendancePercent,
        ])->layout('layouts.mobile-app', [
            'title' => 'Dashboard Admin',
        ]);
    }
}
