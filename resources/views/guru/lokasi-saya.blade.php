@extends('layouts.app')

@section('title', 'Lokasi Saya - Sistem Absensi Guru')

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
            padding-top: 0;
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
            background: #fff;
            overflow: hidden;
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
            margin-bottom: 25px;
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
        
        .location-section {
            text-align: center;
            padding: 30px;
        }
        
        .location-icon {
            font-size: 64px;
            color: #1976D2;
            margin-bottom: 20px;
        }
        
        .location-description {
            font-size: 18px;
            margin: 15px 0;
            color: #212121;
        }
        
        .location-coordinates {
            font-size: 16px;
            color: #757575;
            margin: 10px 0;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
        }
        
        .current-location-btn {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .current-location-btn:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .location-map {
            height: 300px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }
        
        .location-map::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, transparent 49%, rgba(255,255,255,0.3) 50%, transparent 51%),
                linear-gradient(transparent 49%, rgba(255,255,255,0.3) 50%, transparent 51%);
            background-size: 30px 30px;
        }
        
        .status-section {
            margin-top: 30px;
        }
        
        .status-card {
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .status-title {
            font-size: 16px;
            color: #757575;
            margin-bottom: 5px;
        }
        
        .status-value {
            font-size: 24px;
            font-weight: 600;
            color: #4CAF50;
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    <div class="sidebar">
        <div style="padding: 0 10px 5px 10px; text-align: center; border-bottom: 1px solid #eee; display: flex; justify-content: center; align-items: center; margin-top: -60px;">
            <img src="{{ asset('image/logo-pelita.png') }}" alt="Logo Pelita" style="width: 140px; height: 140px; object-fit: contain;">
        </div>
        <ul>
            <li><a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) class="active" @endif><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li><a href="{{ route('guru.absensi.harian') }}" @if(request()->routeIs('guru.absensi.harian')) class="active" @endif><i class="material-icons">calendar_today</i> Absensi Harian</a></li>
            <li><a href="{{ route('guru.riwayat.kehadiran') }}" @if(request()->routeIs('guru.riwayat.kehadiran')) class="active" @endif><i class="material-icons">history</i> Riwayat Kehadiran</a></li>
            <li><a href="{{ route('guru.lokasi.saya') }}" @if(request()->routeIs('guru.lokasi.saya')) class="active" @endif><i class="material-icons">location_on</i> Lokasi Saya</a></li>
            <li><a href="{{ route('guru.izin') }}" @if(request()->routeIs('guru.izin')) class="active" @endif><i class="material-icons">event_note</i> Izin/Sakit</a></li>
            <li><a href="#"><i class="material-icons">settings</i> Pengaturan</a></li>
        </ul>
    </div>
    
    <!-- Top Bar -->
    <div class="topbar">
        <div class="clock-display" id="live-clock">00:00:00</div>
        @php
            $fotoProfileUrl = $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5';
        @endphp
        <div class="profile-menu dropdown-trigger" data-target="dropdown-profile">
            <img src="{{ $fotoProfileUrl }}" 
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
            <h4 class="welcome-title">Lokasi Saya</h4>
            <p class="welcome-subtitle">Tentukan lokasi Anda saat ini untuk absensi</p>
        </div>
        
        <div class="dashboard-card">
            <div class="card-content">
                <div class="location-section">
                    <i class="material-icons location-icon">location_on</i>
                    <div class="location-description">
                        Anda berada di sekitar area
                    </div>
                    <h5 style="color: #1976D2; margin: 10px 0;">PLUS Pelita Insani</h5>
                    <div class="location-coordinates" id="location-display">
                        Lokasi Anda: Menunggu izin akses lokasi...
                    </div>
                    
                    <button class="current-location-btn" id="getLocationBtn">
                        <i class="material-icons left">my_location</i> Dapatkan Lokasi Saya
                    </button>
                    
                    <div class="location-map" id="location-map">
                        <div style="text-align: center; z-index: 1;">
                            <i class="material-icons large" style="color: #1976D2; margin-bottom: 10px;">map</i>
                            <p style="color: #1976D2; margin: 0; font-weight: 500;">Peta Lokasi</p>
                            <p style="color: #90a4ae; margin: 5px 0 0 0; font-size: 14px;">Lokasi akan ditampilkan di sini</p>
                        </div>
                    </div>
                    
                    <div class="status-section">
                        <div class="status-card">
                            <div class="status-title">Status Lokasi</div>
                            <div class="status-value" id="location-status">Belum Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
            
            // Variabel untuk menyimpan lokasi
            let userLat = null;
            let userLng = null;
            
            // Fungsi untuk mendapatkan lokasi
            function getCurrentLocation() {
                const locationBtn = document.getElementById('getLocationBtn');
                locationBtn.innerHTML = '<span class="loading"></span> Mendapatkan Lokasi...';
                locationBtn.disabled = true;
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            userLat = position.coords.latitude;
                            userLng = position.coords.longitude;
                            
                            document.getElementById('location-display').textContent = 
                                `Lokasi Anda: ${userLat.toFixed(6)}, ${userLng.toFixed(6)}`;
                            
                            document.getElementById('location-status').textContent = 'Terverifikasi';
                            document.getElementById('location-status').style.color = '#4CAF50';
                            
                            locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Lokasi Ditemukan';
                            locationBtn.disabled = false;
                        },
                        function(error) {
                            let errorMessage = '';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = "Pengguna menolak permintaan akses lokasi.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = "Informasi lokasi tidak tersedia.";
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = "Permintaan waktu untuk mendapatkan lokasi pengguna habis.";
                                    break;
                                case error.UNKNOWN_ERROR:
                                    errorMessage = "Terjadi kesalahan yang tidak diketahui.";
                                    break;
                            }
                            
                            document.getElementById('location-display').textContent = 
                                `Gagal mendapatkan lokasi: ${errorMessage}`;
                            
                            document.getElementById('location-status').textContent = 'Gagal';
                            document.getElementById('location-status').style.color = '#F44336';
                            
                            locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Dapatkan Lokasi Saya';
                            locationBtn.disabled = false;
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    document.getElementById('location-display').textContent = 
                        "Geolocation tidak didukung oleh browser ini.";
                    locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Dapatkan Lokasi Saya';
                    locationBtn.disabled = true;
                }
            }
            
            // Event listener untuk tombol lokasi
            document.getElementById('getLocationBtn').addEventListener('click', getCurrentLocation);
        });
    </script>
@endsection