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
            // Genset & Kelistrikan (category_id = 1)
            ['name' => 'Genset 1000 Watt', 'category_id' => 1, 'satuan' => 'unit', 'harga_beli' => 1500000, 'harga_jual' => 1750000],
            ['name' => 'Genset 3000 Watt', 'category_id' => 1, 'satuan' => 'unit', 'harga_beli' => 2800000, 'harga_jual' => 3250000],
            ['name' => 'Stabilizer 500 VA', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 250000, 'harga_jual' => 300000],
            ['name' => 'MCB 10 Ampere', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 25000, 'harga_jual' => 35000],

            // Kabel & Aksesoris (category_id = 2)
            ['name' => 'Kabel NYY 2x1.5 mm', 'category_id' => 2, 'satuan' => 'meter', 'harga_beli' => 3500, 'harga_jual' => 5000],
            ['name' => 'Kabel NYA 1.5 mm', 'category_id' => 2, 'satuan' => 'meter', 'harga_beli' => 1800, 'harga_jual' => 2500],
            ['name' => 'Stop Kontak Industri', 'category_id' => 2, 'satuan' => 'pcs', 'harga_beli' => 15000, 'harga_jual' => 22000],
            ['name' => 'Kabel Rol 20 meter', 'category_id' => 2, 'satuan' => 'pcs', 'harga_beli' => 120000, 'harga_jual' => 150000],

            // Penyedot Debu & Kebersihan (category_id = 3)
            ['name' => 'Vacuum Cleaner 600W', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 350000, 'harga_jual' => 450000],
            ['name' => 'Vacuum Cleaner Basah & Kering', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 650000, 'harga_jual' => 800000],
            ['name' => 'Blower Debu Industri', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 250000, 'harga_jual' => 320000],
            ['name' => 'Filter HEPA Vacuum', 'category_id' => 3, 'satuan' => 'pcs', 'harga_beli' => 45000, 'harga_jual' => 60000],

            // Power Tools (category_id = 4)
            ['name' => 'Bor Listrik 10 mm', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 180000, 'harga_jual' => 240000],
            ['name' => 'Gerinda Tangan 4"', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 220000, 'harga_jual' => 290000],
            ['name' => 'Mesin Amplas', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['name' => 'Mesin Bor Bobok', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 400000, 'harga_jual' => 520000],

            // Aksesoris & Perlengkapan (category_id = 5)
            ['name' => 'Kabel Ties 10 cm', 'category_id' => 5, 'satuan' => 'pak', 'harga_beli' => 5000, 'harga_jual' => 8000],
            ['name' => 'Multimeter Digital', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 85000, 'harga_jual' => 120000],
            ['name' => 'Sarung Tangan Las', 'category_id' => 5, 'satuan' => 'pasang', 'harga_beli' => 25000, 'harga_jual' => 35000],
            ['name' => 'Kacamata Safety', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 15000, 'harga_jual' => 22000],
        ];

        foreach ($data as $item) {
            \App\Models\Produk::create([
                'toko_id' => rand(1, 2),
                'name' => $item['name'],
                'kategori_id' => $item['category_id'],
                'satuan' => $item['satuan'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
            ]);
        }
    }
}
