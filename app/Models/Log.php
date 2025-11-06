<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'aktivitas',
        'waktu',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}