<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'data',
        'dibaca_pada',
        'url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dibaca_pada' => 'datetime',
        'data' => 'array',
    ];

    /**
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}