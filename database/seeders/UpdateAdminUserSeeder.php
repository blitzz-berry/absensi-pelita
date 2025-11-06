<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update password user dengan email achmad@sch.id jika ada
        $user = User::where('email', 'achmad@sch.id')->first();
        
        if ($user) {
            $user->update([
                'password' => Hash::make('231011401673'),
            ]);
            echo "Password untuk user achmad@sch.id telah diperbarui.\n";
        } else {
            // Jika tidak ada, buat user admin baru
            User::create([
                'nomor_id' => 'ADM-001',
                'nama' => 'Admin Achmad',
                'email' => 'achmad@sch.id',
                'password' => Hash::make('231011401673'),
                'role' => 'admin',
                'nomor_telepon' => '081234567890',
            ]);
            echo "User achmad@sch.id telah dibuat dengan password baru.\n";
        }
    }
}