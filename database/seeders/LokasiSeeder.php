<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasis')->insert([
            ['nama_lokasi' => 'Ruang Kepala Dinas', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Ruang Rapat Utama', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Gudang Arsip', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Lobi Depan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Ruang Staff Umum', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Ruang IT', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Ruang Security', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'Parkiran', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
