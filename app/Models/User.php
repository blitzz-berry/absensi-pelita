<?php

namespace App\Models;

// import 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_id',
        'nama',
        'email',
        'password',
        'role',
        'nomor_telepon',
        'foto_profile',
        'jabatan',
        'gelar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke tabel absensi
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Relasi ke tabel izin
     */
    public function izin()
    {
        return $this->hasMany(Izin::class);
    }

    /**
     * Relasi ke tabel log
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Relasi ke tabel notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}