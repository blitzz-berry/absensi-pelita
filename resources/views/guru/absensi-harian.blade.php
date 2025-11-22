@extends('layouts.app')

@section('title', 'Absensi Harian - Sistem Absensi Guru')

@section('styles')
    <style>
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
        
        .date-time-card {
            background-color: rgba(33, 150, 243, 0.1);
        }
        
        .status-card {
            background-color: rgba(76, 175, 80, 0.1);
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
        
        .status-belum {
            background-color: rgba(158, 158, 158, 0.1);
            color: #9E9E9E;
        }
        
        .date-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .date-navigation-btn {
            background: #1976D2;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .date-navigation-btn:hover {
            background: #1565C0;
        }
        
        .date-display {
            font-size: 20px;
            font-weight: 500;
            color: #212121;
        }
        
        .absensi-summary {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .summary-item {
            flex: 1;
            min-width: 200px;
            padding: 20px;
            border-radius: 8px;
            background: #f5f5f5;
        }
        
        .summary-title {
            font-size: 14px;
            color: #757575;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 24px;
            font-weight: 600;
            color: #212121;
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
            <h4 class="welcome-title">Absensi Harian</h4>
            <p class="welcome-subtitle">Lihat riwayat absensi harian Anda selama 7 hari terakhir</p>
        </div>
        
        <div class="dashboard-card">
            <div class="card-content">
                <div class="date-navigation">
                    <button class="date-navigation-btn" id="prevWeek">
                        <i class="material-icons">chevron_left</i> Minggu Lalu
                    </button>
                    <div class="date-display">
                        {{ \Carbon\Carbon::now()->subDays(6)->format('d M Y') }} - {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </div>
                    <button class="date-navigation-btn" id="nextWeek" disabled>
                        Minggu Berikutnya <i class="material-icons">chevron_right</i>
                    </button>
                </div>
                
                <div class="absensi-summary">
                    <div class="summary-item">
                        <div class="summary-title">Total Hari Kerja</div>
                        <div class="summary-value">{{ $riwayat_absensi->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-title">Hadir</div>
                        <div class="summary-value">{{ $riwayat_absensi->where('status', 'hadir')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-title">Terlambat</div>
                        <div class="summary-value">{{ $riwayat_absensi->where('status', 'terlambat')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-title">Belum Absen</div>
                        <div class="summary-value">{{ $riwayat_absensi->where('jam_masuk', null)->count() }}</div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
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
                                        @else status-belum @endif">
                                        {{ $absensi->jam_masuk ? ucfirst($absensi->status) : 'Belum Absen' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #9e9e9e;">
                                    Belum ada data absensi dalam 7 hari terakhir
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            
            // Navigation buttons functionality
            document.getElementById('prevWeek').addEventListener('click', function() {
                // In a real implementation, this would load previous week data
                alert('Navigasi ke minggu sebelumnya - fungsi ini akan diterapkan di implementasi lengkap');
            });
            
            document.getElementById('nextWeek').addEventListener('click', function() {
                // In a real implementation, this would load next week data
                alert('Navigasi ke minggu berikutnya - fungsi ini akan diterapkan di implementasi lengkap');
            });
        });
    </script>
@endsection