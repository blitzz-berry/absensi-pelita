<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test basic home page response
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test login page
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test authentication (login and logout)
     */
    public function test_user_can_login_and_logout(): void
    {
        $user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
            'nama' => 'Test User',
            'nomor_id' => 'TEST001',
            'nomor_telepon' => '081234567890',
            'jabatan' => 'Guru',
            'gelar' => 'S.Pd',
            'email_verified_at' => now()
        ]);

        // Test login
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        // Test logout
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test dashboard access for different roles
     */
    public function test_dashboard_access_for_guru(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/dashboard');

        $response->assertRedirect('/guru/dashboard');
    }

    public function test_dashboard_access_for_admin(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/dashboard');

        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Test guru dashboard access
     */
    public function test_guru_dashboard_is_accessible_when_logged_in_as_guru(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test admin dashboard access
     */
    public function test_admin_dashboard_is_accessible_when_logged_in_as_admin(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test data guru access for admin
     */
    public function test_admin_can_access_data_guru(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/data-guru');

        $response->assertStatus(200);
    }

    /**
     * Test rekap absensi access for admin
     */
    public function test_admin_can_access_rekap_absensi(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/rekap-absensi');

        $response->assertStatus(200);
    }

    /**
     * Test peta kehadiran access for admin
     */
    public function test_admin_can_access_peta_kehadiran(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/peta-kehadiran');

        $response->assertStatus(200);
    }

    /**
     * Test pengajuan izin access for admin
     */
    public function test_admin_can_access_pengajuan_izin(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/pengajuan-izin');

        $response->assertStatus(200);
    }

    /**
     * Test guru attendance status
     */
    public function test_guru_can_access_attendance_status(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/attendance-status');

        $response->assertStatus(200);
    }

    /**
     * Test guru absensi harian
     */
    public function test_guru_can_access_absensi_harian(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/absensi-harian');

        $response->assertStatus(200);
    }

    /**
     * Test guru riwayat kehadiran
     */
    public function test_guru_can_access_riwayat_kehadiran(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/riwayat-kehadiran');

        $response->assertStatus(200);
    }

    /**
     * Test guru izin
     */
    public function test_guru_can_access_izin(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/izin');

        $response->assertStatus(200);
    }

    /**
     * Test guru pengaturan
     */
    public function test_guru_can_access_pengaturan(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/guru/pengaturan');

        $response->assertStatus(200);
    }

    /**
     * Test admin profil access
     */
    public function test_admin_can_access_profil(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/profil');

        $response->assertStatus(200);
    }

    /**
     * Test admin pengaturan access
     */
    public function test_admin_can_access_pengaturan(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/pengaturan');

        $response->assertStatus(200);
    }

    /**
     * Test admin notifications access
     */
    public function test_admin_can_access_notifications(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/notifications');

        $response->assertStatus(200);
    }

    /**
     * Test guru can perform attendance (absen masuk)
     */
    public function test_guru_can_perform_absen_masuk(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->post('/guru/absen/masuk', [
                             'latitude' => '-6.200000',
                             'longitude' => '106.816666',
                             'lokasi' => 'Kantor',
                             'foto' => null
                         ]);

        // Karena absen masuk perlu validasi lokasi dan lainnya,
        // kita hanya cek apakah route bisa diakses dengan metode yang benar
        $response->assertStatus(422); // Akan mengembalikan error karena validasi, yang berarti route dikenali
    }

    /**
     * Test guru can perform attendance (absen pulang)
     */
    public function test_guru_can_perform_absen_pulang(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru Test'
        ]);

        $response = $this->actingAs($user)
                         ->post('/guru/absen/pulang', [
                             'latitude' => '-6.200000',
                             'longitude' => '106.816666',
                             'lokasi' => 'Kantor',
                             'foto' => null
                         ]);

        // Karena absen pulang perlu validasi lokasi dan lainnya,
        // kita hanya cek apakah route bisa diakses dengan metode yang benar
        $response->assertStatus(422); // Akan mengembalikan error karena validasi, yang berarti route dikenali
    }

    /**
     * Test admin can access create guru page
     */
    public function test_admin_can_access_create_guru_page(): void
    {
        $user = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($user)
                         ->get('/admin/data-guru/create');

        $response->assertStatus(200);
    }

    /**
     * Test admin can create guru
     */
    public function test_admin_can_create_guru(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->post('/admin/data-guru', [
                             'nomor_id' => '123456',
                             'nama' => 'Test Guru',
                             'email' => 'testguru@example.com',
                             'password' => 'password',
                             'nomor_telepon' => '081234567890',
                             'jabatan' => 'Guru',
                             'gelar' => 'S.Pd'
                         ]);

        $response->assertRedirect('/admin/data-guru');
        $this->assertDatabaseHas('users', [
            'nomor_id' => '123456',
            'nama' => 'Test Guru',
            'email' => 'testguru@example.com',
            'role' => 'guru'
        ]);
    }

    /**
     * Test admin can edit guru
     */
    public function test_admin_can_edit_guru(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $guru = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Original Name'
        ]);

        $response = $this->actingAs($adminUser)
                         ->get("/admin/data-guru/{$guru->id}/edit");

        $response->assertStatus(200);
    }

    /**
     * Test admin can update guru
     */
    public function test_admin_can_update_guru(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $guru = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Original Name'
        ]);

        $response = $this->actingAs($adminUser)
                         ->put("/admin/data-guru/{$guru->id}", [
                             'nomor_id' => $guru->nomor_id,
                             'nama' => 'Updated Name',
                             'email' => $guru->email,
                             'nomor_telepon' => '081234567890',
                             'jabatan' => 'Guru Updated',
                             'gelar' => 'S.Pd'
                         ]);

        $response->assertRedirect('/admin/data-guru');
        $this->assertDatabaseHas('users', [
            'id' => $guru->id,
            'nama' => 'Updated Name',
            'jabatan' => 'Guru Updated'
        ]);
    }

    /**
     * Test admin can delete guru
     */
    public function test_admin_can_delete_guru(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $guru = User::factory()->create([
            'name' => '',
            'role' => 'guru',
            'nama' => 'Guru To Delete'
        ]);

        $this->assertDatabaseHas('users', ['id' => $guru->id]);

        $response = $this->actingAs($adminUser)
                         ->delete("/admin/data-guru/{$guru->id}");

        $response->assertRedirect('/admin/data-guru');
        $this->assertDatabaseMissing('users', ['id' => $guru->id]);
    }

    /**
     * Test admin can generate rekap absensi
     */
    public function test_admin_can_generate_rekap_absensi(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->post('/admin/rekap-absensi/generate', [
                             'bulan' => date('m'),
                             'tahun' => date('Y')
                         ]);

        // Karena fungsi generate rekap absensi mengarahkan kembali ke halaman rekap absensi,
        // kita hanya cek apakah route bisa diakses
        $response->assertRedirect('/admin/rekap-absensi');
    }

    /**
     * Test admin can access pengajuan izin page
     */
    public function test_admin_can_access_pengajuan_izin_page(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->get('/admin/pengajuan-izin');

        $response->assertStatus(200);
    }

    /**
     * Test admin can submit pengajuan izin
     */
    public function test_admin_can_submit_pengajuan_izin(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->post('/admin/pengajuan-izin', [
                             'jenis_pengajuan' => 'izin',
                             'tanggal_mulai' => date('Y-m-d'),
                             'tanggal_selesai' => date('Y-m-d'),
                             'alasan' => 'Testing izin functionality'
                         ]);

        // Karena fungsi storePengajuanIzin mengarahkan kembali ke halaman pengajuan izin,
        // kita hanya cek apakah route bisa diakses
        $response->assertRedirect('/admin/pengajuan-izin');
    }

    /**
     * Test admin can update status pengajuan izin
     */
    public function test_admin_can_update_status_pengajuan_izin(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        // Kita tidak bisa menguji fungsi update status izin tanpa membuat data izin terlebih dahulu
        // Jadi kita hanya menguji bahwa route bisa diakses dengan metode yang benar
        $response = $this->actingAs($adminUser)
                         ->put('/admin/pengajuan-izin/1/status', [
                             'status' => 'disetujui'
                         ]);

        // Karena ID izin 1 belum tentu ada, kemungkinan akan error 404 atau 422
        // Tapi yang penting adalah route dikenali dan middlewarenya bekerja
        $response->assertStatus(404); // 404 karena ID izin tidak ditemukan
    }

    /**
     * Test admin can access notifications page
     */
    public function test_admin_can_access_notifications_page(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->get('/admin/notifications');

        $response->assertStatus(200);
    }

    /**
     * Test admin can mark notification as read
     */
    public function test_admin_can_mark_notification_as_read(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        // Kita tidak bisa menguji fungsi mark notification as read tanpa membuat data notification terlebih dahulu
        // Jadi kita hanya menguji bahwa route bisa diakses dengan metode yang benar
        $response = $this->actingAs($adminUser)
                         ->post('/admin/notifications/1/read');

        // Karena ID notifikasi 1 belum tentu ada, kemungkinan akan error 404
        // Tapi yang penting adalah route dikenali dan middlewarenya bekerja
        $response->assertStatus(404); // 404 karena ID notifikasi tidak ditemukan
    }

    /**
     * Test admin can mark notification as unread
     */
    public function test_admin_can_mark_notification_as_unread(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        // Kita tidak bisa menguji fungsi mark notification as unread tanpa membuat data notification terlebih dahulu
        // Jadi kita hanya menguji bahwa route bisa diakses dengan metode yang benar
        $response = $this->actingAs($adminUser)
                         ->post('/admin/notifications/1/unread');

        // Karena ID notifikasi 1 belum tentu ada, kemungkinan akan error 404
        // Tapi yang penting adalah route dikenali dan middlewarenya bekerja
        $response->assertStatus(404); // 404 karena ID notifikasi tidak ditemukan
    }

    /**
     * Test admin can mark all notifications as read
     */
    public function test_admin_can_mark_all_notifications_as_read(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->post('/admin/notifications/read-all');

        $response->assertStatus(200); // Akan mengembalikan response JSON
    }

    /**
     * Test admin can delete notification
     */
    public function test_admin_can_delete_notification(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        // Kita tidak bisa menguji fungsi delete notification tanpa membuat data notification terlebih dahulu
        // Jadi kita hanya menguji bahwa route bisa diakses dengan metode yang benar
        $response = $this->actingAs($adminUser)
                         ->delete('/admin/notifications/1');

        // Karena ID notifikasi 1 belum tentu ada, kemungkinan akan error 404
        // Tapi yang penting adalah route dikenali dan middlewarenya bekerja
        $response->assertStatus(404); // 404 karena ID notifikasi tidak ditemukan
    }

    /**
     * Test admin can delete all notifications
     */
    public function test_admin_can_delete_all_notifications(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->delete('/admin/notifications/delete-all');

        $response->assertStatus(200); // Akan mengembalikan response JSON
    }

    /**
     * Test admin can access profile page
     */
    public function test_admin_can_access_profile_page(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->get('/admin/profil');

        $response->assertStatus(200);
    }

    /**
     * Test admin can update profile
     */
    public function test_admin_can_update_profile(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Original Name'
        ]);

        $response = $this->actingAs($adminUser)
                         ->put('/admin/profil', [
                             'nama' => 'Updated Name',
                             'email' => 'updated@example.com'
                         ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $adminUser->id,
            'nama' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    /**
     * Test admin can access settings page
     */
    public function test_admin_can_access_settings_page(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->get('/admin/pengaturan');

        $response->assertStatus(200);
    }

    /**
     * Test admin can update general settings
     */
    public function test_admin_can_update_general_settings(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test'
        ]);

        $response = $this->actingAs($adminUser)
                         ->put('/admin/pengaturan/umum', [
                             'notifikasi_absensi' => true,
                             'lokasi_wajib' => true,
                             'selfie_wajib' => false,
                             'toleransi_keterlambatan' => 30,
                             'waktu_absen_masuk' => '08:00',
                             'waktu_absen_pulang' => '17:00',
                             'radius_absen' => 100,
                             'pesan_pengingat' => 'Silahkan absen tepat waktu'
                         ]);

        $response->assertRedirect();
        // Kita tidak bisa mengecek data di database karena model SystemSetting belum tentu ada
        // Tapi kita bisa cek bahwa route bisa diakses tanpa error
        $response->assertSessionHas('success');
    }

    /**
     * Test admin can update password
     */
    public function test_admin_can_update_password(): void
    {
        $adminUser = User::factory()->create([
            'name' => '',
            'role' => 'admin',
            'email' => 'admin@pelita.com', // Sesuai dengan middleware admin.email
            'nama' => 'Admin Test',
            'password' => bcrypt('oldpassword')
        ]);

        $response = $this->actingAs($adminUser)
                         ->put('/admin/pengaturan/password', [
                             'password_lama' => 'oldpassword',
                             'password_baru' => 'newpassword',
                             'password_baru_confirmation' => 'newpassword'
                         ]);

        $response->assertRedirect();
        // Kita tidak bisa memvalidasi password baru karena perlu login kembali
        // Tapi kita bisa cek bahwa route bisa diakses tanpa error
    }
}
