<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdditionalAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional admin users
        User::updateOrCreate(
            ['nomor_id' => 'ADM-002'],
            [
                'nama' => 'Admin Dua',
                'email' => 'admin2@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nomor_telepon' => '081234567891',
            ]
        );

        User::updateOrCreate(
            ['nomor_id' => 'ADM-003'],
            [
                'nama' => 'Admin Tiga',
                'email' => 'admin3@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nomor_telepon' => '081234567892',
            ]
        );

        User::updateOrCreate(
            ['nomor_id' => 'ADM-004'],
            [
                'nama' => 'Admin Empat',
                'email' => 'admin4@sekolah.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nomor_telepon' => '081234567893',
            ]
        );
    }
}
