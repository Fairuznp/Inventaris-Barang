<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BarangSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama tanpa truncate untuk menghindari foreign key constraint
        DB::table('barangs')->delete();
        
        DB::table('barangs')->insert([
            [
                'kode_barang' => 'LP001',
                'nama_barang' => 'Laptop Dell Latitude 5420',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 1, // Ruang Kepala Dinas
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 1,
                'satuan' => 'Unit',
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
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 1,
                'satuan' => 'Unit',
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
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 1,
                'satuan' => 'Buah',
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
                'jumlah_baik' => 45,
                'jumlah_rusak_ringan' => 5,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 50,
                'satuan' => 'Pcs',
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
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 1,
                'satuan' => 'Unit',
                'tanggal_pengadaan' => '2023-08-15',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Proyektor Epson EB-X500x',
                'kategori_id' => 1, // Elektronik
                'lokasi_id' => 2, // Ruang Rapat Utama
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 1,
                'jumlah_rusak_berat' => 0,
                'jumlah_total' => 2,
                'satuan' => 'Unit',
                'tanggal_pengadaan' => '2023-03-10',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}