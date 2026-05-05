<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // protected $fillable = [
        // 'toko_id',
        // 'kategori_id',
        // 'name',
        // 'harga_beli',
        // 'harga_jual',
        // 'created_by',
        // 'updated_by',
        // 'deleted_by',
        // ];

        $data = [
            // Makanan Ringan (category_id = 1)
            ['name' => 'Indomie Goreng', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 2800, 'harga_jual' => 3500, 'min_stock' => 20, 'image' => null],
            ['name' => 'Indomie Kari Ayam', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 2800, 'harga_jual' => 3500, 'min_stock' => 20, 'image' => null],
            ['name' => 'Chitato Sapi Panggang 68g', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 12000, 'harga_jual' => 15500, 'min_stock' => 10, 'image' => null],
            ['name' => 'Qtela', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 6000, 'harga_jual' => 8000, 'min_stock' => 15, 'image' => null],
            ['name' => 'Taro Net 54g', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 6500, 'harga_jual' => 8500, 'min_stock' => 12, 'image' => null],
            
            
            ['name' => 'Teh Botol Sosro 350ml', 'category_id' => 6, 'satuan' => 'botol', 'harga_beli' => 3500, 'harga_jual' => 4500, 'min_stock' => 20, 'image' => null],
            ['name' => 'Coca Cola 390ml', 'category_id' => 6, 'satuan' => 'kaleng', 'harga_beli' => 5000, 'harga_jual' => 6500, 'min_stock' => 20, 'image' => null],
            ['name' => 'Aqua 600ml', 'category_id' => 6, 'satuan' => 'botol', 'harga_beli' => 2500, 'harga_jual' => 3500, 'min_stock' => 30, 'image' => null],

            ['name' => 'Ultra Milk Coklat 250ml', 'category_id' => 6, 'satuan' => 'kotak', 'harga_beli' => 5500, 'harga_jual' => 7000, 'min_stock' => 10, 'image' =>null],
            
            ['name' => 'Sampoerna Mild 16', 'category_id' => 3, 'satuan' => 'batang', 'harga_beli' => 25000, 'harga_jual' => 30000, 'min_stock' => 5, 'image' => null],
            ['name' => 'Dunhill 20', 'category_id' => 3, 'satuan' => 'batang', 'harga_beli' => 32000, 'harga_jual' => 38000, 'min_stock' => 5, 'image' => null],
            ['name' => 'Marlboro 20', 'category_id' => 3, 'satuan' => 'batang', 'harga_beli' => 35000, 'harga_jual' => 42000, 'min_stock' => 5, 'image' =>null],
            
            ['name' => 'Lifebuoy Sabun Mandi 80ml', 'category_id' => 4, 'satuan' => 'pcs', 'harga_beli' => 3500, 'harga_jual' => 4500, 'min_stock' => 15, 'image' => null],
            ['name' => 'Pepsodent Pasta Gigi', 'category_id' => 4, 'satuan' => 'pcs', 'harga_beli' => 12000, 'harga_jual' => 15000, 'min_stock' => 10, 'image' => null],
            ['name' => 'Shampo Pantene 200ml', 'category_id' => 4, 'satuan' => 'pcs', 'harga_beli' => 18000, 'harga_jual' => 23000, 'min_stock' => 8, 'image' =>null],
            
            ['name' => 'Sasa Santan Bubuk', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 3500, 'harga_jual' => 4500, 'min_stock' => 10, 'image' => null],
            ['name' => 'Royco Ayam', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 500, 'harga_jual' => 1000, 'min_stock' => 50, 'image' => null],
            ['name' => 'Kecap Bango 135ml', 'category_id' => 7, 'satuan' => 'botol', 'harga_beli' => 8000, 'harga_jual' => 11000, 'min_stock' => 12, 'image' =>null],
          
            ['name' => 'Kacang Atom', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 1000, 'harga_jual' => 2000, 'min_stock' => 30, 'image' => null],
            ['name' => 'Yogurt Cimory 250ml', 'category_id' => 8, 'satuan' => 'botol', 'harga_beli' => 8000, 'harga_jual' => 12000, 'min_stock' => 8, 'image' => null]
        ];

        foreach ($data as $item) {
            \App\Models\Produk::create([
                'toko_id' => rand(1,2),
                'name' => $item['name'],
                'kategori_id' => $item['category_id'],
                'satuan' => $item['satuan'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
            ]);
        }
    }
}
