<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotKonseling extends Model
{
    use HasFactory;

    protected $table = 'slot_konseling';

    protected $primaryKey = 'id_slot';

    protected $fillable = [
        'id_guru_bk',
        'id_user',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'status_slot',
        'status',
        'catatan',
        'keterangan',
    ];

    public const OPERATIONAL_START = '08:00:00';
    public const OPERATIONAL_END = '15:00:00';

    public const STATUS_TERSEDIA = 'Tersedia';
    public const STATUS_MENUNGGU = 'Menunggu_Diproses';
    public const STATUS_DIPESAN = 'Dipesan';
    public const STATUS_TIDAK_TERSEDIA = 'Tidak_Tersedia';

    public function setIdUserAttribute($value): void
    {
        $this->attributes['id_guru_bk'] = $value;
    }

    public function getIdUserAttribute()
    {
        return $this->attributes['id_guru_bk'] ?? null;
    }

    public function setStatusAttribute($value): void
    {
        $this->attributes['status_slot'] = $value;
    }

    public function getStatusAttribute(): ?string
    {
        return $this->attributes['status_slot'] ?? null;
    }

    public function setKeteranganAttribute($value): void
    {
        $this->attributes['catatan'] = $value;
    }

    public function getKeteranganAttribute(): ?string
    {
        return $this->attributes['catatan'] ?? null;
    }

    public function guruBk()
    {
        return $this->belongsTo(User::class, 'id_guru_bk', 'id_user');
    }

    public function penjadwalan()
    {
        return $this->hasMany(Penjadwalan::class, 'id_slot', 'id_slot');
    }

    public static function normalizeTime(string $time): string
    {
        $time = trim($time);
        if (strlen($time) === 5) {
            return $time . ':00';
        }
        return $time;
    }

    /**
     * Memeriksa apakah waktu slot berada dalam jam operasional 08:00 - 15:00 WIB.
     */
    public static function isWithinOperationalHours(string $waktuMulai, string $waktuSelesai): bool
    {
        $mulai = self::normalizeTime($waktuMulai);
        $selesai = self::normalizeTime($waktuSelesai);

        return $mulai >= self::OPERATIONAL_START
            && $selesai <= self::OPERATIONAL_END
            && $selesai > $mulai;
    }

    /**
     * Menghitung durasi slot dalam satuan menit.
     */
    public static function calculateDurationMinutes(string $waktuMulai, string $waktuSelesai): int
    {
        $start = Carbon::createFromFormat('H:i:s', self::normalizeTime($waktuMulai));
        $end = Carbon::createFromFormat('H:i:s', self::normalizeTime($waktuSelesai));

        return max(0, $start->diffInMinutes($end, false));
    }

    /**
     * Label durasi ramah pengguna (contoh: "1 Jam", "2 Jam", "45 Menit", "1 Jam 30 Menit").
     */
    public function getFormattedDurationAttribute(): string
    {
        $mins = (int) ($this->durasi_menit ?: self::calculateDurationMinutes($this->waktu_mulai, $this->waktu_selesai));
        if ($mins <= 0) {
            return '-';
        }
        $hours = intdiv($mins, 60);
        $rem = $mins % 60;
        if ($hours > 0 && $rem === 0) {
            return $hours . ' Jam';
        }
        if ($hours > 0 && $rem > 0) {
            return $hours . ' Jam ' . $rem . ' Menit';
        }
        return $rem . ' Menit';
    }

    public function getDurasiLabelAttribute(): string
    {
        return $this->formatted_duration;
    }

    /**
     * Mencari slot konseling lain yang bertabrakan pada tanggal yang sama.
     */
    public static function findConflict(
        string $tanggal,
        string $waktuMulai,
        string $waktuSelesai,
        ?int $excludeSlotId = null,
        bool $lockForUpdate = false,
        ?array $statuses = null
    ): ?self {
        $mulai = self::normalizeTime($waktuMulai);
        $selesai = self::normalizeTime($waktuSelesai);

        $query = self::where('tanggal', $tanggal)
            ->where('waktu_mulai', '<', $selesai)
            ->where('waktu_selesai', '>', $mulai);

        if ($statuses !== null) {
            $query->whereIn('status_slot', $statuses);
        }

        if ($excludeSlotId) {
            $query->where('id_slot', '!=', $excludeSlotId);
        }

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->first();
    }

    /**
     * Mencari slot konseling yang sesuai dengan pilihan siswa pada tanggal dan jam tertentu.
     */
    public static function findMatchingSlot(
        string $tanggal,
        string $waktuMulai,
        string $waktuSelesai,
        ?int $idSlot = null,
        bool $lockForUpdate = false
    ): ?self {
        $mulai = self::normalizeTime($waktuMulai);
        $selesai = self::normalizeTime($waktuSelesai);

        $query = self::where('tanggal', $tanggal);

        if ($idSlot) {
            $query->where('id_slot', $idSlot);
        } else {
            $query->where('waktu_mulai', $mulai)
                ->where('waktu_selesai', $selesai);
        }

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->first();
    }

    /**
     * Menentukan status efektif slot berdasarkan jadwal mengajar dan permohonan siswa yang aktif.
     */
    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status_slot === self::STATUS_TIDAK_TERSEDIA) {
            return self::STATUS_TIDAK_TERSEDIA;
        }

        // Cek apakah berbenturan dengan jadwal mengajar Guru BK
        $teachingConflict = JadwalMengajarBk::findConflictOnDate(
            $this->tanggal,
            $this->waktu_mulai,
            $this->waktu_selesai
        );
        if ($teachingConflict) {
            return self::STATUS_TIDAK_TERSEDIA;
        }

        // Cek apakah ada jadwal konseling siswa yang aktif pada slot atau rentang waktu slot ini
        $activeBooking = ($this->id_slot ? Penjadwalan::where('id_slot', $this->id_slot)
            ->where('tanggal', $this->tanggal)
            ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
            ->orderByRaw("CASE WHEN status IN ('Terjadwal', 'Selesai') THEN 0 ELSE 1 END")
            ->first() : null) ?? Penjadwalan::findConflict(
                $this->tanggal,
                $this->waktu_mulai,
                $this->waktu_selesai,
                null,
                Penjadwalan::ACTIVE_STATUSES,
                false,
                true
            );

        if ($activeBooking) {
            if (in_array($activeBooking->status, ['Terjadwal', 'Selesai'], true)) {
                return self::STATUS_DIPESAN;
            }
            if (in_array($activeBooking->status, ['Disetujui_Wali', 'Diajukan'], true)) {
                return self::STATUS_MENUNGGU;
            }
        }

        return $this->status_slot ?: self::STATUS_TERSEDIA;
    }

    /**
     * Label status efektif slot yang ramah pengguna.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            self::STATUS_TERSEDIA => 'Tersedia',
            self::STATUS_MENUNGGU => 'Menunggu Diproses',
            self::STATUS_DIPESAN => 'Dipesan',
            self::STATUS_TIDAK_TERSEDIA => 'Tidak Tersedia',
            default => str_replace('_', ' ', $this->effective_status),
        };
    }

    /**
     * Memeriksa apakah slot sudah diajukan/dipesan atau tidak tersedia.
     */
    public function isBooked(): bool
    {
        return $this->effective_status !== self::STATUS_TERSEDIA;
    }

    /**
     * Sinkronisasi kolom status_slot pada tanggal tertentu dengan kondisi jadwal aktual.
     */
    public static function syncSlotStatusesOnDate(string $tanggal): void
    {
        $slots = self::where('tanggal', $tanggal)->get();

        foreach ($slots as $slot) {
            if ($slot->status_slot === self::STATUS_TIDAK_TERSEDIA) {
                continue;
            }

            $activeBooking = Penjadwalan::where('id_slot', $slot->id_slot)
                ->where('tanggal', $slot->tanggal)
                ->whereIn('status', Penjadwalan::ACTIVE_STATUSES)
                ->orderByRaw("CASE WHEN status IN ('Terjadwal', 'Selesai') THEN 0 ELSE 1 END")
                ->first() ?? Penjadwalan::findConflict(
                    $slot->tanggal,
                    $slot->waktu_mulai,
                    $slot->waktu_selesai,
                    null,
                    Penjadwalan::ACTIVE_STATUSES,
                    false,
                    true
                );

            $targetStatus = self::STATUS_TERSEDIA;
            if ($activeBooking) {
                // Pastikan relasi id_slot pada jadwal aktif tetap tersinkron dengan slot yang ditempatinya
                if (empty($activeBooking->id_slot) && in_array($activeBooking->status, ['Terjadwal', 'Selesai'], true)) {
                    $activeBooking->update(['id_slot' => $slot->id_slot]);
                }

                if (in_array($activeBooking->status, ['Terjadwal', 'Selesai'], true)) {
                    $targetStatus = self::STATUS_DIPESAN;
                } elseif (in_array($activeBooking->status, ['Disetujui_Wali', 'Diajukan'], true)) {
                    $targetStatus = self::STATUS_MENUNGGU;
                }
            }

            if ($slot->status_slot !== $targetStatus) {
                $slot->update(['status_slot' => $targetStatus]);
            }
        }
    }
}
