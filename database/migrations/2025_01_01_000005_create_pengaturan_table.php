<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('jam_masuk_mulai')->default('07:00'); // Jam mulai absen masuk
            $table->string('jam_masuk_batas')->default('08:00'); // Jam batas absen masuk
            $table->string('jam_pulang_mulai')->default('15:00'); // Jam mulai absen pulang
            $table->string('jam_pulang_batas')->default('16:00'); // Jam batas absen pulang
            $table->string('radius_lokasi')->default('50'); // Radius lokasi absen dalam meter
            $table->string('lokasi_absen_lat')->nullable(); // Koordinat lintang lokasi absen
            $table->string('lokasi_absen_lng')->nullable(); // Koordinat bujur lokasi absen
            $table->string('nama_sekolah');
            $table->string('alamat_sekolah');
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('settings')->insert([
            'nama_sekolah' => 'Sekolah Pelita Harapan',
            'alamat_sekolah' => 'Jl. Pendidikan No. 1, Kota Edukasi',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};