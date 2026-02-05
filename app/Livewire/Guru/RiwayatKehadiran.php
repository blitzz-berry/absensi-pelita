<?php

namespace App\Livewire\Guru;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RiwayatKehadiran extends Component
{
    public function render()
    {
        $user = Auth::user();
        $rangeEnd = Carbon::now('Asia/Jakarta');
        $rangeStart = $rangeEnd->copy()->subDays(29);

        $riwayat = collect();
        $counts = [
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
        ];

        if ($user) {
            $baseQuery = Absensi::where('user_id', $user->id)
                ->whereBetween('tanggal', [$rangeStart->toDateString(), $rangeEnd->toDateString()]);

            $riwayat = (clone $baseQuery)
                ->orderBy('tanggal', 'desc')
                ->limit(10)
                ->get();

            $counts['hadir'] = (clone $baseQuery)->where('status', 'hadir')->count();
            $counts['terlambat'] = (clone $baseQuery)->where('status', 'terlambat')->count();
            $counts['izin'] = (clone $baseQuery)->where('status', 'izin')->count();
            $counts['sakit'] = (clone $baseQuery)->where('status', 'sakit')->count();
        }

        return view('livewire.guru.riwayat-kehadiran', [
            'riwayat' => $riwayat,
            'counts' => $counts,
            'rangeStart' => $rangeStart,
            'rangeEnd' => $rangeEnd,
        ])->layout('layouts.mobile-app', [
            'title' => 'Riwayat Kehadiran',
        ]);
    }
}
