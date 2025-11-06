<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $bulan }}/{{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Absensi Guru</h1>
        <p>PLUS Pelita Insani</p>
        <p>Bulan: {{ \Carbon\Carbon::create()->month($bulan)->format('F') }}, Tahun: {{ $tahun }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Nama Guru</th>
                <th>Nomor ID</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap_absensi as $rekap)
            <tr>
                <td>{{ $rekap->user->nama ?? 'N/A' }}</td>
                <td>{{ $rekap->user->nomor_id ?? 'N/A' }}</td>
                <td>{{ $rekap->jumlah_hadir }}</td>
                <td>{{ $rekap->jumlah_terlambat }}</td>
                <td>{{ $rekap->jumlah_izin }}</td>
                <td>{{ $rekap->jumlah_sakit }}</td>
                <td>{{ $rekap->jumlah_alpha }}</td>
                <td>{{ $rekap->jumlah_hadir + $rekap->jumlah_terlambat + $rekap->jumlah_izin + $rekap->jumlah_sakit + $rekap->jumlah_alpha }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2">TOTAL</td>
                <td>{{ $rekap_absensi->sum('jumlah_hadir') }}</td>
                <td>{{ $rekap_absensi->sum('jumlah_terlambat') }}</td>
                <td>{{ $rekap_absensi->sum('jumlah_izin') }}</td>
                <td>{{ $rekap_absensi->sum('jumlah_sakit') }}</td>
                <td>{{ $rekap_absensi->sum('jumlah_alpha') }}</td>
                <td>{{ $rekap_absensi->sum(function($item) {
                    return $item->jumlah_hadir + $item->jumlah_terlambat + $item->jumlah_izin + $item->jumlah_sakit + $item->jumlah_alpha;
                }) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>