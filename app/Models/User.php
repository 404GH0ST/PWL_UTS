<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName
{
    public const LEVEL_ADMIN = 'ADM';
    public const LEVEL_MANAGER = 'MNG';
    public const LEVEL_STAFF = 'STF';

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdministrator() || $this->isManager() || $this->isStaff();
    }

    public function getAuthIdentifierName(): string
    {
        return 'user_id';
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }

    public function getFilamentName(): string
    {
        return (string) ($this->nama ?: $this->username);
    }

    public function hasLevelCode(string $kode): bool
    {
        $levelKode = $this->relationLoaded('level')
            ? $this->level?->level_kode
            : $this->level()->value('level_kode');

        return $levelKode === $kode;
    }

    public function isAdministrator(): bool
    {
        return $this->hasLevelCode(self::LEVEL_ADMIN);
    }

    public function isManager(): bool
    {
        return $this->hasLevelCode(self::LEVEL_MANAGER);
    }

    public function isStaff(): bool
    {
        return $this->hasLevelCode(self::LEVEL_STAFF);
    }
}
