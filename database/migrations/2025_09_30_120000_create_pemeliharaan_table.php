<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Info Pemeliharaan
            $table->string('kode_pemeliharaan')->unique(); // PM-2025-001
            $table->enum('jenis_kerusakan', ['rusak_ringan', 'rusak_berat']);
            $table->text('deskripsi_kerusakan');
            $table->integer('jumlah_dipelihara');
            
            // Info Vendor/Toko Komputer
            $table->string('nama_vendor');
            $table->string('kontak_vendor')->nullable();
            $table->text('alamat_vendor')->nullable();
            $table->string('pic_vendor')->nullable(); // Person In Charge
            
            // Estimasi & Biaya
            $table->decimal('estimasi_biaya', 12, 2)->nullable();
            $table->decimal('biaya_aktual', 12, 2)->nullable();
            $table->text('rincian_biaya')->nullable(); // JSON atau text
            
            // Timeline
            $table->date('tanggal_kirim');
            $table->date('estimasi_selesai')->nullable();
            $table->date('tanggal_selesai_aktual')->nullable();
            
            // Status Tracking
            $table->enum('status', [
                'dikirim',          // Baru dikirim ke vendor
                'dalam_perbaikan',  // Sedang diperbaiki
                'menunggu_approval', // Menunggu approval biaya
                'selesai',          // Selesai diperbaiki
                'dibatalkan',       // Dibatalkan
                'tidak_bisa_diperbaiki' // Total loss
            ])->default('dikirim');
            
            // Hasil Pemeliharaan
            $table->integer('jumlah_berhasil_diperbaiki')->default(0);
            $table->integer('jumlah_tidak_bisa_diperbaiki')->default(0);
            $table->text('catatan_vendor')->nullable();
            $table->text('catatan_internal')->nullable();
            
            // Dokumentasi
            $table->json('foto_sebelum')->nullable(); // Array foto
            $table->json('foto_sesudah')->nullable(); // Array foto
            $table->string('dokumen_invoice')->nullable(); // Path file invoice
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index(['barang_id', 'status']);
            $table->index(['nama_vendor', 'tanggal_kirim']);
            $table->index(['status', 'tanggal_kirim']);
            $table->index('kode_pemeliharaan');
        });
        
        // Tabel untuk tracking history perubahan status
        Schema::create('pemeliharaan_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeliharaan_id')->constrained('pemeliharaan')->onDelete('cascade');
            $table->string('status_dari');
            $table->string('status_ke');
            $table->text('keterangan')->nullable();
            $table->decimal('biaya_perubahan', 12, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('created_at');
            
            $table->index(['pemeliharaan_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan_history');
        Schema::dropIfExists('pemeliharaan');
    }
};