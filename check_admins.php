<?php
require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\DB;

// Create a simple script to check admin users
try {
    $adminUsers = User::where('role', 'admin')->get(['nomor_id', 'nama', 'email']);
    
    echo "Admin Users in Database:\n";
    echo "------------------------\n";
    
    foreach ($adminUsers as $user) {
        echo "ID: {$user->nomor_id}, Name: {$user->nama}, Email: {$user->email}\n";
    }
    
    echo "\nTotal admin users: " . $adminUsers->count() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}