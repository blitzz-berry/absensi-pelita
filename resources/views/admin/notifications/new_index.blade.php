@extends('layouts.app')

@section('title', 'Pusat Notifikasi - Admin')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .notification-unread {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
        }
        .notification-read {
            background-color: white;
        }
        .notification-actions {
            display: flex;
            gap: 10px;
        }
        .notification-dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 6px;
            overflow: hidden;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .notification-dropdown:hover .dropdown-content {
            display: block;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
            color: #6b7280;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #d1d5db;
        }
    </style>
@endsection

@section('content')
    @include('admin.components.sidebar')
    @include('admin.components.topbar')

    <div class="main-content ml-64 mt-20 p-6">
        <div class="mb-6">
            <h4 class="text-2xl font-bold text-gray-800">Pusat Notifikasi</h4>
            <p class="text-gray-600">Lihat dan kelola semua notifikasi Anda</p>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Notifikasi Header -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-800">Daftar Notifikasi</h5>
                <div class="flex space-x-3">
                    <button id="markAllAsRead" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        <i class="fas fa-check-circle mr-2"></i> Tandai semua sudah dibaca
                    </button>
                    <button id="deleteAll" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash mr-2"></i> Hapus semua
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingSpinner" class="hidden flex justify-center items-center py-10">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden">
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <h5 class="text-xl font-medium text-gray-700 mb-2">Tidak ada notifikasi</h5>
                    <p class="text-gray-500">Anda belum memiliki notifikasi apapun saat ini</p>
                </div>
            </div>

            <!-- Notifikasi List -->
            <div id="notificationList" class="divide-y divide-gray-200">
                @forelse ($notifications as $notification)
                    <div class="notification-item p-6 {{ is_null($notification->read_at) ? 'notification-unread' : 'notification-read' }}" data-id="{{ $notification->id }}">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas {{ is_null($notification->read_at) ? 'fa-bell text-blue-500' : 'fa-bell-slash text-gray-400' }}"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h6 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $notification->title }}
                                    </h6>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                        <div class="notification-dropdown">
                                            <button class="text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                @if(is_null($notification->read_at))
                                                    <a href="#" class="mark-as-read" data-id="{{ $notification->id }}">
                                                        <i class="fas fa-check mr-2"></i> Tandai sudah dibaca
                                                    </a>
                                                @else
                                                    <a href="#" class="mark-as-unread" data-id="{{ $notification->id }}">
                                                        <i class="fas fa-envelope mr-2"></i> Tandai belum dibaca
                                                    </a>
                                                @endif
                                                <a href="#" class="delete-notification" data-id="{{ $notification->id }}">
                                                    <i class="fas fa-trash mr-2"></i> Hapus notifikasi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">
                                    {{ $notification->message }}
                                </p>
                                
                                @if($notification->link && $notification->link !== '#')
                                    <div class="mt-3">
                                        <a href="{{ $notification->link }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="emptyState" class="block">
                        <div class="empty-state">
                            <i class="fas fa-bell-slash"></i>
                            <h5 class="text-xl font-medium text-gray-700 mb-2">Tidak ada notifikasi</h5>
                            <p class="text-gray-500">Anda belum memiliki notifikasi apapun saat ini</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk menandai notifikasi sebagai sudah dibaca
            function attachEventListeners() {
                document.querySelectorAll('.mark-as-read').forEach(button => {
                    button.removeEventListener('click', handleMarkAsRead); // Hapus listener lama agar tidak duplikat
                    button.addEventListener('click', handleMarkAsRead);
                });

                document.querySelectorAll('.mark-as-unread').forEach(button => {
                    button.removeEventListener('click', handleMarkAsUnread);
                    button.addEventListener('click', handleMarkAsUnread);
                });

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

            // Inisialisasi event listeners untuk semua tombol
            attachEventListeners();

            // Fungsi untuk menandai semua sebagai sudah dibaca
            document.getElementById('markAllAsRead').addEventListener('click', function() {
                markAllAsRead();
            });

            // Fungsi untuk menghapus semua notifikasi
            document.getElementById('deleteAll').addEventListener('click', function() {
                deleteAllNotifications();
            });

            // Fungsi AJAX untuk menandai sebagai sudah dibaca
            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
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
                            notificationItem.classList.remove('notification-unread');
                            notificationItem.classList.add('notification-read');
                            
                            // Update dropdown menu
                            const dropdown = notificationItem.querySelector('.dropdown-content');
                            dropdown.innerHTML = `
                                <a href="#" class="mark-as-unread" data-id="${notificationId}">
                                    <i class="fas fa-envelope mr-2"></i> Tandai belum dibaca
                                </a>
                                <a href="#" class="delete-notification" data-id="${notificationId}">
                                    <i class="fas fa-trash mr-2"></i> Hapus notifikasi
                                </a>
                            `;
                            
                            // Re-attach event listeners
                            attachEventListeners();
                        }
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menandai sebagai belum dibaca
            function markAsUnread(notificationId) {
                fetch(`/notifications/${notificationId}/unread`, {
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
                            notificationItem.classList.remove('notification-read');
                            notificationItem.classList.add('notification-unread');
                            
                            // Update dropdown menu
                            const dropdown = notificationItem.querySelector('.dropdown-content');
                            dropdown.innerHTML = `
                                <a href="#" class="mark-as-read" data-id="${notificationId}">
                                    <i class="fas fa-check mr-2"></i> Tandai sudah dibaca
                                </a>
                                <a href="#" class="delete-notification" data-id="${notificationId}">
                                    <i class="fas fa-trash mr-2"></i> Hapus notifikasi
                                </a>
                            `;
                            
                            // Re-attach event listeners
                            attachEventListeners();
                        }
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menghapus notifikasi
            function deleteNotification(notificationId) {
                if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) return;
                
                fetch(`/notifications/${notificationId}`, {
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
                        }
                        updateUnreadCount();
                        
                        // Show empty state if no notifications left
                        if (document.querySelectorAll('.notification-item').length === 0) {
                            document.getElementById('notificationList').classList.add('hidden');
                            document.getElementById('emptyState').classList.remove('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menandai semua sebagai sudah dibaca
            function markAllAsRead() {
                if (!confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?')) return;
                
                fetch('/notifications/read-all', {
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
                            item.classList.remove('notification-unread');
                            item.classList.add('notification-read');
                            
                            // Update dropdown menu
                            const dropdown = item.querySelector('.dropdown-content');
                            const notificationId = item.dataset.id;
                            dropdown.innerHTML = `
                                <a href="#" class="mark-as-unread" data-id="${notificationId}">
                                    <i class="fas fa-envelope mr-2"></i> Tandai belum dibaca
                                </a>
                                <a href="#" class="delete-notification" data-id="${notificationId}">
                                    <i class="fas fa-trash mr-2"></i> Hapus notifikasi
                                </a>
                            `;
                        });
                        
                        // Re-attach event listeners
                        attachEventListeners();
                        
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi AJAX untuk menghapus semua notifikasi
            function deleteAllNotifications() {
                if (!confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')) return;
                
                fetch('/notifications/delete-all', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('notificationList').innerHTML = '';
                        document.getElementById('notificationList').classList.add('hidden');
                        document.getElementById('emptyState').classList.remove('hidden');
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi untuk memperbarui jumlah notifikasi belum dibaca
            function updateUnreadCount() {
                let unreadCount = document.querySelectorAll('.notification-unread').length;
                
                // Update jumlah notifikasi belum dibaca di sidebar/topbar jika ada
                // Kode ini dapat disesuaikan dengan elemen yang ada di layout
            }
        });
    </script>
@endsection