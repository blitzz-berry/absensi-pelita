@extends('layouts.app')

@section('title', 'Pengajuan Izin - Sistem Absensi Guru PLUS Pelita Insani')

@section('styles')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #F5F7FB;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            overflow-x: hidden;
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
            min-height: calc(100vh - 60px);
            width: calc(100% - 260px);
        }
        
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            background: #fff;
            overflow: hidden;
            margin-bottom: 30px;
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
            font-size: 20px;
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
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #424242;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #1976D2, #2196F3);
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
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(25, 118, 210, 0.4);
        }
        
        .btn-cancel {
            background: #f5f5f5;
            color: #555;
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            margin-left: 10px;
        }
        
        .btn-cancel:hover {
            background: #e0e0e0;
        }
        
        .file-input {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }
        
        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            display: block;
            padding: 12px 15px;
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .file-input-label:hover {
            background: #e0e0e0;
        }
        
        .file-name {
            margin-top: 5px;
            font-size: 12px;
            color: #757575;
            text-align: center;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-draft { background-color: rgba(158, 158, 158, 0.1); color: #9E9E9E; }
        .status-diajukan { background-color: rgba(255, 193, 7, 0.1); color: #FFC107; }
        .status-disetujui { background-color: rgba(76, 175, 80, 0.1); color: #4CAF50; }
        .status-ditolak { background-color: rgba(244, 67, 54, 0.1); color: #F44336; }
        
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        
        .history-table th, .history-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .history-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #555;
        }
        
        .history-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1976D2, #2196F3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        
        /* Modal Styles */
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

        #admin-pengajuan-izin .x-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 3000;
        }

        #admin-pengajuan-izin .x-modal.is-open {
            display: block;
        }

        #admin-pengajuan-izin .x-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.55);
            z-index: 2990;
        }

        #admin-pengajuan-izin .x-dialog {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 3000;
        }

        #admin-pengajuan-izin .x-content {
            width: min(900px, 95vw);
            max-height: 90vh;
            overflow: hidden;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        #admin-pengajuan-izin .x-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid #E5E7EB;
            background: #ffffff;
            color: #111827;
            font-size: 22px;
            line-height: 32px;
            cursor: pointer;
        }

        #admin-pengajuan-izin .x-body {
            padding: 22px 60px 22px 22px;
            max-height: calc(90vh - 20px);
            overflow: auto;
            overflow-x: hidden;
        }

        #admin-pengajuan-izin .izin-title {
            font-size: 26px;
            font-weight: 800;
            color: #2F80ED;
            margin: 0 0 14px;
        }

        #admin-pengajuan-izin .izin-modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        #admin-pengajuan-izin .izin-section {
            background: #F8FAFC;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }

        #admin-pengajuan-izin .izin-modal-grid .izin-section {
            margin-bottom: 0;
        }

        #admin-pengajuan-izin .izin-section-title {
            font-weight: 800;
            color: #2F80ED;
            margin: 0 0 10px;
            font-size: 16px;
        }

        #admin-pengajuan-izin .izin-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 6px 0;
        }

        #admin-pengajuan-izin .izin-row span:last-child {
            font-weight: 600;
            color: #111827;
        }

        #admin-pengajuan-izin .izin-muted {
            color: #6B7280;
        }

        #admin-pengajuan-izin .izin-text {
            margin: 0;
            color: #111827;
        }

        #admin-pengajuan-izin .izin-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
        }

        #admin-pengajuan-izin .izin-pill.approved { background: #DCFCE7; color: #166534; }
        #admin-pengajuan-izin .izin-pill.rejected { background: #FEE2E2; color: #991B1B; }
        #admin-pengajuan-izin .izin-pill.pending { background: #FEF3C7; color: #92400E; }

        #admin-pengajuan-izin .izin-link {
            color: #2F80ED;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        body.modal-lock {
            overflow: hidden !important;
        }
        
        /* Spinner animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        
        .modal-footer {
            border-top: 1px solid #e0e0e0;
            padding: 20px 30px;
            text-align: right;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #F44336, #C62828);
            color: white;
        }
        
        .btn-secondary {
            background: #f5f5f5;
            color: #555;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Stats cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 24px;
        }
        
        .stat-diajukan .stat-icon { background: linear-gradient(135deg, #FFC107, #FF9800); }
        .stat-disetujui .stat-icon { background: linear-gradient(135deg, #4CAF50, #2E7D32); }
        .stat-ditolak .stat-icon { background: linear-gradient(135deg, #F44336, #C62828); }
        
        .stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }
        
        .stat-label {
            font-size: 14px;
            color: #757575;
            margin: 0;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .action-button {
            padding: 8px;
            border-radius: 50%;
            background: #f5f5f5;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-button:hover {
            background: #e0e0e0;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }

            .card-content {
                padding: 20px;
            }

            .stats-container {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .stat-card {
                padding: 14px;
            }

            .stat-number {
                font-size: 22px;
            }

            .stat-label {
                font-size: 12px;
            }

            .table-responsive {
                overflow: visible;
            }

            .history-table thead {
                display: none;
            }

            .history-table,
            .history-table tbody,
            .history-table tr,
            .history-table td {
                display: block;
                width: 100%;
            }

            .history-table tr {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 12px;
                margin-bottom: 12px;
                background: #ffffff;
            }

            .history-table td {
                border: none;
                padding: 6px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                text-align: left;
            }

            .history-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }

            .history-table td.empty-cell {
                display: block;
                text-align: center;
            }

            .history-table td:last-child {
                justify-content: flex-start;
            }

            .history-table td:last-child::before {
                display: none;
            }

            .action-buttons {
                justify-content: flex-start;
            }
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
                width: calc(100% - 70px);
                padding: 20px;
            }
            
            .topbar {
                left: 70px;
                padding: 0 15px;
            }
            
            .modal-content {
                margin: 10% auto;
                width: 95%;
                max-height: 80vh;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
        }

        #admin-pengajuan-izin {
            overflow-x: hidden;
        }

        #admin-pengajuan-izin .is-container {
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            #admin-pengajuan-izin .is-container {
                max-width: 640px;
            }
        }

        @media (max-width: 767px) {
            #admin-pengajuan-izin .izin-sakit-main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 16px 0 24px !important;
            }

            #admin-pengajuan-izin .is-container {
                padding-left: 16px;
                padding-right: 16px;
                padding-left: max(16px, env(safe-area-inset-left));
                padding-right: max(16px, env(safe-area-inset-right));
            }

            #admin-pengajuan-izin .is-cards {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            #admin-pengajuan-izin .is-card {
                width: 100%;
                margin: 0;
                padding: 16px;
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(15,23,42,0.08);
                background: #ffffff;
                box-sizing: border-box;
            }

            #admin-pengajuan-izin .izin-modal-grid {
                grid-template-columns: 1fr;
            }

            #admin-pengajuan-izin .x-dialog {
                padding: 16px;
            }

            #admin-pengajuan-izin .x-body {
                padding: 20px 52px 20px 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div id="admin-pengajuan-izin">
        <!-- Sidebar -->
        @include('admin.components.sidebar')
        
        <!-- Top Bar -->
        @include('admin.components.topbar', ['currentUser' => $currentUser])
        
        <!-- Main Content - Full Screen -->
        <div class="main-content izin-sakit-main">
            <div class="is-container">
                <div class="welcome-section">
                    <h4 class="welcome-title">Pengajuan Izin & Sakit</h4>
                    <p class="welcome-subtitle">Manajemen pengajuan izin guru di PLUS Pelita Insani</p>
                </div>
                
                <!-- Stats Cards -->
                <div class="stats-container is-cards">
                    <div class="stat-card stat-diajukan is-card">
                        <div class="stat-icon">
                            <i class="material-icons">hourglass_empty</i>
                        </div>
                        <div class="stat-number">{{ $pengajuanIzin->where('status', 'diajukan')->count() }}</div>
                        <p class="stat-label">Menunggu Persetujuan</p>
                    </div>
                    
                    <div class="stat-card stat-disetujui is-card">
                        <div class="stat-icon">
                            <i class="material-icons">check_circle</i>
                        </div>
                        <div class="stat-number">{{ $pengajuanIzin->where('status', 'disetujui')->count() }}</div>
                        <p class="stat-label">Telah Disetujui</p>
                    </div>
                    
                    <div class="stat-card stat-ditolak is-card">
                        <div class="stat-icon">
                            <i class="material-icons">cancel</i>
                        </div>
                        <div class="stat-number">{{ $pengajuanIzin->where('status', 'ditolak')->count() }}</div>
                        <p class="stat-label">Telah Ditolak</p>
                    </div>
                </div>
                
                <!-- Riwayat Pengajuan Izin -->
                <div class="card dashboard-card">
                    <div class="card-content">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <span class="card-title">Daftar Pengajuan Izin</span>
                            <div style="font-size: 14px; color: #757575;">
                                Total: {{ $pengajuanIzin->count() }} pengajuan
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th style="width: 18%;">Guru</th>
                                        <th style="width: 13%;">Tanggal</th>
                                        <th style="width: 8%;">Jenis</th>
                                        <th style="width: 18%;">Periode</th>
                                        <th style="width: 15%;">Alasan</th>
                                        <th style="width: 8%;">Status</th>
                                        <th style="width: 15%;">Disetujui Oleh</th>
                                        <th style="width: 5%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanIzin as $izin)
                                <tr>
                                    <td data-label="Guru">
                                        <div class="user-info">
                                            <div class="user-avatar">{{ strtoupper(substr($izin->user->nama ?? 'N/A', 0, 2)) }}</div>
                                            <span>{{ $izin->user->nama ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Tanggal">{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y') }}</td>
                                    <td data-label="Jenis">
                                        <span style="background: {{ $izin->jenis_pengajuan === 'izin' ? '#e3f2fd' : '#fce4ec' }}; color: {{ $izin->jenis_pengajuan === 'izin' ? '#1976D2' : '#C2185B' }}; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                            {{ ucfirst($izin->jenis_pengajuan) }}
                                        </span>
                                    </td>
                                    <td data-label="Periode">{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}</td>
                                    <td data-label="Alasan">
                                        <div style="max-width: 170px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $izin->alasan }}">
                                            {{ $izin->alasan }}
                                        </div>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge
                                            @if($izin->status === 'diajukan') status-diajukan
                                            @elseif($izin->status === 'disetujui') status-disetujui
                                            @else status-ditolak @endif">
                                            {{ ucfirst($izin->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Disetujui Oleh">
                                        @if($izin->status !== 'diajukan' && $izin->approvedBy)
                                            <div style="font-size: 12px;">
                                                <div>{{ $izin->approvedBy->nama ?? 'N/A' }}</div>
                                                @if($izin->approved_at)
                                                    <div style="color: #757575;">{{ \Carbon\Carbon::parse($izin->approved_at)->format('d M Y H:i') }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span style="color: #9e9e9e; font-style: italic;">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <button class="action-button btn-detail" data-id="{{ $izin->id }}" title="Lihat detail">
                                                <i class="material-icons" style="font-size: 18px;">remove_red_eye</i>
                                            </button>

                                            @if($izin->status === 'diajukan')
                                                <button class="action-button btn-setujui" data-id="{{ $izin->id }}" title="Setujui">
                                                    <i class="material-icons" style="font-size: 18px; color: #4CAF50;">check_circle</i>
                                                </button>
                                                <button class="action-button btn-tolak" data-id="{{ $izin->id }}" title="Tolak">
                                                    <i class="material-icons" style="font-size: 18px; color: #F44336;">cancel</i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-cell" style="text-align: center; padding: 60px;">
                                        <i class="material-icons" style="font-size: 48px; color: #bdbdbd; margin-bottom: 15px;">event_note</i>
                                        <p style="margin: 0; color: #9e9e9e; font-size: 16px;">Tidak ada pengajuan izin</p>
                                        <p style="margin: 5px 0 0 0; color: #bdbdbd; font-size: 14px;">Belum ada guru yang mengajukan izin/sakit</p>
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

        <!-- Modal Detail Izin -->
        <div id="izinDetailModal" class="x-modal" aria-hidden="true">
            <div class="x-backdrop" data-close></div>
            <div class="x-dialog" role="dialog" aria-modal="true" aria-labelledby="izinDetailTitle">
                <div class="x-content">
                    <button type="button" class="x-close" data-close aria-label="Tutup">&times;</button>
                    <div class="x-body">
                        <h4 class="izin-title" id="izinDetailTitle">Detail Pengajuan Izin</h4>
                        <div id="detail-content">
                            <!-- Detail akan dimuat secara dinamis -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Setujui/Tolak Izin -->
        <div id="aksiModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="aksiModalTitle">Konfirmasi Aksi</h4>
                    <span class="close">&times;</span>
                </div>
                <form id="aksiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="statusInput">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan_admin">Catatan Admin (Opsional):</label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control" rows="3" placeholder="Tambahkan catatan untuk guru..."></textarea>
                        </div>
                        <p id="konfirmasiText"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-modal">Batal</button>
                        <button type="submit" class="btn" id="submitAksi">Konfirmasi</button>
                    </div>
                </form>
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
            
            // Modal functionality
            const aksiModal = document.getElementById('aksiModal');
            const detailModal = document.getElementById('izinDetailModal');
            const detailContent = document.getElementById('detail-content');

            function updateBodyLock() {
                const detailOpen = detailModal && detailModal.classList.contains('is-open');
                const aksiOpen = aksiModal && aksiModal.style.display === 'block';
                if (detailOpen || aksiOpen) {
                    document.body.classList.add('modal-lock');
                    return;
                }
                document.body.classList.remove('modal-lock');
            }

            function openDetailModal() {
                if (!detailModal) {
                    return;
                }
                closeAksiModal();
                detailModal.classList.add('is-open');
                detailModal.setAttribute('aria-hidden', 'false');
                updateBodyLock();
            }

            function closeDetailModal() {
                if (!detailModal) {
                    return;
                }
                detailModal.classList.remove('is-open');
                detailModal.setAttribute('aria-hidden', 'true');
                updateBodyLock();
            }

            function openAksiModal() {
                if (!aksiModal) {
                    return;
                }
                closeDetailModal();
                aksiModal.style.display = 'block';
                updateBodyLock();
            }

            function closeAksiModal() {
                if (!aksiModal) {
                    return;
                }
                aksiModal.style.display = 'none';
                updateBodyLock();
            }

            if (detailModal) {
                detailModal.querySelectorAll('[data-close]').forEach(button => {
                    button.addEventListener('click', closeDetailModal);
                });
            }

            if (aksiModal) {
                aksiModal.querySelectorAll('.close, .close-modal').forEach(button => {
                    button.addEventListener('click', closeAksiModal);
                });
            }

            window.addEventListener('click', function(event) {
                if (aksiModal && event.target === aksiModal) {
                    closeAksiModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    if (detailModal && detailModal.classList.contains('is-open')) {
                        closeDetailModal();
                        return;
                    }
                    if (aksiModal && aksiModal.style.display === 'block') {
                        closeAksiModal();
                    }
                }
            });
            
            // Detail button functionality
            const detailButtons = document.querySelectorAll('.btn-detail');
            detailButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    
                    // Show loading indicator
                    detailContent.innerHTML = `
                        <div class="izin-section">
                            <div class="izin-section-title">Memuat</div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="spinner" style="border: 4px solid #e5e7eb; border-top: 4px solid #2F80ED; border-radius: 50%; width: 32px; height: 32px; animation: spin 1s linear infinite;"></div>
                                <span class="izin-muted">Memuat detail...</span>
                            </div>
                        </div>
                    `;
                    
                    openDetailModal();
                    
                    // Fetch detail via AJAX
                    fetch(`/admin/pengajuan-izin/${id}/detail`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const statusClass = data.izin.status === 'diajukan'
                                ? 'pending'
                                : (data.izin.status === 'disetujui' ? 'approved' : 'rejected');

                            detailContent.innerHTML = `
                                <div class="izin-modal-grid">
                                    <div class="izin-section">
                                        <div class="izin-section-title">Informasi Guru</div>
                                        <div class="izin-row">
                                            <span class="izin-muted">Nama</span>
                                            <span>${data.izin.user.nama}</span>
                                        </div>
                                        <div class="izin-row">
                                            <span class="izin-muted">Nomor ID</span>
                                            <span>${data.izin.user.nomor_id}</span>
                                        </div>
                                    </div>

                                    <div class="izin-section">
                                        <div class="izin-section-title">Periode Izin</div>
                                        <div class="izin-row">
                                            <span class="izin-muted">Mulai</span>
                                            <span>${data.izin.tanggal_mulai_formatted}</span>
                                        </div>
                                        <div class="izin-row">
                                            <span class="izin-muted">Selesai</span>
                                            <span>${data.izin.tanggal_selesai_formatted}</span>
                                        </div>
                                        <div class="izin-row">
                                            <span class="izin-muted">Durasi</span>
                                            <span>${data.izin.durasi} hari</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="izin-section">
                                    <div class="izin-section-title">Detail Pengajuan</div>
                                    <div class="izin-row">
                                        <span class="izin-muted">Jenis Pengajuan</span>
                                        <span>${data.izin.jenis_pengajuan_formatted}</span>
                                    </div>
                                    <div class="izin-row">
                                        <span class="izin-muted">Tanggal Pengajuan</span>
                                        <span>${data.izin.created_at_formatted}</span>
                                    </div>
                                    <div class="izin-row">
                                        <span class="izin-muted">Status</span>
                                        <span class="izin-pill ${statusClass}">${data.izin.status_formatted}</span>
                                    </div>
                                </div>

                                <div class="izin-section">
                                    <div class="izin-section-title">Alasan</div>
                                    <p class="izin-text">${data.izin.alasan}</p>
                                </div>
                                
                                ${data.izin.catatan_admin ? `
                                <div class="izin-section">
                                    <div class="izin-section-title">Catatan Admin</div>
                                    <p class="izin-text">${data.izin.catatan_admin}</p>
                                </div>
                                ` : ''}

                                ${(data.izin.status === 'disetujui' || data.izin.status === 'ditolak') && data.izin.approved_by ? `
                                <div class="izin-section">
                                    <div class="izin-section-title">Informasi Persetujuan</div>
                                    <div class="izin-row">
                                        <span class="izin-muted">Disetujui/Ditolak oleh</span>
                                        <span>${data.izin.approved_by}</span>
                                    </div>
                                    <div class="izin-row">
                                        <span class="izin-muted">Tanggal</span>
                                        <span>${data.izin.approved_at_formatted}</span>
                                    </div>
                                    ${data.izin.admin_notes ? `
                                    <div class="izin-row">
                                        <span class="izin-muted">Catatan</span>
                                        <span>${data.izin.admin_notes}</span>
                                    </div>
                                    ` : ''}
                                </div>
                                ` : ''}

                                ${data.izin.bukti_file ? `
                                <div class="izin-section">
                                    <div class="izin-section-title">Bukti Pendukung</div>
                                    <a class="izin-link" href="/storage/izin_files/${data.izin.bukti_file}" target="_blank" rel="noopener">
                                        <i class="material-icons">insert_drive_file</i>
                                        <span>${data.izin.bukti_file}</span>
                                    </a>
                                </div>
                                ` : ''}
                            `;
                        } else {
                            detailContent.innerHTML = `
                                <div class="izin-section">
                                    <div class="izin-section-title">Gagal memuat</div>
                                    <p class="izin-text">Error memuat detail: ${data.message}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        detailContent.innerHTML = `
                            <div class="izin-section">
                                <div class="izin-section-title">Gagal memuat</div>
                                <p class="izin-text">Error memuat detail. Silakan coba lagi.</p>
                            </div>
                        `;
                    });
                });
            });
            
            // Setujui button functionality
            const setujuiButtons = document.querySelectorAll('.btn-setujui');
            setujuiButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    
                    // Set form action
                    document.getElementById('aksiForm').action = `/admin/pengajuan-izin/${id}/status`;
                    document.getElementById('statusInput').value = 'disetujui';
                    document.getElementById('aksiModalTitle').textContent = 'Setujui Pengajuan Izin';
                    document.getElementById('konfirmasiText').innerHTML = 'Apakah Anda yakin ingin menyetujui pengajuan izin ini?<br><small style="color: #666;">Guru akan menerima notifikasi tentang persetujuan ini.</small>';
                    document.getElementById('submitAksi').className = 'btn btn-success';
                    document.getElementById('submitAksi').textContent = 'Setujui';
                    
                    openAksiModal();
                });
            });
            
            // Tolak button functionality
            const tolakButtons = document.querySelectorAll('.btn-tolak');
            tolakButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    
                    // Set form action
                    document.getElementById('aksiForm').action = `/admin/pengajuan-izin/${id}/status`;
                    document.getElementById('statusInput').value = 'ditolak';
                    document.getElementById('aksiModalTitle').textContent = 'Tolak Pengajuan Izin';
                    document.getElementById('konfirmasiText').innerHTML = 'Apakah Anda yakin ingin menolak pengajuan izin ini?<br><small style="color: #666;">Guru akan menerima notifikasi tentang penolakan ini.</small>';
                    document.getElementById('submitAksi').className = 'btn btn-danger';
                    document.getElementById('submitAksi').textContent = 'Tolak';
                    
                    openAksiModal();
                });
            });
            
            // Handle form submission with AJAX
            const aksiForm = document.getElementById('aksiForm');
            aksiForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = this.action;
                
                // Show loading state
                const submitButton = document.getElementById('submitAksi');
                const originalText = submitButton.textContent;
                submitButton.textContent = 'Memproses...';
                submitButton.disabled = true;
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        closeAksiModal();
                        
                        // Show success message
                        alert(data.message);
                        
                        // Reload page to show updated status
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                });
            });
        });
    </script>
@endsection
