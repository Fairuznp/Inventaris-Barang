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
        Schema::table('barangs', function (Blueprint $table) {
            // Index untuk optimasi pencarian
            $table->index(['nama_barang', 'kode_barang'], 'idx_barang_search');
            $table->index(['kategori_id', 'lokasi_id'], 'idx_barang_relations');
            $table->index('created_at', 'idx_barang_created');
            
            // Index untuk dashboard statistics
            $table->index(['jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat'], 'idx_barang_kondisi');
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->index('nama_kategori', 'idx_kategori_nama');
        });

        Schema::table('lokasis', function (Blueprint $table) {
            $table->index('nama_lokasi', 'idx_lokasi_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropIndex('idx_barang_search');
            $table->dropIndex('idx_barang_relations');
            $table->dropIndex('idx_barang_created');
            $table->dropIndex('idx_barang_kondisi');
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropIndex('idx_kategori_nama');
        });

        Schema::table('lokasis', function (Blueprint $table) {
            $table->dropIndex('idx_lokasi_nama');
        });
    }
};