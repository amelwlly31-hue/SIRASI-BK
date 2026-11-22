<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $primaryKey = 'id_siswa';

    public $timestamps = false;

    protected $attributes = [
        'status' => 'Aktif',
    ];

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'id_kelas',
        'alamat',
        'no_telp',
        'status',
    ];

    /** Format names for all model-backed views without changing stored values. */
    public function getNamaSiswaAttribute($value): string
    {
        return Str::title((string) $value);
    }

    /** Match student names consistently regardless of the input's letter case. */
    public function scopeWhereNameLike($query, string $search)
    {
        return $query->whereRaw('LOWER(nama_siswa) LIKE ?', ['%' . Str::lower(trim($search)) . '%']);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function konseling()
    {
        return $this->hasMany(Konseling::class, 'id_siswa', 'id_siswa');
    }

    public function penjadwalan()
    {
        return $this->hasMany(Penjadwalan::class, 'id_siswa', 'id_siswa');
    }
}
