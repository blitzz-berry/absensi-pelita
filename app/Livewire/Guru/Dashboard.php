<?php

namespace App\Livewire\Guru;

use App\Models\Absensi;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $now = Carbon::now('Asia/Jakarta');

        $absensiHariIni = null;
        $riwayatAbsensi = collect();

        if ($user) {
            $absensiHariIni = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $now->toDateString())
                ->first();

            $riwayatAbsensi = Absensi::where('user_id', $user->id)
                ->orderBy('tanggal', 'desc')
                ->limit(4)
                ->get();
        }

        $requiresLocation = filter_var(SystemSetting::get('lokasi_wajib', true), FILTER_VALIDATE_BOOLEAN);
        $requiresSelfie = filter_var(SystemSetting::get('selfie_wajib', true), FILTER_VALIDATE_BOOLEAN);

        return view('livewire.guru.dashboard', [
            'user' => $user,
            'now' => $now,
            'absensiHariIni' => $absensiHariIni,
            'riwayatAbsensi' => $riwayatAbsensi,
            'requiresLocation' => $requiresLocation,
            'requiresSelfie' => $requiresSelfie,
        ])->layout('layouts.mobile-app', [
            'title' => 'Dashboard Guru',
        ]);
    }
}
