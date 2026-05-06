<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    // Schema::create('penjualans', function (Blueprint $table) {
    //     $table->id();
    //     $table->integer('customer_id')->default(0);
    //     $table->foreignId('toko_id')->constrained('tokos');
    //     $table->string('no_invoice'); // (generated [kodetoko#tahun#bulan#id])
    //     $table->foreignId('tipe_pembayaran_id')->constrained('tipe_pembayaran');
    //     $table->integer('total_pembelian'); // Rupiah
    //     $table->float('diskon_percentage'); // %
    //     $table->integer('diskon_nominal');
    //     $table->integer('total_harus_dibayar'); //  (total_pembelian-diskon)
    //     $table->integer('dibayar'); 
    //     $table->integer('kembalian')->default(0); 
    //     $table->string('keterangan')->nullable(); 
    //     $table->timestamps();
    //     $table->softDeletes();
    //     $table->foreignId('created_by')->nullable();
    //     $table->foreignId('updated_by')->nullable();
    //     $table->foreignId('deleted_by')->nullable();
    // });

    protected $fillable = [
        'customer_id',
        'toko_id',
        'no_invoice',
        'tipe_pembayaran_id',
        'total_pembelian',
        'diskon_percentage',
        'diskon_nominal',
        'total_harus_dibayar',
        'dibayar',
        'kembalian',
        'keterangan',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function toko(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }
    public function tipePembayaran(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TipePembayaran::class);
    }
    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PenjualanDetail::class);
    }

}
