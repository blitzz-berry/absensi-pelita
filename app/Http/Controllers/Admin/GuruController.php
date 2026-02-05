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
    public function petaKehadiran(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Ambil tanggal dari request atau default ke tanggal saat ini
        $tanggal = $request->tanggal ?? date('Y-m-d');

        // Ambil total guru
        $totalGuru = User::where('role', 'guru')->count();

        // Hitung kehadiran berdasarkan status untuk tanggal tertentu
        $jumlahHadir = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'hadir')
            ->count();

        $jumlahTerlambat = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'terlambat')
            ->count();

        $jumlahIzin = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'izin')
            ->count();

        $jumlahSakit = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'sakit')
            ->count();

        // Jumlah alpha (tidak hadir)
        $jumlahAlpha = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'alpha')
            ->count();

        // Jumlah yang tidak hadir secara keseluruhan (guru yang tidak absen sama sekali + status alpha)
        // Hitung jumlah guru yang tidak memiliki absensi sama sekali pada tanggal tersebut
        $idsGuruAbsen = \App\Models\Absensi::where('tanggal', $tanggal)
            ->pluck('user_id');

        $jumlahTidakHadir = ($totalGuru - $idsGuruAbsen->count()) + $jumlahAlpha;

        return view('admin.peta-kehadiran', [
            'currentUser' => $user,
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'jumlahTidakHadir' => $jumlahTidakHadir,
            'tanggal' => $tanggal
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
        
        // Ambil semua pengajuan izin dengan informasi guru dan informasi approval, diurutkan berdasarkan tanggal terbaru
        $pengajuanIzin = \App\Models\Izin::with(['user', 'approvedBy'])
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
     * Get kehadiran harian untuk tanggal tertentu (untuk polling AJAX).
     */
    public function getKehadiranHarian(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tanggal = $request->tanggal ?? date('Y-m-d');

        // Ambil total guru
        $totalGuru = User::where('role', 'guru')->count();

        // Hitung kehadiran berdasarkan status untuk tanggal tertentu
        $jumlahHadir = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'hadir')
            ->count();

        $jumlahTerlambat = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'terlambat')
            ->count();

        $jumlahIzin = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'izin')
            ->count();

        $jumlahSakit = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'sakit')
            ->count();

        // Jumlah alpha (tidak hadir)
        $jumlahAlpha = \App\Models\Absensi::where('tanggal', $tanggal)
            ->where('status', 'alpha')
            ->count();

        // Jumlah yang tidak hadir secara keseluruhan (guru yang tidak absen sama sekali + status alpha)
        // Hitung jumlah guru yang tidak memiliki absensi sama sekali pada tanggal tersebut
        $idsGuruAbsen = \App\Models\Absensi::where('tanggal', $tanggal)
            ->pluck('user_id');

        $jumlahTidakHadir = ($totalGuru - $idsGuruAbsen->count()) + $jumlahAlpha;

        return response()->json([
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'jumlahTidakHadir' => $jumlahTidakHadir,
            'tanggal' => $tanggal
        ]);
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

        // Prepare update data
        $updateData = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin ?? null,
        ];

        // If the status is approved or rejected, add approval information
        if (in_array($request->status, ['disetujui', 'ditolak'])) {
            $updateData['approved_by'] = $user->id;
            $updateData['approved_at'] = now();
            $updateData['admin_notes'] = $request->catatan_admin ?? null;
        }

        $izin->update($updateData);

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
     * Tampilkan bukti izin dari storage tanpa symlink public.
     */
    public function showIzinBukti(string $filename)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $safeName = basename($filename);
        $path = 'izin_files/' . $safeName;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);
        $mime = Storage::disk('public')->mimeType($path) ?? 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mime,
        ]);
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

        $izin = Izin::with(['user', 'approvedBy'])->findOrFail($id);

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
                'approved_by' => $izin->approvedBy ? $izin->approvedBy->nama : null,
                'approved_by_email' => $izin->approvedBy ? $izin->approvedBy->email : null,
                'approved_at' => $izin->approved_at,
                'approved_at_formatted' => $izin->approved_at ? \Carbon\Carbon::parse($izin->approved_at)->format('d M Y H:i') : null,
                'admin_notes' => $izin->admin_notes,
                'created_at' => $izin->created_at,
                'created_at_formatted' => \Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i'),
            ]
        ];

        return response()->json(['success' => true, 'izin' => $data['izin']]);
    }

    /**
     * Display rekap absensi harian.
     */
    public function rekapAbsensi(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Ambil tanggal dari request atau default ke tanggal saat ini
        $tanggal = $request->get('tanggal', date('Y-m-d'));

        // Ambil data absensi untuk tanggal tertentu, termasuk data user
        $absensi_harian_collection = \App\Models\Absensi::with('user')
            ->where('tanggal', $tanggal)
            ->get();

        // Ambil semua guru dan lakukan paginasi (10 per halaman)
        $guru_paginator = User::where('role', 'guru')->paginate(10);

        // Ambil hanya user_id dari guru pada halaman saat ini
        $userIdsOnCurrentPage = $guru_paginator->pluck('id');

        // Filter koleksi absensi hanya untuk user pada halaman saat ini
        $filtered_absensi_collection = $absensi_harian_collection->whereIn('user_id', $userIdsOnCurrentPage);

        // Indeks koleksi absensi yang difilter berdasarkan user_id untuk pencarian cepat di view
        $absensi_harian = $filtered_absensi_collection->keyBy('user_id');

        return view('admin.rekap-absensi', [
            'guru' => $guru_paginator, // Ganti dengan $guru_paginator
            'absensi_harian' => $absensi_harian,
            'tanggal' => $tanggal,
            // 'rekap_absensi', 'bulan', 'tahun' tidak lagi dikirim
            'currentUser' => $user
        ]);
    }


    /**
     * Generate rekap absensi untuk bulan dan tahun tertentu (tanpa redirect)
     */
    private function generateRekapForMonth($bulan, $tahun)
    {
        $rangeStart = \Carbon\Carbon::create($tahun, $bulan, 15, 0, 0, 0, 'Asia/Jakarta');
        $rangeEnd = $rangeStart->copy()->addMonthNoOverflow()->setDay(16)->endOfDay();

        // Ambil semua guru
        $guru = User::where('role', 'guru')->get();
        
        foreach ($guru as $g) {
            // Hitung jumlah kehadiran per status untuk bulan dan tahun tertentu
            $absensi = \App\Models\Absensi::where('user_id', $g->id)
                ->whereBetween('tanggal', [$rangeStart->toDateString(), $rangeEnd->toDateString()])
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
        
        $this->generateRekapForMonth($bulan, $tahun);
        
        return redirect()->route('admin.rekap-absensi')->with('success', 'Rekap absensi berhasil dibuat');
    }
    
    
    /**
     * Export rekap absensi to Excel (Global - All Users).
     * This will also generate the recap if it doesn't exist for the selected month/year.
     */
    public function exportExcelGlobal(Request $request)
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

        $this->generateRekapForMonth($bulan, $tahun);

        // Use Excel facade to download
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapAbsensiExport($bulan, $tahun),
            'rekap-absensi-'.$bulan.'-'.$tahun.'.xlsx'
        );
    }

    /**
     * Export rekap absensi gaji (Uang Transport & Makan) to Excel (Global - All Users).
     * This will calculate based on daily allowance and attendance count.
     * This also generates the recap if it doesn't exist for the selected month/year.
     */
    public function exportExcelGajiGlobal(Request $request)
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

        $this->generateRekapForMonth($bulan, $tahun);

        // Use Excel facade to download using the new export class
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapAbsensiGajiExport($bulan, $tahun),
            'rekap-gaji-absensi-'.$bulan.'-'.$tahun.'.xlsx'
        );
    }


    /**
     * Export absensi harian to Excel for a specific user.
     * Expects 'tanggal' as a query parameter.
     */
    public function exportExcelPerGuru(Request $request, $user_id)
    {
        $admin = auth()->user();
        if ($admin->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $tanggal = $request->query('tanggal');

        if (!$tanggal) {
             return redirect()->back()->with('error', 'Tanggal wajib disertakan untuk export harian.');
        }

        // Validasi apakah user_id adalah guru
        $guru = User::where('id', $user_id)->where('role', 'guru')->firstOrFail();

        // Ambil data absensi harian untuk guru dan tanggal tertentu
        $absensi_harian = \App\Models\Absensi::where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first(); // Bisa null jika tidak absen

        // Check if maatwebsite/excel is available
        if (!class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return redirect()->back()->with('error', 'Excel export package not installed. Please run: composer require maatwebsite/excel');
        }

        // Kita buat anonymous class untuk export data harian
        $exportClass = new class($guru, $absensi_harian, $tanggal) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
        {
            private $guru;
            private $absensi;
            private $tanggal;

            public function __construct($guru, $absensi, $tanggal)
            {
                $this->guru = $guru;
                $this->absensi = $absensi;
                $this->tanggal = $tanggal;
            }

            public function collection()
            {
                // Return collection dengan satu baris data
                $rowData = [
                     'Nama' => $this->guru->nama,
                     'Nomor ID' => $this->guru->nomor_id,
                     'Tanggal' => $this->tanggal, // Gunakan tanggal dari request
                     'Status' => $this->absensi ? $this->absensi->status : 'Belum Absen',
                     'Jam Masuk' => $this->absensi ? $this->absensi->jam_masuk : '-',
                     'Jam Pulang' => $this->absensi ? $this->absensi->jam_pulang : '-',
                     'Lokasi Masuk' => $this->absensi ? $this->absensi->lokasi_masuk : '-',
                     'Lokasi Pulang' => $this->absensi ? $this->absensi->lokasi_pulang : '-',
                 ];
                return collect([$rowData]);
            }

            public function headings(): array
            {
                return [
                    'Nama Guru',
                    'Nomor ID',
                    'Tanggal',
                    'Status',
                    'Jam Masuk',
                    'Jam Pulang',
                    'Lokasi Masuk',
                    'Lokasi Pulang'
                ];
            }

            public function title(): string
            {
                return 'Absensi ' . $this->guru->nama;
            }
        };

        $namaGuru = \Str::slug($guru->nama, '_');
        return \Maatwebsite\Excel\Facades\Excel::download($exportClass, 'absensi-harian-'.$namaGuru.'-'.$tanggal.'.xlsx');
    }

    /**
     * Get lokasi kehadiran guru untuk tanggal tertentu (untuk peta kehadiran).
     */
    public function getLokasiKehadiran(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tanggal = $request->tanggal ?? date('Y-m-d');
        $status = $request->status ?? null; // Filter berdasarkan status kehadiran
        $scope = $request->get('scope', 'tanggal');

        // Ambil data absensi dengan lokasi untuk tanggal tertentu
        $query = \App\Models\Absensi::with('user:id,nama,gelar,jabatan')
            ->whereHas('user', function ($q) {
                $q->where('role', 'guru');
            })
            ->where(function($q) {
                $q->where(function ($sub) {
                    $sub->whereNotNull('lokasi_masuk')
                        ->where('lokasi_masuk', '!=', '');
                })->orWhere(function ($sub) {
                    $sub->whereNotNull('lokasi_pulang')
                        ->where('lokasi_pulang', '!=', '');
                });
            })
            ->where(function ($q) {
                $q->whereNotNull('jam_masuk')
                    ->orWhereNotNull('jam_pulang');
            });

        if ($scope !== 'all') {
            $query->where('tanggal', $tanggal);
        }

        // Tambahkan filter status jika disediakan
        if ($status) {
            $query->where('status', $status);
        }

        $absensi = $query
            ->orderBy('tanggal', 'desc')
            ->orderByRaw('COALESCE(jam_pulang, jam_masuk) DESC')
            ->get();

        if ($scope === 'all') {
            $absensi = $absensi->groupBy('user_id')->map->first();
        }

        // Format data untuk peta
        $lokasiGuru = [];
        $parseLokasi = function ($lokasi) {
            if (!$lokasi) {
                return null;
            }
            $parts = array_map('trim', explode(',', $lokasi));
            if (count($parts) < 2) {
                return null;
            }
            $lat = filter_var($parts[0], FILTER_VALIDATE_FLOAT);
            $lng = filter_var($parts[1], FILTER_VALIDATE_FLOAT);
            if ($lat === false || $lng === false) {
                return null;
            }
            if (!is_finite($lat) || !is_finite($lng)) {
                return null;
            }
            return ['lat' => (float) $lat, 'lng' => (float) $lng];
        };

        foreach ($absensi as $item) {
            $user = $item->user;
            $namaLengkap = $user->gelar ? $user->nama . ' ' . $user->gelar : $user->nama;

            // Tambahkan lokasi masuk jika tersedia
            if ($item->lokasi_masuk) {
                $parsed = $parseLokasi($item->lokasi_masuk);
                if ($parsed) {
                    $lokasiGuru[] = [
                        'lat' => $parsed['lat'],
                        'lng' => $parsed['lng'],
                        'name' => $namaLengkap,
                        'status' => $item->status,
                        'time' => $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->timezone('Asia/Jakarta')->format('H:i') : '-',
                        'location_type' => 'masuk',
                        'jabatan' => $user->jabatan ?? '-'
                    ];
                }
            }

            // Tambahkan lokasi pulang jika tersedia dan berbeda dari lokasi masuk
            if ($item->lokasi_pulang && $item->lokasi_pulang !== $item->lokasi_masuk) {
                $parsed = $parseLokasi($item->lokasi_pulang);
                if ($parsed) {
                    $lokasiGuru[] = [
                        'lat' => $parsed['lat'],
                        'lng' => $parsed['lng'],
                        'name' => $namaLengkap,
                        'status' => $item->status,
                        'time' => $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->timezone('Asia/Jakarta')->format('H:i') : '-',
                        'location_type' => 'pulang',
                        'jabatan' => $user->jabatan ?? '-'
                    ];
                }
            }
        }

        return response()->json([
            'lokasi_guru' => $lokasiGuru,
            'tanggal' => $scope === 'all' ? null : $tanggal,
            'jumlah_total' => count($lokasiGuru)
        ]);
    }
}
