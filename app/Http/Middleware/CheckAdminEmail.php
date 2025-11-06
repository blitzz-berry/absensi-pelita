<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CheckAdminEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Jika user adalah admin, periksa apakah emailnya diizinkan (jika validasi diaktifkan)
            if ($user->role === 'admin') {
                // Cek apakah validasi email untuk admin diaktifkan
                if (Config::get('admin.require_email_validation', false)) {
                    $allowedAdminEmails = Config::get('admin.allowed_emails', []);
                    
                    // Tambahkan email dari environment jika ada
                    $envAdminEmail = Config::get('app.admin_email');
                    if ($envAdminEmail) {
                        $allowedAdminEmails[] = $envAdminEmail;
                    }
                    
                    if (!in_array($user->email, $allowedAdminEmails)) {
                        Auth::logout();
                        return redirect('/login')->withErrors([
                            'login_field' => 'Email Anda tidak diizinkan untuk login sebagai admin.',
                        ]);
                    }
                }
            }
        }

        return $next($request);
    }
}