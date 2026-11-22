<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'role',
        'id_kelas',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function hasRole(...$roles): bool
    {
        if (empty($this->role)) {
            return false;
        }

        $userRole = $this->normalizeRole($this->role);

        $normalizedRoles = [];
        foreach ($roles as $role) {
            if (is_array($role)) {
                foreach ($role as $r) {
                    $normalizedRoles[] = $this->normalizeRole($r);
                }
            } else {
                foreach (explode(',', (string) $role) as $r) {
                    $normalizedRoles[] = $this->normalizeRole($r);
                }
            }
        }

        return in_array($userRole, $normalizedRoles, true);
    }

    private function normalizeRole(string $role): string
    {
        $role = strtolower(trim($role));
        $compact = preg_replace('/[\s_-]+/', '', $role);

        return match ($compact) {
            'walikelas' => 'wali_kelas',
            'gurubk', 'guru' => 'guru_bk',
            default => $compact,
        };
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isGuruBK(): bool
    {
        return $this->hasRole('guru_bk');
    }

    public function isWaliKelas(): bool
    {
        return $this->hasRole('wali_kelas');
    }

    public function isSiswa(): bool
    {
        return $this->hasRole('siswa');
    }
}
