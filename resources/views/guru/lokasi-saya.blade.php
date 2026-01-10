@extends('layouts.app')

@section('title', 'Lokasi Saya - Sistem Absensi Guru')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <style>
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
        
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            background: #fff;
            overflow: hidden;
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

        .accuracy-tip {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 6px;
            background: #fff3e0;
            color: #e65100;
            font-size: 13px;
            line-height: 1.4;
        }

        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('guru.components.sidebar')
    
    <!-- Top Bar -->
    @include('guru.components.topbar')
    
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
                    <div id="accuracy-tip" class="accuracy-tip" style="display: none;"></div>
                    
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
            try {
                var elems = document.querySelectorAll('.dropdown-trigger');
                var instances = M.Dropdown.init(elems, {
                    coverTrigger: false
                });
            } catch (e) {
                console.warn('Materialize init skipped:', e);
            }

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
            let highAccuracyTimerId = null;
            let bestAccuracy = Infinity;
            const TARGET_ACCURACY = 20; // Target akurasi dalam meter
            const LOCATION_TIMEOUT = 5 * 60 * 1000; // 5 menit dalam milidetik
            const HIGH_ACCURACY_MAX_WAIT = 25000; // Batas tunggu untuk akurasi tinggi
            const QUICK_TIMEOUT = 6000;
            const QUICK_MAX_AGE = 120000;
            const hasLeaflet = typeof L !== 'undefined';
            const ACCURACY_TIP_DELAY = 12000;
            let accuracyTipTimerId = null;

            // Fungsi baca lokasi dari localStorage
            function getLastLocation() {
                try {
                    const stored = localStorage.getItem('last_location');
                    if (!stored) return null;

                    const data = JSON.parse(stored);
                    const now = Date.now();
                    const elapsed = now - data.timestamp;

                    // Cek apakah lokasi masih valid (kurang dari 5 menit)
                    if (elapsed < LOCATION_TIMEOUT) {
                        return data;
                    } else {
                        // Hapus data lama jika sudah kadaluarsa
                        localStorage.removeItem('last_location');
                        return null;
                    }
                } catch (e) {
                    console.error('Error reading location from storage:', e);
                    return null;
                }
            }

            // Fungsi simpan lokasi ke localStorage
            function saveLocation(lat, lng, accuracy) {
                const data = {
                    lat: lat,
                    lng: lng,
                    accuracy: accuracy,
                    timestamp: Date.now()
                };
                localStorage.setItem('last_location', JSON.stringify(data));
            }

            // Tampilin lokasi terakhir yang valid
            function displayLastLocation(locationData) {
                const displayEl = document.getElementById('location-display');
                const statusEl = document.getElementById('location-status');
                const accuracyEl = document.getElementById('accuracy-display');
                const locationBtn = document.getElementById('getLocationBtn');

                displayEl.textContent = `Lokasi: ${locationData.lat.toFixed(7)}, ${locationData.lng.toFixed(7)}`;

                let accuracyHtml = `Akurasi: <strong>${Math.round(locationData.accuracy)} meter</strong>`;
                let accuracyClass = '';

                if (locationData.accuracy <= TARGET_ACCURACY) {
                    accuracyHtml += ` <i class="material-icons tiny" style="vertical-align: middle;">check_circle</i> Lokasi Terakhir (Valid)`;
                    accuracyClass = 'accuracy-good';
                    statusEl.textContent = 'Terakhir Digunakan (Valid)';
                    statusEl.style.color = '#4CAF50';
                    locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Gunakan Lokasi Ini';
                    locationBtn.disabled = false;
                } else {
                    accuracyHtml += ` <i class="material-icons tiny" style="vertical-align: middle;">warning</i> Lokasi Tidak Akurat`;
                    accuracyClass = 'accuracy-bad';
                    statusEl.textContent = 'Lokasi Tidak Akurat';
                    statusEl.style.color = '#FF9800';
                    locationBtn.innerHTML = '<i class="material-icons left">refresh</i> Perbarui Lokasi';
                    locationBtn.disabled = false;
                }

                accuracyEl.innerHTML = `<div class="accuracy-info ${accuracyClass}">${accuracyHtml}</div>`;

                // Update peta dengan lokasi terakhir
                if (map && marker) {
                    marker.setLatLng([locationData.lat, locationData.lng]);
                    if (circle) {
                        circle.setLatLng([locationData.lat, locationData.lng]);
                        circle.setRadius(locationData.accuracy);
                    }
                    map.setView([locationData.lat, locationData.lng], 18);
                }
            }

            // Inisialisasi Peta
            function initMap() {
                if (!hasLeaflet) {
                    return;
                }
                // Default coordinate (Indonesia)
                map = L.map('location-map').setView([-6.2088, 106.8456], 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            }

            // Panggil initMap saat halaman load, tapi sembunyikan marker dulu
            initMap();
            if (!hasLeaflet) {
                const mapContainer = document.getElementById('location-map');
                if (mapContainer) {
                    mapContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: #757575;">Peta tidak dapat dimuat. Cek koneksi internet untuk Leaflet.</div>';
                }
            }

            // Fungsi update UI Peta
            function updateMap(lat, lng, accuracy) {
                if (!map) {
                    return;
                }
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

            function updateLocationUI(lat, lng, accuracy, label) {
                const displayEl = document.getElementById('location-display');
                const statusEl = document.getElementById('location-status');
                const accuracyEl = document.getElementById('accuracy-display');
                const locationBtn = document.getElementById('getLocationBtn');
                const tipEl = document.getElementById('accuracy-tip');

                displayEl.textContent = `Lokasi: ${lat.toFixed(7)}, ${lng.toFixed(7)}`;

                let accuracyHtml = `Akurasi: <strong>${Math.round(accuracy)} meter</strong>`;
                let accuracyClass = '';

                if (accuracy <= TARGET_ACCURACY) {
                    accuracyHtml += ' <i class="material-icons tiny" style="vertical-align: middle;">check_circle</i> Akurat';
                    accuracyClass = 'accuracy-good';
                    statusEl.textContent = label || 'Terverifikasi (Akurat)';
                    statusEl.style.color = '#4CAF50';
                    locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Lokasi Akurat Ditemukan';
                    locationBtn.disabled = false;
                    if (tipEl) {
                        tipEl.style.display = 'none';
                    }
                } else {
                    accuracyHtml += ' <i class="material-icons tiny" style="vertical-align: middle;">warning</i> Menunggu akurasi <= ' + TARGET_ACCURACY + 'm';
                    accuracyClass = 'accuracy-bad';
                    statusEl.textContent = label || 'Menunggu akurasi lebih baik...';
                    statusEl.style.color = '#FF9800';
                    locationBtn.innerHTML = '<i class="material-icons left">hourglass_top</i> Menunggu Akurasi';
                    locationBtn.disabled = true;
                }

                accuracyEl.innerHTML = `<div class="accuracy-info ${accuracyClass}">${accuracyHtml}</div>`;
                updateMap(lat, lng, accuracy);
            }

            function stopHighAccuracyWatch() {
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
                if (highAccuracyTimerId) {
                    clearTimeout(highAccuracyTimerId);
                    highAccuracyTimerId = null;
                }
                if (accuracyTipTimerId) {
                    clearTimeout(accuracyTipTimerId);
                    accuracyTipTimerId = null;
                }
            }

            // Cek apakah ada lokasi valid sebelumnya saat halaman dibuka
            const lastLocation = getLastLocation();
            if (lastLocation) {
                displayLastLocation(lastLocation);

                // Update tombol untuk mengganti lokasi atau gunakan lokasi yang ada
                const locationBtn = document.getElementById('getLocationBtn');
                locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Gunakan Lokasi Ini';
                locationBtn.disabled = false;
            }

            function setStatusMessage(message, color) {
                const statusEl = document.getElementById('location-status');
                statusEl.textContent = message;
                statusEl.style.color = color;
            }

            function requestQuickPosition() {
                if (!navigator.geolocation) {
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        if (accuracy < bestAccuracy) {
                            bestAccuracy = accuracy;
                            saveLocation(lat, lng, accuracy);
                        }

                        updateLocationUI(lat, lng, accuracy, 'Lokasi cepat didapat, memperbaiki akurasi...');
                    },
                    function() {
                        // Abaikan error quick, lanjut high accuracy
                    },
                    {
                        enableHighAccuracy: false,
                        timeout: QUICK_TIMEOUT,
                        maximumAge: QUICK_MAX_AGE
                    }
                );
            }

            function quickLocate() {
                if (!navigator.geolocation) {
                    return;
                }

                const options = {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 60000
                };

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        if (accuracy < bestAccuracy) {
                            bestAccuracy = accuracy;
                            saveLocation(lat, lng, accuracy);
                        }

                        updateLocationUI(lat, lng, accuracy, 'Lokasi cepat didapat, memperbaiki akurasi...');
                    },
                    function() {
                        // Abaikan error cepat, akan ditangani oleh high accuracy
                    },
                    options
                );
            }

            // Fungsi untuk mendapatkan lokasi dengan watchPosition
            function startTracking() {
                const locationBtn = document.getElementById('getLocationBtn');
                const statusEl = document.getElementById('location-status');
                const displayEl = document.getElementById('location-display');
                const accuracyEl = document.getElementById('accuracy-display');
                const tipEl = document.getElementById('accuracy-tip');

                locationBtn.innerHTML = '<span class="loading"></span> Mencari lokasi...';
                locationBtn.disabled = true;
                statusEl.textContent = "Mencari lokasi...";
                statusEl.style.color = "#FF9800"; // Orange
                if (tipEl) {
                    tipEl.style.display = 'none';
                    tipEl.textContent = '';
                }

                if (!window.isSecureContext) {
                    displayEl.textContent = "Geolocation hanya bisa diakses di HTTPS atau localhost.";
                    statusEl.textContent = "Tidak aman";
                    statusEl.style.color = "#F44336";
                    locationBtn.disabled = false;
                    locationBtn.innerHTML = '<i class="material-icons left">refresh</i> Coba Lagi';
                    return;
                }

                if (!navigator.geolocation) {
                    displayEl.textContent = "Geolocation tidak didukung browser ini.";
                    return;
                }

                // Reset best accuracy
                bestAccuracy = Infinity;

                // Ambil lokasi cepat terlebih dahulu
                requestQuickPosition();

                const options = {
                    enableHighAccuracy: true, // Paksa gunakan GPS
                    timeout: 15000,           // Waktu tunggu agak lama
                    maximumAge: 0             // Jangan pakai cache!
                };

                // Tampilkan tips jika akurasi belum membaik setelah beberapa detik
                accuracyTipTimerId = setTimeout(function() {
                    if (tipEl) {
                        tipEl.style.display = 'block';
                        tipEl.textContent = 'Tips akurasi: aktifkan GPS mode High Accuracy, nyalakan Wi-Fi, dan coba di area terbuka. Di laptop/PC tanpa GPS, akurasi 20m sering tidak tercapai.';
                    }
                }, ACCURACY_TIP_DELAY);

                // Stop tracking jika terlalu lama agar tidak menggantung
                highAccuracyTimerId = setTimeout(function() {
                    stopHighAccuracyWatch();
                    if (bestAccuracy <= TARGET_ACCURACY) {
                        statusEl.textContent = 'Terverifikasi (Akurat)';
                        statusEl.style.color = '#4CAF50';
                        locationBtn.innerHTML = '<i class="material-icons left">my_location</i> Lokasi Akurat Ditemukan';
                        locationBtn.disabled = false;
                    } else {
                        statusEl.textContent = 'Akurasi belum cukup';
                        statusEl.style.color = '#FF9800';
                        locationBtn.innerHTML = '<i class="material-icons left">refresh</i> Coba Lagi';
                        locationBtn.disabled = false;
                        if (tipEl) {
                            tipEl.style.display = 'block';
                            tipEl.textContent = 'Akurasi masih di atas 20m. Coba pindah ke area terbuka atau gunakan perangkat dengan GPS (HP).';
                        }
                    }
                }, HIGH_ACCURACY_MAX_WAIT);

                watchId = navigator.geolocation.watchPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        // Cek apakah ini lokasi paling akurat sejauh ini
                        if (accuracy < bestAccuracy) {
                            bestAccuracy = accuracy;

                            // Simpan lokasi terbaik ke localStorage
                            saveLocation(lat, lng, accuracy);
                        }

                        updateLocationUI(lat, lng, accuracy);

                        // Stop watchPosition karena udah dapet akurasi bagus
                        if (accuracy <= TARGET_ACCURACY) {
                            stopHighAccuracyWatch();
                        }
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
                        stopHighAccuracyWatch();
                    },
                    options
                );
            }

            const locationBtn = document.getElementById('getLocationBtn');
            if (!locationBtn) {
                return;
            }

            // Event listener untuk tombol lokasi
            locationBtn.addEventListener('click', function() {
                // Cek apakah tombol digunakan untuk "Gunakan Lokasi Ini" atau "Perbarui Lokasi"
                const currentText = this.innerHTML;

                if (currentText.includes('Gunakan Lokasi Ini') || currentText.includes('Lokasi Akurat Ditemukan') || currentText.includes('Lokasi Terakhir')) {
                    // Lokasi akurat siap digunakan
                    M.toast({html: 'Lokasi akurat siap digunakan!'});
                } else {
                    // Jika sedang tracking, stop dulu (reset)
                    if (watchId) {
                        navigator.geolocation.clearWatch(watchId);
                        watchId = null;
                    }
                    startTracking();
                }
            });

            // Auto start jika izin sudah granted dan belum ada lokasi
            if (navigator.permissions && !lastLocation) {
                navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                    if (result.state === 'granted') {
                        setStatusMessage('Mendeteksi lokasi secara otomatis...', '#FF9800');
                        startTracking();
                    } else if (result.state === 'denied') {
                        setStatusMessage('Izin lokasi ditolak di browser', '#F44336');
                    }
                }).catch(function() {
                    // Permissions API tidak tersedia
                });
            }
        });
    </script>
@endsection
