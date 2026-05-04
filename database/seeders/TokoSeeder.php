<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Alfamart",
                'kode_toko' => "ALF-001",
                'pass_toko' => "12345678",
                'alamat' => "Jl.Semarang Bali No.20, Yogyakarta",
                'status_toko' => 'Pusat',
            ],
            [
                'name' => "Indomart",
                'kode_toko' => "Ind-002",
                'pass_toko' => "12345678",
                'alamat' => "Jl.Semarang Solo No.10, Jakarta",
                'status_toko' => 'Cabang',

            ],

        ];

        foreach ($data as $item) {
            \App\Models\Toko::create($item);
        }
    }
}
