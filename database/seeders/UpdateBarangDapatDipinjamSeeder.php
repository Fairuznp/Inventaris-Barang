<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateBarangDapatDipinjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update semua barang yang belum memiliki nilai dapat_dipinjam
        \App\Models\Barang::whereNull('dapat_dipinjam')
            ->orWhere('dapat_dipinjam', 0)
            ->update(['dapat_dipinjam' => true]);

        $this->command->info('Successfully updated dapat_dipinjam status for all existing barang.');
    }
}
