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
     * Relasi ke tabel user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}