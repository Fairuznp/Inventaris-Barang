<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Pemeliharaan extends Model
{
    protected $table = 'pemeliharaan';

    protected $fillable = [
        'barang_id',
        'user_id',
        'kode_pemeliharaan',
        'jenis_kerusakan',
        'deskripsi_kerusakan',
        'jumlah_dipelihara',
        'nama_vendor',
        'kontak_vendor',
        'alamat_vendor',
        'pic_vendor',
        'estimasi_biaya',
        'biaya_aktual',
        'rincian_biaya',
        'tanggal_kirim',
        'estimasi_selesai',
        'tanggal_selesai_aktual',
        'status',
        'jumlah_berhasil_diperbaiki',
        'jumlah_tidak_bisa_diperbaiki',
        'catatan_vendor',
        'catatan_internal',
        'foto_sebelum',
        'foto_sesudah',
        'dokumen_invoice',
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'estimasi_selesai' => 'date',
        'tanggal_selesai_aktual' => 'date',
        'estimasi_biaya' => 'decimal:2',
        'biaya_aktual' => 'decimal:2',
        'jumlah_dipelihara' => 'integer',
        'jumlah_berhasil_diperbaiki' => 'integer',
        'jumlah_tidak_bisa_diperbaiki' => 'integer',
        'foto_sebelum' => 'array',
        'foto_sesudah' => 'array',
    ];

    /**
     * Boot method untuk auto-generate kode
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pemeliharaan) {
            if (empty($pemeliharaan->kode_pemeliharaan)) {
                $pemeliharaan->kode_pemeliharaan = self::generateKodePemeliharaan();
            }
        });
    }

    /**
     * Generate kode pemeliharaan unik
     */
    public static function generateKodePemeliharaan(): string
    {
        $tahun = date('Y');
        $bulan = date('m');

        $lastPemeliharaan = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('id', 'desc')
            ->first();

        $nomor = $lastPemeliharaan ?
            (int) substr($lastPemeliharaan->kode_pemeliharaan, -3) + 1 : 1;

        return 'PM-' . $tahun . $bulan . '-' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi ke Barang
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Relasi ke User (PIC Internal)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke History
     */
    public function history(): HasMany
    {
        return $this->hasMany(PemeliharaanHistory::class)->latest();
    }

    /**
     * Scope untuk status tertentu
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk vendor tertentu
     */
    public function scopeByVendor($query, $vendor)
    {
        return $query->where('nama_vendor', 'like', '%' . $vendor . '%');
    }

    /**
     * Scope untuk pencarian yang dioptimasi
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('kode_pemeliharaan', 'like', '%' . $search . '%')
                    ->orWhere('nama_vendor', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi_kerusakan', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Scope untuk pencarian dengan relasi barang (gunakan dengan hati-hati)
     */
    public function scopeSearchWithBarang($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('kode_pemeliharaan', 'like', '%' . $search . '%')
                    ->orWhere('nama_vendor', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi_kerusakan', 'like', '%' . $search . '%')
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
            'barang' => function ($query) {
                $query->select(['id', 'nama_barang', 'kode_barang', 'kategori_id', 'lokasi_id'])
                    ->with([
                        'kategori:id,nama_kategori',
                        'lokasi:id,nama_lokasi'
                    ]);
            },
            'user:id,name'
        ]);
    }

    /**
     * Accessor untuk status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'dikirim' => 'bg-blue-100 text-blue-800',
            'dalam_perbaikan' => 'bg-yellow-100 text-yellow-800',
            'menunggu_approval' => 'bg-orange-100 text-orange-800',
            'selesai' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-gray-100 text-gray-800',
            'tidak_bisa_diperbaiki' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Accessor untuk durasi pemeliharaan
     */
    public function getDurasiPemeliharaanAttribute(): ?int
    {
        if (!$this->tanggal_selesai_aktual) {
            return null;
        }

        return Carbon::parse($this->tanggal_kirim)->diffInDays(Carbon::parse($this->tanggal_selesai_aktual));
    }

    /**
     * Accessor untuk selisih biaya
     */
    public function getSelisihBiayaAttribute(): ?float
    {
        if (!$this->estimasi_biaya || !$this->biaya_aktual) {
            return null;
        }

        return $this->biaya_aktual - $this->estimasi_biaya;
    }

    /**
     * Accessor untuk efisiensi perbaikan (%)
     */
    public function getEfisiensiPerbaikanAttribute(): ?float
    {
        if ($this->jumlah_dipelihara <= 0) {
            return null;
        }

        return ($this->jumlah_berhasil_diperbaiki / $this->jumlah_dipelihara) * 100;
    }

    /**
     * Check apakah terlambat
     */
    public function getTerlambatAttribute(): bool
    {
        if (!$this->estimasi_selesai || $this->status === 'selesai') {
            return false;
        }

        return Carbon::parse($this->estimasi_selesai)->isPast();
    }

    /**
     * Get info vendor lengkap
     */
    public function getInfoVendorLengkapAttribute(): string
    {
        $info = $this->nama_vendor;

        if ($this->pic_vendor) {
            $info .= " (PIC: {$this->pic_vendor})";
        }

        if ($this->kontak_vendor) {
            $info .= " - {$this->kontak_vendor}";
        }

        return $info;
    }

    /**
     * Static method untuk mendapatkan statistik dengan query yang efisien
     */
    public static function getStatistics()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        return DB::select("
            SELECT 
                COUNT(*) as total_pemeliharaan,
                SUM(CASE WHEN status = 'dalam_perbaikan' THEN 1 ELSE 0 END) as dalam_perbaikan,
                SUM(CASE WHEN status = 'menunggu_approval' THEN 1 ELSE 0 END) as menunggu_approval,
                SUM(CASE WHEN status = 'selesai' AND MONTH(tanggal_selesai_aktual) = ? AND YEAR(tanggal_selesai_aktual) = ? THEN 1 ELSE 0 END) as selesai_bulan_ini,
                COALESCE(SUM(CASE WHEN status = 'selesai' AND MONTH(tanggal_selesai_aktual) = ? AND YEAR(tanggal_selesai_aktual) = ? THEN biaya_aktual ELSE 0 END), 0) as total_biaya_bulan_ini
            FROM pemeliharaan
        ", [$currentMonth, $currentYear, $currentMonth, $currentYear])[0];
    }
}
