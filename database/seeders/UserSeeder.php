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
        // Create admin user
        User::create([
            'nomor_id' => 'ADM-001',
            'nama' => 'Admin Sekolah',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nomor_telepon' => '081234567890',
        ]);

        // Create teacher users
        User::create([
            'nomor_id' => 'GRU-001',
            'nama' => 'Budi Santoso',
            'email' => 'budi@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nomor_telepon' => '081234567891',
        ]);

        User::create([
            'nomor_id' => 'GRU-002',
            'nama' => 'Ani Lestari',
            'email' => 'ani@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nomor_telepon' => '081234567892',
        ]);

        User::create([
            'nomor_id' => 'GRU-003',
            'nama' => 'Agus Kurniawan',
            'email' => 'agus@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nomor_telepon' => '081234567893',
        ]);
    }
}