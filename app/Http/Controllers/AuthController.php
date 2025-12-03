<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        }
        
        // Pastikan session dan token CSRF siap
        if (!$request->session()->has('_token')) {
            $request->session()->regenerateToken();
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email atau nomor_id
        $loginField = $credentials['login_field'];
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($loginField)])
                    ->orWhereRaw('LOWER(nomor_id) = ?', [strtolower($loginField)])
                    ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect()->back()->withErrors([
                'login_field' => 'Email, Nomor ID, atau password salah.',
            ])->withInput($request->only('login_field'));
        }

        // Periksa apakah user adalah admin dan menggunakan email yang diizinkan (jika validasi diaktifkan)
        if ($user->role === 'admin') {
            // Cek apakah validasi email untuk admin diaktifkan
            if (config('admin.require_email_validation', false)) {
                $allowedAdminEmails = config('admin.allowed_emails', []);
                
                // Tambahkan email dari environment jika ada
                $envAdminEmail = config('app.admin_email');
                if ($envAdminEmail) {
                    $allowedAdminEmails[] = $envAdminEmail;
                }
                
                if (!in_array($user->email, $allowedAdminEmails)) {
                    return redirect()->back()->withErrors([
                        'login_field' => 'Email ini tidak diizinkan untuk login sebagai admin.',
                    ])->withInput($request->only('login_field'));
                }
            }
        }

        // Login user
        Auth::login($user);

        // Regenerasi session ID untuk mencegah session fixation
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}