<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Setting;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruAbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil data absensi hari ini
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        // Ambil 4 riwayat absensi terakhir
        $riwayat_absensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(4)
            ->get();
        
        return view('guru.dashboard', [
            'user' => $user,
            'absensi_hari_ini' => $absensi_hari_ini,
            'riwayat_absensi' => $riwayat_absensi,
            'waktu_sekarang' => $waktu_sekarang
        ]);
    }
    
    public function getAttendanceStatus()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        // Ambil 4 riwayat absensi terbaru
        $riwayat_absensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(4)
            ->get();
        
        return response()->json([
            'absensi_hari_ini' => $absensi_hari_ini ? $absensi_hari_ini->toArray() : null,
            'riwayat_absensi' => $riwayat_absensi->toArray(),
            'waktu_sekarang' => $waktu_sekarang->toIso8601String()
        ]);
    }

    public function absenMasuk(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            
            // Validasi input
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'lokasi' => 'required|string',
            ]);
            
            // Ambil setting waktu absen
            $setting = Setting::first();
            $waktu_sekarang = Carbon::now('Asia/Jakarta');
            
            // Cek apakah sudah absen masuk hari ini
            $absensi_hari_ini = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $waktu_sekarang->toDateString())
                ->first();
                
            if ($absensi_hari_ini && $absensi_hari_ini->jam_masuk) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen masuk hari ini'
                ], 400);
            }
            
            // Proses upload foto dengan validasi lengkap
            $foto_path = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                
                // Validasi file valid
                if (!$foto->isValid()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'File foto tidak valid'
                    ], 400);
                }
                
                $foto_name = 'foto_selfie_masuk_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
                $foto_path = $foto->storeAs('absensi', $foto_name, 'public');
                
                // Cek apakah upload berhasil
                if (!$foto_path) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menyimpan foto'
                    ], 500);
                }
            }
            
            // Simpan data absensi
            $waktu_absen = $waktu_sekarang->toTimeString();
            $tanggal_absen = $waktu_sekarang->toDateString();
            
            // Tentukan status berdasarkan waktu
            $status = 'hadir';
            $jam_masuk_batas = $setting ? $setting->jam_masuk_batas : '08:00:00';
            if ($waktu_absen > $jam_masuk_batas) {
                $status = 'terlambat';
            }
            
            // Simpan atau update data absensi
            $absensi = Absensi::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $tanggal_absen,
                ],
                [
                    'jam_masuk' => $waktu_absen,
                    'status' => $status,
                    'lokasi_masuk' => $request->lokasi,
                    'foto_selfie_masuk' => $foto_path,
                ]
            );
            
            // Perbarui rekap absensi
            $this->updateRekapAbsensi($user->id, $tanggal_absen);
            
            // Simpan log aktivitas
            Log::create([
                'user_id' => $user->id,
                'aktivitas' => 'Absen Masuk',
                'waktu' => $waktu_sekarang,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil',
                'data' => [
                    'absensi' => $absensi,
                    'status' => $status
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error absen masuk: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat absen masuk'
            ], 500);
        }
    }

    public function absenPulang(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            
            // Validasi input
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'lokasi' => 'required|string',
            ]);
            
            $waktu_sekarang = Carbon::now('Asia/Jakarta');
            
            // Cek apakah sudah absen pulang hari ini
            $absensi_hari_ini = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $waktu_sekarang->toDateString())
                ->first();
                
            if (!$absensi_hari_ini || !$absensi_hari_ini->jam_masuk) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum absen masuk hari ini'
                ], 400);
            }
            
            if ($absensi_hari_ini->jam_pulang) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen pulang hari ini'
                ], 400);
            }
            
            // Proses upload foto dengan validasi lengkap
            $foto_path = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                
                // Validasi file valid
                if (!$foto->isValid()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'File foto tidak valid'
                    ], 400);
                }
                
                $foto_name = 'foto_selfie_pulang_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
                $foto_path = $foto->storeAs('absensi', $foto_name, 'public');
                
                // Cek apakah upload berhasil
                if (!$foto_path) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menyimpan foto'
                    ], 500);
                }
            }
            
            // Update data absensi
            $absensi_hari_ini->update([
                'jam_pulang' => $waktu_sekarang->toTimeString(),
                'lokasi_pulang' => $request->lokasi,
                'foto_selfie_pulang' => $foto_path,
            ]);
            
            // Perbarui rekap absensi
            $this->updateRekapAbsensi($user->id, $waktu_sekarang->toDateString());
            
            // Simpan log aktivitas
            Log::create([
                'user_id' => $user->id,
                'aktivitas' => 'Absen Pulang',
                'waktu' => $waktu_sekarang,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Absen pulang berhasil',
                'data' => [
                    'absensi' => $absensi_hari_ini
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error absen pulang: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat absen pulang'
            ], 500);
        }
    }
    
    /**
     * Memperbarui rekap absensi untuk pengguna pada tanggal tertentu
     */
    private function updateRekapAbsensi($userId, $tanggal)
    {
        $tanggalObj = Carbon::parse($tanggal)->timezone('Asia/Jakarta');
        $bulan = $tanggalObj->month;
        $tahun = $tanggalObj->year;
        
        // Ambil data absensi lengkap untuk hari tersebut untuk menghitung status yang benar
        $absensi_harian = Absensi::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->first();
        
        // Jika tidak ada data absensi harian, keluar dari fungsi
        if (!$absensi_harian) {
            return;
        }
        
        // Gunakan status dari data absensi harian
        $status = $absensi_harian->status;
        
        // Hitung ulang semua status absensi untuk bulan dan tahun ini
        $absensi_bulanan = Absensi::where('user_id', $userId)
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
            // Update semua jumlah berdasarkan perhitungan terbaru
            $rekap->update([
                'jumlah_hadir' => $jumlah_hadir,
                'jumlah_terlambat' => $jumlah_terlambat,
                'jumlah_izin' => $jumlah_izin,
                'jumlah_sakit' => $jumlah_sakit,
                'jumlah_alpha' => $jumlah_alpha,
            ]);
        } else {
            // Buat rekap baru jika belum ada
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
    
    public function absensiHarian()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil data absensi 7 hari terakhir
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $tanggal_mulai = $waktu_sekarang->copy()->subDays(6); // 7 hari termasuk hari ini
        
        $riwayat_absensi = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Ambil data absensi hari ini
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        return view('guru.absensi-harian', [
            'user' => $user,
            'absensi_hari_ini' => $absensi_hari_ini,
            'riwayat_absensi' => $riwayat_absensi,
            'waktu_sekarang' => $waktu_sekarang
        ]);
    }
    
    public function riwayatKehadiran()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil data absensi 30 hari terakhir
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $tanggal_mulai = $waktu_sekarang->copy()->subDays(29); // 30 hari termasuk hari ini
        
        // Ambil semua data absensi dari user ini
        $riwayat_absensi = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->paginate(10); // Gunakan pagination untuk menampilkan 10 data per halaman
        
        // Ambil data absensi hari ini
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        // Hitung ringkasan kehadiran
        $total_hadir = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->where('status', 'hadir')
            ->count();
        
        $total_terlambat = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->where('status', 'terlambat')
            ->count();
            
        $total_izin = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->where('status', 'izin')
            ->count();
            
        $total_sakit = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->where('status', 'sakit')
            ->count();
            
        $total_alpha = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggal_mulai->toDateString(), $waktu_sekarang->toDateString()])
            ->where('status', 'alpha')
            ->count();
        
        return view('guru.riwayat-kehadiran', [
            'user' => $user,
            'absensi_hari_ini' => $absensi_hari_ini,
            'riwayat_absensi' => $riwayat_absensi,
            'waktu_sekarang' => $waktu_sekarang,
            'total_hadir' => $total_hadir,
            'total_terlambat' => $total_terlambat,
            'total_izin' => $total_izin,
            'total_sakit' => $total_sakit,
            'total_alpha' => $total_alpha,
        ]);
    }
    
    public function lokasiSaya()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil data absensi hari ini
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        return view('guru.lokasi-saya', [
            'user' => $user,
            'absensi_hari_ini' => $absensi_hari_ini,
            'waktu_sekarang' => $waktu_sekarang
        ]);
    }
    
    public function izin()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        // Ambil data izin yang diajukan oleh guru ini
        $pengajuanIzin = \App\Models\Izin::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Ambil data absensi hari ini
        $waktu_sekarang = Carbon::now('Asia/Jakarta');
        $absensi_hari_ini = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $waktu_sekarang->toDateString())
            ->first();
        
        return view('guru.izin', [
            'user' => $user,
            'absensi_hari_ini' => $absensi_hari_ini,
            'pengajuanIzin' => $pengajuanIzin,
            'waktu_sekarang' => $waktu_sekarang
        ]);
    }
    
    public function storeIzin(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            if ($user->role !== 'guru') {
                abort(403, 'Unauthorized');
            }
            
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
                
                // Validasi file valid
                if (!$file->isValid()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'File bukti tidak valid'
                    ], 400);
                }
                
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('izin_files', $fileName, 'public');
                
                // Cek apakah upload berhasil
                if (!$filePath) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menyimpan file bukti'
                    ], 500);
                }
            }
            
            // Create the izin record
            $izin = \App\Models\Izin::create([
                'user_id' => $user->id,
                'jenis' => $request->jenis_pengajuan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'alasan' => $request->alasan,
                'bukti_file' => $fileName,
                'status' => 'diajukan', // Default status
            ]);
            
            DB::commit();
            
            // Return JSON response for AJAX requests or redirect for regular requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan izin berhasil diajukan'
                ]);
            }
            
            return redirect()->route('guru.izin')->with('success', 'Pengajuan izin berhasil diajukan');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error store izin: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengajukan izin'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengajukan izin');
        }
    }
    
    public function pengaturan()
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403, 'Unauthorized');
        }
        
        return view('guru.pengaturan', [
            'user' => $user
        ]);
    }
    
    /**
     * Helper method untuk delete old profile picture dengan error handling
     */
    private function deleteOldProfilePicture($filePath)
    {
        try {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return true;
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to delete old profile picture: ' . $e->getMessage());
        }
        return false;
    }
    
    /**
     * Helper method untuk handle profile update
     */
    private function handleProfileUpdate($user, $validatedData, $request)
    {
        $updateData = [];
        
        // Only update fields if they are provided and not empty in the request
        if (isset($validatedData['nama']) && !empty(trim($validatedData['nama']))) {
            $updateData['nama'] = $validatedData['nama'];
        }
        if (isset($validatedData['email']) && !empty(trim($validatedData['email']))) {
            $updateData['email'] = $validatedData['email'];
        }
        if (isset($validatedData['nomor_telepon'])) {
            $updateData['nomor_telepon'] = $validatedData['nomor_telepon'];
        }
        
        // Handle profile picture upload ONLY if a new file is provided
        if ($request->hasFile('foto_profile') && $request->file('foto_profile')->isValid()) {
            $foto = $request->file('foto_profile');
            
            $foto_name = 'profile_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto_path = $foto->storeAs('profile_pictures', $foto_name, 'public');
            
            if ($foto_path) {
                // Delete old profile picture ONLY if upload successful and new file exists
                if ($user->foto_profile) {
                    $this->deleteOldProfilePicture($user->foto_profile);
                }
                $updateData['foto_profile'] = $foto_path;
            } else {
                throw new \Exception('Gagal menyimpan file');
            }
        }
        // If no new photo uploaded, DO NOT touch existing photo
        
        // Update user data if provided
        if (!empty($updateData)) {
            $user->update($updateData);
        }
        
        return $updateData;
    }
    
    public function updateProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            if (!$user || $user->role !== 'guru') {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
                abort(403, 'Unauthorized');
            }
            
            // Handle form request (including file uploads)
            $rules = [];
            $messages = [
                'foto_profile.image' => 'File harus berupa gambar',
                'foto_profile.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'foto_profile.max' => 'Ukuran gambar maksimal 2MB',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
            ];
            
            // Only validate fields that are actually present in the request
            if ($request->has('nama') && !empty(trim($request->nama))) {
                $rules['nama'] = 'string|max:255';
            }
            
            if ($request->has('email') && !empty(trim($request->email))) {
                $rules['email'] = 'email|unique:users,email,' . $user->id;
            }
            
            if ($request->has('nomor_telepon')) {
                $rules['nomor_telepon'] = 'string|max:20';
            }
            
            if ($request->hasFile('foto_profile')) {
                $rules['foto_profile'] = 'image|mimes:jpeg,png,jpg|max:2048';
            }
            
            $validator = \Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                DB::rollBack();
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $validatedData = $validator->validated();
            
            // Use helper method untuk handle update
            $updateData = $this->handleProfileUpdate($user, $validatedData, $request);
            
            DB::commit();
            
            // Check if request wants JSON response (AJAX)
            if ($request->wantsJson()) {
                // Return photo URL in response if photo was updated
                $response = [
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui'
                ];
                
                if (isset($updateData['foto_profile'])) {
                    $response['foto_url'] = url('storage/' . $updateData['foto_profile']);
                }
                
                return response()->json($response);
            } else {
                // Redirect back with success message
                return redirect()->back()->with('profile_success', 'Profil berhasil diperbarui');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in updateProfile: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil');
        }
    }
    
    public function uploadFotoProfil(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            if (!$user || $user->role !== 'guru') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            // Validate file presence
            if (!$request->hasFile('foto_profile')) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada file yang diupload'
                ]);
            }
            
            $foto = $request->file('foto_profile');
            
            // Validate the file
            $validator = \Validator::make(['foto_profile' => $foto], [
                'foto_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'foto_profile.required' => 'File foto wajib diisi',
                'foto_profile.image' => 'File harus berupa gambar',
                'foto_profile.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'foto_profile.max' => 'Ukuran gambar maksimal 2MB'
            ]);
            
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            
            // Validasi file valid
            if (!$foto->isValid()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'File foto tidak valid'
                ]);
            }
            
            // Generate filename
            $foto_name = 'profile_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            
            // Store the file
            $foto_path = $foto->storeAs('profile_pictures', $foto_name, 'public');
            
            if (!$foto_path) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file'
                ]);
            }
            
            // Delete old profile picture if exists
            $this->deleteOldProfilePicture($user->foto_profile);
            
            // Update user's profile picture path
            $user->update([
                'foto_profile' => $foto_path
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diunggah',
                'foto_url' => url('storage/' . $foto_path),
                'full_name' => $user->nama,
                'email' => $user->email
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in uploadFotoProfil: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunggah foto: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function profilSaya()
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                \Log::error('User not authenticated for profilSaya');
                return redirect()->route('login');
            }
            
            $user = Auth::user();
            \Log::info('User accessing profilSaya: ' . $user->id . ', role: ' . $user->role);
            
            if ($user->role !== 'guru') {
                \Log::error('User role not guru: ' . $user->role);
                abort(403, 'Unauthorized');
            }
            
            // Debug: Check user attributes
            $user_data = [
                'id' => $user->id,
                'nama' => $user->nama ?? 'N/A',
                'email' => $user->email ?? 'N/A',
                'nomor_id' => $user->nomor_id ?? 'N/A',
                'nomor_telepon' => $user->nomor_telepon ?? 'N/A',
                'role' => $user->role ?? 'N/A',
                'foto_profile' => $user->foto_profile ?? 'N/A',
                'created_at' => $user->created_at ?? 'N/A'
            ];
            
            \Log::info('User data for profilSaya: ' . json_encode($user_data));
            
            return view('guru.profil-saya', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in profilSaya: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' line ' . $e->getLine());
            abort(500, 'Terjadi kesalahan saat memuat halaman profil: ' . $e->getMessage());
        }
    }
    
    public function updatePassword(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            if (!$user || $user->role !== 'guru') {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
                abort(403, 'Unauthorized');
            }
            
            // Check if request is JSON (for AJAX requests)
            $isJsonRequest = $request->wantsJson() || $request->header('Content-Type') === 'application/json';
            
            // Validate input with custom messages
            $validator = \Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ], [
                'current_password.required' => 'Password saat ini wajib diisi',
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.min' => 'Password baru minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);
            
            if ($validator->fails()) {
                DB::rollBack();
                if ($isJsonRequest) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }
                return redirect()->route('guru.pengaturan')->withErrors([
                    'passwordUpdateError' => [$validator->errors()->first()]
                ]);
            }
            
            $validated = $validator->validated();
            
            // Check if current password is correct
            if (!\Hash::check($validated['current_password'], $user->password)) {
                DB::rollBack();
                if ($isJsonRequest) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password saat ini tidak benar'
                    ]);
                }
                
                return redirect()->route('guru.pengaturan')->withErrors([
                    'passwordUpdateError' => ['Password saat ini tidak benar']
                ]);
            }
            
            // Update password
            $user->update([
                'password' => \Hash::make($validated['new_password'])
            ]);
            
            DB::commit();
            
            if ($isJsonRequest) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diubah'
                ]);
            }
            
            return redirect()->route('guru.pengaturan')->with('password_success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in updatePassword: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateProfilSaya(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            if (!$user || $user->role !== 'guru') {
                abort(403, 'Unauthorized');
            }
            
            // Validate input
            $rules = [
                'nama' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'nomor_telepon' => 'nullable|string|max:20',
                'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
            
            $messages = [
                'foto_profile.image' => 'File harus berupa gambar',
                'foto_profile.mimes' => 'Format gambar harus jpeg, png, atau jpg',
                'foto_profile.max' => 'Ukuran gambar maksimal 2MB',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
            ];
            
            $validator = \Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                DB::rollBack();
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $validated = $validator->validated();
            
            // Use helper method untuk handle update
            $updateData = $this->handleProfileUpdate($user, $validated, $request);
            
            DB::commit();
            
            // Check if request wants JSON response (AJAX)
            if ($request->wantsJson()) {
                // Return photo URL in response if photo was updated
                $response = [
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui'
                ];
                
                if (isset($updateData['foto_profile'])) {
                    $response['foto_url'] = url('storage/' . $updateData['foto_profile']);
                }
                
                return response()->json($response);
            } else {
                return redirect()->route('guru.profil.saya')->with('success', 'Profil berhasil diperbarui');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in updateProfilSaya: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui profil'
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil');
        }
    }
}