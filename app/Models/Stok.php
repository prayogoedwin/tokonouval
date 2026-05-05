<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = [
        'produk_id',
        'tipe',
        'jumlah',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function produk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
