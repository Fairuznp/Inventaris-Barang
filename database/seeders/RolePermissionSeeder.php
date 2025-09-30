<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Create permissions if they don't exist
        $permissions = [
            'manage barang',
            'delete barang',
            'view kategori',
            'manage kategori',
            'view lokasi',
            'manage lokasi',
            'view peminjaman',
            'manage peminjaman',
            'view pemeliharaan',
            'manage pemeliharaan'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles if they don't exist and assign permissions
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $petugasRole->syncPermissions([
            'manage barang',
            'view kategori',
            'view lokasi',
            'view peminjaman',
            'manage peminjaman',
            'view pemeliharaan',
            'manage pemeliharaan',
        ]);
        $adminRole->syncPermissions(Permission::all());
    }
}
