<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'bukti_file',
        'status',
        'catatan_admin',
        'approved_by',
        'approved_at',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Akses kolom 'jenis' sebagai 'jenis_pengajuan'
    public function getJenisPengajuanAttribute()
    {
        return $this->jenis;
    }

    public function setJenisPengajuanAttribute($value)
    {
        $this->attributes['jenis'] = $value;
    }

    /**
     * Relasi ke tabel user (pemohon izin)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel user (admin yang menyetujui)
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}