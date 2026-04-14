<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'barang_id', 'barang_id');
    }

    public function penjualanDetails(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'barang_id', 'barang_id');
    }

    public function totalStokMasuk(): int
    {
        return (int) $this->stoks()->sum('stok_jumlah');
    }

    public function totalTerjual(?int $ignoreDetailId = null): int
    {
        return (int) $this->penjualanDetails()
            ->when($ignoreDetailId, fn ($query) => $query->whereKeyNot($ignoreDetailId))
            ->sum('jumlah');
    }

    public function stokTersedia(?int $ignoreDetailId = null): int
    {
        return max(0, $this->totalStokMasuk() - $this->totalTerjual($ignoreDetailId));
    }
}
