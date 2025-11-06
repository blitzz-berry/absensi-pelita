<?php

namespace App\Exports;

use App\Models\RekapAbsensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapAbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RekapAbsensi::with('user')
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Guru',
            'Nomor ID',
            'Bulan',
            'Tahun',
            'Jumlah Hadir',
            'Jumlah Terlambat',
            'Jumlah Izin',
            'Jumlah Sakit',
            'Jumlah Alpha',
            'Total Kehadiran'
        ];
    }

    public function map($rekap): array
    {
        return [
            $rekap->user->nama ?? 'N/A',
            $rekap->user->nomor_id ?? 'N/A',
            $rekap->bulan,
            $rekap->tahun,
            $rekap->jumlah_hadir,
            $rekap->jumlah_terlambat,
            $rekap->jumlah_izin,
            $rekap->jumlah_sakit,
            $rekap->jumlah_alpha,
            $rekap->jumlah_hadir + $rekap->jumlah_terlambat + $rekap->jumlah_izin + $rekap->jumlah_sakit + $rekap->jumlah_alpha
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]] // Header row
        ];
    }
}