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

        .aksi-column {
            text-align: center;
            vertical-align: middle;
            width: 100px; /* Sesuaikan lebar kolom aksi */
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-hadir { background-color: rgba(76, 175, 80, 0.1); color: #4CAF50; }
        .status-terlambat { background-color: rgba(255, 193, 7, 0.1); color: #FFC107; }
        .status-izin { background-color: rgba(33, 150, 243, 0.1); color: #2196F3; }
        .status-sakit { background-color: rgba(156, 39, 176, 0.1); color: #9C27B0; }
        .status-alpha { background-color: rgba(244, 67, 54, 0.1); color: #F44336; }
        .status-belum-absen { background-color: rgba(158, 158, 158, 0.1); color: #9E9E9E; }

        .btn-sm.btn-icon {
            padding: 6px;
            margin: 0 2px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-pdf {
            background-color: #d9534f;
            color: white;
        }

        .btn-excel {
            background-color: #5cb85c;
            color: white;
        }

        .btn-sm.btn-icon:hover {
            opacity: 0.8;
        }

        .success-message {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #e8f5e9;
            color: #2e7d32;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }

        /* Custom Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px; /* Jarak antar elemen */
            margin-top: 30px;
            padding: 0;
            list-style: none; /* Hapus list-style jika menggunakan <ul> */
        }

        .pagination-arrow,
        .pagination span.active {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            padding: 0;
            margin: 0 2px;
            background-color: #ffffff;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-arrow:hover:not(.disabled) {
            background-color: #f0f5ff;
            color: #1976D2;
            border-color: #1976D2;
        }

        .pagination span.active {
            background-color: #1976D2;
            color: white;
            border-color: #1976D2;
            cursor: default; /* Nonaktifkan cursor pointer untuk halaman aktif */
        }

        .pagination-arrow.disabled {
            color: #ccc;
            background-color: #f9f9f9;
            border-color: #eee;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination .page-link:focus {
            outline: 0;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2); /* Fokus ring */
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
                <!-- Combined Filter Section for Daily Recap and Monthly Export -->
                <div class="filter-section" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: end; padding: 15px; background: #f9f9f9; border-radius: 8px; border: 1px solid #e0e0e0;">
                    <!-- Form Filter Harian -->
                    <form method="GET" action="{{ route('admin.rekap-absensi') }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: end; flex: 1 1 280px;">
                        <div class="filter-subgroup" style="display: flex; flex-direction: column; flex: 1 1 150px;">
                            <label for="tanggal" style="font-size: 13px; font-weight: 500; color: #424242;">Tanggal Harian</label>
                            <input type="date" name="tanggal" id="tanggal" class="filter-control" value="{{ $tanggal ?? date('Y-m-d') }}" style="padding: 8px 10px; font-size: 13px;">
                        </div>

                        <button type="submit" class="btn-export" style="margin-bottom: 2px; white-space: nowrap; padding: 10px 16px; font-size: 13px;">
                            <i class="material-icons" style="font-size: 18px;">autorenew</i> Tampilkan
                        </button>
                    </form>

                    <!-- Container untuk Input Bulan/Tahun dan Tombol Export (Rekap & Gaji) -->
                    <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: end; flex: 1 1 320px;">
                        <!-- Input Bulan dan Tahun (digunakan bersama untuk kedua export) -->
                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            <div class="filter-subgroup" style="display: flex; flex-direction: column; flex: 1 1 100px;">
                                <select name="bulan_export" id="bulan_export" class="filter-control" style="padding: 8px 10px; font-size: 13px;" onchange="updateFormAction()">
                                    <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>Jan</option>
                                    <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>Feb</option>
                                    <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>Mar</option>
                                    <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>Apr</option>
                                    <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>Jun</option>
                                    <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>Jul</option>
                                    <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>Agu</option>
                                    <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>Sep</option>
                                    <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>Okt</option>
                                    <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>Nov</option>
                                    <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>Des</option>
                                </select>
                            </div>
                            <div class="filter-subgroup" style="display: flex; flex-direction: column; flex: 1 1 100px;">
                                <select name="tahun_export" id="tahun_export" class="filter-control" style="padding: 8px 10px; font-size: 13px;" onchange="updateFormAction()">
                                    <?php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 5;
                                    $endYear = $currentYear + 2;
                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        $selected = ($i == $currentYear) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Export Rekap dan Gaji -->
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <!-- Form Export Rekap (dengan action yang diupdate oleh JS) -->
                            <form method="POST" action="{{ route('admin.rekap-absensi.export.excel.global') }}" id="export-rekap-form" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="bulan" id="bulan_rekap" value="{{ date('m') }}">
                                <input type="hidden" name="tahun" id="tahun_rekap" value="{{ date('Y') }}">
                                <button type="submit" class="btn-export" id="btn-export-rekap" style="margin-bottom: 2px; padding: 10px 16px; font-size: 13px;">
                                    <i class="material-icons" style="font-size: 18px;">file_download</i> Export Rekap
                                </button>
                            </form>

                            <!-- Form Export Gaji (dengan action yang diupdate oleh JS) -->
                            <form method="POST" action="{{ route('admin.rekap-absensi.export.gaji.excel.global') }}" id="export-gaji-form" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="bulan" id="bulan_gaji" value="{{ date('m') }}">
                                <input type="hidden" name="tahun" id="tahun_gaji" value="{{ date('Y') }}">
                                <button type="submit" class="btn-export" id="btn-export-gaji" style="margin-bottom: 2px; padding: 10px 16px; font-size: 13px; background: linear-gradient(135deg, #9C27B0, #7B1FA2);">
                                    <i class="material-icons" style="font-size: 18px;">file_download</i> Export Gaji
                                </button>
                            </form>
                        </div>
                    </div>
                </div> <!-- End of .filter-section -->

                <script>
                    function updateFormAction() {
                        const bulanVal = document.getElementById('bulan_export').value;
                        const tahunVal = document.getElementById('tahun_export').value;

                        // Update nilai hidden input di form rekap
                        document.getElementById('bulan_rekap').value = bulanVal;
                        document.getElementById('tahun_rekap').value = tahunVal;

                        // Update nilai hidden input di form gaji
                        document.getElementById('bulan_gaji').value = bulanVal;
                        document.getElementById('tahun_gaji').value = tahunVal;
                    }

                    // Panggil sekali saat halaman load untuk set nilai awal
                    updateFormAction();
                </script>

                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <!-- Tombol export global (bulan/tahun) dihapus karena filter sekarang berdasarkan tanggal -->
                </div>
                
                <!-- Summary Statistics Cards -->
                <div class="summary-cards">
                    <div class="summary-card hadir">
                        <div class="summary-value">{{ $absensi_harian->where('status', 'hadir')->count() }}</div>
                        <div class="summary-label">Total Hadir</div>
                    </div>
                    <div class="summary-card terlambat">
                        <div class="summary-value">{{ $absensi_harian->where('status', 'terlambat')->count() }}</div>
                        <div class="summary-label">Total Terlambat</div>
                    </div>
                    <div class="summary-card izin">
                        <div class="summary-value">{{ $absensi_harian->where('status', 'izin')->count() }}</div>
                        <div class="summary-label">Total Izin</div>
                    </div>
                    <div class="summary-card sakit">
                        <div class="summary-value">{{ $absensi_harian->where('status', 'sakit')->count() }}</div>
                        <div class="summary-label">Total Sakit</div>
                    </div>
                    <div class="summary-card alpha">
                        <div class="summary-value">{{ $absensi_harian->where('status', 'alpha')->count() }}</div>
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
                                <th>Status</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Lokasi Masuk</th>
                                <th>Lokasi Pulang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guru as $guruItem)
                                @php
                                    $absensiGuru = $absensi_harian->get($guruItem->id);
                                @endphp
                                <tr>
                                    <td class="name-col">
                                        {{ $guruItem->nama ?? 'N/A' }}
                                    </td>
                                    <td>{{ $guruItem->nomor_id ?? 'N/A' }}</td>
                                    <td>
                                        @if($absensiGuru)
                                            <span class="status-badge status-{{ $absensiGuru->status }}">
                                                {{ ucfirst($absensiGuru->status) }}
                                            </span>
                                        @else
                                            <span class="status-badge status-belum-absen">Belum Absen</span>
                                        @endif
                                    </td>
                                    <td>{{ $absensiGuru->jam_masuk ?? '-' }}</td>
                                    <td>{{ $absensiGuru->jam_pulang ?? '-' }}</td>
                                    <td>{{ $absensiGuru->lokasi_masuk ?? '-' }}</td>
                                    <td>{{ $absensiGuru->lokasi_pulang ?? '-' }}</td>
                                    <td class="aksi-column">
                                        <!-- Link untuk ekspor Excel harian per guru -->
                                        <a href="{{ route('admin.rekap-absensi.export.excel', ['user_id' => $guruItem->id]) }}?tanggal={{ $tanggal }}" class="btn btn-sm btn-icon btn-excel" title="Download Excel Harian">
                                            <i class="material-icons">file_download</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">Tidak ada data guru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    @if (!$guru->onFirstPage())
                        <a href="{{ $guru->previousPageUrl() }}" class="pagination-arrow">«</a>
                    @else
                        <span class="pagination-arrow disabled">«</span>
                    @endif

                    @foreach ($guru->getUrlRange(1, $guru->lastPage()) as $page => $url)
                        @if ($page == $guru->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($guru->hasMorePages())
                        <a href="{{ $guru->nextPageUrl() }}" class="pagination-arrow">»</a>
                    @else
                        <span class="pagination-arrow disabled">»</span>
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
            

            // Initial update for clock is already handled above
            // No more auto-submit on change for date input, manual submit via button

            // Get the new date input and period display element
            const tanggalInput = document.getElementById('tanggal');
            const periodDisplay = document.querySelector('.period-value');

            // Update period display based on the date input value
            function updatePeriodDisplay() {
                const tanggalValue = tanggalInput.value;
                if (tanggalValue) {
                    const dateObject = new Date(tanggalValue + 'T00:00:00'); // Add time to avoid timezone issues
                    periodDisplay.textContent = dateObject.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                } else {
                    // Fallback if no date is selected, though the input likely has a default value
                    periodDisplay.textContent = 'Belum dipilih';
                }
            }

            // Add event listener to update period display when date input changes
            tanggalInput.addEventListener('change', updatePeriodDisplay);

            // Initial update on page load using the value from the input
            updatePeriodDisplay();

        });
    </script>
@endsection