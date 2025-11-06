@extends('layouts.app')

@section('title', 'Pengajuan Izin - Sistem Absensi Guru')

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
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #212121;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn {
            padding: 2px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1976D2, #2196F3);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1565C0, #1976D2);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .btn-block {
            display: block;
            width: 100%;
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
        
        .status-diajukan {
            background-color: rgba(255, 152, 0, 0.1);
            color: #FF9800;
        }
        
        .status-disetujui {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        
        .status-ditolak {
            background-color: rgba(244, 67, 54, 0.1);
            color: #F44336;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px 15px;
            border: 2px dashed #ddd;
            border-radius: 6px;
            text-align: center;
            color: #757575;
            transition: border-color 0.3s;
        }
        
        .file-upload-label:hover {
            border-color: #1976D2;
        }
        
        .file-name {
            margin-top: 10px;
            font-size: 14px;
            color: #424242;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-col {
            flex: 1;
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
            <h4 class="welcome-title">Pengajuan Izin/Sakit</h4>
            <p class="welcome-subtitle">Ajukan izin atau sakit dengan mengisi formulir di bawah ini</p>
            <a href="{{ route('guru.lokasi.saya') }}" class="btn btn-primary" style="margin-top: 10px; text-decoration: none; display: inline-block;">
                <i class="material-icons left">location_on</i> Lihat Lokasi Saya
            </a>
        </div>
        
        <div class="row">
            <div class="col s12 m8">
                <div class="dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Formulir Pengajuan</span>
                        
                        @if(session('success'))
                            <div class="alert alert-success" style="padding: 15px; margin-bottom: 20px; background-color: #e8f5e9; border-radius: 6px; color: #2e7d32;">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger" style="padding: 15px; margin-bottom: 20px; background-color: #ffebee; border-radius: 6px; color: #c62828;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form id="izinForm" action="{{ route('guru.izin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label>Jenis Pengajuan</label>
                                        <div style="display: flex; gap: 10px; margin-top: 8px;">
                                            <button type="button" class="btn" id="btn-izin" style="flex: 1; background: #e3f2fd; color: #1976D2; border: 2px solid #bbdefb;" onclick="selectJenisPengajuan('izin')">
                                                <i class="material-icons left" style="font-size: 18px;">event_note</i> Izin
                                            </button>
                                            <button type="button" class="btn" id="btn-sakit" style="flex: 1; background: #e3f2fd; color: #1976D2; border: 2px solid #bbdefb;" onclick="selectJenisPengajuan('sakit')">
                                                <i class="material-icons left" style="font-size: 18px;">favorite</i> Sakit
                                            </button>
                                        </div>
                                        <input type="hidden" name="jenis_pengajuan" id="jenis_pengajuan" required>
                                        <div id="jenis-pengajuan-display" style="margin-top: 10px; padding: 10px; background-color: #f5f5f5; border-radius: 6px; display: none;">
                                            Jenis yang dipilih: <span id="selected-jenis"></span>
                                            <button type="button" onclick="resetJenisPengajuan()" style="margin-left: 15px; background: #ff5252; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;">Ubah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="alasan">Alasan</label>
                                <textarea name="alasan" id="alasan" class="form-control" placeholder="Jelaskan alasan pengajuan izin/sakit Anda" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="bukti_file">File Bukti (Opsional)</label>
                                <div class="file-upload">
                                    <input type="file" name="bukti_file" id="bukti_file" accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="bukti_file" class="file-upload-label">
                                        <i class="material-icons" style="vertical-align: middle; margin-right: 8px;">cloud_upload</i>
                                        Pilih file bukti (PDF, JPG, PNG maks 2MB)
                                    </label>
                                </div>
                                <div id="file-name" class="file-name" style="display: none;"></div>
                            </div>
                            
                            <button type="button" class="btn btn-primary btn-block" onclick="submitForm()" id="submitBtn">
                                <i class="material-icons left">send</i> Ajukan Izin/Sakit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col s12 m4">
                <div class="dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Status Hari Ini</span>
                        <div class="status-card" style="background-color: rgba(33, 150, 243, 0.1); padding: 20px; border-radius: 8px;">
                            <div style="text-align: center;">
                                <div style="font-size: 24px; font-weight: 600; color: #1976D2; margin: 10px 0;">
                                    @if($absensi_hari_ini && $absensi_hari_ini->jam_masuk)
                                        {{ $absensi_hari_ini->status === 'terlambat' ? 'Terlambat' : 'Hadir' }}
                                    @else
                                        -
                                    @endif
                                </div>
                                <div style="color: #757575; margin: 5px 0;">
                                    @if($absensi_hari_ini && $absensi_hari_ini->jam_masuk)
                                        Jam Masuk: {{ \Carbon\Carbon::parse($absensi_hari_ini->jam_masuk)->format('H:i') }}
                                        @if($absensi_hari_ini->jam_pulang)
                                            | Pulang: {{ \Carbon\Carbon::parse($absensi_hari_ini->jam_pulang)->format('H:i') }}
                                        @endif
                                    @else
                                        Belum Absen
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px;">
                            <h6 style="font-weight: 600; color: #212121; margin-bottom: 10px;">Panduan Pengajuan</h6>
                            <ul style="padding-left: 20px; color: #757575;">
                                <li style="margin-bottom: 8px;">Izin: untuk keperluan pribadi, keluarga, atau alasan penting lainnya</li>
                                <li style="margin-bottom: 8px;">Sakit: sertakan surat keterangan dokter jika diminta</li>
                                <li style="margin-bottom: 8px;">Pengajuan akan diproses oleh admin</li>
                                <li>Ajukan minimal 1 hari sebelum tanggal izin dimulai</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" style="margin-top: 30px;">
            <div class="col s12">
                <div class="dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Riwayat Pengajuan</span>
                        <div class="table-container">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Jenis</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajuanIzin as $izin)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y') }}</td>
                                        <td>{{ ucfirst($izin->jenis_pengajuan) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}</td>
                                        <td>
                                            <span class="status-badge 
                                                @if($izin->status === 'diajukan') status-diajukan 
                                                @elseif($izin->status === 'disetujui') status-disetujui 
                                                @else status-ditolak @endif">
                                                {{ ucfirst($izin->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($izin->catatan_admin)
                                                {{ Str::limit($izin->catatan_admin, 50) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 20px; color: #9e9e9e;">
                                            Belum ada pengajuan izin/sakit
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
            
            // Show selected file name
            document.getElementById('bukti_file').addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '';
                const fileNameElement = document.getElementById('file-name');
                
                if (fileName) {
                    fileNameElement.textContent = 'File dipilih: ' + fileName;
                    fileNameElement.style.display = 'block';
                } else {
                    fileNameElement.style.display = 'none';
                }
            });
            

            

            
            // Tambahkan validasi min tanggal_mulai dan tanggal_selesai
            document.getElementById('tanggal_mulai').addEventListener('change', function() {
                document.getElementById('tanggal_selesai').min = this.value;
            });
        });
        
        // Fungsi untuk memilih jenis pengajuan
        function selectJenisPengajuan(jenis) {
            // Hapus kelas aktif dari kedua tombol
            document.getElementById('btn-izin').style.borderColor = jenis === 'izin' ? '#1976D2' : '#bbdefb';
            document.getElementById('btn-izin').style.backgroundColor = jenis === 'izin' ? '#1976D2' : '#e3f2fd';
            document.getElementById('btn-izin').style.color = jenis === 'izin' ? 'white' : '#1976D2';
            
            document.getElementById('btn-sakit').style.borderColor = jenis === 'sakit' ? '#1976D2' : '#bbdefb';
            document.getElementById('btn-sakit').style.backgroundColor = jenis === 'sakit' ? '#1976D2' : '#e3f2fd';
            document.getElementById('btn-sakit').style.color = jenis === 'sakit' ? 'white' : '#1976D2';
            
            // Simpan nilai ke input hidden
            document.getElementById('jenis_pengajuan').value = jenis;
            
            // Tampilkan jenis yang dipilih
            document.getElementById('selected-jenis').textContent = jenis.charAt(0).toUpperCase() + jenis.slice(1);
            document.getElementById('jenis-pengajuan-display').style.display = 'block';
        }
        
        // Fungsi untuk mereset pilihan jenis pengajuan
        function resetJenisPengajuan() {
            // Reset warna tombol
            document.getElementById('btn-izin').style.borderColor = '#bbdefb';
            document.getElementById('btn-izin').style.backgroundColor = '#e3f2fd';
            document.getElementById('btn-izin').style.color = '#1976D2';
            
            document.getElementById('btn-sakit').style.borderColor = '#bbdefb';
            document.getElementById('btn-sakit').style.backgroundColor = '#e3f2fd';
            document.getElementById('btn-sakit').style.color = '#1976D2';
            
            // Reset input hidden
            document.getElementById('jenis_pengajuan').value = '';
            
            // Sembunyikan display
            document.getElementById('jenis-pengajuan-display').style.display = 'none';
        }
        
        // Fungsi untuk submit form secara manual - didefinisikan di luar event listener agar bisa diakses oleh onclick
        function submitForm() {
            // Tunggu sampai DOM selesai dimuat sebelum menjalankan validasi
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', submitForm);
                return;
            }
            
            console.log('Fungsi submitForm dipanggil');
            
            // Validasi sederhana di client-side
            const jenisPengajuan = document.getElementById('jenis_pengajuan').value;
            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;
            
            if (!jenisPengajuan) {
                alert('Silakan pilih jenis pengajuan (izin atau sakit)');
                return false;
            }
            
            if (!tanggalMulai || !tanggalSelesai) {
                alert('Silakan isi tanggal mulai dan tanggal selesai');
                return false;
            }
            
            // Validasi tanggal_mulai tidak boleh lebih dari tanggal_selesai
            if (new Date(tanggalMulai) > new Date(tanggalSelesai)) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
                return false;
            }
            
            // Tampilkan loading
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn ? submitBtn.innerHTML : '';
            
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="material-icons left">autorenew</i> Mengajukan...';
                submitBtn.disabled = true;
            }
            
            // Submit form secara manual
            document.getElementById('izinForm').submit();
            
            // Kembalikan tombol ke kondisi semula setelah submit
            setTimeout(() => {
                if (submitBtn) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 3000);
        }
    </script>
@endsection