@extends('layouts.app')

@section('title', 'Login - Sistem Absensi Guru')

@section('styles')
    <style>
        body {
            background: linear-gradient(135deg, #1976D2, #42A5F5);
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            margin: 0 20px;
        }
        
        .welcome-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
            color: white;
            margin: 0 20px;
            text-align: center;
            flex: 1;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #1976D2, #2196F3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 40px;
            box-shadow: 0 5px 15px rgba(25, 118, 210, 0.4);
        }
        
        .input-field {
            margin: 30px 0;
        }
        
        .input-field input {
            width: 100%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-field input:focus {
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(25, 118, 210, 0.4);
        }
        
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #1976D2;
            text-decoration: none;
            font-size: 14px;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .welcome-title {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .welcome-subtitle {
            font-size: 16px;
            margin-bottom: 25px;
            opacity: 0.9;
        }
        
        .features {
            text-align: left;
            margin-top: 30px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .feature-item i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .error-message {
            color: #f44336;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="login-container">
        <div class="welcome-section">
            <h2 class="welcome-title">Sistem Absensi Guru</h2>
            <p class="welcome-subtitle">PLUS Pelita Insani</p>
            <p>Lacak kehadiran guru secara digital, real-time, dan aman</p>
            
            <div class="features">
                <div class="feature-item">
                    <i class="material-icons">check_circle</i>
                    <span>Validasi Lokasi (GPS)</span>
                </div>
                <div class="feature-item">
                    <i class="material-icons">camera_alt</i>
                    <span>Ambil Foto Saat Absen</span>
                </div>
                <div class="feature-item">
                    <i class="material-icons">location_on</i>
                    <span>Peta Lokasi Guru</span>
                </div>
                <div class="feature-item">
                    <i class="material-icons">event_note</i>
                    <span>Sistem Izin & Sakit</span>
                </div>
            </div>
        </div>
        
        <div class="login-card">
            <div class="logo-container">
                <div class="logo">
                    <i class="material-icons">school</i>
                </div>
                <h4 class="center-align" style="color: #333; margin: 0;">Selamat Datang</h4>
                <p class="center-align grey-text" style="margin-top: 5px;">Silakan masuk ke akun Anda</p>
            </div>
            
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="input-field">
                    <input id="login_field" type="text" name="login_field" value="{{ old('login_field') }}" required autocomplete="off" placeholder="Masukkan Email atau Nomor ID">
                    @error('login_field')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="input-field">
                    <input id="password" type="password" name="password" required placeholder="Masukkan Password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="material-icons left">login</i> Masuk
                </button>
                
                <a href="#" class="forgot-password">Lupa kata sandi?</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set CSRF token untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan efek ripple pada tombol login
            const loginBtn = document.querySelector('.btn-login');
            if (loginBtn) {
                loginBtn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            }
        });
    </script>
@endsection