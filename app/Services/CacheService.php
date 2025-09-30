<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache keys yang digunakan di aplikasi
     */
    const CACHE_KEYS = [
        'dashboard_statistics' => 3600, // 1 hour
        'kategoris_all' => 1800,        // 30 minutes
        'lokasis_all' => 1800,          // 30 minutes
        'barangs_available_for_loan' => 300, // 5 minutes
        'barang_statistics' => 1800,    // 30 minutes
    ];

    /**
     * Clear specific cache atau semua cache terkait
     */
    public static function clearCache($keys = null)
    {
        if ($keys === null) {
            // Clear semua cache yang didefinisikan
            foreach (array_keys(self::CACHE_KEYS) as $key) {
                Cache::forget($key);
            }
        } else {
            // Clear cache tertentu
            if (is_string($keys)) {
                $keys = [$keys];
            }

            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
    }

    /**
     * Clear cache yang terkait dengan barang
     */
    public static function clearBarangRelatedCache()
    {
        self::clearCache([
            'dashboard_statistics',
            'barangs_available_for_loan',
            'barang_statistics'
        ]);
    }

    /**
     * Clear cache yang terkait dengan peminjaman
     */
    public static function clearPeminjamanRelatedCache()
    {
        self::clearCache([
            'dashboard_statistics',
            'barangs_available_for_loan'
        ]);
    }

    /**
     * Clear cache yang terkait dengan kategori
     */
    public static function clearKategoriRelatedCache()
    {
        self::clearCache([
            'kategoris_all',
            'dashboard_statistics'
        ]);
    }

    /**
     * Clear cache yang terkait dengan lokasi
     */
    public static function clearLokasiRelatedCache()
    {
        self::clearCache([
            'lokasis_all',
            'dashboard_statistics'
        ]);
    }

    /**
     * Remember dengan cache time default atau custom
     */
    public static function remember($key, callable $callback, $ttl = null)
    {
        $ttl = $ttl ?? self::CACHE_KEYS[$key] ?? 1800; // Default 30 minutes
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Forget cache dengan pattern matching
     */
    public static function forgetMatching($pattern)
    {
        // Simple pattern matching untuk cache keys
        $allKeys = [
            'pemeliharaan_list_*',
            'barangs_rusak_for_pemeliharaan_v2',
            'pemeliharaan_statistics_v2'
        ];

        foreach ($allKeys as $key) {
            if (str_contains($pattern, '*')) {
                $basePattern = str_replace('*', '', $pattern);
                if (str_starts_with($key, $basePattern)) {
                    Cache::forget($key);
                }
            } else {
                if ($key === $pattern) {
                    Cache::forget($key);
                }
            }
        }
    }

    /**
     * Clear cache yang terkait dengan pemeliharaan
     */
    public static function clearPemeliharaanRelatedCache()
    {
        self::clearCache([
            'pemeliharaan_statistics_v3',
            'barangs_rusak_for_pemeliharaan_v2'
        ]);

        // Clear pagination cache
        self::forgetMatching('pemeliharaan_list_*');
    }
}
