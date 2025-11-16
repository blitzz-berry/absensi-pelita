<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RekapAbsensi;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = User::where('role', 'guru');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_id', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%");
            });
        }

        $guru = $query->paginate(10);
        $guru->appends(['search' => $request->search]); // Menyimpan parameter pencarian saat paginasi

        return view('admin.data-guru', ['guru' => $guru, 'currentUser' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        return view('admin.create-guru', ['currentUser' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'nomor_id' => 'required|unique:users,nomor_id',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nomor_telepon' => 'required|string|max:15',
            'jabatan' => 'nullable|string|max:255',
            'gelar' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        User::create([
            'nomor_id' => $request->nomor_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'nomor_telepon' => $request->nomor_telepon,
            'jabatan' => $request->jabatan,
            'gelar' => $request->gelar,
        ]);

        return redirect()->route('admin.data-guru')->with('success', 'Guru berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        $guru = User::findOrFail($id);
        return view('admin.edit-guru', ['guru' => $guru, 'currentUser' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $guru = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nomor_id' => 'required|unique:users,nomor_id,'.$id,
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
            'nomor_telepon' => 'required|string|max:15',
            'jabatan' => 'nullable|string|max:255',
            'gelar' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [
            'nomor_id' => $request->nomor_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'jabatan' => $request->jabatan,
            'gelar' => $request->gelar,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('admin.data-guru')->with('success', 'Guru berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.data-guru')->with('success', 'Guru berhasil dihapus');
    }

    /**
     * Display peta kehadiran.
     */
    public function petaKehadiran()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        return view('admin.peta-kehadiran', [
            'currentUser' => $user
        ]);
    }

    /**
     * Display pengajuan izin.
     */
    public function pengajuanIzin()
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil semua pengajuan izin dengan informasi guru, diurutkan berdasarkan tanggal terbaru
        $pengajuanIzin = \App\Models\Izin::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pengajuan-izin', [
            'currentUser' => $user,
            'pengajuanIzin' => $pengajuanIzin
        ]);
    }

    /**
     * Store a newly created pengajuan izin in storage.
     */
    public function storePengajuanIzin(Request $request)
    {
        $user = auth()->user();
        // Dalam konteks admin, mungkin admin ingin mengajukan izin untuk guru tertentu
        // atau mungkin seharusnya fungsi ini hanya tersedia untuk guru
        // Sesuaikan dengan kebutuhan - untuk sekarang saya asumsikan ini untuk guru yang login

        $request->validate([
            'jenis_pengajuan' => 'required|in:izin,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'bukti_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload if exists
        $fileName = null;
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('izin_files', $fileName, 'public');
        }

        // Create the izin record
        Izin::create([
            'user_id' => $user->id, // Untuk pengajuan izin, user_id adalah guru yang mengajukan
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'bukti_file' => $fileName,
            'status' => 'diajukan', // Default status
        ]);

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan izin berhasil diajukan'
            ]);
        }

        return redirect()->route('admin.pengajuan-izin')->with('success', 'Pengajuan izin berhasil diajukan');
    }

    /**
     * Update status pengajuan izin (setujui/tolak).
     */
    public function updateStatusIzin(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $izin = Izin::with('user')->findOrFail($id);
        
        // Cek apakah izin sudah memiliki status akhir (disetujui/ditolak)
        if ($izin->status !== 'diajukan') {
            return response()->json(['success' => false, 'message' => 'Pengajuan izin ini sudah diproses sebelumnya.'], 400);
        }

        $izin->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin ?? null,
        ]);

        // Jika izin disetujui, update status di tabel absensi sesuai tanggal izin
        if ($request->status === 'disetujui') {
            $this->updateAbsensiForIzin($izin);
        }

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Status pengajuan izin berhasil diperbarui'
            ]);
        }

        // For non-AJAX requests, redirect back
        return redirect()->back()->with('success', 'Status pengajuan izin berhasil diperbarui');
    }
    
    /**
     * Update status di tabel absensi sesuai tanggal izin
     */
    private function updateAbsensiForIzin($izin)
    {
        $userId = $izin->user_id;
        $tanggalMulai = \Carbon\Carbon::parse($izin->tanggal_mulai);
        $tanggalSelesai = \Carbon\Carbon::parse($izin->tanggal_selesai);
        $jenisIzin = $izin->jenis; // 'izin' atau 'sakit'
        
        // Update status absensi untuk setiap tanggal dalam rentang izin
        $currentDate = $tanggalMulai->copy();
        while ($currentDate->lte($tanggalSelesai)) {
            $absensi = \App\Models\Absensi::firstOrCreate(
                [
                    'user_id' => $userId,
                    'tanggal' => $currentDate->toDateString(),
                ],
                [
                    'status' => $jenisIzin, // 'izin' atau 'sakit'
                ]
            );
            
            // Jika absensi sudah ada dan statusnya belum sesuai izin, update
            if ($absensi->jam_masuk === null && $absensi->jam_pulang === null) {
                $absensi->update(['status' => $jenisIzin]);
            }
            
            $currentDate->addDay();
        }
        
        // Perbarui rekap absensi setelah perubahan
        $this->updateRekapAbsensiForUser($userId, $tanggalMulai->month, $tanggalMulai->year);
        
        // Jika bulan berbeda antara tanggal mulai dan selesai, update juga bulan kedua
        if ($tanggalMulai->month !== $tanggalSelesai->month || $tanggalMulai->year !== $tanggalSelesai->year) {
            $this->updateRekapAbsensiForUser($userId, $tanggalSelesai->month, $tanggalSelesai->year);
        }
    }
    
    /**
     * Update rekap absensi untuk pengguna pada bulan dan tahun tertentu
     */
    private function updateRekapAbsensiForUser($userId, $bulan, $tahun)
    {
        // Ambil data absensi untuk bulan dan tahun ini
        $absensi_bulanan = \App\Models\Absensi::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
        
        // Hitung jumlah per status
        $jumlah_hadir = $absensi_bulanan->where('status', 'hadir')->count();
        $jumlah_terlambat = $absensi_bulanan->where('status', 'terlambat')->count();
        $jumlah_izin = $absensi_bulanan->where('status', 'izin')->count();
        $jumlah_sakit = $absensi_bulanan->where('status', 'sakit')->count();
        $jumlah_alpha = $absensi_bulanan->where('status', 'alpha')->count();
        
        // Cek apakah sudah ada rekap untuk bulan dan tahun ini
        $rekap = \App\Models\RekapAbsensi::where('user_id', $userId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
        
        if ($rekap) {
            // Update jika sudah ada
            $rekap->update([
                'jumlah_hadir' => $jumlah_hadir,
                'jumlah_terlambat' => $jumlah_terlambat,
                'jumlah_izin' => $jumlah_izin,
                'jumlah_sakit' => $jumlah_sakit,
                'jumlah_alpha' => $jumlah_alpha,
            ]);
        } else {
            // Buat baru jika belum ada
            \App\Models\RekapAbsensi::create([
                'user_id' => $userId,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_hadir' => $jumlah_hadir,
                'jumlah_terlambat' => $jumlah_terlambat,
                'jumlah_izin' => $jumlah_izin,
                'jumlah_sakit' => $jumlah_sakit,
                'jumlah_alpha' => $jumlah_alpha,
            ]);
        }
    }

    /**
     * Get detail izin for AJAX request.
     */
    public function getDetailIzin($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $izin = Izin::with('user')->findOrFail($id);
        
        // Format data for response
        $data = [
            'izin' => [
                'id' => $izin->id,
                'user' => [
                    'nama' => $izin->user->nama,
                    'nomor_id' => $izin->user->nomor_id,
                ],
                'jenis_pengajuan' => $izin->jenis_pengajuan,
                'jenis_pengajuan_formatted' => ucfirst($izin->jenis_pengajuan),
                'tanggal_mulai' => $izin->tanggal_mulai,
                'tanggal_mulai_formatted' => \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y'),
                'tanggal_selesai' => $izin->tanggal_selesai,
                'tanggal_selesai_formatted' => \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y'),
                'durasi' => \Carbon\Carbon::parse($izin->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($izin->tanggal_selesai)) + 1,
                'alasan' => $izin->alasan,
                'bukti_file' => $izin->bukti_file,
                'status' => $izin->status,
                'status_formatted' => ucfirst($izin->status),
                'catatan_admin' => $izin->catatan_admin,
                'created_at' => $izin->created_at,
                'created_at_formatted' => \Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i'),
            ]
        ];

        return response()->json(['success' => true, 'izin' => $data['izin']]);
    }

    /**
     * Display rekap absensi.
     */
    public function rekapAbsensi(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil semua guru
        $guru = User::where('role', 'guru')->get();
        
        // Ambil data absensi terbaru
        $absensi = \App\Models\Absensi::with('user')->get();
        
        // Ambil data rekap absensi (menggunakan query parameter atau default ke bulan ini)
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Selalu perbarui rekap absensi sebelum menampilkan
        $this->generateRekapForMonth($bulan, $tahun);
        
        $rekap_absensi = \App\Models\RekapAbsensi::with('user')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        return view('admin.rekap-absensi', [
            'guru' => $guru,
            'absensi' => $absensi,
            'rekap_absensi' => $rekap_absensi,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'currentUser' => $user
        ]);
    }


    /**
     * Generate rekap absensi untuk bulan dan tahun tertentu (tanpa redirect)
     */
    private function generateRekapForMonth($bulan, $tahun)
    {
        // Ambil semua guru
        $guru = User::where('role', 'guru')->get();
        
        foreach ($guru as $g) {
            // Hitung jumlah kehadiran per status untuk bulan dan tahun tertentu
            $absensi = \App\Models\Absensi::where('user_id', $g->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
            
            // Hitung jumlah per status
            $jumlah_hadir = $absensi->where('status', 'hadir')->count();
            $jumlah_terlambat = $absensi->where('status', 'terlambat')->count();
            $jumlah_izin = $absensi->where('status', 'izin')->count();
            $jumlah_sakit = $absensi->where('status', 'sakit')->count();
            $jumlah_alpha = $absensi->where('status', 'alpha')->count();
            
            // Cek apakah sudah ada rekap untuk bulan dan tahun ini
            $rekap = \App\Models\RekapAbsensi::where('user_id', $g->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            
            if ($rekap) {
                // Update jika sudah ada
                $rekap->update([
                    'jumlah_hadir' => $jumlah_hadir,
                    'jumlah_terlambat' => $jumlah_terlambat,
                    'jumlah_izin' => $jumlah_izin,
                    'jumlah_sakit' => $jumlah_sakit,
                    'jumlah_alpha' => $jumlah_alpha,
                ]);
            } else {
                // Buat baru jika belum ada
                \App\Models\RekapAbsensi::create([
                    'user_id' => $g->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jumlah_hadir' => $jumlah_hadir,
                    'jumlah_terlambat' => $jumlah_terlambat,
                    'jumlah_izin' => $jumlah_izin,
                    'jumlah_sakit' => $jumlah_sakit,
                    'jumlah_alpha' => $jumlah_alpha,
                ]);
            }
        }
    }

    /**
     * Generate rekap absensi bulanan.
     */
    public function generateRekap(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        
        // Ambil semua guru
        $guru = User::where('role', 'guru')->get();
        
        foreach ($guru as $g) {
            // Hitung jumlah kehadiran per status untuk bulan dan tahun tertentu
            $absensi = \App\Models\Absensi::where('user_id', $g->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
            
            // Hitung jumlah per status
            $jumlah_hadir = $absensi->where('status', 'hadir')->count();
            $jumlah_terlambat = $absensi->where('status', 'terlambat')->count();
            $jumlah_izin = $absensi->where('status', 'izin')->count();
            $jumlah_sakit = $absensi->where('status', 'sakit')->count();
            $jumlah_alpha = $absensi->where('status', 'alpha')->count();
            
            // Cek apakah sudah ada rekap untuk bulan dan tahun ini
            $rekap = \App\Models\RekapAbsensi::where('user_id', $g->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            
            if ($rekap) {
                // Update jika sudah ada
                $rekap->update([
                    'jumlah_hadir' => $jumlah_hadir,
                    'jumlah_terlambat' => $jumlah_terlambat,
                    'jumlah_izin' => $jumlah_izin,
                    'jumlah_sakit' => $jumlah_sakit,
                    'jumlah_alpha' => $jumlah_alpha,
                ]);
            } else {
                // Buat baru jika belum ada
                \App\Models\RekapAbsensi::create([
                    'user_id' => $g->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jumlah_hadir' => $jumlah_hadir,
                    'jumlah_terlambat' => $jumlah_terlambat,
                    'jumlah_izin' => $jumlah_izin,
                    'jumlah_sakit' => $jumlah_sakit,
                    'jumlah_alpha' => $jumlah_alpha,
                ]);
            }
        }
        
        return redirect()->route('admin.rekap-absensi')->with('success', 'Rekap absensi berhasil dibuat');
    }
    
    /**
     * Export rekap absensi to PDF
     */
    public function exportPDF(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $rekap_absensi = \App\Models\RekapAbsensi::with('user')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();
        
        // Check if dompdf is available
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->back()->with('error', 'PDF export package not installed. Please run: composer require barryvdh/laravel-dompdf');
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.rekap-absensi-pdf', [
            'rekap_absensi' => $rekap_absensi,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        
        return $pdf->download('rekap-absensi-'.$bulan.'-'.$tahun.'.pdf');
    }
    
    /**
     * Export rekap absensi to Excel
     */
    public function exportExcel(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        // Check if maatwebsite/excel is available
        if (!class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return redirect()->back()->with('error', 'Excel export package not installed. Please run: composer require maatwebsite/excel');
        }
        
        // Use Excel facade to download
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapAbsensiExport($bulan, $tahun), 
            'rekap-absensi-'.$bulan.'-'.$tahun.'.xlsx'
        );
    }
}