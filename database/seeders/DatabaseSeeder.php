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
        // Create default users dengan role terlebih dahulu
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password123'),
        ]);
        
        $petugas = User::factory()->create([
            'name' => 'Petugas Inventaris',
            'email' => 'petugas@mail.com',
            'password' => bcrypt('password123'),
        ]);

        $this->call([
            // Seeder untuk data master
            KategoriSeeder::class,
            LokasiSeeder::class,
            
            // Seeder untuk roles dan permissions
            RolePermissionSeeder::class,
            
            // Seeder untuk data barang (gunakan yang sudah diupdate dengan struktur baru)
            BarangSeederNew::class,
            
            // Seeder untuk transaksi (setelah user dibuat)
            PeminjamanSeeder::class,
            PemeliharaanSeeder::class,
        ]);

        // Assign roles setelah role seeder dijalankan
        $admin->assignRole('admin');
        $petugas->assignRole('petugas');
    }
}
