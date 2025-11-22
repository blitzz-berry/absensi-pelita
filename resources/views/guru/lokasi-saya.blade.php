@extends('layouts.app')

@section('title', 'Lokasi Saya - Sistem Absensi Guru')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        
        .location-map {
            height: 400px;
            background: #e3f2fd;
            border-radius: 8px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .accuracy-info {
            margin-top: 10px;
            font-size: 14px;
            padding: 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .accuracy-good {
            background-color: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        
        .accuracy-bad {
            background-color: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        
        .pulse-ring {
            content: '';
            width: 20px;
            height: 20px;
            border: 5px solid #1976D2;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulsate 1.5s infinite ease-out;
            opacity: 0;
            z-index: 0;
        }
        
        @keyframes pulsate {
            0% { transform: translate(-50%, -50%) scale(0.1); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; }
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

                    <div id="accuracy-display" style="text-align: center; margin-bottom: 15px;"></div>
                    
                    <button class="current-location-btn" id="getLocationBtn">
                        <i class="material-icons left">my_location</i> Mulai Pelacakan Akurat
                    </button>
                    
                    <div class="location-map" id="location-map"></div>
                    
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
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

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
            
            updateClock();
            setInterval(updateClock, 1000);
            
            // Variabel Global
            let map = null;
            let marker = null;
            let circle = null;
            let watchId = null;
            let bestAccuracy = Infinity;
            const TARGET_ACCURACY = 20; // Target akurasi dalam meter
            
            // Inisialisasi Peta
            function initMap() {
                // Default coordinate (Indonesia)
                map = L.map('location-map').setView([-6.2088, 106.8456], 13);
                
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }
            
            // Panggil initMap saat halaman load, tapi sembunyikan marker dulu
            initMap();

            // Fungsi update UI Peta
            function updateMap(lat, lng, accuracy) {
                const latLng = [lat, lng];
                
                if (!marker) {
                    marker = L.marker(latLng).addTo(map);
                } else {
                    marker.setLatLng(latLng);
                }
                
                if (!circle) {
                    circle = L.circle(latLng, {
                        color: '#1976D2',
                        fillColor: '#1976D2',
                        fillOpacity: 0.15,
                        radius: accuracy
                    }).addTo(map);
                } else {
                    circle.setLatLng(latLng);
                    circle.setRadius(accuracy);
                }
                
                map.setView(latLng, 18); // Zoom in dekat
            }
            
            // Fungsi untuk mendapatkan lokasi dengan watchPosition
            function startTracking() {
                const locationBtn = document.getElementById('getLocationBtn');
                const statusEl = document.getElementById('location-status');
                const displayEl = document.getElementById('location-display');
                const accuracyEl = document.getElementById('accuracy-display');
                
                locationBtn.innerHTML = '<span class="loading"></span> Mencari Sinyal Terbaik...';
                locationBtn.disabled = true;
                statusEl.textContent = "Mencari Sinyal...";
                statusEl.style.color = "#FF9800"; // Orange
                
                if (!navigator.geolocation) {
                    displayEl.textContent = "Geolocation tidak didukung browser ini.";
                    return;
                }

                // Reset best accuracy
                bestAccuracy = Infinity;

                const options = {
                    enableHighAccuracy: true, // Paksa gunakan GPS
                    timeout: 15000,           // Waktu tunggu agak lama
                    maximumAge: 0             // Jangan pakai cache!
                };

                watchId = navigator.geolocation.watchPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        
                        // Update UI Teks
                        displayEl.textContent = `Lokasi: ${lat.toFixed(7)}, ${lng.toFixed(7)}`;
                        
                        // Cek apakah ini lokasi paling akurat sejauh ini
                        if (accuracy < bestAccuracy) {
                            bestAccuracy = accuracy;
                        }

                        // Update Status Akurasi
                        let accuracyHtml = `Akurasi: <strong>${Math.round(accuracy)} meter</strong>`;
                        let accuracyClass = '';
                        
                        if (accuracy <= TARGET_ACCURACY) {
                            accuracyHtml += ` <i class="material-icons tiny" style="vertical-align: middle;">check_circle</i> Sangat Baik`;
                            accuracyClass = 'accuracy-good';
                            
                            // Jika akurasi sudah bagus, update status jadi hijau
                            statusEl.textContent = 'Terverifikasi (Akurat)';
                            statusEl.style.color = '#4CAF50';
                            locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Lokasi Akurat Ditemukan';
                            locationBtn.disabled = false;
                        } else {
                            accuracyHtml += ` <i class="material-icons tiny" style="vertical-align: middle;">warning</i> Mencari sinyal lebih baik...`;
                            accuracyClass = 'accuracy-bad';
                            
                            // Masih mencari
                            statusEl.textContent = 'Mencari presisi...';
                            statusEl.style.color = '#FF9800';
                        }
                        
                        accuracyEl.innerHTML = `<div class="accuracy-info ${accuracyClass}">${accuracyHtml}</div>`;
                        
                        // Update Peta
                        updateMap(lat, lng, accuracy);
                    },
                    function(error) {
                        let msg = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED: msg = "Izin lokasi ditolak."; break;
                            case error.POSITION_UNAVAILABLE: msg = "Lokasi tidak tersedia."; break;
                            case error.TIMEOUT: msg = "Waktu habis mencari lokasi."; break;
                            default: msg = "Error tidak diketahui."; break;
                        }
                        displayEl.textContent = msg;
                        statusEl.textContent = "Gagal";
                        statusEl.style.color = "#F44336";
                        locationBtn.disabled = false;
                        locationBtn.innerHTML = '<i class="material-icons left">refresh</i> Coba Lagi';
                        
                        // Stop watching on error
                        if(watchId) navigator.geolocation.clearWatch(watchId);
                    },
                    options
                );
            }
            
            // Event listener untuk tombol lokasi
            document.getElementById('getLocationBtn').addEventListener('click', function() {
                // Jika sedang tracking, stop dulu (reset)
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
                startTracking();
            });
        });
    </script>
@endsection
