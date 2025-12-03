<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            ['nomor_id' => 'ADM-001'],
            [
                'nama' => 'Admin Sekolah',
                'email' => 'admin@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nomor_telepon' => '081234567890',
            ]
        );

        // Create or update teacher users from existing data
        User::updateOrCreate(
            ['nomor_id' => 'GRU-001'],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nomor_telepon' => '081234567891',
            ]
        );

        User::updateOrCreate(
            ['nomor_id' => 'GRU-002'],
            [
                'nama' => 'Ani Lestari',
                'email' => 'ani@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nomor_telepon' => '081234567892',
            ]
        );

        User::updateOrCreate(
            ['nomor_id' => 'GRU-003'],
            [
                'nama' => 'Agus Kurniawan',
                'email' => 'agus@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nomor_telepon' => '081234567893',
            ]
        );

        User::updateOrCreate(
            ['nomor_id' => 'GRU-004'],
            [
                'nama' => 'Ardega',
                'email' => 'ardega@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nomor_telepon' => '089123456789',
            ]
        );

        // Create or update teacher users from datakaryawan.md (62 unique entries)
        // Total unique entries after removing duplicates: 62 (001-019, 020-029, 030-045, 048-067 except for some missing numbers)
        $karyawanData = [
            ['id' => '001', 'nama' => 'Cecep Hidayat', 'jabatan' => 'Office Boy'],
            ['id' => '002', 'nama' => 'Hasan', 'jabatan' => 'Office Boy'],
            ['id' => '003', 'nama' => 'Aniq Farida, S.Ag', 'jabatan' => 'Wali Kelas 2 A'],
            ['id' => '004', 'nama' => 'Silvina Rini Hapsari, SE', 'jabatan' => 'Wali Kelas 4'],
            ['id' => '005', 'nama' => 'Evranita, SP., S.Pd.Bio.,M.Si', 'jabatan' => 'Riset & Devlopment'],
            ['id' => '006', 'nama' => 'Kristiana Sundari, S.Pd.', 'jabatan' => 'Wali Kelas 1 A'],
            ['id' => '007', 'nama' => 'Enita Hartati Sinaga, S.T., S.P.d.Kim.', 'jabatan' => 'Personalia'],
            ['id' => '008', 'nama' => 'Ernawati, S.Pd.', 'jabatan' => 'Wali Kelas TK B'],
            ['id' => '009', 'nama' => 'Aden', 'jabatan' => 'Office Boy'],
            ['id' => '010', 'nama' => 'Andriyanto, S.Pd.I', 'jabatan' => 'Koordinator Agama'],
            ['id' => '011', 'nama' => 'Rila Juwita Dian Fajarwati, ST', 'jabatan' => 'Wakil Kepala Sekolah SD'],
            ['id' => '012', 'nama' => 'Sri Puji Sekar W, S.Pd', 'jabatan' => 'Kepala Sekolah SD'],
            ['id' => '013', 'nama' => 'Yoli Yana, ST', 'jabatan' => 'Kepala Sekolah SMP'],
            ['id' => '014', 'nama' => 'Endang Prihesti, S.H.', 'jabatan' => 'Wali Kelas VI A'],
            ['id' => '015', 'nama' => 'Evita Nuryani, S.Si.', 'jabatan' => 'Wali Kelas 5B'],
            ['id' => '016', 'nama' => 'Neni Hernani, S.Ag', 'jabatan' => 'Wali Kelas 1B'],
            ['id' => '017', 'nama' => 'Shelly Lamin, SE', 'jabatan' => 'Guru Kelas 3B'],
            ['id' => '018', 'nama' => 'Solkah, S.Pd', 'jabatan' => 'Dapodik & Operator Bos TK SD SMP'],
            ['id' => '019', 'nama' => 'Sayuti', 'jabatan' => 'Satpam'],
            ['id' => '020', 'nama' => 'Gaby Melani P, S.Sos', 'jabatan' => 'Marketing'],
            ['id' => '021', 'nama' => 'Istiqomah, S.Mat', 'jabatan' => 'Guru Tim kelas 4'],
            ['id' => '022', 'nama' => 'Diana Maratusshaliha, S.Pd', 'jabatan' => 'Asisten Guru Kelas TK B'],
            ['id' => '023', 'nama' => 'Putri Yani, S.Pd', 'jabatan' => 'Wali Kelas TK A'],
            ['id' => '024', 'nama' => 'Siti Maesyaroh', 'jabatan' => 'Asisten TK A'],
            ['id' => '025', 'nama' => 'Wahju Handajani, ST', 'jabatan' => 'Kepala Finance'],
            ['id' => '026', 'nama' => 'Ruslan', 'jabatan' => 'Office Boy'],
            ['id' => '027', 'nama' => 'Ine Irawati, A.Md', 'jabatan' => 'Wali Kelas TK B'],
            ['id' => '028', 'nama' => 'Dewi Desmawati, S.Pd.', 'jabatan' => 'Kepala KB-TK'],
            ['id' => '029', 'nama' => 'Farkhatun Nikmah, STP', 'jabatan' => 'Wakil Kepala Sekolah SMP'],
            ['id' => '030', 'nama' => 'Ulli Wardani, SH.', 'jabatan' => 'Guru Tim SMP'],
            ['id' => '031', 'nama' => 'Eko Wratsongko, S.Pd', 'jabatan' => 'Guru mapel MTK & Seni Vokal SD-SMP'],
            ['id' => '032', 'nama' => 'Ida Rosanna Siahaan,SE', 'jabatan' => 'Wali Kelas 7'],
            ['id' => '034', 'nama' => 'Ait Pratiwi, S.Pd.', 'jabatan' => 'Wali Kelas 2B'],
            ['id' => '035', 'nama' => 'Diniyati, SE.', 'jabatan' => 'Asisten Kelas 2B'],
            ['id' => '036', 'nama' => 'Yiska Eberta, S.Pd.K', 'jabatan' => 'Guru PAK'],
            ['id' => '037', 'nama' => 'Sabila Miftahul Jannah', 'jabatan' => 'Asisten 1A'],
            ['id' => '038', 'nama' => 'Ira Imelia', 'jabatan' => 'Kasir'],
            ['id' => '039', 'nama' => 'Rahmat', 'jabatan' => 'Satpam'],
            ['id' => '040', 'nama' => 'Merlis Irmayanti, SE', 'jabatan' => 'Asisten TK B'],
            ['id' => '041', 'nama' => 'Fatma Handayani, S.Sos', 'jabatan' => 'Asisten kelas 1A'],
            ['id' => '042', 'nama' => 'Murdika Isnaeni Zahra, SE', 'jabatan' => 'Asisten Kelas 2A'],
            ['id' => '043', 'nama' => 'Hasnaa Niditya R.,SH', 'jabatan' => 'Tim guru kelas 3'],
            ['id' => '044', 'nama' => 'Andi Rezki Bahara., S.I.Kom', 'jabatan' => 'Asisten Kelas PG + Admin Kepsek'],
            ['id' => '045', 'nama' => 'Tania Herdi Merdhikawati, S.Pd', 'jabatan' => 'Guru PJOK'],
            ['id' => '048', 'nama' => 'Edo', 'jabatan' => 'Parkir'],
            ['id' => '049', 'nama' => 'Rakhmat', 'jabatan' => 'Guru Agama Budha'],
            ['id' => '050', 'nama' => 'Drajat Nugroho', 'jabatan' => 'Guru Pramuka SD 4,5,6 dan SMP'],
            ['id' => '051', 'nama' => 'Nabila', 'jabatan' => 'Guru BM Tari SMP'],
            ['id' => '054', 'nama' => 'Gabby Livia', 'jabatan' => 'Guru Konghucu'],
            ['id' => '055', 'nama' => 'Wartono', 'jabatan' => 'Guru ekskul lukis'],
            ['id' => '056', 'nama' => 'Feriansyah', 'jabatan' => 'Guru ekskul paskibraka'],
            ['id' => '057', 'nama' => 'Andriyanto', 'jabatan' => 'Guru ekskul kaligrafi'],
            ['id' => '058', 'nama' => 'Eko Wratsongko', 'jabatan' => 'Guru ekskul gitar'],
            ['id' => '059', 'nama' => 'Samuel AP Sinaga', 'jabatan' => 'Guru ekskul coding'],
            ['id' => '060', 'nama' => 'Alex Asikin', 'jabatan' => 'Guru ekskul taekwondo'],
            ['id' => '061', 'nama' => 'Ricko Febrianto', 'jabatan' => 'Guru ekskul sinematographi'],
            ['id' => '062', 'nama' => 'Yanti Suherti', 'jabatan' => 'Guru ekskul karate'],
            ['id' => '063', 'nama' => 'Chairul Bone Taviq', 'jabatan' => 'Guru ekskul silat SD'],
            ['id' => '064', 'nama' => 'Chairul Bone Taviq', 'jabatan' => 'Guru ekskul silat SMP'],
            ['id' => '065', 'nama' => 'Ibnu Wibowo', 'jabatan' => 'Guru Ekskul bola'],
            ['id' => '066', 'nama' => 'Nabila', 'jabatan' => 'Ekskul Tari SD'],
            ['id' => '067', 'nama' => 'Felly', 'jabatan' => 'Guru Konghucu'],
        ];

        foreach ($karyawanData as $karyawan) {
            User::updateOrCreate(
                ['nomor_id' => 'KRY-' . $karyawan['id']],
                [
                    'nama' => $karyawan['nama'],
                    'email' => strtolower(str_replace([' ', ',', '.', '&'], ['.', '', '', 'and'], $karyawan['nama'])) . '.' . $karyawan['id'] . '@sekolah.com',
                    'password' => Hash::make('password'),
                    'role' => 'guru',
                    'nomor_telepon' => '081' . $karyawan['id'] . '000000', // Buat nomor telepon unik
                    'jabatan' => $karyawan['jabatan'],
                ]
            );
        }
    }
}