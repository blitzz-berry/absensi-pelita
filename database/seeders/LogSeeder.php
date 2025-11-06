<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create log records
        Log::create([
            'user_id' => 2, // Budi Santoso
            'aktivitas' => 'Login Sistem',
            'waktu' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        Log::create([
            'user_id' => 2, // Budi Santoso
            'aktivitas' => 'Absen Masuk',
            'waktu' => now()->setTime(7, 30, 0),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        Log::create([
            'user_id' => 3, // Ani Lestari
            'aktivitas' => 'Login Sistem',
            'waktu' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        Log::create([
            'user_id' => 3, // Ani Lestari
            'aktivitas' => 'Absen Masuk',
            'waktu' => now()->setTime(7, 45, 0),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        Log::create([
            'user_id' => 1, // Admin
            'aktivitas' => 'Login Sistem',
            'waktu' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);
    }
}