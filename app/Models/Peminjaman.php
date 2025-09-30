<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'barang_id',
        'user_id',
        'nama_peminjam',
        'kontak_peminjam',
        'instansi_peminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_kembali_aktual',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'jumlah' => 'integer',
    ];

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Relasi ke User (Peminjam) - Opsional
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk nama peminjam (prioritas nama_peminjam atau user->name)
     */
    public function getNamaPeminjamLengkapAttribute()
    {
        return $this->nama_peminjam ?? $this->user?->name ?? 'Tidak diketahui';
    }

    /**
     * Accessor untuk informasi lengkap peminjam
     */
    public function getInfoPeminjamAttribute()
    {
        $info = $this->nama_peminjam_lengkap;

        if ($this->instansi_peminjam) {
            $info .= " ({$this->instansi_peminjam})";
        }

        return $info;
    }

    /**
     * Accessor untuk cek apakah terlambat
     */
    public function getIsTerlambatAttribute(): bool
    {
        if ($this->status !== 'dipinjam' || !$this->tanggal_kembali) {
            return false;
        }

        return Carbon::now()->gt($this->tanggal_kembali);
    }

    /**
     * Accessor untuk jumlah hari terlambat
     */
    public function getHariTerlambatAttribute(): int
    {
        if (!$this->is_terlambat) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->tanggal_kembali);
    }

    /**
     * Scope untuk peminjaman aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope untuk peminjaman terlambat
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<', Carbon::now());
    }
}
