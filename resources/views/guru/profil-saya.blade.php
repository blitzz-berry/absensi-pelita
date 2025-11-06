@extends('layouts.app')

@section('title', 'Profil Saya - Sistem Absensi Guru')

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
        
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: 100%;
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
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: #1976D2;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1565C0;
            box-shadow: 0 4px 8px rgba(25, 118, 210, 0.3);
        }
        
        .btn-outline {
            background-color: white;
            border: 1px solid #e0e0e0;
            color: #666;
        }
        
        .btn-outline:hover {
            background-color: #f5f5f5;
            color: #333;
            border-color: #c0c0c0;
        }
        
        .form-actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: white;
        }
        
        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .edit-profile-form {
            display: none;
        }
        
        .profile-view {
            display: block;
        }
        
        .form-actions .btn {
            margin-left: 10px;
            min-width: 120px;
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
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
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
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) class="active" @endif><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li><a href="{{ route('guru.absensi.harian') }}" @if(request()->routeIs('guru.absensi.harian')) class="active" @endif><i class="material-icons">calendar_today</i> Absensi Harian</a></li>
            <li><a href="{{ route('guru.riwayat.kehadiran') }}" @if(request()->routeIs('guru.riwayat.kehadiran')) class="active" @endif><i class="material-icons">history</i> Riwayat Kehadiran</a></li>
            <li><a href="{{ route('guru.lokasi.saya') }}" @if(request()->routeIs('guru.lokasi.saya')) class="active" @endif><i class="material-icons">location_on</i> Lokasi Saya</a></li>
            <li><a href="{{ route('guru.izin') }}" @if(request()->routeIs('guru.izin')) class="active" @endif><i class="material-icons">event_note</i> Izin/Sakit</a></li>
            <li><a href="{{ route('guru.pengaturan') }}" @if(request()->routeIs('guru.pengaturan')) class="active" @endif><i class="material-icons">settings</i> Pengaturan</a></li>
        </ul>
    </div>
    
    <!-- Top Bar -->
    <div class="topbar">
        <div class="clock-display" id="live-clock">00:00:00</div>
        <div class="profile-menu dropdown-trigger" data-target="dropdown-profile">
            <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                 alt="Profile" class="circle" width="40" height="40">
            <span style="margin-left: 10px; font-weight: 500;">{{ $user->nama }}</span>
        </div>
        <ul id="dropdown-profile" class="dropdown-content">
            <li><a href="{{ route('guru.profil.saya') }}"><i class="material-icons left">person</i> Profil Saya</a></li>
            <li><a href="{{ route('guru.pengaturan') }}"><i class="material-icons left">settings</i> Pengaturan</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons left">exit_to_app</i> Keluar</a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Profil Saya</h4>
            <p class="welcome-subtitle">Kelola informasi pribadi Anda</p>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <!-- View Profile Section -->
                        <div id="profile-view" class="profile-view">
                            <div class="profile-header">
                                <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                     alt="Profile" class="profile-avatar">
                                <div class="profile-info">
                                    <h3>{{ $user->nama ?? 'User' }}</h3>
                                    <p>{{ $user->email ?? 'Email belum diatur' }}</p>
                                    <span class="role">{{ ucfirst($user->role ?? 'guru') }}</span>
                                </div>
                            </div>
                            
                            <div class="profile-details">
                                <div class="detail-item">
                                    <div class="detail-label">Nama Lengkap</div>
                                    <div class="detail-value">{{ $user->nama ?? '-' }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value">{{ $user->email ?? '-' }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Nomor Induk</div>
                                    <div class="detail-value">{{ $user->nomor_id ?? '-' }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Nomor Telepon</div>
                                    <div class="detail-value">{{ $user->nomor_telepon ?? '-' }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Role</div>
                                    <div class="detail-value">{{ ucfirst($user->role ?? 'guru') }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Tanggal Bergabung</div>
                                    <div class="detail-value">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary" onclick="showEditForm()">Edit Profil</button>
                            </div>
                        </div>
                        
                        <!-- Edit Profile Form -->
                        <form id="edit-profile-form" class="edit-profile-form" action="{{ route('guru.pengaturan.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            
                            <div class="profile-header">
                                <div>
                                    <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                         id="preview-image" alt="Profile" class="profile-avatar">
                                    <input type="file" name="foto_profile" id="foto_profile" accept="image/*" style="margin-top: 10px;" onchange="previewImage(event)">
                                </div>
                                <div class="profile-info">
                                    <h3>
                                        <input type="text" name="nama" value="{{ $user->nama ?? '' }}" class="input-edit">
                                    </h3>
                                    <p>
                                        <input type="email" name="email" value="{{ $user->email ?? '' }}" class="input-edit">
                                    </p>
                                    <span class="role">{{ ucfirst($user->role ?? 'guru') }}</span>
                                </div>
                            </div>
                            
                            <div class="profile-details">
                                <div class="input-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ $user->nama ?? '' }}">
                                </div>
                                
                                <div class="input-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user->email ?? '' }}">
                                </div>
                                
                                <div class="input-group">
                                    <label>Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" value="{{ $user->nomor_telepon ?? '' }}">
                                </div>
                                
                                <div class="input-group">
                                    <label>Role</label>
                                    <input type="text" value="{{ ucfirst($user->role ?? 'guru') }}" disabled>
                                </div>
                                
                                <div class="input-group">
                                    <label>Tanggal Bergabung</label>
                                    <input type="text" value="{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : '-' }}" disabled>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline" onclick="hideEditForm()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize dropdown
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });
            
            // Update live clock
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                
                document.getElementById('live-clock').textContent = timeString;
            }
            
            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);
        });
        
        function showEditForm() {
            document.getElementById('profile-view').style.display = 'none';
            document.getElementById('edit-profile-form').style.display = 'block';
        }
        
        function hideEditForm() {
            document.getElementById('profile-view').style.display = 'block';
            document.getElementById('edit-profile-form').style.display = 'none';
        }
        
        function showEditForm() {
            document.getElementById('profile-view').style.display = 'none';
            document.getElementById('edit-profile-form').style.display = 'block';
        }
        
        function hideEditForm() {
            document.getElementById('profile-view').style.display = 'block';
            document.getElementById('edit-profile-form').style.display = 'none';
        }
        
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        
        // Add event listener for edit profile form submission
        document.addEventListener('DOMContentLoaded', function() {
            const profileForm = document.getElementById('edit-profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = profileForm.querySelector('.btn-primary');
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Menyimpan...';
                    submitBtn.disabled = true;
                    
                    // Check if there's a file to upload
                    const fileInput = document.getElementById('foto_profile');
                    const hasFile = fileInput && fileInput.files.length > 0;
                    
                    if (hasFile) {
                        // If there's a file, use the specific photo upload endpoint
                        const photoFormData = new FormData();
                        photoFormData.append('foto_profile', fileInput.files[0]);
                        photoFormData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        
                        fetch('{{ route("guru.pengaturan.upload.foto") }}', {
                            method: 'POST',
                            body: photoFormData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(photoData => {
                            if (photoData.success) {
                                // Update foto profile in all locations
                                const profileDisplay = document.querySelector('#profile-view .profile-avatar');
                                const topbarProfile = document.querySelector('.topbar .profile-menu img');
                                
                                if (profileDisplay) {
                                    profileDisplay.src = photoData.foto_url + '?t=' + new Date().getTime(); // Add timestamp to bypass cache
                                }
                                if (topbarProfile) {
                                    topbarProfile.src = photoData.foto_url + '?t=' + new Date().getTime(); // Add timestamp to bypass cache
                                }
                                
                                // Also update the preview image in the edit form
                                if (document.getElementById('preview-image')) {
                                    document.getElementById('preview-image').src = photoData.foto_url + '?t=' + new Date().getTime();
                                }
                                
                                // Show success message
                                alert(photoData.message);
                                
                                // Switch back to profile view
                                hideEditForm();
                                
                                // Reset form
                                profileForm.reset();
                                
                                // Refresh the page to update all views
                                location.reload();
                            } else {
                                alert(photoData.message || 'Terjadi kesalahan saat mengunggah foto profil.');
                            }
                        })
                        .catch(error => {
                            console.error('Error in photo upload:', error);
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            alert('Terjadi kesalahan saat mengunggah foto profil. Silakan coba lagi.');
                        });
                    } else {
                        // If no file, just update text fields using the standard endpoint
                        const formData = new FormData(profileForm);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        
                        fetch(profileForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Restore button
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            
                            if (data.success) {
                                // Update profile information in the view
                                const profileName = document.querySelector('#profile-view h3');
                                const profileEmail = document.querySelector('#profile-view p');
                                
                                // Update name and email in the view
                                if (document.querySelector('input[name="nama"]').value) {
                                    const newName = document.querySelector('input[name="nama"]').value;
                                    profileName.textContent = newName;
                                    document.querySelector('.detail-value').textContent = newName;
                                }
                                
                                if (document.querySelector('input[name="email"]').value) {
                                    const newEmail = document.querySelector('input[name="email"]').value;
                                    profileEmail.textContent = newEmail;
                                }
                                
                                // Show success message
                                alert(data.message);
                                
                                // Switch back to profile view
                                hideEditForm();
                                
                                // Reset form
                                profileForm.reset();
                                
                                // Refresh the page to update all views
                                location.reload();
                            } else {
                                alert(data.message || 'Terjadi kesalahan saat memperbarui profil.');
                            }
                        })
                        .catch(error => {
                            console.error('Error in profile update:', error);
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            alert('Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
                        });
                    }
                });
            }
        });
    </script>
@endsection