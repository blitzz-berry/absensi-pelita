@extends('layouts.app')

@section('title', 'Peta Kehadiran - Sistem Absensi Guru PLUS Pelita Insani')

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
        
        .filter-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .filter-group label {
            font-weight: 500;
            color: #424242;
            font-size: 14px;
        }
        
        .filter-control {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .filter-control:focus {
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .btn-filter {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            align-self: flex-end;
        }
        
        .btn-filter:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
        }
        
        .map-container {
            height: 500px;
            background: #e3f2fd;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .map-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }
        
        .map-icon {
            font-size: 80px;
            color: #1976D2;
            margin-bottom: 20px;
        }
        
        .map-title {
            font-size: 24px;
            color: #1976D2;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .map-subtitle {
            font-size: 16px;
            color: #64b5f6;
            text-align: center;
            max-width: 600px;
            line-height: 1.6;
        }
        
        .legend-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        
        .legend-hadir { background-color: #4CAF50; }
        .legend-terlambat { background-color: #FFC107; }
        .legend-alpha { background-color: #F44336; }
        .legend-izin { background-color: #2196F3; }
        
        .map-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .map-btn {
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .map-btn:hover {
            background: #f5f5f5;
            transform: scale(1.1);
        }
        
        .location-markers {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .location-marker {
            position: absolute;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }
        
        .marker-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .marker-hadir { background-color: #4CAF50; }
        .marker-terlambat { background-color: #FFC107; }
        .marker-alpha { background-color: #F44336; }
        .marker-izin { background-color: #2196F3; }
        
        .marker-popup {
            position: absolute;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 2000;
            display: none;
            min-width: 200px;
        }
        
        .popup-header {
            font-weight: 600;
            margin-bottom: 5px;
            color: #212121;
        }
        
        .popup-content {
            font-size: 14px;
            color: #666;
        }
        
        .popup-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .status-hadir { background-color: rgba(76, 175, 80, 0.1); color: #4CAF50; }
        .status-terlambat { background-color: rgba(255, 193, 7, 0.1); color: #FFC107; }
        .status-alpha { background-color: rgba(244, 67, 54, 0.1); color: #F44336; }
        .status-izin { background-color: rgba(33, 150, 243, 0.1); color: #2196F3; }
        
        #map { 
            height: 100%; 
            width: 100%; 
            z-index: 100; 
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar ul li a span {
                display: none;
            }
            
            .sidebar ul li a i {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .topbar {
                left: 70px;
            }
            
            .map-container {
                height: 400px;
            }
        }
    </style>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    @include('admin.components.topbar', ['currentUser' => $currentUser])
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Peta Kehadiran</h4>
            <p class="welcome-subtitle">Lokasi kehadiran guru di PLUS Pelita Insani</p>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-content">
                <!-- Filter Section -->
                <form method="GET" action="{{ route('admin.peta-kehadiran') }}">
                    <div class="filter-section">
                        <div class="filter-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="filter-control" value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div class="filter-group">
                            <label for="status">Status Kehadiran</label>
                            <select name="status" id="status" class="filter-control">
                                <option value="">Semua Status</option>
                                <option value="hadir">Hadir</option>
                                <option value="terlambat">Terlambat</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alpha">Alpha</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="kelas" class="filter-control">
                                <option value="">Semua Kelas</option>
                                <option value="1a">Kelas 1A</option>
                                <option value="1b">Kelas 1B</option>
                                <option value="2a">Kelas 2A</option>
                                <option value="2b">Kelas 2B</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-filter">
                            <i class="material-icons">search</i> Filter
                        </button>
                    </div>
                </form>
                
                <!-- Map Section -->
                <div class="map-container">
                    <div id="map"></div>
                    
                    <div class="map-controls">
                        <button class="map-btn" id="zoomInBtn">
                            <i class="material-icons">add</i>
                        </button>
                        <button class="map-btn" id="zoomOutBtn">
                            <i class="material-icons">remove</i>
                        </button>
                        <button class="map-btn" id="refreshBtn">
                            <i class="material-icons">refresh</i>
                        </button>
                    </div>
                </div>
                
                <!-- Map Info Section -->
                <div style="margin-top: 20px; display: flex; justify-content: space-around; flex-wrap: wrap; gap: 15px;">
                    <div style="text-align: center; padding: 15px; background: #e3f2fd; border-radius: 8px; flex: 1; min-width: 150px;">
                        <div style="font-size: 24px; font-weight: bold; color: #1976D2;">105</div>
                        <div style="color: #555;">Total Guru Hadir</div>
                    </div>
                    <div style="text-align: center; padding: 15px; background: #fff3e0; border-radius: 8px; flex: 1; min-width: 150px;">
                        <div style="font-size: 24px; font-weight: bold; color: #FF9800;">10</div>
                        <div style="color: #555;">Terlambat</div>
                    </div>
                    <div style="text-align: center; padding: 15px; background: #ffebee; border-radius: 8px; flex: 1; min-width: 150px;">
                        <div style="font-size: 24px; font-weight: bold; color: #F44336;">5</div>
                        <div style="color: #555;">Tidak Hadir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize Materialize dropdowns and other UI components
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
            
            // Map controls functionality
            document.getElementById('zoomInBtn').addEventListener('click', function() {
                const mapElement = document.getElementById('map');
                if (window.map) {
                    window.map.zoomIn();
                }
            });
            
            document.getElementById('zoomOutBtn').addEventListener('click', function() {
                const mapElement = document.getElementById('map');
                if (window.map) {
                    window.map.zoomOut();
                }
            });
            
            document.getElementById('refreshBtn').addEventListener('click', function() {
                // Reload the map with current data
                if (window.map) {
                    window.map.setView([-6.470063, 106.703517], 16);
                }
            });
            
            // Initialize Leaflet map
            const map = L.map('map').setView([-6.470063, 106.703517], 16);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add school marker
            const schoolIcon = L.divIcon({
                className: 'custom-school-icon',
                html: '<div style="background-color: #1976D2; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; border: 2px solid white;">S</div>',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });
            
            const schoolMarker = L.marker([-6.470063, 106.703517], {icon: schoolIcon})
                .addTo(map)
                .bindPopup('<b>PLUS Pelita Insani</b><br>Jl. Raya Pelita, Tangerang Selatan')
                .openPopup();
            
            // Add a circle to highlight school area (radius 100 meters)
            const schoolCircle = L.circle([-6.470063, 106.703517], {
                color: '#1976D2',
                fillColor: '#e3f2fd',
                fillOpacity: 0.2,
                radius: 100
            }).addTo(map).bindPopup('Area Sekolah (Radius 100m)');

            // Sample locations for teachers around the school
            const locations = [
                { lat: -6.469000, lng: 106.702500, name: 'Budi Santoso', status: 'hadir', time: '07:30:25', location: 'Gerbang Utama' },
                { lat: -6.471500, lng: 106.704000, name: 'Siti Lestari', status: 'terlambat', time: '08:15:10', location: 'Ruang Guru' },
                { lat: -6.468500, lng: 106.704500, name: 'Agus Kurniawan', status: 'izin', time: '07:00:00', location: 'Ruang 2B' },
                { lat: -6.470500, lng: 106.702000, name: 'Dewi Anggraini', status: 'alpha', time: '-', location: '-' },
                { lat: -6.469500, lng: 106.705000, name: 'Rahmat Hidayat', status: 'hadir', time: '07:25:40', location: 'Perpustakaan' },
                { lat: -6.471000, lng: 106.703000, name: 'Ani Lestari', status: 'hadir', time: '07:20:15', location: 'Laboratorium' },
                { lat: -6.468000, lng: 106.703500, name: 'Ahmad Fauzi', status: 'terlambat', time: '08:05:30', location: 'Aula' }
            ];

            // Add markers to the map for each teacher
            locations.forEach(location => {
                // Create custom marker icon based on status
                let iconColor, popupClass;
                
                if (location.status === 'hadir') {
                    iconColor = '#4CAF50';
                    popupClass = 'status-hadir';
                } else if (location.status === 'terlambat') {
                    iconColor = '#FFC107';
                    popupClass = 'status-terlambat';
                } else if (location.status === 'izin') {
                    iconColor = '#2196F3';
                    popupClass = 'status-izin';
                } else {
                    iconColor = '#F44336';
                    popupClass = 'status-alpha';
                }

                const markerIcon = L.divIcon({
                    className: 'custom-marker-icon',
                    html: `<div style="background-color: ${iconColor}; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; border: 2px solid white;">${location.name.charAt(0)}</div>`,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const marker = L.marker([location.lat, location.lng], {icon: markerIcon})
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width: 200px;">
                            <div class="popup-header" style="font-weight: 600; margin-bottom: 5px; color: #212121;">${location.name}</div>
                            <div class="popup-content">
                                Status: <span class="popup-status ${popupClass}" style="display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; margin-top: 5px;">${location.status.charAt(0).toUpperCase() + location.status.slice(1)}</span><br>
                                Waktu: ${location.time}<br>
                                Lokasi: ${location.location}
                            </div>
                        </div>
                    `);
            });

            // Store map instance in global variable for later use
            window.map = map;
        });
    </script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection