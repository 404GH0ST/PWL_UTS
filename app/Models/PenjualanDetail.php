<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class PenjualanDetail extends Model
{
    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah',
    ];

    protected static function booted(): void
    {
        static::saving(function (PenjualanDetail $detail): void {
            if (! filled($detail->barang_id) || ! filled($detail->jumlah)) {
                return;
            }

            $barang = $detail->barang ?? Barang::query()->find($detail->barang_id);

            if (! $barang) {
                return;
            }

            if (blank($detail->harga)) {
                $detail->harga = $barang->harga_jual;
            }

            $stokTersedia = $barang->stokTersedia($detail->exists ? $detail->detail_id : null);

            if ((int) $detail->jumlah > $stokTersedia) {
                throw ValidationException::withMessages([
                    'jumlah' => "Stok {$barang->barang_nama} tersisa {$stokTersedia}.",
                ]);
            }
        });
    }

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
