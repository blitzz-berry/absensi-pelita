@extends('layouts.app')

@section('title', 'Data Guru - Sistem Absensi Guru')

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
        
        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .btn-primary {
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
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .search-box {
            width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .search-input:focus {
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            white-space: nowrap; /* Mencegah teks terpecah */
        }

        th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #555;
        }

        /* Sesuaikan lebar kolom agar informasi terlihat jelas */
        th:nth-child(1), td:nth-child(1) { /* Kolom Nomor ID */
            width: 15%;
        }

        th:nth-child(2), td:nth-child(2) { /* Kolom Nama Guru */
            width: 35%;
        }

        th:nth-child(3), td:nth-child(3) { /* Kolom Jabatan */
            width: 25%;
        }

        th:nth-child(4), td:nth-child(4) { /* Kolom Status */
            width: 15%;
        }

        th:nth-child(5), td:nth-child(5) { /* Kolom Aksi */
            width: 10%;
            text-align: center;
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
        
        .status-active {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        
        .status-inactive {
            background-color: rgba(244, 67, 54, 0.1);
            color: #F44336;
        }
        
        .action-icons {
            display: flex;
            gap: 10px;
        }
        
        .action-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #f5f5f5;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .action-icons a:hover {
            background-color: #1976D2;
            color: white;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .pagination a, .pagination .active, .pagination .pagination-arrow {
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

        .pagination .disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .pagination .disabled:hover {
            background-color: transparent;
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
            <h4 class="welcome-title">Data Guru</h4>
            <p class="welcome-subtitle">Manajemen data guru di PLUS Pelita Insani</p>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-content">
                <div class="action-buttons">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <a href="{{ route('admin.data-guru.create') }}" class="btn-primary">
                            <i class="material-icons">add</i> Tambah Guru
                        </a>
                    </div>
                    <form action="{{ route('admin.data-guru') }}" method="GET" style="width: 300px;">
                        <div class="search-box">
                            <input type="text" class="search-input" name="search" value="{{ request()->search }}" placeholder="Cari guru...">
                        </div>
                    </form>
                </div>
                
                <div class="table-responsive">
                    <table id="guru-table">
                        <thead>
                            <tr>
                                <th>Nomor ID</th>
                                <th>Nama Guru</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru as $g)
                            <tr class="guru-row">
                                <td class="nomor-id">{{ $g->nomor_id }}</td>
                                <td class="nama">
                                    @if($g->gelar)
                                        {{ $g->nama }} {{ $g->gelar }}
                                    @else
                                        {{ $g->nama }}
                                    @endif
                                </td>
                                <td class="jabatan">{{ $g->jabatan ?: '-' }}</td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('admin.data-guru.edit', $g->id) }}" title="Edit"><i class="material-icons">edit</i></a>
                                        <a href="#" onclick="confirmDelete({{ $g->id }})" title="Hapus"><i class="material-icons">delete</i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    @if ($guru->onFirstPage())
                        <span class="pagination-arrow disabled">«</span>
                    @else
                        <a href="{{ $guru->previousPageUrl() }}" class="pagination-arrow">«</a>
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
        // Initialize dropdown
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });
            
            // Server-side search is active, client-side search removed
            // The search form now sends a GET request to the server
        });
        
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus guru ini? Data yang dihapus tidak dapat dikembalikan.')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/data-guru/${id}`;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                form.appendChild(methodInput);
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
