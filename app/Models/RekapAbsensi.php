<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapAbsensi extends Model
{
    use HasFactory;

    protected $table = 'rekap_absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_terlambat',
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_alpha',
        'detail_harian',
    ];

    /**
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}