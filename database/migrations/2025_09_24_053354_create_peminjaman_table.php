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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah')->unsigned();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat', 'hilang'])->default('dipinjam');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Indexes untuk optimasi
            $table->index(['status', 'tanggal_pinjam']);
            $table->index(['barang_id', 'status']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
