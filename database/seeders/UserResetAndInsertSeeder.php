<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Log;
use App\Models\Notification;

class UserResetAndInsertSeeder extends Seeder
{
    /**
     * Run the database seeds for resetting and re-inserting users.
     * This will delete all related data before inserting new users from UserSeeder.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily to avoid constraint errors during deletion
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete related records first (child tables)
        Notification::truncate();
        Log::truncate();
        Izin::truncate();
        Absensi::truncate();

        // Delete users last (parent table)
        User::truncate();

        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Now run the UserSeeder to insert the fresh data
        $this->call(UserSeeder::class);

        // Optional: Output message
        $this->command->info('User data reset and re-inserted successfully!');
    }
}