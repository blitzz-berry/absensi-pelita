<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jam_masuk_mulai',
        'jam_masuk_batas',
        'jam_pulang_mulai',
        'jam_pulang_batas',
        'radius_lokasi',
        'lokasi_absen_lat',
        'lokasi_absen_lng',
        'nama_sekolah',
        'alamat_sekolah',
    ];
}