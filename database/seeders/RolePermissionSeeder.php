<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'delete barang']);
        Permission::create(['name' => 'view kategori']);
        Permission::create(['name' => 'manage kategori']);
        Permission::create(['name' => 'view lokasi']);
        Permission::create(['name' => 'manage lokasi']);

        $petugasRole = Role::create(['name' => 'petugas']);
        $adminRole = Role::create(['name' => 'admin']);

        $petugasRole->givePermissionTo([
            'view kategori',
            'view lokasi',
        ]);
        $adminRole->givePermissionTo(Permission::all());
    }
}
