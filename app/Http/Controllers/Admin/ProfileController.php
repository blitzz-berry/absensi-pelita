<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('admin.profil', compact('user'));
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
}