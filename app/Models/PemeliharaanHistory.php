<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeliharaanHistory extends Model
{
    protected $table = 'pemeliharaan_history';
    
    public $timestamps = false; // Hanya menggunakan created_at

    protected $fillable = [
        'pemeliharaan_id',
        'status_dari',
        'status_ke',
        'keterangan',
        'biaya_perubahan',
        'user_id',
    ];

    protected $casts = [
        'biaya_perubahan' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /**
     * Boot method untuk auto-set created_at
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($history) {
            $history->created_at = now();
        });
    }

    /**
     * Relasi ke Pemeliharaan
     */
    public function pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(Pemeliharaan::class);
    }

    /**
     * Relasi ke User (yang melakukan perubahan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk label status
     */
    public function getStatusLabelAttribute(): string
    {
        return "Status berubah dari '{$this->status_dari}' ke '{$this->status_ke}'";
    }

    /**
     * Scope untuk pemeliharaan tertentu
     */
    public function scopeForPemeliharaan($query, $pemeliharaanId)
    {
        return $query->where('pemeliharaan_id', $pemeliharaanId);
    }
}