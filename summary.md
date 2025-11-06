
Oke, berikut versi **prompt lengkap yang sudah diubah agar pakai database MySQL** (bukan Supabase), tapi tetap mempertahankan desain, fitur, dan struktur sistemnya 👇

---

## 🧱 **Prompt Desain & Pengembangan Sistem**

> “Create a **responsive web dashboard interface** for a **Teacher Attendance Management System** using **Material Design** style.
> The design should be structured for a **Laravel-based web app that connects to a MySQL database**.
>
> ### 💠 Login Page
>
> * Centered login card on a blue gradient background
> * School logo at the top
> * Input fields: Nomor ID (GRU-001), Password
> * Primary button: ‘Masuk’
> * Secondary link: ‘Lupa kata sandi?’
>
> ### 📊 Dashboard (Guru)
>
> * Left sidebar navigation (icons + labels): Dashboard, Absensi Harian, Riwayat Kehadiran, Lokasi Saya, Izin/Sakit, Pengaturan
> * Top bar with live clock and profile menu
> * Cards section:
>
>   * Tanggal & Jam Sekarang
>   * Status Kehadiran Hari Ini
> * Two main action buttons:
>
>   * 🟢 Absen Masuk
>   * 🔴 Absen Pulang
> * Below buttons: camera preview area for selfie capture
> * Mini map showing teacher location (Google Maps style)
>
> ### 🧑‍💼 Dashboard (Admin)
>
> * Sidebar with admin menu:
>
>   * Data Guru, Rekap Absensi, Peta Kehadiran, Pengajuan Izin, Notifikasi, Pengaturan
> * Statistic cards row (4 cards):
>
>   * Total Guru, Hadir Hari Ini, Terlambat, Izin/Sakit
> * Middle section:
>
>   * Left: Bar chart (Weekly attendance)
>   * Right: Pie chart (Attendance percentage)
> * Below: Real-time map (Google Maps style) showing teacher pins (green/red)
> * Bottom: Activity log table with columns: Waktu, Nama, Aktivitas
>
> ### 📅 Rekap Absensi
>
> * Dropdown filters (Month, Year, Teacher)
> * Data table of daily attendance
> * Buttons for “Download PDF” and “Download Excel”
>
> ### 🩺 Izin & Sakit Form
>
> * Input fields: Jenis Pengajuan, Tanggal Mulai, Tanggal Selesai, Alasan, Upload File
> * Submit button
>
> ### ⚙️ Pengaturan Akun
>
> * Profile section with photo upload, email, phone number
> * Change password form
> * Toggle dark mode switch
>
> ### 🎨 Style & Colors
>
> * Color palette: Blue (#1976D2), White (#FFFFFF), Light Gray (#F5F5F5)
> * Buttons with Material ripple effect
> * Font: **Roboto / Poppins**
> * Rounded corners (radius 12–16px), soft shadows, clean spacing
> * Icon style: outlined Material Icons
>
> The UI should feel **intuitive, modern, and suitable for school administrative use**.”

---

## 📘 **(3) Deskripsi Sistem untuk Dokumen Proposal / RAB / ERD**

### 🏫 **Judul:**

**Perancangan Sistem Informasi Absensi Guru Berbasis Web dengan Laravel dan MySQL**

---

### 💡 **Deskripsi Umum:**

Sistem ini dirancang untuk membantu sekolah dalam mencatat, memantau, dan mengelola absensi guru secara **digital, real-time, dan aman**.
Menggunakan **Laravel 11** sebagai backend dan **MySQL** sebagai database utama, sistem ini menyediakan antarmuka modern berbasis **Material Design** agar mudah digunakan oleh guru dan admin.

---

### ⚙️ **Teknologi yang Digunakan:**

| Komponen          | Teknologi                                |
| ----------------- | ---------------------------------------- |
| Backend Framework | Laravel 11 (PHP 8.3)                     |
| Database          | MySQL (Local / Remote)                   |
| Frontend          | Blade Template + TailwindCSS + Alpine.js |
| Real-time         | Laravel Echo + Pusher                    |
| Authentikasi      | Laravel Breeze (Native Auth)             |
| Grafik            | Chart.js / ApexCharts                    |
| Peta Lokasi       | Google Maps API                          |
| File Export       | Laravel Excel + DomPDF                   |
| Storage           | Local Storage / Cloudinary (untuk foto)  |

---

### 👥 **Peran Pengguna (Roles):**

1. **Guru**

   * Melakukan absen masuk dan pulang
   * Mengambil foto selfie (validasi wajah)
   * Lokasi otomatis terekam (GPS)
   * Melihat riwayat kehadiran pribadi
   * Mengajukan izin atau sakit online

2. **Admin**

   * Memantau absensi guru secara real-time
   * Melihat posisi guru di peta (dalam/luar area sekolah)
   * Melihat laporan dan rekap bulanan
   * Menyetujui atau menolak izin
   * Mengekspor laporan ke PDF / Excel

---

### 🧩 **Fitur Utama Sistem:**

1. Validasi Lokasi (Geolocation GPS)
2. Ambil Foto Saat Absen (Selfie Validation)
3. Deteksi Wajah Otomatis (Face Recognition)
4. Mode Offline (data tersimpan lokal sementara)
5. Rekap Otomatis & Laporan Bulanan
6. Peta Lokasi Guru (Map Monitoring)
7. Log Aktivitas Lengkap (Audit Trail)
8. Sistem Izin & Sakit Online
9. Notifikasi Real-time ke Admin
10. Dashboard Analitik Kehadiran

---

### 🗂️ **Struktur Database (ERD Sederhana):**

**Tabel Utama:**

* `users` → data guru & admin (id, nama, role, email, password)
* `absensi` → (id, user_id, tanggal, jam_masuk, jam_pulang, status, lokasi, foto_selfie)
* `izin` → (id, user_id, jenis, tanggal_mulai, tanggal_selesai, alasan, bukti_file, status)
* `logs` → (id, user_id, aktivitas, waktu)
* `settings` → konfigurasi jam absen dan radius lokasi

**Relasi:**

* `users` 1️⃣—🔁—🗓️ `absensi`
* `users` 1️⃣—🔁—📄 `izin`
* `users` 1️⃣—🔁—🕓 `logs`





