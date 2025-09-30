<?php

namespace App\Observers;

use App\Models\Peminjaman;
use App\Services\CacheService;

class PeminjamanObserver
{
    /**
     * Handle the Peminjaman "created" event.
     */
    public function created(Peminjaman $peminjaman): void
    {
        CacheService::clearPeminjamanRelatedCache();
    }

    /**
     * Handle the Peminjaman "updated" event.
     */
    public function updated(Peminjaman $peminjaman): void
    {
        CacheService::clearPeminjamanRelatedCache();
    }

    /**
     * Handle the Peminjaman "deleted" event.
     */
    public function deleted(Peminjaman $peminjaman): void
    {
        CacheService::clearPeminjamanRelatedCache();
    }
}
