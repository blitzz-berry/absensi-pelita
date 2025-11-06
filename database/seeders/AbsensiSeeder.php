<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create attendance records
        Absensi::create([
            'user_id' => 2, // Budi Santoso
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '07:30:00',
            'jam_pulang' => '15:30:00',
            'status' => 'hadir',
            'lokasi_masuk' => '-6.200000,106.816666',
            'lokasi_pulang' => '-6.200000,106.816666',
            'foto_selfie_masuk' => 'photos/budi_masuk_' . now()->toDateString() . '.jpg',
            'foto_selfie_pulang' => 'photos/budi_pulang_' . now()->toDateString() . '.jpg',
        ]);

        Absensi::create([
            'user_id' => 3, // Ani Lestari
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '07:45:00',
            'jam_pulang' => '15:45:00',
            'status' => 'hadir',
            'lokasi_masuk' => '-6.200000,106.816666',
            'lokasi_pulang' => '-6.200000,106.816666',
            'foto_selfie_masuk' => 'photos/ani_masuk_' . now()->toDateString() . '.jpg',
            'foto_selfie_pulang' => 'photos/ani_pulang_' . now()->toDateString() . '.jpg',
        ]);

        Absensi::create([
            'user_id' => 4, // Agus Kurniawan
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '08:15:00',
            'jam_pulang' => null,
            'status' => 'terlambat',
            'lokasi_masuk' => '-6.200000,106.816666',
            'lokasi_pulang' => null,
            'foto_selfie_masuk' => 'photos/agus_masuk_' . now()->toDateString() . '.jpg',
            'foto_selfie_pulang' => null,
        ]);
    }
}