@extends('layouts.app')

@section('title', 'Login - absensi guru pelita')

@section('styles')
    <style>
        body {
            background: url('{{ asset('image/sekolah.png') }}') no-repeat center center fixed;
            background-size: cover;
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
            margin: 0 auto;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 380px;
            margin: 0 20px;
        }
        
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 0;
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
        <div class="login-card">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('image/logo-pelita.png') }}" alt="Logo Pelita" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h4 class="center-align" style="color: #333; margin: 0;">Selamat Datang</h4>
                <p class="center-align grey-text" style="margin-top: 5px;">Silakan masuk ke akun Anda</p>
            </div>
            
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="input-field">
                    <label for="login_field" class="sr-only" style="display:none;">Nomor ID</label>
                    <input id="login_field" type="text" name="login_field" value="{{ old('login_field') }}" required autocomplete="off" placeholder="Masukkan Nomor ID">
                    @error('login_field')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-field">
                    <div style="position: relative;">
                        <label for="password" class="sr-only" style="display:none;">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan Password">
                        <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword()">
                            <i class="material-icons" id="togglePasswordIcon">visibility</i>
                        </span>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <label style="display: flex; align-items: center;">
                        <input type="checkbox" name="remember" id="remember" style="margin-right: 8px;">
                        <span style="color: #333; font-size: 14px;">Ingat Saya</span>
                    </label>
                    <a href="#" class="forgot-password">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="material-icons left">login</i> Masuk
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Load jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Set CSRF token untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }

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