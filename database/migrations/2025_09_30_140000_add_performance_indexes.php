<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hanya tambahkan index yang penting dan belum ada
        try {
            Schema::table('pemeliharaan', function (Blueprint $table) {
                $table->index('status', 'idx_pemeliharaan_status');
                $table->index('nama_vendor', 'idx_pemeliharaan_vendor');
                $table->index(['status', 'tanggal_selesai_aktual'], 'idx_pemeliharaan_status_selesai');
            });
        } catch (\Exception $e) {
            // Ignore if index already exists
        }

        try {
            Schema::table('pemeliharaan_history', function (Blueprint $table) {
                $table->index(['pemeliharaan_id', 'created_at'], 'idx_history_pemeliharaan_date');
            });
        } catch (\Exception $e) {
            // Ignore if index already exists
        }

        try {
            Schema::table('barangs', function (Blueprint $table) {
                $table->index(['jumlah_rusak_ringan', 'jumlah_rusak_berat'], 'idx_barangs_rusak');
            });
        } catch (\Exception $e) {
            // Ignore if index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('pemeliharaan', function (Blueprint $table) {
                $table->dropIndex('idx_pemeliharaan_status');
                $table->dropIndex('idx_pemeliharaan_vendor');
                $table->dropIndex('idx_pemeliharaan_status_selesai');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            Schema::table('pemeliharaan_history', function (Blueprint $table) {
                $table->dropIndex('idx_history_pemeliharaan_date');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }

        try {
            Schema::table('barangs', function (Blueprint $table) {
                $table->dropIndex('idx_barangs_rusak');
            });
        } catch (\Exception $e) {
            // Ignore if index doesn't exist
        }
    }
};