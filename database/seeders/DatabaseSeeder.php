<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(TokoSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(StokSeeder::class);
        $this->call(TipePembayaranSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'toko_id' => 1
        ]);
    }
}
