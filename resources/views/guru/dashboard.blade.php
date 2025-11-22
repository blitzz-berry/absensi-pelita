@extends('layouts.app')

@section('title', 'Dashboard Guru - Sistem Absensi Guru')

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
            height: 100%;
            background: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .attendance-btn {
            border-radius: 12px;
            padding: 20px;
            font-size: 18px;
            font-weight: 500;
            width: 100%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .attendance-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }
        
        .btn-masuk {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
        }
        
        .btn-pulang {
            background: linear-gradient(135deg, #F44336, #C62828);
            color: white;
        }
        
        .camera-preview {
            background: linear-gradient(135deg, #e0f2f1, #f5f5f5);
            border-radius: 8px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #424242;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .camera-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, transparent 49%, rgba(255,255,255,0.3) 50%, transparent 51%),
                linear-gradient(transparent 49%, rgba(255,255,255,0.3) 50%, transparent 51%);
            background-size: 25px 25px;
        }
        
        .location-map {
            height: 200px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
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
            padding: 20px;
        }
        
        .card-title {
            font-weight: 600;
            color: #212121;
            margin-bottom: 15px;
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
        
        .date-time-card {
            background-color: rgba(33, 150, 243, 0.1);
        }
        
        .status-card {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .btn-masuk-card {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .btn-pulang-card {
            background-color: rgba(244, 67, 54, 0.1);
        }
        
        .date-display {
            font-size: 24px;
            font-weight: 600;
            color: #1976D2;
            margin: 10px 0;
        }
        
        .time-display {
            font-size: 18px;
            color: #424242;
            font-family: 'Courier New', monospace;
        }
        
        .status-display {
            font-size: 24px;
            font-weight: 600;
            color: #4CAF50;
            margin: 10px 0;
        }
        
        .status-detail {
            font-size: 16px;
            color: #666;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-hadir {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        
        .status-terlambat {
            background-color: rgba(255, 152, 0, 0.1);
            color: #FF9800;
        }
        
        .status-unsubmitted {
            background-color: rgba(158, 158, 158, 0.1);
            color: #9E9E9E;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .activity-table th {
            background: linear-gradient(to bottom, #f5f7fa, #e8eaf6);
            color: #37474f;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .activity-table th, .activity-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-table tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border: none;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 30px;
            margin-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-weight: 600;
            color: #212121;
            margin: 0;
            font-size: 20px;
        }
        
        .modal-body {
            padding: 20px 30px;
            margin-bottom: 0;
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        
        .close:hover {
            color: #000;
        }
        
        .video-container {
            width: 100%;
            text-align: center;
            margin: 20px 0;
        }
        
        #video {
            width: 100%;
            max-width: 400px;
            height: auto;
            border: 2px solid #1976D2;
            border-radius: 8px;
        }
        
        .capture-btn {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin: 10px;
            transition: all 0.3s ease;
        }
        
        .capture-btn:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
        }
        
        .capture-btn:disabled {
            background: #b0bec5;
            cursor: not-allowed;
        }
        
        .captured-image {
            width: 100%;
            max-width: 400px;
            margin: 15px auto;
            display: block;
            border: 2px solid #4CAF50;
            border-radius: 8px;
        }
        
        .loading {
            display: inline-block;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #1976D2;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            <li><a href="{{ route('guru.pengaturan') }}" @if(request()->routeIs('guru.pengaturan')) class="active" @endif><i class="material-icons">settings</i> Pengaturan</a></li>
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
            <span style="margin-left: 10px; font-weight: 500;">
                @if($user->gelar)
                    {{ $user->nama }} {{ $user->gelar }}
                @else
                    {{ $user->nama }}
                @endif
            </span>
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
            <h4 class="welcome-title">Selamat Datang,
                @if($user->gelar)
                    {{ $user->nama }} {{ $user->gelar }}
                @else
                    {{ $user->nama }}
                @endif
            </h4>
            <p class="welcome-subtitle">Dashboard Guru - Sistem Absensi Guru</p>
        </div>
        
        <div class="row">
            <!-- Tanggal & Jam Sekarang -->
            <div class="col s12 m6 l3">
                <div class="card dashboard-card date-time-card">
                    <div class="card-content">
                        <span class="card-title">Tanggal & Jam</span>
                        <div class="date-display" id="current-date">{{ $waktu_sekarang ? $waktu_sekarang->format('d M Y') : date('d M Y') }}</div>
                        <div class="time-display" id="current-time">{{ $waktu_sekarang ? $waktu_sekarang->format('H:i') : date('H:i') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Status Kehadiran Hari Ini -->
            <div class="col s12 m6 l3">
                <div class="card dashboard-card status-card">
                    <div class="card-content">
                        <span class="card-title">Status Hari Ini</span>
                        <div class="status-display" id="status-hari-ini">
                            @if($absensi_hari_ini && $absensi_hari_ini->jam_masuk)
                                {{ $absensi_hari_ini->status === 'terlambat' ? 'Terlambat' : 'Hadir' }}
                            @else
                                -
                            @endif
                        </div>
                        <div class="status-detail" id="status-detail">
                            @if($absensi_hari_ini && $absensi_hari_ini->jam_masuk)
                                Jam Masuk: {{ \Carbon\Carbon::parse($absensi_hari_ini->jam_masuk)->format('H:i') }}
                                @if($absensi_hari_ini->jam_pulang)
                                    | Jam Pulang: {{ \Carbon\Carbon::parse($absensi_hari_ini->jam_pulang)->format('H:i') }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dua tombol utama: Absen Masuk dan Absen Pulang -->
            <div class="col s12 m6 l3">
                <div class="card dashboard-card btn-masuk-card">
                    <div class="card-content center-align">
                        <button class="btn-masuk attendance-btn waves-effect waves-light" id="btn-absen-masuk" 
                            @if($absensi_hari_ini && $absensi_hari_ini->jam_masuk) disabled @endif>
                            <i class="material-icons left">check_circle</i> Absen Masuk
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col s12 m6 l3">
                <div class="card dashboard-card btn-pulang-card">
                    <div class="card-content center-align">
                        <button class="btn-pulang attendance-btn waves-effect waves-light" id="btn-absen-pulang" 
                            @if(!$absensi_hari_ini || !$absensi_hari_ini->jam_masuk || $absensi_hari_ini->jam_pulang) disabled @endif>
                            <i class="material-icons left">power_settings_new</i> Absen Pulang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Riwayat Absensi Terakhir -->
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Riwayat Absensi Terakhir</span>
                        <div class="table-container">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: 600; color: #212121;">Tanggal</th>
                                        <th style="font-weight: 600; color: #212121;">Jam Masuk</th>
                                        <th style="font-weight: 600; color: #212121;">Jam Pulang</th>
                                        <th style="font-weight: 600; color: #212121;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat_absensi as $absensi)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                        <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
                                        <td>
                                            <span class="status-badge 
                                                @if($absensi->status === 'hadir') status-hadir 
                                                @elseif($absensi->status === 'terlambat') status-terlambat 
                                                @else status-unsubmitted @endif">
                                                {{ ucfirst($absensi->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 20px; color: #9e9e9e;">
                                            Belum ada riwayat absensi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal untuk kamera -->
    <div id="cameraModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Absensi Masuk</h4>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="video-container">
                    <video id="video" autoplay playsinline></video>
                </div>
                <div class="center-align">
                    <button id="captureBtn" class="capture-btn">Ambil Foto</button>
                    <button id="submitBtn" class="capture-btn" disabled>Submit Absensi</button>
                </div>
                <div class="center-align" id="locationStatusMsg" style="margin-top: 10px; font-size: 14px; font-weight: 500;">
                    <span style="color: #9E9E9E;">Menunggu Lokasi...</span>
                </div>
                <div id="capturedImageContainer" class="center-align"></div>
                <p class="center-align" id="statusMessage"></p>
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
            
            // Variabel untuk menyimpan data kamera
            let currentStream = null;
            let capturedImage = null;
            let currentAction = null; // 'masuk' atau 'pulang'
            let userLat = null;
            let userLng = null;
            let locationAccuracy = null;
            let watchId = null;
            const TARGET_ACCURACY = 50; // Toleransi 50 meter untuk absen cepat

            
            // Update live clock
            function updateClock() {
                try {
                    const now = new Date();
                    const timeString = now.toLocaleTimeString();
                    const dateString = now.toLocaleDateString('id-ID', { 
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric' 
                    });
                    
                    const liveClockElement = document.getElementById('live-clock');
                    const currentTimeElement = document.getElementById('current-time');
                    const currentDateElement = document.getElementById('current-date');
                    
                    if (liveClockElement) {
                        liveClockElement.textContent = timeString;
                    }
                    
                    if (currentTimeElement) {
                        currentTimeElement.textContent = timeString;
                    }
                    
                    if (currentDateElement) {
                        currentDateElement.textContent = dateString;
                    }
                } catch (error) {
                    console.error('Error updating clock:', error);
                }
            }
            
            // Update clock immediately and then every second
            setTimeout(updateClock, 100);
            setInterval(updateClock, 1000);
            
            // (HAPUS DUPLIKASI VARIABEL DI SINI) - Done
            
            // Fungsi Start Tracking Location (Background)
            function startLocationTracking() {
                if (!navigator.geolocation) {
                    console.error("Geolocation tidak didukung.");
                    return;
                }
                
                const options = {
                    enableHighAccuracy: true,
                    timeout: 20000,
                    maximumAge: 0
                };
                
                watchId = navigator.geolocation.watchPosition(
                    function(position) {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        locationAccuracy = position.coords.accuracy;
                        
                        // Update status di modal jika sedang terbuka
                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (locationStatusEl) {
                            if (locationAccuracy <= TARGET_ACCURACY) {
                                locationStatusEl.innerHTML = `<span style="color: #4CAF50;"><i class="material-icons tiny">check</i> Lokasi Siap (Akurasi: ${Math.round(locationAccuracy)}m)</span>`;
                                // Enable submit button if photo exists
                                if(capturedImage) document.getElementById('submitBtn').disabled = false;
                            } else {
                                locationStatusEl.innerHTML = `<span style="color: #FF9800;"><i class="material-icons tiny">warning</i> Mencari sinyal lebih baik... (${Math.round(locationAccuracy)}m)</span>`;
                            }
                        }
                    },
                    function(error) {
                        console.error("Error lokasi:", error);
                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (locationStatusEl) {
                            locationStatusEl.innerHTML = `<span style="color: #F44336;">Gagal mendapatkan lokasi. Pastikan GPS aktif.</span>`;
                        }
                    },
                    options
                );
            }
            
            // Mulai tracking lokasi saat load
            startLocationTracking();

            
            // Fungsi untuk memperbarui status absensi secara real-time
            function updateAttendanceStatus() {
                fetch('{{ route("guru.attendance.status") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update status hari ini
                    const statusDisplay = document.getElementById('status-hari-ini');
                    const statusDetail = document.getElementById('status-detail');
                    
                    if (data.absensi_hari_ini && data.absensi_hari_ini.jam_masuk) {
                        statusDisplay.textContent = data.absensi_hari_ini.status === 'terlambat' ? 'Terlambat' : 'Hadir';
                        statusDisplay.style.color = data.absensi_hari_ini.status === 'terlambat' ? '#FF9800' : '#4CAF50';
                        
                        const jamMasuk = data.absensi_hari_ini.jam_masuk.substring(0, 5);
                        let statusText = `Jam Masuk: ${jamMasuk}`;
                        
                        if (data.absensi_hari_ini.jam_pulang) {
                            const jamPulang = data.absensi_hari_ini.jam_pulang.substring(0, 5);
                            statusText += ` | Jam Pulang: ${jamPulang}`;
                        }
                        
                        statusDetail.textContent = statusText;
                        
                        // Update tombol absen
                        document.getElementById('btn-absen-masuk').disabled = true;
                        if (!data.absensi_hari_ini.jam_pulang) {
                            document.getElementById('btn-absen-pulang').disabled = false;
                        } else {
                            document.getElementById('btn-absen-pulang').disabled = true;
                        }
                    } else {
                        statusDisplay.textContent = '-';
                        statusDetail.textContent = '-';
                        document.getElementById('btn-absen-masuk').disabled = false;
                        document.getElementById('btn-absen-pulang').disabled = true;
                    }
                    
                    // Update riwayat absensi
                    if (data.riwayat_absensi && data.riwayat_absensi.length > 0) {
                        updateAttendanceHistory(data.riwayat_absensi);
                    }
                })
                .catch(error => {
                    console.error('Error updating attendance status:', error);
                });
            }
            
            // Fungsi untuk memperbarui tabel riwayat absensi
            function updateAttendanceHistory(riwayat) {
                const tableBody = document.querySelector('.activity-table tbody');
                if (!tableBody) return;
                
                // Bersihkan tabel terlebih dahulu
                tableBody.innerHTML = '';
                
                if (riwayat.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: #9e9e9e;">Belum ada riwayat absensi</td></tr>';
                    return;
                }
                
                riwayat.forEach(function(absensi) {
                    const date = new Date(absensi.tanggal);
                    const formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                    
                    const jamMasuk = absensi.jam_masuk ? absensi.jam_masuk.substring(0, 5) : '-';
                    const jamPulang = absensi.jam_pulang ? absensi.jam_pulang.substring(0, 5) : '-';
                    
                    let statusClass = 'status-unsubmitted';
                    let statusText = 'Belum Absen';
                    if (absensi.status) {
                        statusClass = absensi.status === 'hadir' ? 'status-hadir' : 
                                    absensi.status === 'terlambat' ? 'status-terlambat' : 'status-unsubmitted';
                        statusText = absensi.status.charAt(0).toUpperCase() + absensi.status.slice(1);
                    }
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${formattedDate}</td>
                        <td>${jamMasuk}</td>
                        <td>${jamPulang}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    `;
                    tableBody.appendChild(row);
                });
            }
            
            // Perbarui data setiap 30 detik
            setInterval(updateAttendanceStatus, 30000);
            
            // Panggil update pertama setiap 5 detik
            setTimeout(updateAttendanceStatus, 5000);
            
            // Tombol absen masuk
            document.getElementById('btn-absen-masuk').addEventListener('click', function() {
                currentAction = 'masuk';
                document.getElementById('modal-title').textContent = 'Absensi Masuk';
                openCameraModal();
            });
            
            // Tombol absen pulang
            document.getElementById('btn-absen-pulang').addEventListener('click', function() {
                currentAction = 'pulang';
                document.getElementById('modal-title').textContent = 'Absensi Pulang';
                openCameraModal();
            });
            
            // Fungsi untuk membuka modal kamera
            function openCameraModal() {
                document.getElementById('cameraModal').style.display = 'block';
                startCamera();
            }
            
            // Fungsi untuk membuka kamera
            function startCamera() {
                const video = document.getElementById('video');
                
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ 
                        video: { 
                            facingMode: 'user',
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        } 
                    })
                    .then(function(stream) {
                        currentStream = stream;
                        video.srcObject = stream;
                    })
                    .catch(function(error) {
                        console.error("Gagal mengakses kamera: ", error);
                        alert("Gagal mengakses kamera. Silakan pastikan izin akses kamera sudah diberikan.");
                    });
                } else {
                    alert("Browser tidak mendukung akses kamera.");
                }
            }
            
            // Tombol ambil foto
            document.getElementById('captureBtn').addEventListener('click', function() {
                const video = document.getElementById('video');
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                capturedImage = canvas.toDataURL('image/png');
                
                // Tampilkan preview foto yang diambil
                document.getElementById('capturedImageContainer').innerHTML = 
                    '<img src="' + capturedImage + '" class="captured-image" id="capturedImagePreview" />';
                
                // Cek lokasi sebelum enable tombol
                const submitBtn = document.getElementById('submitBtn');
                if (userLat && userLng) {
                     // Jika akurasi masih buruk, user tetap bisa submit tapi kita warnai statusnya kuning (opsional: bisa di-block jika mau strict)
                     // Di sini saya biarkan enable asalkan koordinat ada, agar tidak blocking user yang buru-buru.
                     submitBtn.disabled = false;
                } else {
                    alert("Lokasi belum ditemukan. Tunggu sebentar...");
                    // Tetap disabled
                }
            });
            
            // Tombol submit absensi
            document.getElementById('submitBtn').addEventListener('click', function() {
                if (!capturedImage) {
                    alert('Silakan ambil foto terlebih dahulu!');
                    return;
                }

                if (!userLat || !userLng) {
                    alert('Lokasi belum ditemukan. Mohon tunggu sebentar atau refresh halaman.');
                    return;
                }
                
                // Tampilkan pesan loading
                const submitBtn = document.getElementById('submitBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading"></span> Mengirim...';
                submitBtn.disabled = true;
                
                // Kirim data absensi
                submitAttendance(capturedImage);
            });
            
            // Fungsi untuk mengirim data absensi
            function submitAttendance(imageData) {
                // Konversi data URI ke blob
                const byteString = atob(imageData.split(',')[1]);
                const mimeString = imageData.split(',')[0].split(':')[1].split(';')[0];
                const ab = new ArrayBuffer(byteString.length);
                const ia = new Uint8Array(ab);
                for (let i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                const blob = new Blob([ab], { type: mimeString });
                const file = new File([blob], `selfie_${currentAction}_${Date.now()}.png`, { type: mimeString });
                
                const formData = new FormData();
                formData.append('foto', file);
                formData.append('lokasi', `${userLat},${userLng}`);
                
                // Tentukan URL berdasarkan action
                const url = currentAction === 'masuk' ? '{{ route("guru.absen.masuk") }}' : '{{ route("guru.absen.pulang") }}';
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Kembalikan tombol ke keadaan semula
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.innerHTML = 'Submit Absensi';
                    submitBtn.disabled = false;
                    
                    if (data.success) {
                        // Tampilkan pesan sukses
                        document.getElementById('statusMessage').innerHTML = 
                            `<span style="color: #4CAF50; font-weight: bold;">${data.message}</span>`;
                        
                        // Perbarui status dengan data terbaru dari server (delay untuk memastikan data sudah tersimpan)
                        setTimeout(updateAttendanceStatus, 1000);
                        
                        // Tutup modal setelah 2 detik
                        setTimeout(function() {
                            closeCameraModal();
                        }, 2000);
                    } else {
                        // Tampilkan pesan error
                        document.getElementById('statusMessage').innerHTML = 
                            `<span style="color: #F44336;">Error: ${data.message}</span>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Kembalikan tombol ke keadaan semula
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.innerHTML = 'Submit Absensi';
                    submitBtn.disabled = false;
                    
                    document.getElementById('statusMessage').innerHTML = 
                        '<span style="color: #F44336;">Terjadi kesalahan saat mengirim data absensi</span>';
                });
            }
            
            // Fungsi untuk menutup modal kamera
            function closeCameraModal() {
                document.getElementById('cameraModal').style.display = 'none';
                
                // Hentikan stream kamera jika ada
                if (currentStream) {
                    const tracks = currentStream.getTracks();
                    tracks.forEach(track => track.stop());
                    currentStream = null;
                }
                
                // Reset elemen
                document.getElementById('capturedImageContainer').innerHTML = '';
                document.getElementById('statusMessage').innerHTML = '';
                document.getElementById('submitBtn').disabled = true;
                capturedImage = null;
            }
            
            // Event listener untuk tombol close modal
            document.querySelector('.close').addEventListener('click', closeCameraModal);
            
            // Close modal jika klik di luar modal content
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('cameraModal');
                if (event.target === modal) {
                    closeCameraModal();
                }
            });
        });
    </script>
@endsection