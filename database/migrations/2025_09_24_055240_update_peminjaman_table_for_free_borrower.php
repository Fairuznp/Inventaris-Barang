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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambah kolom untuk peminjam bebas
            $table->string('nama_peminjam')->after('user_id');
            $table->string('kontak_peminjam')->nullable()->after('nama_peminjam');
            $table->string('instansi_peminjam')->nullable()->after('kontak_peminjam');
            
            // Buat user_id nullable untuk backward compatibility
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['nama_peminjam', 'kontak_peminjam', 'instansi_peminjam']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
