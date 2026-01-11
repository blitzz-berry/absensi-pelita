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
                justify-content: center; /* Memastikan teks tetap di tengah dalam mode mobile */
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    <div class="topbar">
        <div class="clock-display" id="live-clock">00:00 WIB</div>
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
                                <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                     alt="Profile" class="profile-avatar">
                                <div class="profile-info">
                                    <h3>{{ $user->nama }}</h3>
                                    <p>{{ $user->email }}</p>
                                    <span class="role">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                            
                            <div class="profile-details">
                                <div class="detail-item">
                                    <div class="detail-label">Nama Lengkap</div>
                                    <div class="detail-value">{{ $user->nama }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value">{{ $user->email }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Role</div>
                                    <div class="detail-value">{{ ucfirst($user->role) }}</div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-label">Tanggal Dibuat</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary" onclick="showEditForm()">Edit Profil</button>
                            </div>
                        </div>
                        
                        <!-- Edit Profile Form -->
                        <form id="edit-profile-form" class="edit-profile-form" action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="profile-header">
                                <div>
                                    <img src="{{ $user->foto_profile ? asset($user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                         id="preview-image" alt="Profile" class="profile-avatar">
                                    <input type="file" name="foto_profile" id="foto_profile" accept="image/*" style="margin-top: 10px;" onchange="previewImage(event)">
                                </div>
                                <div class="profile-info">
                                    <h3>
                                        <input type="text" name="nama" value="{{ $user->nama }}" class="input-edit">
                                    </h3>
                                    <p>
                                        <input type="email" name="email" value="{{ $user->email }}" class="input-edit">
                                    </p>
                                    <span class="role">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                            
                            <div class="profile-details">
                                <div class="input-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ $user->nama }}">
                                </div>
                                
                                <div class="input-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}">
                                </div>
                                
                                <div class="input-group">
                                    <label>Role</label>
                                    <input type="text" value="{{ ucfirst($user->role) }}" disabled>
                                </div>
                                
                                <div class="input-group">
                                    <label>Tanggal Dibuat</label>
                                    <input type="text" value="{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}" disabled>
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
            
        });
        
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
    </script>
@endsection
