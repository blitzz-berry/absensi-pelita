<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Setting;
use App\Models\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil setting jam masuk batas
        $setting = Setting::first();
        $jam_masuk_batas = $setting ? $setting->jam_masuk_batas : '08:00:00'; // Default jam masuk batas
        
        // Hitung jumlah total guru
        $totalGuru = User::where('role', 'guru')->count();
        
        $today = Carbon::today();
        
        // Hitung jumlah guru yang hadir hari ini (sudah absen masuk, mungkin atau tidak sudah absen pulang)
        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->whereHas('user', function($query) {
                $query->where('role', 'guru');
            })
            ->whereNotNull('jam_masuk')
            ->count();
        
        // Hitung jumlah guru terlambat hari ini (sudah absen masuk tapi lewat dari jam masuk batas)
        $terlambatHariIni = Absensi::whereDate('tanggal', $today)
            ->whereHas('user', function($query) {
                $query->where('role', 'guru');
            })
            ->whereNotNull('jam_masuk')
            ->whereRaw("TIME(jam_masuk) > ?", [$jam_masuk_batas])
            ->count();
        
        // Hitung jumlah guru izin/sakit hari ini
        $izinHariIni = Izin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->whereHas('user', function($query) {
                $query->where('role', 'guru');
            })
            ->whereIn('status', ['disetujui', 'diajukan'])
            ->count();
        
        // Hitung data kehadiran minggu ini (7 hari terakhir)
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        
        $kehadiranMingguIni = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $tanggal = $date->format('Y-m-d');
            
            $jumlahHadir = Absensi::whereDate('tanggal', $tanggal)
                ->whereHas('user', function($query) {
                    $query->where('role', 'guru');
                })
                ->whereNotNull('jam_masuk')
                ->count();
                
            $kehadiranMingguIni[] = [
                'tanggal' => $date->format('l'), // Nama hari
                'jumlah' => $jumlahHadir,
                'tanggal_pendek' => $date->format('d M') // Tanggal pendek
            ];
        }
        
        // Hitung persentase kehadiran keseluruhan
        $totalAbsensi = Absensi::whereHas('user', function($query) {
            $query->where('role', 'guru');
        })->count();
        
        $totalHariKerja = Absensi::selectRaw('COUNT(DISTINCT tanggal) as hari')
            ->whereHas('user', function($query) {
                $query->where('role', 'guru');
            })
            ->first()->hari ?? 0;
            
        $totalKehadiranPotensial = $totalGuru * $totalHariKerja;
        $persentaseKehadiran = $totalKehadiranPotensial > 0 ? round(($totalAbsensi / $totalKehadiranPotensial) * 100, 2) : 0;
        
        // Data untuk pie chart (presentase vs alpha)
        $totalAlpha = ($totalGuru * $totalHariKerja) - $totalAbsensi;
        
        // Ambil log aktivitas terbaru
        $logAktivitas = Log::with('user') // Menyertakan relasi ke model User
            ->latest('waktu')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', [
            'user' => $user,
            'totalGuru' => $totalGuru,
            'hadirHariIni' => $hadirHariIni,
            'terlambatHariIni' => $terlambatHariIni,
            'izinHariIni' => $izinHariIni,
            'kehadiranMingguIni' => $kehadiranMingguIni,
            'persentaseKehadiran' => $persentaseKehadiran,
            'totalAbsensi' => $totalAbsensi,
            'totalAlpha' => $totalAlpha,
            'logAktivitas' => $logAktivitas
        ]);
    }
}