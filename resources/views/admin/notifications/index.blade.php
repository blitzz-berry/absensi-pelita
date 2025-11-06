@extends('layouts.app')

@section('title', 'Pusat Notifikasi - Admin')

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
        
        .notification-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            align-items: center;
        }
        
        .notification-actions h5 {
            margin: 0;
            font-weight: 600;
            color: #212121;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
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
        
        .btn-danger {
            background: linear-gradient(135deg, #F44336, #C62828);
            color: white;
        }
        
        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .notification-item {
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #e0e0e0;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .notification-item:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        
        .notification-item.unread {
            border-left: 4px solid #2196F3;
            background: #e3f2fd;
        }
        
        .notification-item.read {
            border-left: 4px solid #e0e0e0;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .notification-title {
            font-weight: 600;
            color: #212121;
            margin: 0;
        }
        
        .notification-time {
            font-size: 12px;
            color: #757575;
        }
        
        .notification-message {
            color: #424242;
            margin: 0;
            line-height: 1.5;
        }
        
        .notification-footer {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .notification-actions-menu {
            display: flex;
            gap: 10px;
        }
        
        .notification-action-btn {
            background: transparent;
            border: none;
            color: #757575;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s ease;
        }
        
        .notification-action-btn:hover {
            color: #1976D2;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            text-align: center;
            color: #9e9e9e;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .empty-state h5 {
            font-size: 18px;
            margin: 15px 0 10px 0;
            color: #757575;
        }
        
        .empty-state p {
            color: #9e9e9e;
            margin: 0;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
    </style>
@endsection

@section('content')
    <!-- Sidebar -->
    @include('admin.components.sidebar')
    
    <!-- Top Bar -->
    @include('admin.components.topbar', ['currentUser' => Auth::user()])
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-section">
            <h4 class="welcome-title">Pusat Notifikasi</h4>
            <p class="welcome-subtitle">Lihat dan kelola semua notifikasi Anda</p>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-content">
                <div class="notification-actions">
                    <h5>Daftar Notifikasi</h5>
                    <div class="action-buttons">
                        <button id="markAllAsRead" class="btn btn-primary">
                            <i class="material-icons">check_circle</i> Tandai semua sudah dibaca
                        </button>
                        <button id="deleteAll" class="btn btn-danger">
                            <i class="material-icons">delete</i> Hapus semua
                        </button>
                    </div>
                </div>
                
                @if($notifications->count() > 0)
                    <div class="notification-list" id="notificationList">
                        @foreach($notifications as $notification)
                            <div class="notification-item {{ is_null($notification->read_at) ? 'unread' : 'read' }}" data-id="{{ $notification->id }}">
                                <div class="notification-header">
                                    <h6 class="notification-title">{{ $notification->title }}</h6>
                                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                                <p class="notification-message">{{ $notification->message }}</p>
                                <div class="notification-footer">
                                    <div class="notification-actions-menu">
                                        @if(is_null($notification->read_at))
                                            <button class="notification-action-btn mark-as-read" data-id="{{ $notification->id }}">
                                                <i class="material-icons">check</i> Tandai sudah dibaca
                                            </button>
                                        @else
                                            <button class="notification-action-btn mark-as-unread" data-id="{{ $notification->id }}">
                                                <i class="material-icons">markunread</i> Tandai belum dibaca
                                            </button>
                                        @endif
                                        <button class="notification-action-btn delete-notification" data-id="{{ $notification->id }}">
                                            <i class="material-icons">delete</i> Hapus
                                        </button>
                                    </div>
                                    @if($notification->link && $notification->link !== '#')
                                        <a href="{{ $notification->link }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                            <i class="material-icons">open_in_new</i> Lihat Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="material-icons">notifications_off</i>
                        <h5>Tidak ada notifikasi</h5>
                        <p>Anda belum memiliki notifikasi apapun saat ini</p>
                    </div>
                @endif
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
            
            // Fungsi untuk mengelola status notifikasi
            function attachEventListeners() {
                // Tandai sebagai sudah dibaca
                document.querySelectorAll('.mark-as-read').forEach(button => {
                    button.removeEventListener('click', handleMarkAsRead);
                    button.addEventListener('click', handleMarkAsRead);
                });

                // Tandai sebagai belum dibaca
                document.querySelectorAll('.mark-as-unread').forEach(button => {
                    button.removeEventListener('click', handleMarkAsUnread);
                    button.addEventListener('click', handleMarkAsUnread);
                });

                // Hapus notifikasi
                document.querySelectorAll('.delete-notification').forEach(button => {
                    button.removeEventListener('click', handleDeleteNotification);
                    button.addEventListener('click', handleDeleteNotification);
                });
            }

            // Fungsi event handler
            function handleMarkAsRead(e) {
                e.preventDefault();
                const notificationId = this.dataset.id;
                markAsRead(notificationId);
            }

            function handleMarkAsUnread(e) {
                e.preventDefault();
                const notificationId = this.dataset.id;
                markAsUnread(notificationId);
            }

            function handleDeleteNotification(e) {
                e.preventDefault();
                const notificationId = this.dataset.id;
                deleteNotification(notificationId);
            }

            // Inisialisasi event listeners
            attachEventListeners();

            // Tandai semua sebagai sudah dibaca
            document.getElementById('markAllAsRead').addEventListener('click', function() {
                markAllAsRead();
            });

            // Hapus semua notifikasi
            document.getElementById('deleteAll').addEventListener('click', function() {
                deleteAllNotifications();
            });

            // Fungsi AJAX untuk menandai sebagai sudah dibaca
            function markAsRead(notificationId) {
                fetch(`/admin/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('unread');
                            notificationItem.classList.add('read');
                            
                            // Update button
                            const button = notificationItem.querySelector('.notification-action-btn');
                            button.outerHTML = `
                                <button class="notification-action-btn mark-as-unread" data-id="${notificationId}">
                                    <i class="material-icons">markunread</i> Tandai belum dibaca
                                </button>
                            `;
                            
                            // Re-attach event listeners
                            attachEventListeners();
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menandai sebagai belum dibaca
            function markAsUnread(notificationId) {
                fetch(`/admin/notifications/${notificationId}/unread`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('read');
                            notificationItem.classList.add('unread');
                            
                            // Update button
                            const button = notificationItem.querySelector('.notification-action-btn');
                            button.outerHTML = `
                                <button class="notification-action-btn mark-as-read" data-id="${notificationId}">
                                    <i class="material-icons">check</i> Tandai sudah dibaca
                                </button>
                            `;
                            
                            // Re-attach event listeners
                            attachEventListeners();
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menghapus notifikasi
            function deleteNotification(notificationId) {
                if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) return;
                
                fetch(`/admin/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.remove();
                            
                            // Jika tidak ada notifikasi lagi, tampilkan empty state
                            if (document.querySelectorAll('.notification-item').length === 0) {
                                document.getElementById('notificationList').outerHTML = `
                                    <div class="empty-state">
                                        <i class="material-icons">notifications_off</i>
                                        <h5>Tidak ada notifikasi</h5>
                                        <p>Anda belum memiliki notifikasi apapun saat ini</p>
                                    </div>
                                `;
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menandai semua sebagai sudah dibaca
            function markAllAsRead() {
                if (!confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?')) return;
                
                fetch('/admin/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.remove('unread');
                            item.classList.add('read');
                            
                            // Update button
                            const button = item.querySelector('.mark-as-read');
                            if (button) {
                                button.outerHTML = `
                                    <button class="notification-action-btn mark-as-unread" data-id="${item.dataset.id}">
                                        <i class="material-icons">markunread</i> Tandai belum dibaca
                                    </button>
                                `;
                            }
                        });
                        
                        // Re-attach event listeners
                        attachEventListeners();
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menghapus semua notifikasi
            function deleteAllNotifications() {
                if (!confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')) return;
                
                fetch('/admin/notifications/delete-all', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('notificationList').outerHTML = `
                            <div class="empty-state">
                                <i class="material-icons">notifications_off</i>
                                <h5>Tidak ada notifikasi</h5>
                                <p>Anda belum memiliki notifikasi apapun saat ini</p>
                            </div>
                        `;
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
