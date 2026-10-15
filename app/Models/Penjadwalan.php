<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan';

    protected $primaryKey = 'id_penjadwalan';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'jenis_bimbingan',
        'catatan',
        'status',
        'id_wali',
        'waktu_persetujuan_wali',
        'catatan_wali',
    ];

    protected $casts = [
        'waktu_persetujuan_wali' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'id_wali', 'id_user');
    }

    public function isDiajukan(): bool
    {
        return $this->status === 'Diajukan';
    }

    public function isMenungguWali(): bool
    {
        return $this->status === 'Diajukan';
    }

    public function isDisetujuiWali(): bool
    {
        return $this->status === 'Disetujui_Wali';
    }

    public function isDitolakWali(): bool
    {
        return $this->status === 'Ditolak_Wali';
    }

    public function isTerjadwal(): bool
    {
        return $this->status === 'Terjadwal';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'Selesai';
    }

    public function isDibatalkan(): bool
    {
        return $this->status === 'Dibatalkan';
    }
}
