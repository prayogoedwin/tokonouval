<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-users',
            'show-users',
            'create-users',
            'edit-users',
            'download-users',
            'delete-users',
            'view-roles',
            'show-roles',
            'create-roles',
            'edit-roles',
            'download-roles',
            'delete-roles',
            'view-permissions',
            'show-permissions',
            'create-permissions',
            'edit-permissions',
            'download-permissions',
            'delete-permissions',

            //TOKO
            'view-tokos',
            'show-tokos',
            'create-tokos',
            'edit-tokos',
            'download-tokos',
            'delete-tokos',

            //Produk
            'view-produks',
            'show-produks',
            'create-produks',
            'edit-produks',
            'download-produks',
            'delete-produks',

            //Satuan
            'view-satuans',
            'show-satuans',
            'create-satuans',
            'edit-satuans',
            'download-satuans',
            'delete-satuans',

            //kategori
            'view-kategories',
            'show-kategories',
            'create-kategories',
            'edit-kategories',
            'download-kategories',
            'delete-kategories',

            //stok
            'view-stoks',
            'show-stoks',
            'create-stoks',
            'edit-stoks',
            'download-stoks',
            'delete-stoks',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $kasirRole = Role::firstOrCreate(['name' => 'kasir']);

        $superAdminRole->permissions()->sync(Permission::all());
        $adminRole->permissions()->sync(Permission::all());

        //TODO : !
        $adminRole->permissions()->sync(Permission::all());


        $editorRole->permissions()->sync(
            Permission::whereIn('name', [
                'view-users',
                'show-users',
                'view-roles',
                'show-roles',
                'view-permissions',
                'show-permissions'
            ])->pluck('id')
        );

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'toko_id' => 1
            ]
        );

        $superAdmin->roles()->sync([$superAdminRole->id]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'toko_id' => 1,
            ]
        );

        $admin->roles()->sync([$adminRole->id]);

        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password'),
                'toko_id' => 1,

            ]
        );

        $editor->roles()->sync([$editorRole->id]);

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'toko_id' => 1,

            ]
        );

        $user->roles()->sync([$userRole->id]);

        $kasir = User::firstOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name' => 'example Kasir',
                'password' => Hash::make('password'),
                'toko_id' => 1,

            ]
        );

        $kasir->roles()->sync([$kasirRole->id]);
    }
}
