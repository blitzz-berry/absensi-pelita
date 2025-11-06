<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Email Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi validasi email untuk login admin
    | Jika require_email_validation di set true, hanya email dalam allowed_emails yang bisa login
    | Jika di set false, semua user dengan role admin bisa login
    |
    */

    'require_email_validation' => false, // Set ke true jika hanya email tertentu yang boleh login sebagai admin
    
    'allowed_emails' => [
        // Daftar email yang diizinkan jika require_email_validation diaktifkan
        env('ADMIN_EMAIL', 'admin@example.com'),
        'achmad@sch.id', // Email admin yang diizinkan
    ],
];