<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Penjualan extends Model
{
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

    protected function casts(): array
    {
        return [
            'penjualan_tanggal' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Penjualan $penjualan): void {
            if (blank($penjualan->penjualan_kode)) {
                $penjualan->penjualan_kode = static::generateKode($penjualan->penjualan_tanggal);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function penjualanDetails(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    public function getTotalHargaAttribute(): int
    {
        return $this->getPenjualanDetailsCollection()
            ->sum(fn (PenjualanDetail $detail): int => (int) $detail->harga * (int) $detail->jumlah);
    }

    public function getTotalItemAttribute(): int
    {
        return (int) $this->getPenjualanDetailsCollection()->sum('jumlah');
    }

    public static function generateKode(mixed $tanggal = null): string
    {
        $tanggal = filled($tanggal) ? Carbon::parse($tanggal) : now();
        $prefix = 'PJ-' . $tanggal->format('Ymd') . '-';

        $lastCode = static::query()
            ->where('penjualan_kode', 'like', $prefix . '%')
            ->orderByDesc('penjualan_kode')
            ->value('penjualan_kode');

        $nomorUrut = (int) substr((string) $lastCode, -3);

        return $prefix . str_pad((string) ($nomorUrut + 1), 3, '0', STR_PAD_LEFT);
    }

    protected function getPenjualanDetailsCollection(): EloquentCollection
    {
        if ($this->relationLoaded('penjualanDetails')) {
            return $this->penjualanDetails;
        }

        return $this->penjualanDetails()->get();
    }
}
