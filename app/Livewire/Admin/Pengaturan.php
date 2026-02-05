<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pengaturan extends Component
{
    public function render()
    {
        $settings = [
            'notifikasi_absensi' => SystemSetting::get('notifikasi_absensi', true),
            'lokasi_wajib' => SystemSetting::get('lokasi_wajib', true),
            'selfie_wajib' => SystemSetting::get('selfie_wajib', true),
            'toleransi_keterlambatan' => SystemSetting::get('toleransi_keterlambatan', 15),
            'waktu_absen_masuk' => SystemSetting::get('waktu_absen_masuk', '07:00'),
            'waktu_absen_pulang' => SystemSetting::get('waktu_absen_pulang', '16:00'),
            'radius_absen' => SystemSetting::get('radius_absen', 50),
            'pesan_pengingat' => SystemSetting::get('pesan_pengingat', 'Jangan lupa absen hari ini!'),
        ];

        return view('livewire.admin.pengaturan', [
            'user' => Auth::user(),
            'settings' => $settings,
        ])->layout('layouts.mobile-app', [
            'title' => 'Pengaturan Admin',
        ]);
    }
}
