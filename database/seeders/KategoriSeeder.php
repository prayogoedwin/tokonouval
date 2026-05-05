<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['name' => 'Makanan & Minuman'],
            ['name' => 'Minuman', 'id_parent' => 1],
            ['name' => 'Rokok & Tembakau'],
            ['name' => 'Perlengkapan Mandi'],
            ['name' => 'Makanan Instan', 'id_parent' => 1],
            ['name' => 'Minuman Kemasan'],
            ['name' => 'Bumbu Dapur'],
            ['name' => 'Snack Sehat', 'id_parent' => 1],
        ];

        foreach ($data as $item) {
            \App\Models\Kategori::create($item);
        }
    }
}
