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

        @media (max-width: 992px) {
            .topbar {
                left: 0;
                padding-left: 10px;
            }

            .main-content {
                margin-left: 0;
            }
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
        html.modal-open,
        body.modal-open {
            overflow: hidden;
        }

        .absensi-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
        }

        .absensi-modal.is-open {
            display: flex;
        }

        .absensi-modal .absensi-dialog {
            width: calc(100% - 2rem);
            max-width: 920px;
            margin: 0;
        }

        .absensi-modal .absensi-content {
            background-color: #ffffff;
            padding: 0;
            border: none;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.3);
            max-height: calc(100vh - 64px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .absensi-modal .modal-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            padding: 18px 22px;
            margin-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
        }
        
        .absensi-modal .modal-title {
            font-weight: 600;
            color: #212121;
            margin: 0;
            font-size: 20px;
        }
        
        .absensi-modal .modal-body {
            padding: 24px;
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #ffffff;
            overflow: auto;
            flex: 1;
            min-height: 0;
            max-height: calc(100vh - 160px);
        }

        .absensi-modal .modal-body > * {
            width: 100%;
        }
        
        .absensi-modal .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background: #f8fafc;
            color: #0f172a;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .absensi-modal .modal-close:hover {
            background: #e2e8f0;
            border-color: rgba(148, 163, 184, 0.6);
        }

        .absensi-modal .modal-close svg {
            width: 18px;
            height: 18px;
        }
        
        .camera-preview {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 20px;
            overflow: hidden;
            background: #e5e7eb;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.15);
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        #video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        #capturedImageContainer {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }

        #capturedImageContainer:empty {
            display: none;
        }

        .camera-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        #locationStatusMsg {
            padding: 10px 12px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.3);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            text-align: center;
            font-size: 13px;
            font-weight: 600;
        }

        #statusMessage {
            margin: 0;
        }
        
        .capture-btn {
            min-width: 170px;
            background: #1976D2;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 18px rgba(25, 118, 210, 0.25);
        }

        .capture-btn.secondary {
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.6);
            color: #6b7280;
            box-shadow: none;
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
            height: 100%;
            display: block;
            border-radius: 16px;
            object-fit: cover;
        }

        .history-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .history-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .history-title::after {
            content: '';
            display: block;
            width: 42px;
            height: 3px;
            background: #1976D2;
            border-radius: 999px;
            margin-top: 6px;
        }

        .history-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }

        .history-table th {
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 12px;
            text-align: left;
        }

        .history-table td {
            padding: 12px;
            font-size: 14px;
            color: #0f172a;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
        }

        @media (max-width: 576px) {
            .absensi-modal {
                padding: 0;
                align-items: flex-end;
                overflow-y: auto;
            }

            .absensi-modal .absensi-dialog {
                width: 100%;
                max-width: 100%;
            }

            .absensi-modal .absensi-content {
                border-radius: 20px 20px 0 0;
                max-height: 92vh;
            }

            .absensi-modal .modal-header {
                padding: 16px 18px;
            }

            .absensi-modal .modal-title {
                font-size: 18px;
            }

            .absensi-modal .modal-body {
                padding: 16px;
                gap: 16px;
                max-height: calc(100vh - 140px);
            }

            .camera-preview {
                border-radius: 16px;
            }

            .camera-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .capture-btn {
                min-width: 0;
                width: 100%;
            }

            .history-table th,
            .history-table td {
                padding: 10px;
                font-size: 13px;
            }
        }

        .history-table tr:first-child td {
            border-top: none;
        }

        .history-table td.empty {
            text-align: center;
            color: #94a3b8;
        }

        .camera-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.8);
            pointer-events: none;
        }

        .camera-placeholder svg {
            width: 52px;
            height: 52px;
            stroke: currentColor;
        }

        .aux-status {
            display: none;
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
    @include('guru.components.sidebar')
    
    <!-- Top Bar -->
    @include('guru.components.topbar')

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
    <div id="cameraModal" class="absensi-modal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="absensi-dialog">
            <div class="absensi-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Absensi Masuk</h4>
                <button type="button" class="modal-close" aria-label="Tutup">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="camera-preview">
                    <video id="video" autoplay playsinline></video>
                    <div id="capturedImageContainer"></div>
                    <div class="camera-placeholder" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6">
                            <path d="M3 7a2 2 0 0 1 2-2h3l1.5-2h5L16 5h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/>
                            <circle cx="12" cy="12" r="3.5"/>
                        </svg>
                    </div>
                </div>
                <div class="center-align aux-status" id="locationStatusMsg">
                    <span style="color: #9E9E9E;">Menunggu Lokasi...</span>
                </div>
                <div class="camera-actions">
                    <button id="captureBtn" class="capture-btn" type="button">Ambil Foto</button>
                    <button id="submitBtn" class="capture-btn" type="button" disabled>Submit Absen</button>
                    <button id="retryBtn" class="capture-btn secondary" type="button">Ulangi</button>
                </div>
                <div class="history-section">
                    <div class="history-title">Riwayat Absensi Terakhir</div>
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_absensi as $absensi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                    <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty">Belum ada riwayat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="center-align aux-status" id="statusMessage"></p>
            </div>
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
            let lastFocusedElement = null;
            let optimisticStatus = null;
            const TARGET_ACCURACY = 50; // Toleransi 50 meter untuk absen cepat
            const systemSettings = @json($system_settings ?? []);
            const LOCATION_REQUIRED = systemSettings.lokasi_wajib !== false;
            const SELFIE_REQUIRED = systemSettings.selfie_wajib !== false;

            const captureBtn = document.getElementById('captureBtn');
            const submitBtn = document.getElementById('submitBtn');
            const retryBtn = document.getElementById('retryBtn');
            const SUBMIT_TEXT = 'Submit Absen';

            function isFiniteNumber(value) {
                return typeof value === 'number' && !isNaN(value);
            }

            function hasLocationFix() {
                return isFiniteNumber(userLat)
                    && isFiniteNumber(userLng)
                    && isFiniteNumber(locationAccuracy);
            }

            function updateSubmitState() {
                if (!submitBtn) {
                    return;
                }
                const canSubmit = (!SELFIE_REQUIRED || !!capturedImage);
                submitBtn.disabled = !canSubmit;
            }

            
            // Update dashboard clock and date in WIB
            function updateClock() {
                try {
                    const now = new Date();
                    const timeString = window.formatWibTime ? window.formatWibTime(now) : now.toLocaleTimeString('en-GB', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                        timeZone: 'Asia/Jakarta'
                    });
                    const dateString = window.formatWibDate ? window.formatWibDate(now) : now.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        timeZone: 'Asia/Jakarta'
                    });
                    
                    const currentTimeElement = document.getElementById('current-time');
                    const currentDateElement = document.getElementById('current-date');
                    
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
            setInterval(updateClock, 60000);
            
            // (HAPUS DUPLIKASI VARIABEL DI SINI) - Done
            
            // Fungsi Start Tracking Location (Background)
            function startLocationTracking() {
                if (!LOCATION_REQUIRED) {
                    return;
                }
                if (!navigator.geolocation) {
                    console.error("Geolocation tidak didukung.");
                    return;
                }
                
                const options = {
                    enableHighAccuracy: true,
                    timeout: 30000,
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
                            locationStatusEl.style.display = 'block';
                            if (locationAccuracy <= TARGET_ACCURACY) {
                                locationStatusEl.innerHTML = `<span style="color: #4CAF50;"><i class="material-icons tiny">check</i> Lokasi Siap (Akurasi: ${Math.round(locationAccuracy)}m)</span>`;
                            } else {
                                locationStatusEl.innerHTML = `<span style="color: #FF9800;"><i class="material-icons tiny">warning</i> Akurasi ${Math.round(locationAccuracy)}m, tetap bisa submit.</span>`;
                            }
                            updateSubmitState();
                        }
                    },
                    function(error) {
                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (error && error.code === error.TIMEOUT) {
                            console.warn("Lokasi timeout, mencoba lagi...", error);
                            if (locationStatusEl) {
                                locationStatusEl.style.display = 'block';
                                locationStatusEl.innerHTML = `<span style="color: #FF9800;"><i class="material-icons tiny">schedule</i> Lokasi timeout, mencoba lagi...</span>`;
                            }
                            return;
                        }

                        console.error("Error lokasi:", error);
                        if (locationStatusEl) {
                            const message = error && error.code === error.PERMISSION_DENIED
                                ? 'Izin lokasi ditolak. Aktifkan izin lokasi di browser.'
                                : 'Gagal mendapatkan lokasi. Pastikan GPS aktif.';
                            locationStatusEl.style.display = 'block';
                            locationStatusEl.innerHTML = `<span style="color: #F44336;">${message}</span>`;
                        }
                        updateSubmitState();
                    },
                    options
                );
            }
            
            // Mulai tracking lokasi saat load
            startLocationTracking();

            function getFreshLocation() {
                return new Promise(function(resolve, reject) {
                    navigator.geolocation.getCurrentPosition(
                        resolve,
                        reject,
                        {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                });
            }

            
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
            
            function setCaptureMode(mode, allowSubmit) {
                if (!submitBtn) {
                    return;
                }

                if (allowSubmit === false) {
                    submitBtn.disabled = true;
                    return;
                }
                updateSubmitState();
            }

            function resetCameraState() {
                const capturedContainer = document.getElementById('capturedImageContainer');
                const statusMessageEl = document.getElementById('statusMessage');
                const locationStatusEl = document.getElementById('locationStatusMsg');

                capturedImage = null;
                if (capturedContainer) {
                    capturedContainer.innerHTML = '';
                }
                if (statusMessageEl) {
                    statusMessageEl.textContent = '';
                    statusMessageEl.style.display = 'none';
                }
                if (locationStatusEl) {
                    if (LOCATION_REQUIRED) {
                        locationStatusEl.style.display = 'block';
                        locationStatusEl.innerHTML = '<span style="color: #9E9E9E;">Menunggu Lokasi...</span>';
                    } else {
                        locationStatusEl.style.display = 'none';
                        locationStatusEl.textContent = '';
                    }
                }
                if (submitBtn) {
                    submitBtn.textContent = SUBMIT_TEXT;
                }
                setCaptureMode('capture');
            }

            function resetCapturePreview() {
                const capturedContainer = document.getElementById('capturedImageContainer');
                const statusMessageEl = document.getElementById('statusMessage');

                capturedImage = null;
                if (capturedContainer) {
                    capturedContainer.innerHTML = '';
                }
                if (statusMessageEl) {
                    statusMessageEl.textContent = '';
                    statusMessageEl.style.display = 'none';
                }
                if (submitBtn) {
                    submitBtn.textContent = SUBMIT_TEXT;
                }
                setCaptureMode('capture');
            }

            function applyOptimisticStatus() {
                const statusEl = document.getElementById('status-hari-ini');
                const detailEl = document.getElementById('status-detail');
                if (!statusEl || !detailEl) {
                    return;
                }
                if (!optimisticStatus) {
                    optimisticStatus = {
                        status: statusEl.textContent,
                        detail: detailEl.textContent
                    };
                }
                const actionLabel = currentAction === 'masuk'
                    ? 'Sudah Absen Masuk'
                    : currentAction === 'pulang'
                        ? 'Sudah Absen Pulang'
                        : 'Sudah Absen';
                statusEl.textContent = actionLabel;
                detailEl.textContent = 'Menunggu konfirmasi server...';
            }

            function restoreOptimisticStatus() {
                if (!optimisticStatus) {
                    return;
                }
                const statusEl = document.getElementById('status-hari-ini');
                const detailEl = document.getElementById('status-detail');
                if (statusEl) {
                    statusEl.textContent = optimisticStatus.status;
                }
                if (detailEl) {
                    detailEl.textContent = optimisticStatus.detail;
                }
                optimisticStatus = null;
            }

            function finalizeOptimisticStatus() {
                optimisticStatus = null;
            }

            // Fungsi untuk membuka modal kamera
            function openCameraModal() {
                const modal = document.getElementById('cameraModal');
                if (!modal) {
                    return;
                }
                lastFocusedElement = document.activeElement;
                resetCameraState();
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                modal.removeAttribute('inert');
                document.documentElement.classList.add('modal-open');
                document.body.classList.add('modal-open');
                startCamera();
                const closeBtn = modal.querySelector('.modal-close');
                if (closeBtn) {
                    closeBtn.focus();
                }
            }
            
            // Fungsi untuk membuka kamera
            function startCamera() {
                const video = document.getElementById('video');
                if (!video) {
                    return;
                }

                if (currentStream) {
                    video.srcObject = currentStream;
                    return;
                }

                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user',
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        },
                        audio: false
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
            
            async function handleSubmitAttendance() {
                if (SELFIE_REQUIRED && !capturedImage) {
                    alert('Silakan ambil foto terlebih dahulu!');
                    return;
                }

                if (!submitBtn) {
                    return;
                }

                applyOptimisticStatus();

                const originalText = submitBtn.textContent;
                submitBtn.innerHTML = '<span class="loading"></span> Memeriksa lokasi...';
                submitBtn.disabled = true;

                if (LOCATION_REQUIRED && !navigator.geolocation) {
                    alert('Geolocation tidak didukung browser ini.');
                    submitBtn.textContent = originalText;
                    updateSubmitState();
                    restoreOptimisticStatus();
                    return;
                }

                try {
                    if (navigator.geolocation) {
                        const position = await getFreshLocation();
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        if (!isFiniteNumber(lat) || !isFiniteNumber(lng) || !isFiniteNumber(accuracy)) {
                            throw new Error('Invalid location data');
                        }

                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (LOCATION_REQUIRED && locationStatusEl) {
                            locationStatusEl.style.display = 'block';
                            if (accuracy > TARGET_ACCURACY) {
                                const accuracyText = `${Math.round(accuracy)}m`;
                                locationStatusEl.innerHTML = `<span style="color: #FF9800;"><i class="material-icons tiny">warning</i> Akurasi ${accuracyText}, tetap lanjut submit.</span>`;
                            } else {
                                locationStatusEl.innerHTML = `<span style="color: #4CAF50;"><i class="material-icons tiny">check</i> Lokasi siap (${Math.round(accuracy)}m)</span>`;
                            }
                        }

                        userLat = lat;
                        userLng = lng;
                        locationAccuracy = accuracy;
                    }
                } catch (error) {
                    console.error('Error mendapatkan lokasi akurat:', error);
                    if (LOCATION_REQUIRED) {
                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (locationStatusEl) {
                            locationStatusEl.style.display = 'block';
                            locationStatusEl.innerHTML = '<span style="color: #F44336;">Gagal mendapatkan lokasi akurat. Coba lagi.</span>';
                        }
                        setCaptureMode('submit', false);
                        submitBtn.textContent = originalText;
                        restoreOptimisticStatus();
                        return;
                    }
                }
                
                submitBtn.innerHTML = '<span class="loading"></span> Mengirim...';
                submitBtn.disabled = true;
                
                submitAttendance(capturedImage);
            }

            // Tombol ambil foto
            if (captureBtn) {
                captureBtn.addEventListener('click', function() {
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

                    const isLocationReady = isFiniteNumber(userLat)
                        && isFiniteNumber(userLng)
                        && isFiniteNumber(locationAccuracy);

                    if (LOCATION_REQUIRED && !isLocationReady) {
                        const locationStatusEl = document.getElementById('locationStatusMsg');
                        if (locationStatusEl) {
                            locationStatusEl.style.display = 'block';
                            locationStatusEl.innerHTML = `<span style="color: #FF9800;"><i class="material-icons tiny">warning</i> Menunggu akurasi lokasi <= ${TARGET_ACCURACY}m...</span>`;
                        }
                    }

                    updateSubmitState();
                });
            }

            if (submitBtn) {
                submitBtn.addEventListener('click', function() {
                    handleSubmitAttendance();
                });
            }

            if (retryBtn) {
                retryBtn.addEventListener('click', function() {
                    resetCapturePreview();
                    startCamera();
                });
            }
            
            // Fungsi untuk mengirim data absensi
            function submitAttendance(imageData) {
                let file = null;
                if (imageData) {
                    // Konversi data URI ke blob
                    const byteString = atob(imageData.split(',')[1]);
                    const mimeString = imageData.split(',')[0].split(':')[1].split(';')[0];
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    const blob = new Blob([ab], { type: mimeString });
                    file = new File([blob], `selfie_${currentAction}_${Date.now()}.png`, { type: mimeString });
                } else if (SELFIE_REQUIRED) {
                    const statusMessageEl = document.getElementById('statusMessage');
                    if (statusMessageEl) {
                        statusMessageEl.style.display = 'block';
                        statusMessageEl.innerHTML =
                            '<span style="color: #F44336;">Foto wajib diambil sebelum absen.</span>';
                    }
                    if (submitBtn) {
                        submitBtn.textContent = SUBMIT_TEXT;
                        updateSubmitState();
                    }
                    restoreOptimisticStatus();
                    return;
                }
                
                // Pastikan lokasi valid sebelum submit
                if (LOCATION_REQUIRED && (!isFiniteNumber(userLat) || !isFiniteNumber(userLng))) {
                    const statusMessageEl = document.getElementById('statusMessage');
                    if (statusMessageEl) {
                        statusMessageEl.style.display = 'block';
                        statusMessageEl.innerHTML =
                            '<span style="color: #F44336;">Lokasi tidak valid. Harap tunggu hingga lokasi ditemukan.</span>';
                    }

                    // Kembalikan tombol ke keadaan semula
                    if (submitBtn) {
                        submitBtn.textContent = SUBMIT_TEXT;
                        updateSubmitState();
                    }
                    restoreOptimisticStatus();
                    return;
                }

                const formData = new FormData();
                if (file) {
                    formData.append('foto', file);
                }
                if (isFiniteNumber(userLat) && isFiniteNumber(userLng)) {
                    formData.append('lokasi', `${userLat},${userLng}`);
                }
                if (isFiniteNumber(locationAccuracy)) {
                    formData.append('akurasi', String(locationAccuracy));
                }

                // Tentukan URL berdasarkan action
                const url = currentAction === 'masuk' ? '{{ route("guru.absen.masuk") }}' : '{{ route("guru.absen.pulang") }}';

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    const contentType = response.headers.get('content-type') || '';
                    if (contentType.includes('application/json')) {
                        return response.json();
                    }
                    return response.text().then(text => {
                        throw new Error(text || `HTTP ${response.status}`);
                    });
                })
                .then(data => {
                    // Kembalikan tombol ke keadaan semula
                    if (submitBtn) {
                        submitBtn.textContent = SUBMIT_TEXT;
                        updateSubmitState();
                    }
                    
                    if (data.success) {
                        finalizeOptimisticStatus();
                        // Tampilkan pesan sukses
                        const statusMessageEl = document.getElementById('statusMessage');
                        if (statusMessageEl) {
                            statusMessageEl.style.display = 'block';
                            statusMessageEl.innerHTML =
                                `<span style="color: #4CAF50; font-weight: bold;">${data.message}</span>`;
                        }
                        
                        // Perbarui status dengan data terbaru dari server (delay untuk memastikan data sudah tersimpan)
                        setTimeout(updateAttendanceStatus, 1000);
                        
                        // Tutup modal setelah 2 detik
                        setTimeout(function() {
                            closeCameraModal();
                        }, 2000);
                    } else {
                        restoreOptimisticStatus();
                        let errorMessage = data && data.message ? data.message : 'Gagal mengirim data absensi';
                        if (data && data.errors) {
                            const firstError = Object.values(data.errors)[0];
                            if (Array.isArray(firstError) && firstError.length > 0) {
                                errorMessage = firstError[0];
                            }
                        }
                        // Tampilkan pesan error
                        const statusMessageEl = document.getElementById('statusMessage');
                        if (statusMessageEl) {
                            statusMessageEl.style.display = 'block';
                            statusMessageEl.innerHTML =
                                `<span style="color: #F44336;">Error: ${errorMessage}</span>`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Kembalikan tombol ke keadaan semula
                    if (submitBtn) {
                        submitBtn.textContent = SUBMIT_TEXT;
                        updateSubmitState();
                    }
                    restoreOptimisticStatus();
                    
                    const statusMessageEl = document.getElementById('statusMessage');
                    if (statusMessageEl) {
                        statusMessageEl.style.display = 'block';
                        const fallbackMessage = error && error.message
                            ? error.message
                            : 'Terjadi kesalahan saat mengirim data absensi';
                        statusMessageEl.innerHTML =
                            `<span style="color: #F44336;">${fallbackMessage}</span>`;
                    }
                });
            }
            
            // Fungsi untuk menutup modal kamera
            function stopCamera() {
                const video = document.getElementById('video');
                if (currentStream) {
                    const tracks = currentStream.getTracks();
                    tracks.forEach(track => track.stop());
                    currentStream = null;
                }
                if (video) {
                    video.pause();
                    video.srcObject = null;
                }
            }

            function closeCameraModal() {
                const modal = document.getElementById('cameraModal');
                if (modal) {
                    if (document.activeElement && modal.contains(document.activeElement)) {
                        document.activeElement.blur();
                    }
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    modal.setAttribute('inert', '');
                }
                document.documentElement.classList.remove('modal-open');
                document.body.classList.remove('modal-open');
                stopCamera();
                resetCameraState();
                if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
                    lastFocusedElement.focus();
                }
            }
            
            // Event listener untuk tombol close modal
            const closeBtn = document.querySelector('.modal-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeCameraModal);
            }
            
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
