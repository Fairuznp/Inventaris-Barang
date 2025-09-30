<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PemeliharaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pemeliharaan')->insert([
            [
                'barang_id' => 1, // Laptop Dell Latitude 5420
                'user_id' => 1, // Admin
                'kode_pemeliharaan' => 'PM-2025-001',
                'jenis_kerusakan' => 'rusak_ringan',
                'deskripsi_kerusakan' => 'Keyboard beberapa tombol tidak berfungsi dengan baik',
                'jumlah_dipelihara' => 1,
                'nama_vendor' => 'CV. Teknik Komputer Jaya',
                'kontak_vendor' => '081234567890',
                'alamat_vendor' => 'Jl. Raya Teknologi No. 123, Jakarta',
                'pic_vendor' => 'Budi Santoso',
                'estimasi_biaya' => 500000.00,
                'biaya_aktual' => 450000.00,
                'rincian_biaya' => 'Penggantian keyboard: Rp 350.000, Jasa service: Rp 100.000',
                'tanggal_kirim' => '2025-09-15',
                'estimasi_selesai' => '2025-09-20',
                'tanggal_selesai_aktual' => '2025-09-18',
                'status' => 'selesai',
                'jumlah_berhasil_diperbaiki' => 1,
                'jumlah_tidak_bisa_diperbaiki' => 0,
                'catatan_vendor' => 'Keyboard berhasil diganti dengan yang baru, testing normal',
                'catatan_internal' => 'Pemeliharaan berjalan lancar, laptop sudah bisa digunakan kembali',
                'foto_sebelum' => null,
                'foto_sesudah' => null,
                'dokumen_invoice' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barang_id' => 2, // Proyektor Epson EB-X500
                'user_id' => 2, // Petugas
                'kode_pemeliharaan' => 'PM-2025-002',
                'jenis_kerusakan' => 'rusak_berat',
                'deskripsi_kerusakan' => 'Lampu proyektor mati total, tidak bisa menyala',
                'jumlah_dipelihara' => 1,
                'nama_vendor' => 'PT. Service Elektronik Prima',
                'kontak_vendor' => '021-87654321',
                'alamat_vendor' => 'Jl. Elektronik Raya No. 456, Jakarta',
                'pic_vendor' => 'Sari Handayani',
                'estimasi_biaya' => 1500000.00,
                'biaya_aktual' => null,
                'rincian_biaya' => 'Penggantian lampu projektor: Rp 1.200.000, Jasa service: Rp 300.000',
                'tanggal_kirim' => '2025-09-25',
                'estimasi_selesai' => '2025-10-05',
                'tanggal_selesai_aktual' => null,
                'status' => 'dalam_perbaikan',
                'jumlah_berhasil_diperbaiki' => 0,
                'jumlah_tidak_bisa_diperbaiki' => 0,
                'catatan_vendor' => 'Sedang menunggu spare part lampu dari supplier',
                'catatan_internal' => 'Perlu follow up progress setiap minggu',
                'foto_sebelum' => null,
                'foto_sesudah' => null,
                'dokumen_invoice' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barang_id' => 4, // Spidol Whiteboard Snowman (beberapa rusak)
                'user_id' => 1, // Admin
                'kode_pemeliharaan' => 'PM-2025-003',
                'jenis_kerusakan' => 'rusak_ringan',
                'deskripsi_kerusakan' => 'Tinta habis dan beberapa spidol mengering',
                'jumlah_dipelihara' => 5,
                'nama_vendor' => 'Toko ATK Lengkap',
                'kontak_vendor' => '081987654321',
                'alamat_vendor' => 'Jl. Perkantoran No. 789, Jakarta',
                'pic_vendor' => 'Ahmad Yusuf',
                'estimasi_biaya' => 100000.00,
                'biaya_aktual' => 75000.00,
                'rincian_biaya' => 'Refill tinta spidol: Rp 15.000 x 5 = Rp 75.000',
                'tanggal_kirim' => '2025-09-20',
                'estimasi_selesai' => '2025-09-21',
                'tanggal_selesai_aktual' => '2025-09-21',
                'status' => 'selesai',
                'jumlah_berhasil_diperbaiki' => 5,
                'jumlah_tidak_bisa_diperbaiki' => 0,
                'catatan_vendor' => 'Semua spidol berhasil direfill dan ditest',
                'catatan_internal' => 'Spidol sudah bisa digunakan kembali, simpan di tempat yang tepat',
                'foto_sebelum' => null,
                'foto_sesudah' => null,
                'dokumen_invoice' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert history untuk tracking perubahan status
        DB::table('pemeliharaan_history')->insert([
            // History untuk PM-2025-001
            [
                'pemeliharaan_id' => 1,
                'status_dari' => 'dikirim',
                'status_ke' => 'dalam_perbaikan',
                'keterangan' => 'Vendor mulai mengerjakan perbaikan keyboard',
                'biaya_perubahan' => null,
                'user_id' => 1,
                'created_at' => Carbon::parse('2025-09-16 10:00:00'),
            ],
            [
                'pemeliharaan_id' => 1,
                'status_dari' => 'dalam_perbaikan',
                'status_ke' => 'selesai',
                'keterangan' => 'Perbaikan selesai, barang siap diambil',
                'biaya_perubahan' => 450000.00,
                'user_id' => 1,
                'created_at' => Carbon::parse('2025-09-18 14:30:00'),
            ],
            // History untuk PM-2025-002
            [
                'pemeliharaan_id' => 2,
                'status_dari' => 'dikirim',
                'status_ke' => 'dalam_perbaikan',
                'keterangan' => 'Vendor sedang menunggu spare part lampu projektor',
                'biaya_perubahan' => null,
                'user_id' => 2,
                'created_at' => Carbon::parse('2025-09-26 09:15:00'),
            ],
            // History untuk PM-2025-003
            [
                'pemeliharaan_id' => 3,
                'status_dari' => 'dikirim',
                'status_ke' => 'selesai',
                'keterangan' => 'Refill spidol selesai dalam 1 hari',
                'biaya_perubahan' => 75000.00,
                'user_id' => 1,
                'created_at' => Carbon::parse('2025-09-21 16:00:00'),
            ],
        ]);
    }
}