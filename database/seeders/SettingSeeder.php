<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create settings record
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'jam_masuk_mulai' => '07:00',
                'jam_masuk_batas' => '08:00',
                'jam_pulang_mulai' => '15:00',
                'jam_pulang_batas' => '16:00',
                'radius_lokasi' => '50',
                'lokasi_absen_lat' => '-6.200000',
                'lokasi_absen_lng' => '106.816666',
                'nama_sekolah' => 'Sekolah Pelita Harapan',
                'alamat_sekolah' => 'Jl. Pendidikan No. 1, Kota Edukasi',
            ]
        );
    }
}