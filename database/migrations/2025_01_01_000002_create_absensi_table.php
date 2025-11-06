<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['belum_absen', 'hadir', 'terlambat', 'izin', 'sakit', 'alpha'])->default('belum_absen');
            $table->string('lokasi_masuk')->nullable(); // Koordinat lokasi saat absen masuk
            $table->string('lokasi_pulang')->nullable(); // Koordinat lokasi saat absen pulang
            $table->string('foto_selfie_masuk')->nullable(); // Path ke foto selfie saat absen masuk
            $table->string('foto_selfie_pulang')->nullable(); // Path ke foto selfie saat absen pulang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};