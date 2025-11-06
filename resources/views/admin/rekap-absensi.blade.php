@extends('layouts.app')

@section('title', 'Rekap Absensi - Sistem Absensi Guru PLUS Pelita Insani')

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
            font-size: 24px;
        }
        
        .welcome-subtitle {
            margin: 0;
            color: #757575;
            font-size: 16px;
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
            padding: 25px;
            background: white;
            border-radius: 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        
        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 12px;
            color: #757575;
            z-index: 1;
            font-size: 18px;
        }
        
        .input-with-icon select {
            padding-left: 40px;
            width: 100%;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            height: 45px;
            font-size: 14px;
            color: #424242;
            cursor: pointer;
        }
        
        .input-with-icon select:focus {
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
            background: white;
        }
        
        .filter-actions {
            margin-bottom: 5px;
        }
        
        .btn-filter {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            height: 45px;
            box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
        }
        
        .btn-filter:hover {
            background: linear-gradient(135deg, #F57C00, #EF6C00);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 152, 0, 0.4);
        }
        
        .filter-group {
            min-width: 150px;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #424242;
            font-size: 14px;
        }
        
        .current-period {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #1976D2;
        }
        
        .current-period h5 {
            margin: 0;
            color: #1976D2;
            font-weight: 500;
            font-size: 16px;
        }
        
        .period-value {
            font-weight: bold;
            color: #0d47a1;
            text-transform: capitalize;
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
        
        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .export-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-export {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(76, 175, 80, 0.3);
        }
        
        .btn-export:hover {
            background: linear-gradient(135deg, #43A047, #1B5E20);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(76, 175, 80, 0.4);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #555;
        }
        
        tr:hover {
            background-color: #f9f9f9;
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
            background-color: rgba(255, 193, 7, 0.1);
            color: #FFC107;
        }
        
        .status-sakit {
            background-color: rgba(244, 67, 54, 0.1);
            color: #F44336;
        }
        
        .status-alpha {
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
            padding: 8px 15px;
            text-decoration: none;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            color: #555;
        }
        
        .pagination .active {
            background-color: #1976D2;
            color: white;
            border-color: #1976D2;
        }
        
        .pagination a:hover:not(.active) {
            background-color: #f5f5f5;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid #1976D2;
        }
        
        .summary-card.hadir { border-left-color: #4CAF50; }
        .summary-card.terlambat { border-left-color: #FF9800; }
        .summary-card.izin { border-left-color: #FFC107; }
        .summary-card.sakit { border-left-color: #F44336; }
        .summary-card.alpha { border-left-color: #9E9E9E; }
        
        .summary-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .summary-label {
            color: #757575;
            font-size: 14px;
        }
        
        .hadir .summary-value { color: #4CAF50; }
        .terlambat .summary-value { color: #FF9800; }
        .izin .summary-value { color: #FFC107; }
        .sakit .summary-value { color: #F44336; }
        .alpha .summary-value { color: #9E9E9E; }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .rekap-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .rekap-table th {
            background: linear-gradient(to bottom, #f5f7fa, #e8eaf6);
            color: #37474f;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .rekap-table td, .rekap-table th {
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .rekap-table tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        .rekap-table .name-col {
            text-align: left;
        }
        
        .rekap-table .total-col {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        
        .rekap-table .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1976D2, #2196F3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        
        .success-message {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #e8f5e9;
            color: #2e7d32;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .export-buttons {
                justify-content: center;
            }
            
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
            
            .summary-cards {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    @include('admin.components.topbar', ['currentUser' => $currentUser])
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Rekap Absensi</h4>
            <p class="welcome-subtitle">Laporan kehadiran guru di PLUS Pelita Insani</p>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-content">
                <!-- Filter Section -->
                <form method="GET" action="{{ route('admin.rekap-absensi') }}">
                    <div class="filter-section">
                        <div class="filter-group">
                            <label for="bulan">Bulan</label>
                            <div class="input-with-icon">
                                <i class="material-icons">date_range</i>
                                <select name="bulan" id="bulan" class="filter-control" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label for="tahun">Tahun</label>
                            <div class="input-with-icon">
                                <i class="material-icons">calendar_today</i>
                                <select name="tahun" id="tahun" class="filter-control" required>
                                    <option value="">Pilih Tahun</option>
                                    <option value="2025" {{ $tahun == '2025' ? 'selected' : '' }}>2025</option>
                                    <option value="2024" {{ $tahun == '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2023" {{ $tahun == '2023' ? 'selected' : '' }}>2023</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter">
                                <i class="material-icons">autorenew</i> Tampilkan Data
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Current Period Display -->
                <div class="current-period">
                    <h5>Periode: 
                        <span class="period-value">
                            @if($bulan && $tahun)
                                {{ \Carbon\Carbon::create()->month((int)$bulan)->format('F') }} {{ $tahun }}
                            @else
                                Belum dipilih
                            @endif
                        </span>
                    </h5>
                </div>
                
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <div class="export-buttons">
                        <form method="POST" action="{{ route('admin.rekap-absensi.export.excel') }}">
                            @csrf
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <button type="submit" class="btn-export">
                                <i class="material-icons">grid_on</i> Excel
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Summary Statistics Cards -->
                <div class="summary-cards">
                    <div class="summary-card hadir">
                        <div class="summary-value">{{ $rekap_absensi->sum('jumlah_hadir') }}</div>
                        <div class="summary-label">Total Hadir</div>
                    </div>
                    <div class="summary-card terlambat">
                        <div class="summary-value">{{ $rekap_absensi->sum('jumlah_terlambat') }}</div>
                        <div class="summary-label">Total Terlambat</div>
                    </div>
                    <div class="summary-card izin">
                        <div class="summary-value">{{ $rekap_absensi->sum('jumlah_izin') }}</div>
                        <div class="summary-label">Total Izin</div>
                    </div>
                    <div class="summary-card sakit">
                        <div class="summary-value">{{ $rekap_absensi->sum('jumlah_sakit') }}</div>
                        <div class="summary-label">Total Sakit</div>
                    </div>
                    <div class="summary-card alpha">
                        <div class="summary-value">{{ $rekap_absensi->sum('jumlah_alpha') }}</div>
                        <div class="summary-label">Total Alpha</div>
                    </div>
                </div>
                
                <!-- Rekap Absensi Table -->
                <div class="table-container">
                    <table class="rekap-table">
                        <thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th>Nomor ID</th>
                                <th>Hadir</th>
                                <th>Terlambat</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alpha</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekap_absensi as $rekap)
                            <tr>
                                <td class="name-col">
                                    <div class="user-info">
                                        <div class="user-avatar">{{ strtoupper(substr($rekap->user->nama ?? 'N/A', 0, 1)) }}</div>
                                        <span>{{ $rekap->user->nama ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>{{ $rekap->user->nomor_id ?? 'N/A' }}</td>
                                <td>{{ $rekap->jumlah_hadir }}</td>
                                <td>{{ $rekap->jumlah_terlambat }}</td>
                                <td>{{ $rekap->jumlah_izin }}</td>
                                <td>{{ $rekap->jumlah_sakit }}</td>
                                <td>{{ $rekap->jumlah_alpha }}</td>
                                <td class="total-col">{{ $rekap->jumlah_hadir + $rekap->jumlah_terlambat + $rekap->jumlah_izin + $rekap->jumlah_sakit + $rekap->jumlah_alpha }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">Belum ada data rekap absensi untuk bulan/tahun yang dipilih. Silakan generate terlebih dahulu.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    @if($rekap_absensi->count() > 0)
                        <span>Menampilkan {{ $rekap_absensi->count() }} data</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set CSRF token untuk semua request AJAX
        document.querySelector('meta[name="csrf-token"]').content
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
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
            
            // Auto-submit form when both month and year are selected
            const bulanSelect = document.getElementById('bulan');
            const tahunSelect = document.getElementById('tahun');
            
            function updatePage() {
                if (bulanSelect.value && tahunSelect.value) {
                    // Submit the form to update the page with new parameters
                    document.querySelector('form[method="GET"]').submit();
                }
            }
            
            // Add event listeners to both select elements
            bulanSelect.addEventListener('change', updatePage);
            tahunSelect.addEventListener('change', updatePage);
            
            // Optional: Add functionality to update period display in real-time
            function updatePeriodDisplay() {
                const bulan = bulanSelect.value;
                const tahun = tahunSelect.value;
                
                const monthNames = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                
                const periodDisplay = document.querySelector('.period-value');
                if (bulan && tahun) {
                    const bulanInt = parseInt(bulan);
                    periodDisplay.textContent = monthNames[bulanInt] + ' ' + tahun;
                } else {
                    periodDisplay.textContent = 'Belum dipilih';
                }
            }
            
            // Initial update
            updatePeriodDisplay();
            
            // Add event listeners to update period display
            bulanSelect.addEventListener('change', updatePeriodDisplay);
            tahunSelect.addEventListener('change', updatePeriodDisplay);
        });
    </script>
@endsection