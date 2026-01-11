@extends('layouts.app')

@section('title', 'Pengajuan Izin - Sistem Absensi Guru')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/izin-form.css') }}">
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

        .submit-btn {
            justify-content: center;
            padding: 12px 20px;
            line-height: 1.2;
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

        @media (max-width: 600px) {
            .card-content {
                padding: 20px;
            }

            .welcome-section {
                margin-bottom: 18px;
            }

            .form-row {
                flex-direction: column;
                gap: 12px;
            }

            .btn {
                width: 100%;
                justify-content: center;
                padding: 10px 16px;
            }

            .jenis-buttons {
                flex-direction: column;
            }

            .jenis-display {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .table-container {
                box-shadow: none;
                border-radius: 0;
            }

            .activity-table thead {
                display: none;
            }

            .activity-table,
            .activity-table tbody,
            .activity-table tr,
            .activity-table td {
                display: block;
                width: 100%;
            }

            .activity-table tr {
                padding: 12px;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                margin-bottom: 12px;
                background: #ffffff;
            }

            .activity-table td {
                border: none;
                padding: 6px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                text-align: left;
            }

            .activity-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }

            .activity-table td.empty-cell {
                display: block;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('guru.components.sidebar')
    
    <!-- Top Bar -->
    @include('guru.components.topbar')
    
    <!-- Main Content -->
    <div class="main-content m-izin-page">
        <div class="m-page">
        <div class="welcome-section">
            <h4 class="welcome-title">Pengajuan Izin/Sakit</h4>
            <p class="welcome-subtitle">Ajukan izin atau sakit dengan mengisi formulir di bawah ini</p>
        </div>
        
        <div class="row">
            <div class="col s12 m8">
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

                <div class="m-card">
                    <form id="izinForm" action="{{ route('guru.izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="m-seg" role="tablist" aria-label="Jenis Pengajuan">
                            <button type="button" class="m-seg-btn active" data-jenis="izin" aria-selected="true">IZIN</button>
                            <button type="button" class="m-seg-btn" data-jenis="sakit" aria-selected="false">SAKIT</button>
                        </div>
                        <input type="hidden" name="jenis_pengajuan" id="jenis_pengajuan" required value="izin">

                        <div class="m-field">
                            <label class="m-label" for="tanggal_mulai_display">Tanggal Mulai</label>
                            <div class="m-input-wrap">
                                <input type="text" id="tanggal_mulai_display" class="m-input m-input-display" placeholder="dd/mm/yyyy" readonly>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="m-date-input" required>
                                <span class="m-trailing-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                                        <line x1="8" y1="3" x2="8" y2="7"></line>
                                        <line x1="16" y1="3" x2="16" y2="7"></line>
                                        <line x1="3" y1="11" x2="21" y2="11"></line>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="m-field">
                            <label class="m-label" for="tanggal_selesai_display">Tanggal Selesai</label>
                            <div class="m-input-wrap">
                                <input type="text" id="tanggal_selesai_display" class="m-input m-input-display" placeholder="dd/mm/yyyy" readonly>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="m-date-input" required>
                                <span class="m-trailing-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                                        <line x1="8" y1="3" x2="8" y2="7"></line>
                                        <line x1="16" y1="3" x2="16" y2="7"></line>
                                        <line x1="3" y1="11" x2="21" y2="11"></line>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="m-field">
                            <label class="m-label" for="alasan" id="alasan-label">Alasan Izin</label>
                            <textarea name="alasan" id="alasan" class="m-input m-textarea" placeholder="Jelaskan alasan pengajuan" required></textarea>
                            <p class="m-helper m-izin-only" id="alasan-helper-izin">Gunakan alasan singkat dan jelas.</p>
                            <p class="m-helper m-sakit-only m-hidden" id="alasan-helper-sakit">Tambahkan info singkat kondisi sakit jika perlu.</p>
                        </div>

                        <div class="m-field">
                            <label class="m-label" for="bukti_file">File Bukti (Opsional)</label>
                            <div class="file-upload">
                                <input type="file" name="bukti_file" id="bukti_file" accept=".pdf,.jpg,.jpeg,.png">
                                <label for="bukti_file" class="file-upload-label">
                                    <i class="material-icons" style="vertical-align: middle; margin-right: 8px;">cloud_upload</i>
                                    Pilih file bukti (PDF, JPG, PNG maks 2MB)
                                </label>
                            </div>
                            <div id="file-name" class="file-name" style="display: none;"></div>
                        </div>
                        
                        <button type="button" class="btn btn-primary btn-block submit-btn m-submit" onclick="submitForm()" id="submitBtn">
                            <i class="material-icons left">send</i> Ajukan
                        </button>
                    </form>
                </div>

                <div class="m-card m-guide-card">
                    <div class="m-guide-title">Panduan Pengajuan</div>
                    <ul class="m-guide">
                        <li class="m-guide-dot">Izin: untuk keperluan pribadi, keluarga, atau alasan penting lainnya.</li>
                        <li class="m-guide-chevron">Sakit: sertakan surat keterangan dokter jika diminta.</li>
                        <li class="m-guide-chevron">Pengajuan akan diproses oleh admin.</li>
                    </ul>
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
                                        <td data-label="Tanggal">{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y') }}</td>
                                        <td data-label="Jenis">{{ ucfirst($izin->jenis_pengajuan) }}</td>
                                        <td data-label="Periode">{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}</td>
                                        <td data-label="Status">
                                            <span class="status-badge 
                                                @if($izin->status === 'diajukan') status-diajukan 
                                                @elseif($izin->status === 'disetujui') status-disetujui 
                                                @else status-ditolak @endif">
                                                {{ ucfirst($izin->status) }}
                                            </span>
                                        </td>
                                        <td data-label="Catatan">
                                            @if($izin->catatan_admin)
                                                {{ Str::limit($izin->catatan_admin, 50) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="empty-cell" style="text-align: center; padding: 20px; color: #9e9e9e;">
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
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                coverTrigger: false
            });
            
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

            const jenisInput = document.getElementById('jenis_pengajuan');
            const segButtons = document.querySelectorAll('.m-seg-btn');
            const alasanLabel = document.getElementById('alasan-label');
            const helperIzin = document.getElementById('alasan-helper-izin');
            const helperSakit = document.getElementById('alasan-helper-sakit');

            function applyJenis(jenis) {
                segButtons.forEach(button => {
                    const isActive = button.dataset.jenis === jenis;
                    button.classList.toggle('active', isActive);
                    button.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                if (jenisInput) {
                    jenisInput.value = jenis;
                }
                if (alasanLabel) {
                    alasanLabel.textContent = jenis === 'sakit' ? 'Alasan Sakit' : 'Alasan Izin';
                }
                if (helperIzin && helperSakit) {
                    helperIzin.classList.toggle('m-hidden', jenis === 'sakit');
                    helperSakit.classList.toggle('m-hidden', jenis !== 'sakit');
                }
            }

            segButtons.forEach(button => {
                button.addEventListener('click', function() {
                    applyJenis(this.dataset.jenis);
                });
            });

            applyJenis(jenisInput?.value || 'izin');

            function formatDateDisplay(value) {
                if (!value) {
                    return '';
                }
                const parts = value.split('-');
                if (parts.length !== 3) {
                    return '';
                }
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            }

            function syncDateDisplay(dateInput, displayInput) {
                if (!dateInput || !displayInput) {
                    return;
                }
                displayInput.value = formatDateDisplay(dateInput.value);
            }

            const tanggalMulaiInput = document.getElementById('tanggal_mulai');
            const tanggalMulaiDisplay = document.getElementById('tanggal_mulai_display');
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
            const tanggalSelesaiDisplay = document.getElementById('tanggal_selesai_display');

            if (tanggalMulaiInput) {
                tanggalMulaiInput.addEventListener('change', function() {
                    if (tanggalSelesaiInput) {
                        tanggalSelesaiInput.min = this.value;
                    }
                    syncDateDisplay(tanggalMulaiInput, tanggalMulaiDisplay);
                });
                syncDateDisplay(tanggalMulaiInput, tanggalMulaiDisplay);
            }

            if (tanggalSelesaiInput) {
                tanggalSelesaiInput.addEventListener('change', function() {
                    syncDateDisplay(tanggalSelesaiInput, tanggalSelesaiDisplay);
                });
                syncDateDisplay(tanggalSelesaiInput, tanggalSelesaiDisplay);
            }
        });
        
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
