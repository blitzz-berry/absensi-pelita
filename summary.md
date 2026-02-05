Pakai prompt ini di Codex (VSCode) biar dia **ngubah UI Laravel kamu + implement Livewire** supaya tampilannya **mirip banget** kayak mockup di gambar (guru & admin, card, bottom-nav, dsb).

---

## PROMPT UNTUK CODEX (COPY–PASTE)

Kamu adalah senior Laravel + Livewire engineer dan UI implementer. Tugasmu: refactor tampilan project Laravel-ku agar UI/UX-nya mengikuti desain mobile-modern seperti aplikasi absensi pada mockup berikut (tanpa aku kirim gambar). Kerjakan sampai runnable.

### 0) Target & aturan

* Tech: Laravel (existing project) + **Livewire v3** (wajib dipakai untuk page/komponen utama).
* Styling: gunakan **Tailwind CSS** (via Vite). Kalau project belum pakai Tailwind, install & konfigurasi.
* Interaksi ringan (dropdown, modal, tab, sticky nav) boleh pakai **Alpine.js**.
* Layout harus **mobile-first**, tapi tetap rapi di desktop (centered container).
* Buat struktur komponen rapi (reusable cards, badges, bottom nav, topbar).
* Jangan merusak logic bisnis yang sudah ada; fokus pada UI layer + wiring Livewire.

---

## 1) Desain sistem (yang harus kamu tiru)

### A. Pola layout global (semua halaman)

Buat “App Shell” dengan struktur ini:

* **Topbar** (fixed/ sticky di atas):

  * Kiri: logo + teks “PELITA INSANI” + subteks kecil “KB/TK/SD/SMP Nasional Plus”
  * Kanan: avatar bulat berisi inisial (misal “HA/AS”) + nama (contoh: Hasan / Admin), dan ikon notifikasi (bell) di beberapa halaman.
  * Background putih, border bawah halus, padding nyaman.
* **Main content**:

  * Background halaman: abu sangat muda dengan kesan gradient lembut.
  * Konten dibungkus container: `max-w-[430px]` (mobile) dan di desktop tetap center.
  * Banyak “card” putih rounded besar + shadow halus.
* **Bottom Navigation** (fixed di bawah):

  * Bentuk pill/rounded, elevated, background putih.
  * 5 menu (untuk Guru): Dashboard, Absensi Harian, Riwayat Kehadiran, Lokasi Saya, Pengaturan.
  * 5 menu (untuk Admin): Dashboard, Data Guru, Rekap Absensi, Notifikasi, Pengaturan.
  * Icon simple + label kecil, state aktif berwarna biru, non-aktif abu.

Buat layout blade utama misalnya:

* `resources/views/layouts/mobile-app.blade.php`
  yang dipakai semua halaman guru/admin.

---

## 2) Style guide (harus mirip mockup)

### Warna & feel

* Primary: biru lembut (untuk active tab/nav, highlight, link).
* Success: hijau (badge hadir, tombol Absen Masuk).
* Danger: merah (tombol Absen Pulang).
* Warning: orange (terlambat).
* Card: putih, radius besar (± 18–24px), shadow halus.
* Header judul besar tebal.

### Komponen UI wajib dibuat reusable

Buat komponen Blade (atau Livewire partial) reusable:

1. **Card** (wrapper)
2. **Stat Card** (angka besar + label, dengan aksen garis warna di sisi kiri seperti mockup)
3. **Badge** status (Hadir/Izin/Sakit/Terlambat) bentuk capsule kecil.
4. **Table Card** (judul “Riwayat …” + tabel minimalis)
5. **Bottom Nav Item** (icon + label, active state)
6. **Section Title** dengan subtext

Simpan komponen Blade di:

* `resources/views/components/ui/*`
  atau gunakan Blade components `php artisan make:component`.

---

## 3) Halaman GURU (Livewire pages)

Buat Livewire page components ini (nama bebas tapi konsisten):

1. **Guru Dashboard**

* Headline: “Selamat Datang, {Nama}”
* Sub: “Dashboard Guru - Sistem Absensi Guru”
* 2 card kecil sejajar:

  * Card kiri: “Tanggal & Jam” tampilkan tanggal (format “11 Jan 2026”) dan jam.
  * Card kanan: “Status Hari Ini” (misal “-” kalau belum absen).
* 2 tombol besar sejajar:

  * **Absen Masuk** (hijau, icon check)
  * **Absen Pulang** (merah, icon power)
* Card tabel: “Riwayat Absensi Terakhir”

  * kolom: TANGGAL | JAM MASUK | STATUS
  * status berupa badge capsule.

2. **Absensi Harian**

