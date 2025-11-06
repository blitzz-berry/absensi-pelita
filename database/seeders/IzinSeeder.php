<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Izin;

class IzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create izin/sakit records
        Izin::create([
            'user_id' => 2, // Budi Santoso
            'jenis' => 'sakit',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'alasan' => 'Sakit demam dan flu',
            'bukti_file' => 'documents/surat_dokter_budi.pdf',
            'status' => 'disetujui',
            'catatan_admin' => 'Silakan istirahat yang cukup',
        ]);

        Izin::create([
            'user_id' => 3, // Ani Lestari
            'jenis' => 'izin',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->toDateString(),
            'alasan' => 'Acara keluarga',
            'status' => 'diajukan',
        ]);

        Izin::create([
            'user_id' => 4, // Agus Kurniawan
            'jenis' => 'izin',
            'tanggal_mulai' => now()->addDays(1)->toDateString(),
            'tanggal_selesai' => now()->addDays(1)->toDateString(),
            'alasan' => 'Pindah rumah',
            'status' => 'ditolak',
            'catatan_admin' => 'Harap memberikan pemberitahuan lebih awal',
        ]);
    }
}