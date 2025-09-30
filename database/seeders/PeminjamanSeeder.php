<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('peminjaman')->insert([
            [
                'barang_id' => 1, // Laptop Dell Latitude 5420
                'user_id' => 2, // Petugas
                'nama_peminjam' => 'Dr. Ahmad Wijaya',
                'kontak_peminjam' => '081234567890',
                'instansi_peminjam' => 'Dinas Kesehatan',
                'jumlah' => 1,
                'tanggal_pinjam' => '2025-09-10',
                'tanggal_kembali' => '2025-09-17',
                'tanggal_kembali_aktual' => '2025-09-16',
                'status' => 'dikembalikan',
                'keterangan' => 'Digunakan untuk presentasi rapat koordinasi dinas',
                'created_at' => Carbon::parse('2025-09-10 08:00:00'),
                'updated_at' => Carbon::parse('2025-09-16 16:30:00'),
            ],
            [
                'barang_id' => 2, // Proyektor Epson EB-X500
                'user_id' => null, // Peminjam bebas (bukan user system)
                'nama_peminjam' => 'Ir. Siti Nurhaliza',
                'kontak_peminjam' => '081987654321',
                'instansi_peminjam' => 'PT. Teknologi Maju',
                'jumlah' => 1,
                'tanggal_pinjam' => '2025-09-20',
                'tanggal_kembali' => '2025-09-27',
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'keterangan' => 'Untuk presentasi proposal kerjasama dengan dinas',
                'created_at' => Carbon::parse('2025-09-20 10:15:00'),
                'updated_at' => Carbon::parse('2025-09-20 10:15:00'),
            ],
            [
                'barang_id' => 5, // Laptop Lenovo ThinkPad
                'user_id' => 1, // Admin
                'nama_peminjam' => 'Prof. Bambang Sutrisno',
                'kontak_peminjam' => '081555666777',
                'instansi_peminjam' => 'Universitas Negeri Jakarta',
                'jumlah' => 1,
                'tanggal_pinjam' => '2025-09-25',
                'tanggal_kembali' => '2025-10-02',
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'keterangan' => 'Untuk workshop digitalisasi arsip dinas',
                'created_at' => Carbon::parse('2025-09-25 14:20:00'),
                'updated_at' => Carbon::parse('2025-09-25 14:20:00'),
            ],
            [
                'barang_id' => 4, // Spidol Whiteboard Snowman
                'user_id' => null, // Peminjam bebas
                'nama_peminjam' => 'Sdr. Rudi Hermawan',
                'kontak_peminjam' => '081333444555',
                'instansi_peminjam' => 'Kelurahan Maju Jaya',
                'jumlah' => 10,
                'tanggal_pinjam' => '2025-09-15',
                'tanggal_kembali' => '2025-09-22',
                'tanggal_kembali_aktual' => '2025-09-23',
                'status' => 'terlambat',
                'keterangan' => 'Untuk kegiatan sosialisasi program dinas di kelurahan',
                'created_at' => Carbon::parse('2025-09-15 09:30:00'),
                'updated_at' => Carbon::parse('2025-09-23 11:45:00'),
            ],
            [
                'barang_id' => 3, // Meja Rapat Kayu Jati
                'user_id' => 2, // Petugas
                'nama_peminjam' => 'Tim Event Organizer',
                'kontak_peminjam' => '021-87654321',
                'instansi_peminjam' => 'CV. Kreasi Mandiri',
                'jumlah' => 1,
                'tanggal_pinjam' => '2025-09-05',
                'tanggal_kembali' => '2025-09-12',
                'tanggal_kembali_aktual' => '2025-09-12',
                'status' => 'dikembalikan',
                'keterangan' => 'Untuk acara peluncuran program baru dinas',
                'created_at' => Carbon::parse('2025-09-05 13:00:00'),
                'updated_at' => Carbon::parse('2025-09-12 17:00:00'),
            ],
        ]);
    }
}
