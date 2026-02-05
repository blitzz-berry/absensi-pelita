<?php

namespace App\Exports;

use App\Models\Absensi; // Kita ambil data harian dari Absensi
use App\Models\User; // Untuk nama guru
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Biar bisa pake query builder
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapAbsensiGajiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    protected $bulan;
    protected $tahun;
    protected $rangeStart;
    protected $rangeEnd;
    protected $periodLabel;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->rangeStart = Carbon::create($tahun, $bulan, 15, 0, 0, 0, 'Asia/Jakarta');
        $this->rangeEnd = $this->rangeStart->copy()->addMonthNoOverflow()->setDay(16)->endOfDay();
        $this->periodLabel = $this->formatPeriode($this->rangeStart, $this->rangeEnd);
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
            ->whereBetween('tanggal', [$this->rangeStart->toDateString(), $this->rangeEnd->toDateString()])
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
            'Periode (15 - 16)',
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
        $bulanTahun = $this->periodLabel;

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
            $uangTransportHarian,
            $uangMakanHarian,
            $totalTransport,
            $totalMakan,
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

    public function columnFormats(): array
    {
        return [
            'C' => '0',
            'D' => '#,##0',
            'E' => '#,##0',
            'F' => '#,##0',
            'G' => '#,##0',
        ];
    }

    /**
     * Helper function untuk format bulan-tahun.
     */
    private function formatPeriode(Carbon $start, Carbon $end): string
    {
        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $startLabel = sprintf('%02d %s %d', $start->day, $namaBulan[$start->month] ?? $start->month, $start->year);
        $endLabel = sprintf('%02d %s %d', $end->day, $namaBulan[$end->month] ?? $end->month, $end->year);

        return $startLabel . ' - ' . $endLabel;
    }
}
