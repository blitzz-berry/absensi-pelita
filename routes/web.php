<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\GuruController;

// Route utama langsung ke login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// Route untuk halaman login dan proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk refresh CSRF token
Route::get('/csrf-token-refresh', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf.token.refresh');

// Route untuk halaman dashboard (harus login dulu)
Route::middleware(['auth'])->group(function () {
    // Dashboard guru
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/guru/dashboard');
    })->middleware(['auth'])->name('dashboard');
    
    // Route khusus untuk guru dashboard
    Route::get('/guru/dashboard', [App\Http\Controllers\GuruAbsensiController::class, 'index'])->middleware(['auth', 'role:guru'])->name('guru.dashboard');

    // Dashboard admin (hanya admin dengan email diizinkan)
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->middleware(['auth', 'role:admin', 'admin.email'])->name('admin.dashboard');
    
    // Route untuk data guru (hanya admin dengan email diizinkan)
    Route::middleware(['auth', 'role:admin', 'admin.email'])->group(function () {
        Route::get('/admin/data-guru', [GuruController::class, 'index'])->name('admin.data-guru');
        Route::get('/admin/data-guru/create', [GuruController::class, 'create'])->name('admin.data-guru.create');
        Route::post('/admin/data-guru', [GuruController::class, 'store'])->name('admin.data-guru.store');
        Route::get('/admin/data-guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.data-guru.edit');
        Route::put('/admin/data-guru/{id}', [GuruController::class, 'update'])->name('admin.data-guru.update');
        Route::delete('/admin/data-guru/{id}', [GuruController::class, 'destroy'])->name('admin.data-guru.destroy');
    });
    
    // Route untuk rekap absensi (hanya admin dengan email diizinkan)
    Route::middleware(['auth', 'role:admin', 'admin.email'])->group(function () {
        Route::match(['get', 'post'], '/admin/rekap-absensi', [GuruController::class, 'rekapAbsensi'])->name('admin.rekap-absensi');
        Route::post('/admin/rekap-absensi/generate', [GuruController::class, 'generateRekap'])->name('admin.rekap-absensi.generate');
        // Route untuk ekspor global (POST) - hanya Excel
        Route::post('/admin/rekap-absensi/export-excel', [GuruController::class, 'exportExcelGlobal'])->name('admin.rekap-absensi.export.excel.global');
        // Route untuk ekspor gaji global (POST) - hanya Excel
        Route::post('/admin/rekap-absensi/export-gaji-excel', [GuruController::class, 'exportExcelGajiGlobal'])->name('admin.rekap-absensi.export.gaji.excel.global');
        // Route untuk ekspor per guru (GET dengan user_id, bulan, tahun sebagai query params) - hanya Excel
        Route::get('/admin/rekap-absensi/export-excel/{user_id}', [GuruController::class, 'exportExcelPerGuru'])->name('admin.rekap-absensi.export.excel');
    });
    
    // Route untuk peta kehadiran (hanya admin dengan email diizinkan)
    Route::get('/admin/peta-kehadiran', [GuruController::class, 'petaKehadiran'])->middleware(['auth', 'role:admin', 'admin.email'])->name('admin.peta-kehadiran');

    // Route untuk API kehadiran harian (hanya admin dengan email diizinkan)
    Route::get('/admin/api/kehadiran-harian', [GuruController::class, 'getKehadiranHarian'])->middleware(['auth', 'role:admin', 'admin.email'])->name('admin.api.kehadiran.harian');

    // Route untuk API lokasi kehadiran (hanya admin dengan email diizinkan)
    Route::get('/admin/api/lokasi-kehadiran', [GuruController::class, 'getLokasiKehadiran'])->middleware(['auth', 'role:admin', 'admin.email'])->name('admin.api.lokasi.kehadiran');
    
    // Route untuk pengajuan izin (hanya admin dengan email diizinkan)
    Route::middleware(['auth', 'role:admin', 'admin.email'])->group(function () {
        Route::get('/admin/pengajuan-izin', [GuruController::class, 'pengajuanIzin'])->name('admin.pengajuan-izin');
        Route::post('/admin/pengajuan-izin', [GuruController::class, 'storePengajuanIzin'])->name('admin.pengajuan-izin.store');
        Route::put('/admin/pengajuan-izin/{id}/status', [GuruController::class, 'updateStatusIzin'])->name('admin.pengajuan-izin.status');
        Route::get('/admin/pengajuan-izin/{id}/detail', [GuruController::class, 'getDetailIzin'])->name('admin.pengajuan-izin.detail');
    });

    // Route untuk absensi guru
    Route::middleware(['auth', 'role:guru'])->group(function () {
        Route::post('/guru/absen/masuk', [App\Http\Controllers\GuruAbsensiController::class, 'absenMasuk'])->name('guru.absen.masuk');
        Route::post('/guru/absen/pulang', [App\Http\Controllers\GuruAbsensiController::class, 'absenPulang'])->name('guru.absen.pulang');
        Route::get('/guru/attendance-status', [App\Http\Controllers\GuruAbsensiController::class, 'getAttendanceStatus'])->name('guru.attendance.status');
        Route::get('/guru/riwayat-kehadiran', [App\Http\Controllers\GuruAbsensiController::class, 'riwayatKehadiran'])->name('guru.riwayat.kehadiran');
        Route::get('/guru/lokasi-saya', [App\Http\Controllers\GuruAbsensiController::class, 'lokasiSaya'])->name('guru.lokasi.saya');
        Route::get('/guru/izin', [App\Http\Controllers\GuruAbsensiController::class, 'izin'])->name('guru.izin');
        Route::post('/guru/izin', [App\Http\Controllers\GuruAbsensiController::class, 'storeIzin'])->name('guru.izin.store');
        Route::get('/guru/pengaturan', [App\Http\Controllers\GuruAbsensiController::class, 'pengaturan'])->name('guru.pengaturan');
        Route::post('/guru/pengaturan/profile', [App\Http\Controllers\GuruAbsensiController::class, 'updateProfile'])->name('guru.pengaturan.update.profile');
        Route::post('/guru/pengaturan/password', [App\Http\Controllers\GuruAbsensiController::class, 'updatePassword'])->name('guru.pengaturan.update.password');
        Route::post('/guru/pengaturan/upload-foto', [App\Http\Controllers\GuruAbsensiController::class, 'uploadFotoProfil'])->name('guru.pengaturan.upload.foto');
        Route::get('/guru/profil-saya', [App\Http\Controllers\GuruAbsensiController::class, 'profilSaya'])->name('guru.profil.saya');
        Route::put('/guru/profil-saya', [App\Http\Controllers\GuruAbsensiController::class, 'updateProfilSaya'])->name('guru.profil.saya.update');
    });

    // Halaman Profil Admin (hanya admin dengan email diizinkan)
    Route::middleware(['auth', 'role:admin', 'admin.email'])->group(function () {
        Route::get('/admin/profil', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profil');
        Route::put('/admin/profil', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profil.update');
        
        // Halaman Pengaturan Admin
        Route::get('/admin/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.pengaturan');
        Route::put('/admin/pengaturan/umum', [\App\Http\Controllers\Admin\SettingController::class, 'updateGeneralSettings'])->name('admin.pengaturan.umum.update');
        Route::put('/admin/pengaturan/akun', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.pengaturan.akun.update');
        Route::put('/admin/pengaturan/password', [\App\Http\Controllers\Admin\SettingController::class, 'updatePassword'])->name('admin.pengaturan.password.update');

        // Halaman Notifikasi Admin
        Route::get('/admin/notifications', [\App\Http\Controllers\NotificationController::class, 'show'])->name('admin.notifications');
        Route::get('/admin/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'getNotificationDetail'])->name('admin.notifications.detail');
    });

    // API untuk Notifikasi Admin (hanya admin dengan email diizinkan)
    Route::middleware(['auth', 'role:admin', 'admin.email'])->group(function () {
        Route::post('/admin/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
        Route::post('/admin/notifications/{notification}/unread', [\App\Http\Controllers\NotificationController::class, 'markAsUnread'])->name('admin.notifications.unread');
        Route::post('/admin/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('admin.notifications.read-all');
        Route::delete('/admin/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'deleteNotification'])->name('admin.notifications.delete');
        Route::delete('/admin/notifications/delete-all', [\App\Http\Controllers\NotificationController::class, 'deleteAllNotifications'])->name('admin.notifications.delete-all');
    });

    // API untuk Notifikasi Umum (jika diperlukan untuk non-admin)
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/{notification}/unread', [\App\Http\Controllers\NotificationController::class, 'markAsUnread'])->name('notifications.unread');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::delete('/notifications/delete-all', [\App\Http\Controllers\NotificationController::class, 'deleteAllNotifications'])->name('notifications.delete-all');

    // Route untuk testing notifikasi (hapus setelah selesai testing)
    Route::get('/test-notification', function() {
        $user = auth()->user();
        $user->notifications()->create([
            'title' => 'Notifikasi Testing',
            'message' => 'Ini adalah notifikasi contoh untuk pengujian fitur notifikasi',
            'link' => '#'
        ]);
        return redirect()->back()->with('success', 'Notifikasi testing telah ditambahkan');
    })->name('test.notification');
});
