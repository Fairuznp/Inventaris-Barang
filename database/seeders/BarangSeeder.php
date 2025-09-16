<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'kode_barang' => 'LP001',
                'nama_barang' => 'Laptop Dell Latitude 5420',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 1, // Ruang Kepala Dinas
                'jumlah' => 1,
                'satuan' => 'Unit',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2023-05-15',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'PRJ01',
                'nama_barang' => 'Proyektor Epson EB-X500',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 2, // Ruang Rapat Utama
                'jumlah' => 1,
                'satuan' => 'Unit',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2022-11-20',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'MJ005',
                'nama_barang' => 'Meja Rapat Kayu Jati',
                'kategori_id' => 2, // Mebel & Furnitur
                'lokasi_id' => 2, // Ruang Rapat Utama
                'jumlah' => 1,
                'satuan' => 'Buah',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2021-02-10',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'ATK-SP-01',
                'nama_barang' => 'Spidol Whiteboard Snowman',
                'kategori_id' => 3, // Alat Tulis Kantor (ATK)
                'lokasi_id' => 3, // Gudang Arsip
                'jumlah' => 50,
                'satuan' => 'Pcs',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2024-01-30',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Laptop Lenovo ThinkPad',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 2, // Ruang Rapat Utama
                'jumlah' => 1,
                'satuan' => 'Unit',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2025-09-13',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Proyektor Epson EB-X500x',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 2, // Ruang Rapat Utama
                'jumlah' => 2,
                'satuan' => 'Unit',
                'kondisi' => 'Baik',
                'tanggal_pengadaan' => '2025-09-13',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
