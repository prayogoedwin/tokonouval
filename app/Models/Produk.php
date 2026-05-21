<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //
    // Schema::create('produks', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('toko_id')->constrained('tokos');
    //         $table->foreignId('kategori_id')->constrained('kategories');
    //         $table->string('name');
    //         $table->integer('harga_beli');
    //         $table->integer('harga_jual');
    //         $table->timestamps();
    //         $table->softDeletes();
    //         $table->foreignId('created_by')->nullable();
    //         $table->foreignId('updated_by')->nullable();
    //         $table->foreignId('deleted_by')->nullable();
    //     });

    protected $fillable = [
        'toko_id',
        'kategori_id',
        'name',
        'satuan',
        'harga_beli',
        'harga_jual',
        'sku',
        'created_by',
        'updated_by',
        'deleted_by',
        
    ];

    public function kategori(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function toko(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }

    // 1. Definisikan relasi ke model Stok
    public function stoks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // Pastikan nama foreign key di tabel stok adalah 'product_id'
        return $this->hasMany(Stok::class); 
    }

    
}
