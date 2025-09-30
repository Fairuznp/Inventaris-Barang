<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Kategori;
use App\Models\Lokasi;

class Barang extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'jumlah_baik' => 'integer',
        'jumlah_rusak_ringan' => 'integer',
        'jumlah_rusak_berat' => 'integer',
        'jumlah_total' => 'integer',
    ];

    /**
     * Scope untuk pencarian yang dioptimasi
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Scope untuk data dengan relasi yang dioptimasi
     */
    public function scopeWithOptimizedRelations($query)
    {
        return $query->with([
            'kategori:id,nama_kategori',
            'lokasi:id,nama_lokasi'
        ]);
    }

    /**
     * Accessor untuk mendapatkan total jumlah stok
     */
    public function getJumlahStokAttribute()
    {
        return $this->jumlah_baik + $this->jumlah_rusak_ringan + $this->jumlah_rusak_berat;
    }

    /**
     * Accessor untuk mendapatkan kondisi dominan (kondisi dengan jumlah terbanyak)
     */
    public function getKondisiAttribute()
    {
        $kondisi = collect([
            'Baik' => $this->jumlah_baik,
            'Rusak Ringan' => $this->jumlah_rusak_ringan,
            'Rusak Berat' => $this->jumlah_rusak_berat,
        ]);

        return $kondisi->keys()->first(function ($key) use ($kondisi) {
            return $kondisi[$key] === $kondisi->max();
        }) ?? 'Baik';
    }

    /**
     * Boot method untuk auto-update jumlah_total
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($barang) {
            $barang->jumlah_total = $barang->jumlah_baik + $barang->jumlah_rusak_ringan + $barang->jumlah_rusak_berat;
        });
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Relasi ke Peminjaman yang masih aktif
     */
    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class)->where('status', 'dipinjam');
    }

    /**
     * Accessor untuk total barang yang sedang dipinjam
     */
    public function getTotalDipinjamAttribute()
    {
        return $this->peminjamanAktif()->sum('jumlah');
    }

    /**
     * Accessor untuk stok baik yang tersedia (belum dipinjam)
     */
    public function getStokBaikTersediaAttribute()
    {
        return max(0, $this->jumlah_baik - $this->total_dipinjam);
    }
}
