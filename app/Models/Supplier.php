<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    public $timestamps = false;

    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
    ];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'supplier_id', 'supplier_id');
    }
}
