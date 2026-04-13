<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    public $timestamps = false;

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'level_id', 'level_id');
    }
}