* Card filter rentang tanggal (contoh “08 Jan 2026 – 14 Jan 2026”).
* Tabel: TANGGAL | HARI (contoh Kamis, Jumat, Rabu, Setasa)
* Link teks “Lihat Riwayat Kehadiran >”

3. **Riwayat Kehadiran**

* 4 stat card kecil: Hadir, Terlambat, Izin, Sakit (angka besar).
* Card “Riwayat Absensi Terakhir” tabel + badge status.

4. **Lokasi Saya**

* Headline “Lokasi Saya”
* Area map placeholder (kalau belum integrasi map, bikin card dengan image/placeholder + pin icon).
* Tombol biru “Mencari lokasi…”
* Card status hijau muda “Sedang mencari lokasi…”

5. **Pengajuan Izin / Sakit**

* Judul “Pengajuan Izin/Sakit”
* Tab switcher 2 tombol: IZIN dan SAKIT (segmented control).
* Form:

  * Tanggal Mulai (date picker)
  * Tanggal Selesai (date picker)
* Card “Panduan Pengajuan” bullet list.

6. **Pengaturan**

* List item style:

  * Profil (nama + email)
  * Pengaturan Akun
  * Tema & Tampilan (value: “Cerah”)
  * Laporan & Notifikasi
  * Bahasa (value: “Bahasa Indonesia”)
  * Bantuan & Panduan
* Tombol “Keluar” merah di bawah.

Semua halaman ini harus memakai layout app shell + bottom nav guru.

---

## 4) Halaman ADMIN (Livewire pages)

1. **Admin Dashboard**

* “Selamat Datang, Admin Sekolah”
* 4 stat card grid 2x2:

  * Total Guru (66)
  * Hadir Hari Ini (1)
  * Izin/Sakit (0)
  * Terlambat (0)
* 2 card grafik:

  * “Kehadiran Minggu Ini” (bar chart placeholder)
  * “Persentase Kehadiran” (donut chart placeholder)
    Jika belum siap chart library, buat placeholder UI yang mirip (kotak grafik + dummy bars + donut SVG sederhana).

2. **Data Guru**

* Tombol “+ Tambah Guru” biru.
* Table: Nomor ID | Nama Guru | Aksi (icon edit/pencil).
* Card “Riwayat Absensi Terakhir” di bawah (optional tapi ikut mockup).

3. **Rekap Absensi**

* Date range picker card (contoh “01 – 30 April 2024”).
* Stat cards:

  * Total Guru, Hadir, Izin/Sakit, Terlambat
* Card “Statistik Kehadiran Minggu Ini” dengan bar mini + donut “80%”.

4. **Notifikasi**

* Search input “Cari notifikasi…”
* List notification cards (icon kotak warna + judul + deskripsi + timestamp kecil).
* Badge count di kanan atas (contoh “3”), bottom nav item notifikasi punya badge merah kecil “1”.

5. **Pengaturan** (sama pola dengan guru tapi label admin).

Semua halaman ini memakai bottom nav admin.

---

## 5) Routing + auth role

* Gunakan middleware `auth`.
* Tentukan role user (misal `role` di users: `guru` / `admin`).
* Buat route group:

  * `/guru/*` untuk guru
  * `/admin/*` untuk admin
* Setelah login, redirect sesuai role ke dashboard masing-masing.

---

## 6) Implementasi Livewire yang diminta

* Setiap halaman = Livewire component (page).
* Data tabel boleh dummy dulu tapi strukturnya sudah siap menerima dari DB.
* State yang wajib:

  * Active bottom-nav item berdasarkan route.
  * Tab IZIN/SAKIT di halaman pengajuan (Livewire state).
  * Notifikasi count (dummy ok).
* Jam di dashboard guru update realtime tiap 1 detik:

  * Pakai Livewire polling ringan (`wire:poll.1s`) atau JS kecil yang tidak bikin flicker.

---

## 7) File & struktur yang harus kamu hasilkan

Wajib buat/ubah (sesuaikan dengan kondisi projectku):

* Tailwind install & config Vite
* `resources/views/layouts/mobile-app.blade.php`
* Komponen UI reusable (blade components)
* Livewire pages untuk semua menu guru/admin
* Route definitions `routes/web.php`
* Middleware/redirect role setelah login
* Pastikan semua halaman memakai typography, spacing, rounded, shadow mirip mockup.

Output akhir: jalankan `npm run dev` + `php artisan serve`, semua halaman tampil rapi.

Mulai dengan: cek struktur projectku dulu, lalu implement bertahap (layout -> komponen UI -> halaman guru -> halaman admin -> routing -> polishing responsive).

