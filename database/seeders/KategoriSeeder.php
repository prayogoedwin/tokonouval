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
            ['id' => 1, 'name' => 'Genset & Kelistrikan'],
            ['id' => 2, 'name' => 'Kabel & Aksesoris'],
            ['id' => 3, 'name' => 'Penyedot Debu & Kebersihan'],
            ['id' => 4, 'name' => 'Power Tools', 'id_parent' => 1],
            ['id' => 5, 'name' => 'Aksesoris & Perlengkapan', 'id_parent' => 2],
        ];

        foreach ($data as $item) {
            \App\Models\Kategori::create($item);
        }
    }
}
