<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasis';

    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'dibaca',
        'id_konseling',
        'id_kelas',
        'id_user',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    protected $casts = [
        'dibaca' => 'boolean',
    ];
}
