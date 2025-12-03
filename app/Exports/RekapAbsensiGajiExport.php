<?php

namespace App\Exports;

use App\Models\Absensi; // Kita ambil data harian dari Absensi
use App\Models\User; // Untuk nama guru
use Illuminate\Support\Facades\DB; // Biar bisa pake query builder
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapAbsensiGajiExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * Query data untuk di-export.
     * Ambil data rekap dari tabel absensi berdasarkan bulan dan tahun, group by user_id.
     * Hitung jumlah hadir per user.
     */
    public function query()
    {
        // Ambil semua user dengan role guru
        $guruQuery = User::where('role', 'guru');

        // Join dengan tabel absensi untuk bulan dan tahun tertentu
        // Hitung jumlah status 'hadir' per user
        $absensiQuery = Absensi::select([
                'user_id',
                DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as jumlah_hadir')
            ])
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->groupBy('user_id');

        // Gabungin query guru dengan query absensi
        // Ini akan nampilin semua guru, bahkan yang ga punya absensi di bulan itu (jumlah_hadir = 0)
        $finalQuery = $guruQuery
            ->leftJoinSub($absensiQuery, 'absensi_summary', function ($join) {
                $join->on('users.id', '=', 'absensi_summary.user_id');
            })
            ->select([
                'users.id as user_id', // Ambil ID user
                'users.nama', // Ambil nama user
                DB::raw($this->bulan . ' as bulan'), // Ambil bulan dari parameter
                DB::raw($this->tahun . ' as tahun'), // Ambil tahun dari parameter
                DB::raw('COALESCE(absensi_summary.jumlah_hadir, 0) as jumlah_hadir') // Ambil jumlah hadir, kalo null berarti 0
            ]);

        return $finalQuery;
    }

    /**
     * Header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Guru',
            'Periode (Bulan-Tahun)',
            'Jumlah Kehadiran',
            'Uang Transport Harian (Rp)',
            'Uang Makan Harian (Rp)',
            'Total Uang Transport (Rp)',
            'Total Uang Makan (Rp)',
        ];
    }

    /**
     * Mapping data dari query ke baris Excel.
     */
    public function map($row): array
    {
        // Format periode
        $bulanTahun = $this->formatBulanTahun($row->bulan, $row->tahun);

        // Jumlah hadir
        $jumlahHadir = (int) $row->jumlah_hadir; // Pastikan integer

        // Uang harian
        $uangTransportHarian = 12500;
        $uangMakanHarian = 10000;

        // Total
        $totalTransport = $jumlahHadir * $uangTransportHarian;
        $totalMakan = $jumlahHadir * $uangMakanHarian;

        return [
            $row->nama,
            $bulanTahun,
            $jumlahHadir,
            number_format($uangTransportHarian, 0, ',', '.'),
            number_format($uangMakanHarian, 0, ',', '.'),
            number_format($totalTransport, 0, ',', '.'),
            number_format($totalMakan, 0, ',', '.'),
        ];
    }

    /**
     * Styling untuk sheet Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header row
        ];
    }

    /**
     * Helper function untuk format bulan-tahun.
     */
    private function formatBulanTahun($bulan, $tahun)
    {
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        return ($namaBulan[$bulan] ?? $bulan) . ' ' . $tahun;
    }
}