@extends('layouts.app')

@section('title', 'Pengaturan - Sistem Absensi Guru')

@section('styles')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: #ffffff;
            box-shadow: 3px 0 15px rgba(0,0,0,0.08);
            z-index: 99;
            padding-top: 60px;
            transition: all 0.3s ease;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar ul li {
            margin: 0;
        }
        
        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #555;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .sidebar ul li a:hover {
            background-color: #f0f5ff;
            color: #1976D2;
        }
        
        .sidebar ul li a.active {
            background-color: #e3f2fd;
            color: #1976D2;
            border-left: 4px solid #1976D2;
        }
        
        .sidebar ul li a i {
            margin-right: 15px;
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 60px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 98;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            transition: left 0.3s ease;
        }
        
        .main-content {
            margin-top: 60px;
            margin-left: 260px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: #ffffff;
            box-shadow: 3px 0 15px rgba(0,0,0,0.08);
            z-index: 99;
            padding-top: 60px;
            transition: all 0.3s ease;
            transform: translateX(0);
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 98;
            display: none;
        }

        .mobile-overlay.active {
            display: block;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            z-index: 100;
        }

        .hamburger span {
            height: 3px;
            width: 100%;
            background-color: #555;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        @media (max-width: 992px) {
            .hamburger {
                display: flex;
                margin-right: 20px;
            }

            .sidebar {
                transform: translateX(-100%) !important;
                left: -260px !important;
            }

            .sidebar.active {
                transform: translateX(0) !important;
                left: 0 !important;
                z-index: 1000 !important;
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding-left: 10px;
            }
        }

        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            background: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-menu {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .clock-display {
            font-size: 18px;
            font-weight: 500;
            margin-right: 20px;
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 5px 12px;
            border-radius: 6px;
        }
        
        .welcome-section {
            margin-bottom: 25px;
        }
        
        .welcome-title {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #212121;
        }
        
        .welcome-subtitle {
            margin: 0;
            color: #757575;
        }
        
        .card-content {
            padding: 30px;
        }
        
        .card-title {
            font-weight: 600;
            color: #212121;
            margin-bottom: 20px;
            position: relative;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(135deg, #1976D2, #2196F3);
            border-radius: 2px;
        }
        
        .setting-section {
            margin-bottom: 30px;
        }
        
        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .setting-item:last-child {
            border-bottom: none;
        }
        
        .setting-label {
            font-weight: 500;
            color: #424242;
        }
        
        .setting-control {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        /* From Uiverse.io by zanina-yassine */
        /* The switch - the box around the slider */
        .container {
          width: 51px;
          height: 31px;
          position: relative;
          display: inline-block;
        }

        /* Hide default HTML checkbox */
        .checkbox {
          opacity: 0;
          width: 0;
          height: 0;
          position: absolute;
        }

        .switch {
          width: 100%;
          height: 100%;
          display: block;
          background-color: #e9e9eb;
          border-radius: 16px;
          cursor: pointer;
          transition: all 0.2s ease-out;
        }

        /* The slider */
        .slider {
          width: 27px;
          height: 27px;
          position: absolute;
          left: calc(50% - 27px/2 - 10px);
          top: calc(50% - 27px/2);
          border-radius: 50%;
          background: #FFFFFF;
          box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.15), 0px 3px 1px rgba(0, 0, 0, 0.06);
          transition: all 0.2s ease-out;
          cursor: pointer;
        }

        .checkbox:checked + .switch {
          background-color: #34C759;
        }

        .checkbox:checked + .switch .slider {
          left: calc(50% - 27px/2 + 10px);
          top: calc(50% - 27px/2);
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .btn-primary {
            background-color: #1976D2;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0d47a1;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #1976D2;
            color: #1976D2;
        }
        
        .btn-outline:hover {
            background-color: #e3f2fd;
        }
        
        .input-group {
            margin-bottom: 15px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #424242;
        }
        
        .input-group input, 
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .form-actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        

        
        .setting-control {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        
        .setting-control span {
            font-size: 14px;
            color: #666;
            white-space: nowrap;
        }
        
        .toggle-text-off, .toggle-text-on {
            font-size: 13px;
            font-weight: 500;
            min-width: 50px;
            text-align: center;
        }
        
        .setting-item .switch {
            margin-left: 5px;
            flex-shrink: 0;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 25px;
            border: 4px solid #e3f2fd;
        }
        
        .profile-info h3 {
            margin: 0 0 10px 0;
            color: #212121;
            font-size: 22px;
        }
        
        .profile-info p {
            margin: 5px 0;
            color: #666;
            font-size: 16px;
        }
        
        .profile-info .role {
            background-color: #e3f2fd;
            color: #1976D2;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-top: 8px;
        }
        
        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 500;
            color: #757575;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .detail-value {
            font-size: 16px;
            color: #212121;
            font-weight: 500;
        }
        
        .file-name-display {
            color: #757575;
            font-size: 14px;
        }
        
        .notification {
            margin-top: 15px;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid transparent;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .topbar {
                left: 0;
            }
            
            .card-content {
                padding: 20px;
            }
            
            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .setting-control {
                width: 100%;
                justify-content: space-between;
            }
            
            .form-actions .btn {
                min-width: auto;
                width: 100%;
                margin-left: 0;
                margin-top: 10px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    <div class="topbar">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="clock-display" id="live-clock">00:00:00</div>
        <div class="profile-menu dropdown-trigger" data-target="dropdown-profile">
            <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                 alt="Profile" class="circle" width="40" height="40">
            <span style="margin-left: 10px; font-weight: 500;">{{ $user->nama }}</span>
        </div>
        <ul id="dropdown-profile" class="dropdown-content">
            <li><a href="{{ route('admin.profil') }}"><i class="material-icons left">person</i> Profil Saya</a></li>
            <li><a href="{{ route('admin.pengaturan') }}"><i class="material-icons left">settings</i> Pengaturan</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons left">exit_to_app</i> Keluar</a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Mobile overlay removed (using layout's overlay) -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Pengaturan Sistem</h4>
            <p class="welcome-subtitle">Kelola pengaturan sistem absensi guru</p>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Pengaturan Umum</span>
                        
                        <form action="{{ route('admin.pengaturan.umum.update') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            
                            <div class="setting-section">
                                <div class="setting-item">
                                    <div class="setting-label">Notifikasi Absensi</div>
                                    <div class="setting-control">
                                        <div class="container">
                                            <input type="checkbox" class="checkbox" name="notifikasi_absensi" value="1" id="notifikasi_absensi" {{ $settings['notifikasi_absensi'] ? 'checked' : '' }}>
                                            <label class="switch" for="notifikasi_absensi">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-label">Lokasi Wajib Absen</div>
                                    <div class="setting-control">
                                        <div class="container">
                                            <input type="checkbox" class="checkbox" name="lokasi_wajib" value="1" id="lokasi_wajib" {{ $settings['lokasi_wajib'] ? 'checked' : '' }}>
                                            <label class="switch" for="lokasi_wajib">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-label">Selfie Wajib Absen</div>
                                    <div class="setting-control">
                                        <div class="container">
                                            <input type="checkbox" class="checkbox" name="selfie_wajib" value="1" id="selfie_wajib" {{ $settings['selfie_wajib'] ? 'checked' : '' }}>
                                            <label class="switch" for="selfie_wajib">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <div class="setting-label">Waktu Toleransi Keterlambatan</div>
                                    <div class="setting-control">
                                        <select name="toleransi_keterlambatan" id="toleransi_keterlambatan">
                                            <option value="15" {{ $settings['toleransi_keterlambatan'] == 15 ? 'selected' : '' }}>15 menit</option>
                                            <option value="30" {{ $settings['toleransi_keterlambatan'] == 30 ? 'selected' : '' }}>30 menit</option>
                                            <option value="45" {{ $settings['toleransi_keterlambatan'] == 45 ? 'selected' : '' }}>45 menit</option>
                                            <option value="60" {{ $settings['toleransi_keterlambatan'] == 60 ? 'selected' : '' }}>60 menit</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="waktu_absen_masuk" class="setting-label">Waktu Absen Masuk (Mulai)</label>
                                    <div class="setting-control">
                                        <input type="time" id="waktu_absen_masuk" name="waktu_absen_masuk" value="{{ $settings['waktu_absen_masuk'] }}" autocomplete="off">
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <label for="waktu_absen_pulang" class="setting-label">Waktu Absen Pulang</label>
                                    <div class="setting-control">
                                        <input type="time" id="waktu_absen_pulang" name="waktu_absen_pulang" value="{{ $settings['waktu_absen_pulang'] }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="setting-section">
                                <div class="input-group">
                                    <label for="radius_absen">Radius Lokasi Absen (meter)</label>
                                    <input type="number" id="radius_absen" name="radius_absen" value="{{ $settings['radius_absen'] }}" min="10" max="200" autocomplete="off">
                                </div>

                                <div class="input-group">
                                    <label for="pesan_pengingat">Pesan Pengingat Absensi</label>
                                    <input type="text" id="pesan_pengingat" name="pesan_pengingat" value="{{ $settings['pesan_pengingat'] }}" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Profil & Akun</span>
                        
                        <div class="profile-header">
                            <div class="profile-avatar-container" style="display: flex; align-items: center; margin-bottom: 20px;">
                                <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                     id="profile-display" alt="Profile" class="profile-avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                <div class="profile-info">
                                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #212121;">{{ $user->nama }}</h3>
                                    <p style="margin: 5px 0; color: #666; font-size: 16px;">{{ $user->email }}</p>
                                    <span class="role" style="background-color: #e3f2fd; color: #1976D2; padding: 4px 12px; border-radius: 20px; font-size: 14px; display: inline-block; margin-top: 8px;">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="profile-details" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; padding: 15px 0; border-top: 1px solid #eee;">
                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Nama Lengkap</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500;">{{ $user->nama }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Email</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500;">{{ $user->email }}</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Role</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500;">{{ ucfirst($user->role) }}</div>
                            </div>
                        </div>
                        
                        <div id="edit-profile-button-container" class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-primary" onclick="showEditProfileForm()">Edit Profil</button>
                        </div>
                        
                        <!-- Form Edit Profil -->
                        <form id="edit-profile-form" class="edit-profile-form" action="{{ route('admin.pengaturan.akun.update') }}" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;" autocomplete="off">
                            @csrf
                            <!-- Note: Method override will be handled in JavaScript -->

                            <div class="input-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ $user->nama }}" autocomplete="name">
                            </div>

                            <div class="input-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" autocomplete="email">
                            </div>

                            <div class="input-group">
                                <label for="foto_profile">Foto Profil</label>
                                <input type="file" name="foto_profile" id="foto_profile" accept="image/*" style="display: none;" onchange="updateFileName(this); previewImage(event);">
                                <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap mt-2">
                                    <button class="btn btn-outline" type="button" onclick="document.getElementById('foto_profile').click()">Pilih Foto</button>
                                    <span id="file-name" class="file-name-display">Tidak ada file dipilih</span>
                                </div>
                                <div id="image-preview-container" style="margin-top: 15px; display: none;">
                                    <img id="image-preview" src="" alt="Pratinjau" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #e0e0e0;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button type="button" class="btn btn-outline" onclick="resetProfileForm(); hideEditProfileForm()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Ganti Password</span>
                        
                        <form id="change-password-form" action="{{ route('admin.pengaturan.password.update') }}" method="POST" autocomplete="off">
                            @csrf
                            <!-- Note: Method override will be handled in JavaScript -->
                            
                            <div class="input-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                            </div>

                            <div class="input-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
                            </div>

                            <div class="input-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password">
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button type="button" class="btn btn-outline" onclick="resetPasswordForm()">Batal</button>
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                            </div>
                        </form>
                        
                        <!-- Notification Elements -->
                        <div id="password-notification" class="notification" style="display: none; margin-top: 15px; padding: 10px; border-radius: 4px; text-align: center;">
                            <span id="notification-message"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log('Script loaded in pengaturan page');

        // Define global functions immediately to ensure they exist for onclick handlers
        // Define placeholder functions to ensure they exist for onclick handlers
        if (typeof window.showEditProfileForm === 'undefined') {
            window.showEditProfileForm = function() {
                console.log('Please wait, page still loading...');
            };
        }

        if (typeof window.hideEditProfileForm === 'undefined') {
            window.hideEditProfileForm = function() {
                console.log('Please wait, page still loading...');
            };
        }

        if (typeof window.resetProfileForm === 'undefined') {
            window.resetProfileForm = function() {
                console.log('Please wait, page still loading...');
            };
        }

        // Initialize dropdown
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded in pengaturan page');
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });

            // Initialize Materialize FormSelect for the tolerance setting and other selects
            var selectElems = document.querySelectorAll('select');
            M.FormSelect.init(selectElems);

            // --- Perbaikan untuk Materialize FormSelect ---
            // Pastikan input.select-dropdown yang dibuat oleh Materialize mendapatkan id jika diperlukan untuk aksesibilitas
            selectElems.forEach(function(originalSelect) {
                const selectId = originalSelect.id;
                // Cari wrapper yang dibuat oleh Materialize
                const wrapper = originalSelect.closest('.select-wrapper');
                if (wrapper) {
                    // Cari input yang ditampilkan kepada pengguna
                    const dropdownInput = wrapper.querySelector('input.select-dropdown');
                    if (dropdownInput && selectId && !dropdownInput.id) {
                        // Berikan id dari select asli ke input dropdown untuk aksesibilitas
                        dropdownInput.id = selectId + '_dropdown'; // Tambahkan akhiran untuk menghindari konflik id
                    }
                }
            });
            // --- Akhir Perbaikan ---

            // Update live clock
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();

                const clockElement = document.getElementById('live-clock');
                if (clockElement) {
                    clockElement.textContent = timeString;
                }
            }

            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);

            // Toggle switch text handlers removed as UI simplified


            // Function to show edit profile form
            function showEditProfileForm() {
                document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
                document.getElementById('edit-profile-button-container').style.display = 'none'; // Sembunyikan tombol Edit Profil
                document.getElementById('edit-profile-form').style.display = 'block';
            }

            // Function to hide edit profile form
            function hideEditProfileForm() {
                document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
                document.getElementById('edit-profile-button-container').style.display = 'flex'; // Tampilkan kembali tombol Edit Profil
                document.getElementById('edit-profile-form').style.display = 'none';
                document.getElementById('image-preview-container').style.display = 'none';
            }

            // Function to update file name display
            function updateFileName(input) {
                const fileNameDisplay = document.getElementById('file-name');
                if (input.files && input.files[0]) {
                    fileNameDisplay.textContent = input.files[0].name;
                } else {
                    fileNameDisplay.textContent = 'Tidak ada file dipilih';
                }
            }

            // Function to preview image
            function previewImage(event) {
                const reader = new FileReader();
                const imagePreviewContainer = document.getElementById('image-preview-container');
                const imagePreview = document.getElementById('image-preview');

                reader.onload = function(){
                    imagePreview.src = reader.result;
                    imagePreviewContainer.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }

            // Function to reset profile form and image preview when cancel is clicked
            function resetProfileForm() {
                document.getElementById('edit-profile-form').reset();
                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                document.getElementById('image-preview-container').style.display = 'none';

                // Reset image preview and hide container
                document.getElementById('image-preview').src = '';
            }

            // Function to submit profile form using AJAX
            function submitProfileForm() {
                console.log('submitProfileForm called');
                const form = document.getElementById('edit-profile-form');
                const formData = new FormData(form);

                // Debug: Log the form data (excluding file objects for safety)
                console.log('Submitting profile form data:', {
                    'nama': formData.get('nama'),
                    'email': formData.get('email'),
                    'has_foto_profile': formData.get('foto_profile') ? 'Yes' : 'No'
                });

                // Show loading indicator
                const submitBtn = document.querySelector('#edit-profile-form .btn-primary');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Menyimpan...';
                submitBtn.disabled = true;

                // Tambahkan CSRF token ke formData
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Cek dulu apakah CSRF token ada
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', csrfToken);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Profile update response status:', response.status);

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, return error
                        return response.text().then(text => {
                            console.error('Non-JSON response received:', text.substring(0, 200) + '...');
                            throw new Error('Server response is not in JSON format');
                        });
                    }
                })
                .then(data => {
                    console.log('Profile update server response:', data);

                    // Restore button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;

                    if (data.success) {
                        // Update profile display with new values
                        if (data.user) {
                            const profileDisplay = document.getElementById('profile-display');
                            if (profileDisplay) {
                                profileDisplay.src = data.user.foto_profile || `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.nama)}&color=1976D2&background=F5F5F5`;
                            }

                            // Update profile header - safe check for elements
                            const profileDetailDiv = document.querySelector('#edit-profile-form + div');
                            if (profileDetailDiv) {
                                const firstDetailValue = profileDetailDiv.querySelector('.detail-value');
                                if (firstDetailValue && data.user.nama) {
                                    firstDetailValue.textContent = data.user.nama;
                                }

                                const secondDetailValue = profileDetailDiv.querySelector('.detail-value:nth-child(2)');
                                if (secondDetailValue && data.user.email) {
                                    secondDetailValue.textContent = data.user.email;
                                }
                            }

                            // Update profile menu in topbar
                            const profileMenuSpan = document.querySelector('.profile-menu span');
                            if (profileMenuSpan && data.user.nama) {
                                profileMenuSpan.textContent = data.user.nama;
                            }

                            const profileMenuImg = document.querySelector('.profile-menu img');
                            if (profileMenuImg && data.user.foto_profile) {
                                profileMenuImg.src = data.user.foto_profile;
                            }
                        }

                        // Show success notification
                        showNotification(true, data.message || 'Profil berhasil diperbarui!');

                        // Hide form and show profile view
                        hideEditProfileForm();
                    } else {
                        showNotification(false, data.message || 'Gagal memperbarui profil.');
                    }
                })
                .catch(error => {
                    console.error('Error in profile update:', error);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    showNotification(false, 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
                });
            }

            // Function to submitGeneralSettingsForm using AJAX
            function submitGeneralSettingsForm() {
                console.log('submitGeneralSettingsForm called');
                const form = document.querySelector('form[action="{{ route("admin.pengaturan.umum.update") }}"]');
                if (!form) {
                    console.error('General settings form not found!');
                    return;
                }

                const formData = new FormData(form);

                // Debug: Log the form data
                console.log('Submitting general settings form data:', {
                    'notifikasi_absensi': formData.get('notifikasi_absensi'),
                    'lokasi_wajib': formData.get('lokasi_wajib'),
                    'selfie_wajib': formData.get('selfie_wajib'),
                    'toleransi_keterlambatan': formData.get('toleransi_keterlambatan'),
                    'waktu_absen_masuk': formData.get('waktu_absen_masuk'),
                    'waktu_absen_pulang': formData.get('waktu_absen_pulang'),
                    'radius_absen': formData.get('radius_absen'),
                    'pesan_pengingat': formData.get('pesan_pengingat')
                });

                // Show loading indicator
                const submitBtn = form.querySelector('.btn-primary');
                if (!submitBtn) {
                    console.error('Submit button not found in general settings form!');
                    return;
                }

                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Menyimpan...';
                submitBtn.disabled = true;

                // Tambahkan CSRF token ke formData
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Cek dulu apakah CSRF token ada
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', csrfToken);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Settings update response status:', response.status);

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, return error
                        return response.text().then(text => {
                            console.error('Non-JSON response received:', text.substring(0, 200) + '...');
                            throw new Error('Server response is not in JSON format');
                        });
                    }
                })
                .then(data => {
                    console.log('Settings update server response:', data);

                    // Restore button only if it still exists
                    if (submitBtn) {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }

                    if (data.success) {
                        // Show success notification
                        showPasswordNotification(true, data.message || 'Pengaturan berhasil disimpan!');
                    } else {
                        showPasswordNotification(false, data.message || 'Gagal menyimpan pengaturan.');
                    }
                })
                .catch(error => {
                    console.error('Error in settings update:', error);
                    // Restore button only if it still exists
                    if (submitBtn) {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                    showPasswordNotification(false, 'Terjadi kesalahan saat menyimpan pengaturan. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
                });
            }

            // Function to submit password form using AJAX
            function submitPasswordForm() {
                console.log('submitPasswordForm called');
                const form = document.getElementById('change-password-form');
                if (!form) {
                    console.error('Password form not found!');
                    return;
                }

                const formData = new FormData(form);

                // Debug: Log the form data
                console.log('Submitting password form data:', {
                    'current_password': formData.get('current_password'),
                    'new_password': formData.get('new_password'),
                    'new_password_confirmation': formData.get('new_password_confirmation')
                });

                // Additional debug - check values directly from inputs
                console.log('Input values directly:', {
                    'current_password_val': document.getElementById('current_password')?.value,
                    'new_password_val': document.getElementById('new_password')?.value,
                    'new_password_confirmation_val': document.getElementById('new_password_confirmation')?.value
                });

                // Show loading indicator
                const submitBtn = form.querySelector('.btn-primary');
                if (!submitBtn) {
                    console.error('Submit button not found in password form!');
                    return;
                }

                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Mengganti...';
                submitBtn.disabled = true;

                // Tambahkan CSRF token ke formData
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Cek dulu apakah CSRF token ada
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', csrfToken);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Password change response status:', response.status);

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, return error
                        return response.text().then(text => {
                            console.error('Non-JSON response received:', text.substring(0, 200) + '...');
                            throw new Error('Server response is not in JSON format');
                        });
                    }
                })
                .then(data => {
                    console.log('Password change server response:', data);

                    // Restore button only if it still exists
                    if (submitBtn) {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }

                    // Show notification
                    showPasswordNotification(data.success, data.message || (data.success ? 'Password berhasil diubah!' : 'Gagal mengganti password.'));

                    if (data.success) {
                        // Reset form on success only if it still exists
                        if (form) {
                            form.reset();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error in password change:', error);
                    // Restore button only if it still exists
                    if (submitBtn) {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                    showPasswordNotification(false, 'Terjadi kesalahan saat mengganti password. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
                });
            }

            // Function to show password notification
            function showPasswordNotification(isSuccess, message) {
                const notification = document.getElementById('password-notification');
                const notificationMessage = document.getElementById('notification-message');

                if (isSuccess) {
                    notification.style.backgroundColor = '#e8f5e9';
                    notification.style.borderColor = '#4caf50';
                    notification.style.color = '#2e7d32';
                } else {
                    notification.style.backgroundColor = '#ffebee';
                    notification.style.borderColor = '#f44336';
                    notification.style.color = '#c62828';
                }

                notificationMessage.textContent = message;
                notification.style.display = 'block';

                // Hide notification after 5 seconds
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 5000);
            }

            // Function to reset password form
            function resetPasswordForm() {
                document.getElementById('change-password-form').reset();
                document.getElementById('password-notification').style.display = 'none';
            }

            // Function to show notification for profile updates
            function showNotification(isSuccess, message) {
                // Create notification element if it doesn't exist
                let notification = document.getElementById('profile-notification');
                if (!notification) {
                    notification = document.createElement('div');
                    notification.id = 'profile-notification';
                    notification.className = 'notification';
                    notification.style.cssText = 'display: none; margin-top: 15px; padding: 10px; border-radius: 4px; text-align: center;';
                    document.querySelector('#edit-profile-form').appendChild(notification);
                }

                const notificationMessage = document.createElement('span');
                notificationMessage.id = 'profile-notification-message';

                if (isSuccess) {
                    notification.style.backgroundColor = '#e8f5e9';
                    notification.style.borderColor = '#4caf50';
                    notification.style.color = '#2e7d32';
                } else {
                    notification.style.backgroundColor = '#ffebee';
                    notification.style.borderColor = '#f44336';
                    notification.style.color = '#c62828';
                }

                notificationMessage.textContent = message;
                notification.innerHTML = '';
                notification.appendChild(notificationMessage);
                notification.style.display = 'block';

                // Hide notification after 5 seconds
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 5000);
            }

            // Add event listener for profile form submission
            console.log('DOMContentLoaded triggered');
            const profileForm = document.getElementById('edit-profile-form');
            if (profileForm) {
                console.log('Profile form found, adding event listener');
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('Profile form submit prevented, calling submitProfileForm');
                    submitProfileForm();
                });
            } else {
                console.log('Profile form NOT found!');
            }

            // Add event listener for password form submission
            const passwordForm = document.getElementById('change-password-form');
            if (passwordForm) {
                console.log('Password form found, adding event listener');
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('Form submit prevented, calling submitPasswordForm');
                    submitPasswordForm();
                });
            } else {
                console.log('Password form NOT found!');
            }

            // Add event listener for general settings form submission
            const generalSettingsForm = document.querySelector('form[action="{{ route("admin.pengaturan.umum.update") }}"]');
            if (generalSettingsForm) {
                console.log('General settings form found, adding event listener');
                generalSettingsForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log('General settings form submit prevented, calling submitGeneralSettingsForm');
                    submitGeneralSettingsForm();
                });
            } else {
                console.log('General settings form NOT found!');
            }

            // Add event listeners to save buttons for direct click handling
            // Only for buttons that are not already handled by form submission
            const saveButtons = document.querySelectorAll('form button[type="submit"].btn-primary');
            saveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Only handle if the click is not already prevented by form submit
                    if (this.closest('#edit-profile-form')) {
                        // Profile form is already handled by form submit
                    } else if (this.closest('#change-password-form')) {
                        // Password form is already handled by form submit
                    } else {
                        // This is likely the general settings form button
                        e.preventDefault();
                        console.log('General settings button clicked, calling submitGeneralSettingsForm');
                        submitGeneralSettingsForm();
                    }
                });
            });

            @if(session('success'))
                showPasswordNotification(true, '{{ session('success') }}');
            @elseif(session('error'))
                showPasswordNotification(false, '{{ session('error') }}');
            @endif

            // Replace global functions with actual implementations
            window.showEditProfileForm = function() {
                document.querySelector('.profile-details').style.display = 'grid';
                document.getElementById('edit-profile-button-container').style.display = 'none';
                document.getElementById('edit-profile-form').style.display = 'block';
            };

            window.hideEditProfileForm = function() {
                document.querySelector('.profile-details').style.display = 'grid';
                document.getElementById('edit-profile-button-container').style.display = 'flex';
                document.getElementById('edit-profile-form').style.display = 'none';
                document.getElementById('image-preview-container').style.display = 'none';
            };

            window.resetProfileForm = function() {
                document.getElementById('edit-profile-form').reset();
                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                document.getElementById('image-preview-container').style.display = 'none';
                document.getElementById('image-preview').src = '';
            };

            // Store references to functions in global variables
            showEditProfileFormGlobal = showEditProfileForm;
            hideEditProfileFormGlobal = hideEditProfileForm;
            resetProfileFormGlobal = resetProfileForm;
            resetPasswordFormGlobal = resetPasswordForm;

        });

        // Global functions for inline onclick handlers
        function showEditProfileForm() {
            if (typeof showEditProfileFormGlobal === 'function') {
                showEditProfileFormGlobal();
            }
        }

        function hideEditProfileForm() {
            if (typeof hideEditProfileFormGlobal === 'function') {
                hideEditProfileFormGlobal();
            }
        }

        function resetProfileForm() {
            if (typeof resetProfileFormGlobal === 'function') {
                resetProfileFormGlobal();
            }
        }

        function resetPasswordForm() {
            if (typeof resetPasswordFormGlobal === 'function') {
                resetPasswordFormGlobal();
            }
        }
    </script>
@endsection