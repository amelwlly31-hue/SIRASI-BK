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

    /**
     * Status yang aktif memblokir slot waktu jadwal konseling.
     * Jadwal dengan status Ditolak_Wali atau Dibatalkan TIDAK memblokir slot.
     */
    public const ACTIVE_STATUSES = [
        'Terjadwal',
        'Disetujui_Wali',
        'Diajukan',
        'Selesai',
    ];

    /**
     * Status yang sudah resmi dikonfirmasi/disetujui.
     */
    public const CONFIRMED_STATUSES = [
        'Terjadwal',
        'Disetujui_Wali',
        'Selesai',
    ];

    /**
     * Mencari jadwal yang saling bertabrakan (time overlap) pada tanggal tertentu.
     *
     * Rumus matematis overlap rentang waktu [A, B] dan [C, D]:
     * waktu_mulai < D AND waktu_selesai > C
     *
     * @param string $tanggal Format 'Y-m-d'
     * @param string $waktuMulai Format 'H:i' atau 'H:i:s'
     * @param string $waktuSelesai Format 'H:i' atau 'H:i:s'
     * @param int|null $excludeId ID jadwal yang dikecualikan (misal saat edit diri sendiri)
     * @param array|null $statuses Daftar status yang dianggap memblokir slot
     * @param bool $lockForUpdate Gunakan lockForUpdate untuk mencegah race condition konkurensi
     * @return self|null
     */
    public static function findConflict(
        string $tanggal,
        string $waktuMulai,
        string $waktuSelesai,
        ?int $excludeId = null,
        ?array $statuses = null,
        bool $lockForUpdate = false
    ): ?self {
        // Normalisasi format jam ke 'H:i:s'
        if (strlen($waktuMulai) === 5) {
            $waktuMulai .= ':00';
        }
        if (strlen($waktuSelesai) === 5) {
            $waktuSelesai .= ':00';
        }

        $statuses = $statuses ?? self::ACTIVE_STATUSES;

        $query = self::where('tanggal', $tanggal)
            ->whereIn('status', $statuses)
            ->where('waktu_mulai', '<', $waktuSelesai)
            ->where('waktu_selesai', '>', $waktuMulai);

        if ($excludeId) {
            $query->where('id_penjadwalan', '!=', $excludeId);
        }

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->with('siswa')->first();
    }

    /**
     * Membuat pesan penjelasan bentrok jadwal yang ramah dan informatif.
     */
    public static function formatConflictMessage(self $conflict): string
    {
        $namaSiswa = $conflict->siswa->nama_siswa ?? 'siswa lain';
        $waktu = substr($conflict->waktu_mulai, 0, 5) . ' - ' . substr($conflict->waktu_selesai, 0, 5);
        $statusLabel = str_replace('_', ' ', $conflict->status);

        return "Waktu bimbingan bertabrakan dengan jadwal ({$statusLabel}) untuk {$namaSiswa} pada pukul {$waktu}. Silakan pilih waktu atau tanggal lain.";
    }
}
