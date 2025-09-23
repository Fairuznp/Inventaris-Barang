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
            // Hapus kolom kondisi dan jumlah yang lama
            $table->dropColumn(['kondisi', 'jumlah']);
            
            // Tambah kolom untuk setiap kondisi
            $table->integer('jumlah_baik')->default(0)->after('lokasi_id');
            $table->integer('jumlah_rusak_ringan')->default(0)->after('jumlah_baik');
            $table->integer('jumlah_rusak_berat')->default(0)->after('jumlah_rusak_ringan');
            
            // Tambah kolom total untuk computed value
            $table->integer('jumlah_total')->default(0)->after('jumlah_rusak_berat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Hapus kolom baru
            $table->dropColumn(['jumlah_baik', 'jumlah_rusak_ringan', 'jumlah_rusak_berat', 'jumlah_total']);
            
            // Kembalikan kolom lama
            $table->integer('jumlah')->default(0)->after('lokasi_id');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik')->after('satuan');
        });
    }
};
