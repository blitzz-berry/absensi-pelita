@extends('layouts.app')

@section('title', 'Riwayat Kehadiran - Sistem Absensi Guru')

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
        
        .absensi-summary {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .summary-item {
            flex: 1;
            min-width: 150px;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .summary-title {
            font-size: 14px;
            color: #757575;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 24px;
            font-weight: 600;
        }
        
        .summary-hadir { background-color: rgba(76, 175, 80, 0.1); color: #4CAF50; }
        .summary-terlambat { background-color: rgba(255, 152, 0, 0.1); color: #FF9800; }
        .summary-izin { background-color: rgba(33, 150, 243, 0.1); color: #2196F3; }
        .summary-sakit { background-color: rgba(244, 67, 54, 0.1); color: #F44336; }
        .summary-alpha { background-color: rgba(158, 158, 158, 0.1); color: #9E9E9E; }
        
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
            padding: 16px;
            text-align: left;
        }
        
        .activity-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-table tbody tr:hover {
            background-color: #f5f5f5;
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
        
        .status-izin {
            background-color: rgba(33, 150, 243, 0.1);
            color: #2196F3;
        }
        
        .status-sakit {
            background-color: rgba(244, 67, 54, 0.1);
            color: #F44336;
        }
        
        .status-alpha {
            background-color: rgba(158, 158, 158, 0.1);
            color: #9E9E9E;
        }
        
        .status-belum {
            background-color: rgba(158, 158, 158, 0.1);
            color: #9E9E9E;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ddd;
            color: #1976D2;
        }
        
        .pagination .active {
            background: #1976D2;
            color: white;
        }
        
        .pagination .disabled {
            color: #999;
            cursor: not-allowed;
        }
        
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-item {
            flex: 1;
            min-width: 200px;
        }
        
        .filter-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #212121;
        }
        
        .filter-item select, .filter-item input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .btn-filter {
            background: #1976D2;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 24px;
        }
        
        .btn-filter:hover {
            background: #1565C0;
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
            <h4 class="welcome-title">Riwayat Kehadiran</h4>
            <p class="welcome-subtitle">Lihat riwayat kehadiran Anda selama 30 hari terakhir</p>
        </div>
        
        <div class="dashboard-card">
            <div class="card-content">
                <!-- Ringkasan Kehadiran -->
                <div class="absensi-summary">
                    <div class="summary-item summary-hadir">
                        <div class="summary-title">Hadir</div>
                        <div class="summary-value">{{ $total_hadir }}</div>
                    </div>
                    <div class="summary-item summary-terlambat">
                        <div class="summary-title">Terlambat</div>
                        <div class="summary-value">{{ $total_terlambat }}</div>
                    </div>
                    <div class="summary-item summary-izin">
                        <div class="summary-title">Izin</div>
                        <div class="summary-value">{{ $total_izin }}</div>
                    </div>
                    <div class="summary-item summary-sakit">
                        <div class="summary-title">Sakit</div>
                        <div class="summary-value">{{ $total_sakit }}</div>
                    </div>
                    <div class="summary-item summary-alpha">
                        <div class="summary-title">Alpha</div>
                        <div class="summary-value">{{ $total_alpha }}</div>
                    </div>
                </div>
                
                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="filter-item">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai">
                    </div>
                    <div class="filter-item">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai">
                    </div>
                    <div class="filter-item">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="hadir">Hadir</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                    <button class="btn-filter" id="filterBtn">Filter</button>
                </div>
                
                <!-- Tabel Riwayat Kehadiran -->
                <div class="table-container">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Lokasi Masuk</th>
                                <th>Lokasi Pulang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_absensi as $absensi)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->dayName }}</td>
                                <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
                                <td>
                                    <span class="status-badge 
                                        @if($absensi->status === 'hadir') status-hadir 
                                        @elseif($absensi->status === 'terlambat') status-terlambat 
                                        @elseif($absensi->status === 'izin') status-izin 
                                        @elseif($absensi->status === 'sakit') status-sakit 
                                        @elseif($absensi->status === 'alpha') status-alpha 
                                        @else status-belum @endif">
                                        {{ $absensi->jam_masuk ? ucfirst($absensi->status) : 'Belum Absen' }}
                                    </span>
                                </td>
                                <td>
                                    @if($absensi->lokasi_masuk)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $absensi->lokasi_masuk }}" target="_blank" style="color: #1976D2;">
                                            Lihat Lokasi
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($absensi->lokasi_pulang)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $absensi->lokasi_pulang }}" target="_blank" style="color: #1976D2;">
                                            Lihat Lokasi
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-small" style="background: #1976D2; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px; color: #9e9e9e;">
                                    Belum ada data absensi dalam 30 hari terakhir
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    {{ $riwayat_absensi->links() }}
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
            
            // Filter functionality
            document.getElementById('filterBtn').addEventListener('click', function() {
                const tanggalMulai = document.getElementById('tanggal_mulai').value;
                const tanggalSelesai = document.getElementById('tanggal_selesai').value;
                const status = document.getElementById('status').value;
                
                // In a real implementation, this would filter the data
                alert('Fitur filter akan diterapkan di implementasi lengkap. Parameter filter: ' 
                      + 'Tanggal Mulai: ' + tanggalMulai + ', Tanggal Selesai: ' + tanggalSelesai + ', Status: ' + status);
            });
        });
    </script>
@endsection