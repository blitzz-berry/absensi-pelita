<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'lokasi_masuk',
        'lokasi_pulang',
        'foto_selfie_masuk',
        'foto_selfie_pulang',
    ];

    /**
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}