<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PeminjamanPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat permission baru jika belum ada
        $permissions = [
            'view peminjaman',
            'manage peminjaman',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign ke role
        $petugasRole = Role::findByName('petugas');
        $adminRole = Role::findByName('admin');

        $petugasRole->givePermissionTo($permissions);
        $adminRole->givePermissionTo($permissions);

        $this->command->info('Peminjaman permissions created and assigned successfully!');
    }
}
