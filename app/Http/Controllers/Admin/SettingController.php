<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua setting yang dibutuhkan untuk ditampilkan di view
        $settings = [
            'notifikasi_absensi' => SystemSetting::get('notifikasi_absensi', true),
            'lokasi_wajib' => SystemSetting::get('lokasi_wajib', true),
            'selfie_wajib' => SystemSetting::get('selfie_wajib', true),
            'toleransi_keterlambatan' => SystemSetting::get('toleransi_keterlambatan', 15),
            'waktu_absen_masuk' => SystemSetting::get('waktu_absen_masuk', '07:00'),
            'waktu_absen_pulang' => SystemSetting::get('waktu_absen_pulang', '16:00'),
            'radius_absen' => SystemSetting::get('radius_absen', 50),
            'pesan_pengingat' => SystemSetting::get('pesan_pengingat', 'Jangan lupa absen hari ini!'),
        ];
        
        // Mengembalikan view pengaturan dengan data user dan setting
        return view('admin.pengaturan', compact('user', 'settings'));
    }
    
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        // Update data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        
        // Jika ada file foto profil yang diunggah
        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($user->foto_profile && file_exists(public_path($user->foto_profile))) {
                unlink(public_path($user->foto_profile));
            }
            
            // Simpan foto baru
            $fotoPath = $request->file('foto_profile')->store('profile-photos', 'public');
            $user->foto_profile = 'storage/' . $fotoPath;
        }
        
        $user->save();
        
        // Return JSON response for AJAX request
        if ($request->wantsJson()) {
            \Log::info('Profile update response', [
                'user_id' => $user->id,
                'foto_profile' => $user->foto_profile,
                'full_path' => $user->foto_profile ? asset($user->foto_profile) : null
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'user' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'foto_profile' => $user->foto_profile ? asset($user->foto_profile) : null
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        // Log data yang diterima dan informasi request
        \Log::info('Password update request data', [
            'password_lama' => $request->password_lama,
            'password_baru' => $request->password_baru,
            'password_baru_confirmation' => $request->password_baru_confirmation,
            'user_id' => Auth::id(),
            'wants_json' => $request->wantsJson(),
            'is_ajax' => $request->ajax(),
            'headers' => [
                'content-type' => $request->header('Content-Type'),
                'accept' => $request->header('Accept'),
            ]
        ]);
        
        // Validasi input
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        \Log::info('User current password check', [
            'user_id' => $user->id,
            'current_password_hash' => $user->password,
            'provided_old_password' => $request->password_lama,
            'old_password_matches' => \Hash::check($request->password_lama, $user->password),
        ]);
        
        // Periksa apakah password lama cocok
        if (!\Hash::check($request->password_lama, $user->password)) {
            \Log::warning('Old password does not match', [
                'user_id' => $user->id,
                'provided_old_password_correct' => \Hash::check($request->password_lama, $user->password),
            ]);
            
            // Return JSON response for AJAX request
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai!'
                ]);
            }
            
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }
        
        // Update password
        $hashedNewPassword = \Hash::make($request->password_baru);
        \Log::info('Password update attempt', [
            'user_id' => $user->id,
            'old_password_matches' => \Hash::check($request->password_lama, $user->password),
            'new_hashed_password' => $hashedNewPassword
        ]);
        
        $user->password = $hashedNewPassword;
        $user->save();
        
        // Refresh user session to ensure new password is recognized
        \Auth::login($user, true); // Login kembali dengan data terbaru
        
        // Verify the password was updated 
        $isUpdated = \Hash::check($request->password_baru, $user->password);
        \Log::info('Password update verification', [
            'password_correctly_updated' => $isUpdated,
            'user_reauthenticated' => \Auth::check()
        ]);
        
        // Return JSON response for AJAX request
        if ($request->wantsJson()) {
            return response()->json([
                'success' => $isUpdated,
                'message' => $isUpdated ? 'Password berhasil diubah!' : 'Gagal mengupdate password.'
            ]);
        }
        
        // For non-AJAX requests
        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
    
    public function updateGeneralSettings(Request $request)
    {
        // Validasi input untuk settingan umum
        $request->validate([
            'notifikasi_absensi' => 'boolean',
            'lokasi_wajib' => 'boolean',
            'selfie_wajib' => 'boolean',
            'toleransi_keterlambatan' => 'integer|min:0|max:120',
            'waktu_absen_masuk' => 'date_format:H:i',
            'waktu_absen_pulang' => 'date_format:H:i',
            'radius_absen' => 'integer|min:1|max:1000',
            'pesan_pengingat' => 'nullable|string|max:500',
        ]);
        
        // Simpan pengaturan ke database menggunakan model SystemSetting
        SystemSetting::set('notifikasi_absensi', $request->notifikasi_absensi ? true : false, 'boolean');
        SystemSetting::set('lokasi_wajib', $request->lokasi_wajib ? true : false, 'boolean');
        SystemSetting::set('selfie_wajib', $request->selfie_wajib ? true : false, 'boolean');
        SystemSetting::set('toleransi_keterlambatan', $request->toleransi_keterlambatan ?? 15, 'integer');
        SystemSetting::set('waktu_absen_masuk', $request->waktu_absen_masuk ?? '07:00');
        SystemSetting::set('waktu_absen_pulang', $request->waktu_absen_pulang ?? '16:00');
        SystemSetting::set('radius_absen', $request->radius_absen ?? 50, 'integer');
        SystemSetting::set('pesan_pengingat', $request->pesan_pengingat ?? 'Jangan lupa absen hari ini!');
        
        // Return JSON response for AJAX request
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan umum berhasil disimpan!'
            ]);
        }
        
        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan!');
    }
}