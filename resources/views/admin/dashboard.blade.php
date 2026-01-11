@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Absensi Guru PLUS Pelita Insani')

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
            padding: 24px;
            transition: margin-left 0.3s ease;
        }
        
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
            margin-bottom: 20px;
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
            padding: 22px;
        }
        
        .card-title {
            font-weight: 600;
            color: #212121;
            margin-bottom: 14px;
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
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }
        
        .summary-card {
            background: white;
            padding: 18px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0,0,0,0.05);
            border-left: 4px solid #1976D2;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        
        .summary-card.hadir { border-left-color: #4CAF50; }
        .summary-card.terlambat { border-left-color: #FF9800; }
        .summary-card.izin { border-left-color: #2196F3; }
        .summary-card.total { border-left-color: #2196F3; }
        
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .summary-label {
            color: #757575;
            font-size: 13px;
        }
        
        .hadir .summary-value { color: #4CAF50; }
        .terlambat .summary-value { color: #FF9800; }
        .izin .summary-value { color: #2196F3; }
        .total .summary-value { color: #2196F3; }
        
        .chart-placeholder {
            height: 250px;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .location-map {
            height: 300px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
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
        
        .chart-wrap {
            height: 220px;
        }

        .chart-wrap canvas {
            width: 100%;
            height: 100%;
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
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-table tbody tr:hover {
            background-color: #f5f5f5;
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

            .main-content {
                padding: 16px;
            }

            .summary-cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                margin-bottom: 16px;
            }

            .summary-card {
                padding: 14px;
            }

            .summary-value {
                font-size: 20px;
            }

            .summary-label {
                font-size: 12px;
            }

            .chart-wrap {
                height: 200px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    @include('admin.components.topbar', ['currentUser' => $user])
    
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
            <p class="welcome-subtitle">Dashboard Admin - Sistem Absensi Guru PLUS Pelita Insani</p>
        </div>
        
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card total">
                <div class="summary-value">{{ $totalGuru ?? 0 }}</div>
                <div class="summary-label">Total Guru</div>
            </div>
            <div class="summary-card hadir">
                <div class="summary-value">{{ $hadirHariIni ?? 0 }}</div>
                <div class="summary-label">Hadir Hari Ini</div>
            </div>
            <div class="summary-card terlambat">
                <div class="summary-value">{{ $terlambatHariIni ?? 0 }}</div>
                <div class="summary-label">Terlambat</div>
            </div>
            <div class="summary-card izin">
                <div class="summary-value">{{ $izinHariIni ?? 0 }}</div>
                <div class="summary-label">Izin/Sakit</div>
            </div>
        </div>
        
        <div class="row">
            <!-- Bar chart -->
            <div class="col s12 m6">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Kehadiran Minggu Ini</span>
                        <div class="chart-wrap">
                            <canvas id="attendanceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pie chart -->
            <div class="col s12 m6">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Persentase Kehadiran</span>
                        <div class="chart-wrap">
                            <canvas id="percentageChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="row">
            <!-- Activity log table -->
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Log Aktivitas Terbaru</span>
                        <div class="table-container">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th style="font-weight: 600; color: #212121;">Waktu</th>
                                        <th style="font-weight: 600; color: #212121;">Nama</th>
                                        <th style="font-weight: 600; color: #212121;">Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logAktivitas as $log)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($log->waktu)->format('H:i:s') }}</td>
                                        <td>{{ $log->user ? $log->user->nama : 'N/A' }}</td>
                                        <td>{{ $log->aktivitas }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; color: #9e9e9e; padding: 30px;">
                                            Tidak ada log aktivitas
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
@endsection

@section('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize dropdown
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });
            
            // Chart data from backend
            const kehadiranMingguIni = @json($kehadiranMingguIni);
            const persentaseKehadiran = {{ $persentaseKehadiran }};
            const totalAbsensi = {{ $totalAbsensi }};
            const totalAlpha = {{ $totalAlpha }};
            
            // Extract data for charts
            const days = kehadiranMingguIni.map(item => item.tanggal_pendek);
            const counts = kehadiranMingguIni.map(item => item.jumlah);
            
            // Bar Chart - Kehadiran Minggu Ini
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Jumlah Kehadiran',
                        data: counts,
                        backgroundColor: 'rgba(25, 118, 210, 0.6)',
                        borderColor: 'rgba(25, 118, 210, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
            
            // Pie Chart - Persentase Kehadiran
            const percentageCtx = document.getElementById('percentageChart').getContext('2d');
            new Chart(percentageCtx, {
                type: 'pie',
                data: {
                    labels: ['Hadir', 'Tidak Hadir (Alpha)'],
                    datasets: [{
                        data: [totalAbsensi, totalAlpha],
                        backgroundColor: [
                            'rgba(76, 175, 80, 0.6)',
                            'rgba(244, 67, 54, 0.6)'
                        ],
                        borderColor: [
                            'rgba(76, 175, 80, 1)',
                            'rgba(244, 67, 54, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
