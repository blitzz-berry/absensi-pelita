@extends('layouts.app')

@section('title', 'Pengaturan - Sistem Absensi Guru')

@section('styles')
    <style>
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            background: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            margin-bottom: 20px;
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
        
        .setting-section {
            margin-bottom: 30px;
        }
        
        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .setting-item:last-child {
            border-bottom: none;
        }
        
        .setting-label {
            font-weight: 500;
            color: #424242;
        }
        
        .setting-control {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #1976D2;
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .btn-primary {
            background-color: #1976D2;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0d47a1;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #1976D2;
            color: #1976D2;
        }
        
        .btn-outline:hover {
            background-color: #e3f2fd;
        }
        
        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #424242;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box; /* Menambahkan ini agar padding tidak menambah lebar */
            word-wrap: break-word; /* Mencegah overflow teks panjang */
        }

        .password-input {
            position: relative;
        }

        .password-input input {
            padding-right: 42px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            color: #757575;
            padding: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:focus {
            outline: none;
            color: #1976D2;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }
        
        .form-actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        div.setting-item .setting-control .admin-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }
        
        div.setting-item .setting-control .admin-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        div.setting-item .setting-control .admin-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px; /* Radius setengah dari tinggi */
        }
        
        div.setting-item .setting-control .admin-switch .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        div.setting-item .setting-control .admin-switch input:checked + .slider {
            background-color: #1976D2;
        }
        
        div.setting-item .setting-control .admin-switch input:checked + .slider:before {
            transform: translateX(30px); /* 60px - 22px - 4px - 4px = 30px */
        }
        
        .setting-control {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        
        .setting-control span {
            font-size: 14px;
            color: #666;
            white-space: nowrap;
        }
        
        .toggle-text-off, .toggle-text-on {
            font-size: 13px;
            font-weight: 500;
            min-width: 50px;
            text-align: center;
        }
        
        .setting-item .switch {
            margin-left: 5px;
            flex-shrink: 0;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 25px;
            border: 4px solid #e3f2fd;
        }
        
        .profile-info h3 {
            margin: 0 0 10px 0;
            color: #212121;
            font-size: 22px;
        }
        
        .profile-info p {
            margin: 5px 0;
            color: #666;
            font-size: 16px;
        }
        
        .profile-info .role {
            background-color: #e3f2fd;
            color: #1976D2;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-top: 8px;
        }
        
        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .detail-item {
            margin-bottom: 15px;
            min-width: 0; /* Penting untuk memungkinkan pembungkusan teks dalam grid */
        }

        .detail-label {
            font-weight: 500;
            color: #757575;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .detail-value {
            font-size: 16px;
            color: #212121;
            font-weight: 500;
            word-wrap: break-word;
            overflow-wrap: break-word;
            min-width: 0; /* Penting untuk mencegah overflow */
        }
        
        .file-name-display {
            color: #757575;
            font-size: 14px;
        }
        
        .notification {
            margin-top: 15px;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid transparent;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notification.success {
            background-color: #e8f5e9;
            border-color: #4caf50;
            color: #2e7d32;
        }
        
        .notification.error {
            background-color: #ffebee;
            border-color: #f44336;
            color: #c62828;
        }
        
        @media (max-width: 768px) {
            .card-content {
                padding: 20px;
            }
            
            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .setting-control {
                width: 100%;
                justify-content: space-between;
            }
            
            .form-actions .btn {
                min-width: auto;
                width: 100%;
                margin-left: 0;
                margin-top: 10px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
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
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Pengaturan Akun</h4>
            <p class="welcome-subtitle">Kelola informasi dan keamanan akun Anda</p>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Profil & Akun</span>
                        
                        <div class="profile-header">
                            <div class="profile-avatar-container" style="display: flex; align-items: center; margin-bottom: 20px;">
                                <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" 
                                     id="profile-display" alt="Profile" class="profile-avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                <div class="profile-info">
                                    <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #212121;">{{ $user->nama }}</h3>
                                    <p style="margin: 5px 0; color: #666; font-size: 16px; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto; min-width: 0;">{{ $user->email }}</p>
                                    <span class="role" style="background-color: #e3f2fd; color: #1976D2; padding: 4px 12px; border-radius: 20px; font-size: 14px; display: inline-block; margin-top: 8px;">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="profile-details" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; padding: 15px 0; border-top: 1px solid #eee;">
                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Nama Lengkap</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word;">{{ $user->nama }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Email</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word; min-width: 0;">{{ $user->email }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Nomor Induk</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word;">{{ $user->nomor_id ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Nomor Telepon</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word;">{{ $user->nomor_telepon ?? '-' }}</div>
                            </div>


                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Role</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word;">{{ ucfirst($user->role) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label" style="font-weight: 500; color: #757575; margin-bottom: 5px; font-size: 14px;">Terdaftar Sejak</div>
                                <div class="detail-value" style="font-size: 16px; color: #212121; font-weight: 500; word-wrap: break-word; overflow-wrap: break-word;">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                        
                        <div id="edit-profile-button-container" class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-primary" onclick="showEditProfileForm()">Edit Profil</button>
                        </div>
                        
                        <!-- Form Edit Profil -->
                        <form id="edit-profile-form" class="edit-profile-form" action="{{ route('guru.pengaturan.update.profile') }}" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                            @csrf
                            @method('POST')
                            
                            <div class="input-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ $user->nama }}" autocomplete="name">
                            </div>
                            
                            <div class="input-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" autocomplete="email">
                            </div>
                            
                            <div class="input-group">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $user->nomor_telepon ?? '' }}" autocomplete="tel">
                            </div>


                            <div class="input-group">
                                <label for="foto_profile">Foto Profil</label>
                                <input type="file" name="foto_profile" id="foto_profile" accept="image/*" style="display: none;" onchange="updateFileName(this); previewImage(event);">
                                <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap mt-2">
                                    <button class="btn btn-outline" type="button" onclick="document.getElementById('foto_profile').click()">Pilih Foto</button>
                                    <button class="btn btn-outline" type="button" id="upload-foto-btn" style="display: none;" onclick="uploadFotoProfil()">Upload Foto</button>
                                    <span id="file-name" class="file-name-display">Tidak ada file dipilih</span>
                                </div>
                                <div id="image-preview-container" class="mt-3 text-center">
                                    <img id="image-preview" src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : 'https://ui-avatars.com/api/?name='.urlencode($user->nama).'&color=1976D2&background=F5F5F5' }}" alt="Pratinjau" class="rounded-circle border border-light" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button type="button" class="btn btn-outline" onclick="resetProfileForm(); hideEditProfileForm()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col s12">
                <div class="card dashboard-card">
                    <div class="card-content">
                        <span class="card-title">Ganti Password</span>
                        
                        <form id="change-password-form" action="{{ route('guru.pengaturan.update.password') }}" method="POST">
                            @csrf
                            @method('POST')
                            
                            <div class="input-group">
                                <label for="old_password">Password Lama</label>
                                <div class="password-input">
                                    <input type="password" name="current_password" id="old_password" required autocomplete="current-password">
                                    <button type="button" class="password-toggle" data-target="old_password" aria-label="Tampilkan password">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="new_password">Password Baru</label>
                                <div class="password-input">
                                    <input type="password" name="new_password" id="new_password" required autocomplete="new-password">
                                    <button type="button" class="password-toggle" data-target="new_password" aria-label="Tampilkan password">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <div class="password-input">
                                    <input type="password" name="new_password_confirmation" id="confirm_password" required autocomplete="new-password">
                                    <button type="button" class="password-toggle" data-target="confirm_password" aria-label="Tampilkan password">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button type="button" class="btn btn-outline" onclick="resetPasswordForm()">Batal</button>
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                            </div>
                        </form>
                        
                        <!-- Notification Elements -->
                        <div id="password-notification" class="notification" style="display: none; margin-top: 15px; padding: 10px; border-radius: 4px; text-align: center;">
                            <span id="notification-message"></span>
                        </div>
                    </div>
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
            
            // Function to show edit profile form
            function showEditProfileForm() {
                document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
                document.getElementById('edit-profile-button-container').style.display = 'none'; // Sembunyikan tombol Edit Profil
                document.getElementById('edit-profile-form').style.display = 'block';
            }
            
            // Function to hide edit profile form
            function hideEditProfileForm() {
                document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
                document.getElementById('edit-profile-button-container').style.display = 'flex'; // Tampilkan kembali tombol Edit Profil
                document.getElementById('edit-profile-form').style.display = 'none';
                document.getElementById('image-preview-container').style.display = 'none';
            }
            
            // Function to update file name display
            function updateFileName(input) {
                const fileNameDisplay = document.getElementById('file-name');
                if (input.files && input.files[0]) {
                    fileNameDisplay.textContent = input.files[0].name;
                } else {
                    fileNameDisplay.textContent = 'Tidak ada file dipilih';
                }
            }
            
            // Function to preview image
            function previewImage(event) {
                const reader = new FileReader();
                const imagePreviewContainer = document.getElementById('image-preview-container');
                const imagePreview = document.getElementById('image-preview');
                
                reader.onload = function(){
                    imagePreview.src = reader.result;
                    imagePreviewContainer.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }

            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (!targetInput || !icon) {
                        return;
                    }

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.textContent = 'visibility_off';
                        this.setAttribute('aria-label', 'Sembunyikan password');
                    } else {
                        targetInput.type = 'password';
                        icon.textContent = 'visibility';
                        this.setAttribute('aria-label', 'Tampilkan password');
                    }
                });
            });
            
            // Function to reset profile form and image preview when cancel is clicked
            function resetProfileForm() {
                document.getElementById('edit-profile-form').reset();
                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                document.getElementById('image-preview-container').style.display = 'none';
                
                // Restore original image in preview
                const originalImage = document.getElementById('profile-display').src;
                document.getElementById('image-preview').src = originalImage;
            }
            
            // Function to submit password form using AJAX
            function submitPasswordForm() {
                const form = document.getElementById('change-password-form');
                const formData = new FormData(form);
                
                // Show loading indicator
                const submitBtn = document.querySelector('#change-password-form .btn-primary');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Mengganti...';
                submitBtn.disabled = true;
                
                // Tambahkan CSRF token ke formData
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                // Cek dulu apakah CSRF token ada
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, return error
                        return response.text().then(text => {
                            console.error('Non-JSON response received:', text.substring(0, 200) + '...');
                            throw new Error('Server response is not in JSON format');
                        });
                    }
                })
                .then(data => {
                    // Restore button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    
                    // Show notification
                    showPasswordNotification(data.success, data.message || (data.success ? 'Password berhasil diubah!' : 'Gagal mengganti password.'));
                    
                    if (data.success) {
                        // Reset form on success
                        form.reset();
                    }
                })
                .catch(error => {
                    console.error('Error in password change:', error);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    showPasswordNotification(false, 'Terjadi kesalahan saat mengganti password. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.');
                });
            }
            
            // Function to show password notification
            function showPasswordNotification(isSuccess, message) {
                const notification = document.getElementById('password-notification');
                const notificationMessage = document.getElementById('notification-message');
                
                if (isSuccess) {
                    notification.className = 'notification success';
                    notificationMessage.textContent = message;
                } else {
                    notification.className = 'notification error';
                    notificationMessage.textContent = message;
                }
                
                notification.style.display = 'block';
                
                // Hide notification after 5 seconds
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 5000);
            }
            
            // Function to reset password form
            function resetPasswordForm() {
                document.getElementById('change-password-form').reset();
                document.getElementById('password-notification').style.display = 'none';
            }
            
            // Function to handle profile picture upload separately
            function handleProfilePictureUpload(fileInput) {
                const file = fileInput.files[0];
                if (!file) return Promise.resolve(null);
                
                const formData = new FormData();
                formData.append('foto_profile', file);
                
                return fetch('{{ route("guru.pengaturan.upload.foto") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                });
            }
            
            // Add event listener for edit profile form submission
            const profileForm = document.getElementById('edit-profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = profileForm.querySelector('.btn-primary');
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Menyimpan...';
                    submitBtn.disabled = true;
                    
                    const formData = new FormData();
                    const nama = document.querySelector('input[name="nama"]').value;
                    const email = document.querySelector('input[name="email"]').value;
                    const nomor_telepon = document.querySelector('input[name="nomor_telepon"]').value;
                    
                    // Add CSRF token
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    
                    // Add data if provided
                    if (nama) formData.append('nama', nama);
                    if (email) formData.append('email', email);
                    if (nomor_telepon) formData.append('nomor_telepon', nomor_telepon);
                    
                    // Check if there's a file to upload
                    const fileInput = document.getElementById('foto_profile');
                    const hasFile = fileInput && fileInput.files.length > 0;
                    
                    if (hasFile) {
                        // If there's a file, first upload the picture, then update other info
                        handleProfilePictureUpload(fileInput)
                        .then(photoResponse => {
                            if (photoResponse && !photoResponse.success) {
                                throw new Error(photoResponse.message || 'Gagal mengunggah foto');
                            }
                            
                            // Update other profile information
                            if (nama || email || nomor_telepon) {
                                return fetch(profileForm.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json',
                                    }
                                }).then(async response => {
                                    if (!response.ok) {
                                        const errorText = await response.text();
                                        console.error('Error response:', errorText);
                                        throw new Error(`Network response was not ok: ${response.status}`);
                                    }

                                    // Check if response is JSON
                                    const contentType = response.headers.get('content-type');
                                    if (contentType && contentType.includes('application/json')) {
                                        return response.json();
                                    } else {
                                        // If not JSON, try to parse as text and create an error response
                                        const text = await response.text();
                                        console.error('Non-JSON response received:', text);
                                        throw new Error('Server response is not in JSON format');
                                    }
                                });
                            } else {
                                // If only photo was updated, return the photo response
                                return photoResponse;
                            }
                        })
                        .then(data => {
                            // Restore button
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            
                            if (data.success) {
                                // Update user profile information in the view
                                const userName = document.querySelector('.profile-header h3');
                                const userEmail = document.querySelector('.profile-header p');
                                const profileDisplay = document.getElementById('profile-display');
                                const topbarProfile = document.querySelector('.topbar .profile-menu img');
                                
                                // Update name and email in the view if they were provided
                                if (nama && userName) {
                                    userName.textContent = nama;
                                    const detailName = document.querySelector('.detail-item:nth-child(1) .detail-value');
                                    if (detailName) detailName.textContent = nama;
                                    const infoName = document.querySelector('.profile-info h3');
                                    if (infoName) infoName.textContent = nama;
                                }
                                
                                if (email && userEmail) {
                                    userEmail.textContent = email;
                                    const detailEmail = document.querySelector('.detail-item:nth-child(2) .detail-value');
                                    if (detailEmail) detailEmail.textContent = email;
                                    const infoEmail = document.querySelector('.profile-info p');
                                    if (infoEmail) infoEmail.textContent = email;
                                }
                                
                                // Update foto profile in all locations if it was changed
                                if (photoResponse && photoResponse.foto_url) {
                                    if (profileDisplay) {
                                        profileDisplay.src = photoResponse.foto_url + '?t=' + new Date().getTime(); // Add timestamp to bypass cache
                                    }
                                    if (topbarProfile) {
                                        topbarProfile.src = photoResponse.foto_url + '?t=' + new Date().getTime(); // Add timestamp to bypass cache
                                    }
                                    
                                    // Also update the profile picture in the edit form preview
                                    if (document.getElementById('image-preview')) {
                                        document.getElementById('image-preview').src = photoResponse.foto_url + '?t=' + new Date().getTime();
                                    }
                                    
                                    // Update the preview image in the profile view
                                    if (document.querySelector('.profile-header .profile-avatar')) {
                                        document.querySelector('.profile-header .profile-avatar').src = photoResponse.foto_url + '?t=' + new Date().getTime();
                                    }
                                }
                                
                                // Show success notification
                                showPasswordNotification(true, data.message);
                                
                                // Reset form and hide it
                                profileForm.reset();
                                hideEditProfileForm();
                                
                                // Update file name display
                                document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                                document.getElementById('image-preview-container').style.display = 'none';
                            } else {
                                showPasswordNotification(false, data.message || 'Terjadi kesalahan saat memperbarui profil.');
                            }
                        })
                        .catch(error => {
                            console.error('Error in profile update:', error);
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            showPasswordNotification(false, error.message || 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
                        });
                    } else {
                        // If no file, just update text fields
                        fetch(profileForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        })
                        .then(async response => {
                            if (!response.ok) {
                                const errorText = await response.text();
                                console.error('Error response:', errorText);
                                throw new Error(`Network response was not ok: ${response.status}`);
                            }

                            // Check if response is JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                // If not JSON, try to parse as text and create an error response
                                const text = await response.text();
                                console.error('Non-JSON response received:', text);
                                throw new Error('Server response is not in JSON format');
                            }
                        })
                        .then(data => {
                            // Restore button
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            
                            if (data.success) {
                                // Update user profile information in the view
                                if (nama) {
                                    const headerName = document.querySelector('.profile-header h3');
                                    if (headerName) headerName.textContent = nama;
                                    
                                    const detailName = document.querySelector('.detail-item:nth-child(1) .detail-value');
                                    if (detailName) detailName.textContent = nama;
                                    
                                    const infoName = document.querySelector('.profile-info h3');
                                    if (infoName) infoName.textContent = nama;
                                }
                                
                                if (email) {
                                    const headerEmail = document.querySelector('.profile-header p');
                                    if (headerEmail) headerEmail.textContent = email;
                                    
                                    const detailEmail = document.querySelector('.detail-item:nth-child(2) .detail-value');
                                    if (detailEmail) detailEmail.textContent = email;
                                    
                                    const infoEmail = document.querySelector('.profile-info p');
                                    if (infoEmail) infoEmail.textContent = email;
                                }
                                
                                // Show success notification
                                showPasswordNotification(true, data.message);
                                
                                // Reset form and hide it
                                profileForm.reset();
                                hideEditProfileForm();
                            } else {
                                showPasswordNotification(false, data.message || 'Terjadi kesalahan saat memperbarui profil.');
                            }
                        })
                        .catch(error => {
                            console.error('Error in profile update:', error);
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            showPasswordNotification(false, error.message || 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
                        });
                    }
                });
            }
            
            // Add event listener for password form submission
            const passwordForm = document.getElementById('change-password-form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitPasswordForm();
                });
            }
            
            // Check for session messages (success/error)
            @if(session('profile_success'))
                // Show success notification for profile update
                showPasswordNotification(true, '{{ session('profile_success') }}');
            @elseif(session('password_success'))
                // Show success notification for password update
                showPasswordNotification(true, '{{ session('password_success') }}');
            @elseif(session('error'))
                // Show error notification
                showPasswordNotification(false, '{{ session('error') }}');
            @endif
        });
        
        function showEditProfileForm() {
            document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
            document.getElementById('edit-profile-button-container').style.display = 'none'; // Sembunyikan tombol Edit Profil
            document.getElementById('edit-profile-form').style.display = 'block';
        }
        
        // Function to hide edit profile form
        function hideEditProfileForm() {
            document.querySelector('.profile-details').style.display = 'grid';  // Mengembalikan ke mode grid
            document.getElementById('edit-profile-button-container').style.display = 'flex'; // Tampilkan kembali tombol Edit Profil
            document.getElementById('edit-profile-form').style.display = 'none';
            document.getElementById('image-preview-container').style.display = 'none';
        }
        
        // Function to update file name display
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Tidak ada file dipilih';
            }
        }
        
        // Function to preview image
        function previewImage(event) {
            const reader = new FileReader();
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');
            
            reader.onload = function(){
                imagePreview.src = reader.result;
                imagePreviewContainer.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        
        // Function to reset profile form and image preview when cancel is clicked
        function resetProfileForm() {
            document.getElementById('edit-profile-form').reset();
            document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
            document.getElementById('image-preview-container').style.display = 'none';
            document.getElementById('upload-foto-btn').style.display = 'none';
            
            // Restore original image in preview
            const originalImage = document.getElementById('profile-display').src;
            document.getElementById('image-preview').src = originalImage;
        }
        
        // Function to show password notification
        function showPasswordNotification(isSuccess, message) {
            const notification = document.getElementById('password-notification');
            const notificationMessage = document.getElementById('notification-message');
            
            if (isSuccess) {
                notification.className = 'notification success';
                notificationMessage.textContent = message;
            } else {
                notification.className = 'notification error';
                notificationMessage.textContent = message;
            }
            
            notification.style.display = 'block';
            
            // Hide notification after 5 seconds
            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000);
        }
        
        // Function to upload foto profil directly
        function uploadFotoProfil() {
            const fileInput = document.getElementById('foto_profile');
            const file = fileInput.files[0];
            
            if (!file) {
                showPasswordNotification(false, 'Silakan pilih file foto terlebih dahulu');
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showPasswordNotification(false, 'File harus berupa gambar (JPEG, PNG, atau GIF)');
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                showPasswordNotification(false, 'Ukuran file maksimal 2MB');
                return;
            }
            
            const formData = new FormData();
            formData.append('foto_profile', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            // Show loading state
            const uploadBtn = document.getElementById('upload-foto-btn');
            const originalText = uploadBtn.textContent;
            uploadBtn.textContent = 'Mengunggah...';
            uploadBtn.disabled = true;
            
            fetch('{{ route("guru.pengaturan.upload.foto") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Restore button
                uploadBtn.textContent = originalText;
                uploadBtn.disabled = false;
                
                if (data.success) {
                    // Update profile picture in all locations
                    const profileDisplay = document.getElementById('profile-display');
                    const topbarProfile = document.querySelector('.topbar .profile-menu img');
                    const profileAvatar = document.querySelector('.profile-header .profile-avatar');
                    
                    if (profileDisplay) {
                        profileDisplay.src = data.foto_url + '?t=' + new Date().getTime();
                    }
                    if (topbarProfile) {
                        topbarProfile.src = data.foto_url + '?t=' + new Date().getTime();
                    }
                    if (profileAvatar) {
                        profileAvatar.src = data.foto_url + '?t=' + new Date().getTime();
                    }
                    
                    // Also update the preview image in the edit form
                    if (document.getElementById('image-preview')) {
                        document.getElementById('image-preview').src = data.foto_url + '?t=' + new Date().getTime();
                    }
                    
                    showPasswordNotification(true, data.message);
                    
                    // Reset form file input
                    document.getElementById('foto_profile').value = '';
                    document.getElementById('file-name').textContent = 'Tidak ada file dipilih';
                    document.getElementById('image-preview-container').style.display = 'none';
                    document.getElementById('upload-foto-btn').style.display = 'none';
                } else {
                    showPasswordNotification(false, data.message || 'Gagal mengunggah foto profil');
                }
            })
            .catch(error => {
                console.error('Error uploading photo:', error);
                uploadBtn.textContent = originalText;
                uploadBtn.disabled = false;
                showPasswordNotification(false, 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.');
            });
        }
        
        // Modified onchange function to show upload button
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            const uploadBtn = document.getElementById('upload-foto-btn');
            
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
                uploadBtn.style.display = 'inline-block'; // Show upload button when file is selected
            } else {
                fileNameDisplay.textContent = 'Tidak ada file dipilih';
                uploadBtn.style.display = 'none'; // Hide upload button when no file is selected
            }
        }
    </script>
@endsection
