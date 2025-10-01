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
        'request_id',
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
     * Relasi ke LoanRequest
     */
    public function loanRequest()
    {
        return $this->belongsTo(LoanRequest::class, 'request_id');
    }

    /**
     * Scope untuk status tertentu
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk peminjaman aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', '%' . $search . '%')
                    ->orWhere('kontak_peminjam', 'like', '%' . $search . '%')
                    ->orWhere('instansi_peminjam', 'like', '%' . $search . '%')
                    ->orWhereHas('barang', function ($subq) use ($search) {
                        $subq->where('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kode_barang', 'like', '%' . $search . '%');
                    });
            });
        }
        return $query;
    }

    /**
     * Scope dengan relasi optimal
     */
    public function scopeWithOptimalRelations($query)
    {
        return $query->with([
            'barang:id,nama_barang,kode_barang,kategori_id,lokasi_id',
            'barang.kategori:id,nama_kategori',
            'barang.lokasi:id,nama_lokasi',
            'user:id,name'
        ]);
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
     * Scope untuk peminjaman terlambat
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<', Carbon::now());
    }
}
