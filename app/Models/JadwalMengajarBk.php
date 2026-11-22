<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMengajarBk extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mengajar_bk';

    protected $primaryKey = 'id_jadwal_mengajar';

    protected $fillable = [
        'id_guru_bk',
        'id_user',
        'hari',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'id_kelas',
        'mata_pelajaran',
        'catatan',
        'keterangan',
        'is_active',
        'is_aktif',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const HARI_MAP = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public const DAFTAR_HARI = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
    ];

    public function setIdUserAttribute($value): void
    {
        $this->attributes['id_guru_bk'] = $value;
    }

    public function getIdUserAttribute()
    {
        return $this->attributes['id_guru_bk'] ?? null;
    }

    public function setKeteranganAttribute($value): void
    {
        $this->attributes['catatan'] = $value;
    }

    public function getKeteranganAttribute()
    {
        return $this->attributes['catatan'] ?? null;
    }

    public function setIsAktifAttribute($value): void
    {
        $this->attributes['is_active'] = (bool) $value;
    }

    public function getIsAktifAttribute(): bool
    {
        return (bool) ($this->attributes['is_active'] ?? true);
    }

    public function guruBk()
    {
        return $this->belongsTo(User::class, 'id_guru_bk', 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public static function normalizeTime(string $time): string
    {
        $time = trim($time);
        if (strlen($time) === 5) {
            return $time . ':00';
        }
        return $time;
    }

    public static function resolveHariFromTanggal(string $tanggal): string
    {
        $iso = Carbon::parse($tanggal)->dayOfWeekIso;
        return self::HARI_MAP[$iso] ?? 'Senin';
    }

    public static function dayNameFromDate(string $tanggal): string
    {
        return self::resolveHariFromTanggal($tanggal);
    }

    /**
     * Cek bentrok antar-jadwal mengajar Guru BK pada hari/tanggal yang sama.
     */
    public static function findTeachingConflict(
        string $hari,
        ?string $tanggal,
        string $waktuMulai,
        string $waktuSelesai,
        ?int $excludeId = null,
        bool $lockForUpdate = false
    ): ?self {
        $waktuMulai = self::normalizeTime($waktuMulai);
        $waktuSelesai = self::normalizeTime($waktuSelesai);

        if (!empty($tanggal)) {
            $hari = self::resolveHariFromTanggal($tanggal);
        }

        $query = self::with('kelas')
            ->where('is_active', true)
            ->where(function ($q) use ($hari, $tanggal) {
                $q->whereRaw('LOWER(hari) = ?', [mb_strtolower(trim($hari))]);
                if (!empty($tanggal)) {
                    $q->where(function ($sub) use ($tanggal) {
                        $sub->whereNull('tanggal')
                            ->orWhere('tanggal', $tanggal);
                    });
                }
            })
            ->where('waktu_mulai', '<', $waktuSelesai)
            ->where('waktu_selesai', '>', $waktuMulai);

        if ($excludeId) {
            $query->where('id_jadwal_mengajar', '!=', $excludeId);
        }

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->first();
    }

    /**
     * Cek apakah suatu tanggal dan rentang jam berbenturan dengan jadwal mengajar Guru BK yang aktif.
     */
    public static function findConflictOnDate(
        string $tanggal,
        string $waktuMulai,
        string $waktuSelesai,
        bool $lockForUpdate = false
    ): ?self {
        $waktuMulai = self::normalizeTime($waktuMulai);
        $waktuSelesai = self::normalizeTime($waktuSelesai);
        $hari = self::resolveHariFromTanggal($tanggal);

        $query = self::with('kelas')
            ->where('is_active', true)
            ->where(function ($q) use ($hari, $tanggal) {
                $q->where(function ($routine) use ($hari) {
                    $routine->whereNull('tanggal')
                        ->whereRaw('LOWER(hari) = ?', [mb_strtolower($hari)]);
                })->orWhere('tanggal', $tanggal);
            })
            ->where('waktu_mulai', '<', $waktuSelesai)
            ->where('waktu_selesai', '>', $waktuMulai);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->first();
    }

    public static function formatConflictMessage(self $conflict): string
    {
        $waktu = substr($conflict->waktu_mulai, 0, 5) . ' - ' . substr($conflict->waktu_selesai, 0, 5);
        $kelasInfo = $conflict->kelas ? ' (Kelas ' . $conflict->kelas->nama_kelas . ')' : '';
        $mapel = $conflict->mata_pelajaran ?: 'Jadwal Mengajar BK';

        return "Waktu bertabrakan dengan Jadwal Mengajar Guru BK: {$mapel}{$kelasInfo} pada hari {$conflict->hari} pukul {$waktu}. Silakan pilih waktu di luar jam mengajar.";
    }
}
