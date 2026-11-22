<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
        'tingkat',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas', 'id_kelas');
    }

    public function waliKelas()
    {
        return $this->hasOne(User::class, 'id_kelas', 'id_kelas')
            ->where('role', 'wali_kelas')
            ->orderByDesc('id_user');
    }

    protected static function booted()
    {
        static::addGlobalScope('order_numerik', function ($builder) {
            $builder->orderBy('tingkat')
                ->orderByRaw("CASE WHEN SUBSTRING_INDEX(nama_kelas, '-', -1) REGEXP '^[0-9]+$' THEN 0 ELSE 1 END ASC")
                ->orderByRaw("CAST(SUBSTRING_INDEX(nama_kelas, '-', -1) AS UNSIGNED) ASC")
                ->orderBy('nama_kelas');
        });
    }
}
