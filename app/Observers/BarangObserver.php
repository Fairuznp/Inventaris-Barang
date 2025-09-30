<?php

namespace App\Observers;

use App\Models\Barang;
use App\Services\CacheService;

class BarangObserver
{
    /**
     * Handle the Barang "created" event.
     */
    public function created(Barang $barang): void
    {
        CacheService::clearBarangRelatedCache();
    }

    /**
     * Handle the Barang "updated" event.
     */
    public function updated(Barang $barang): void
    {
        CacheService::clearBarangRelatedCache();
    }

    /**
     * Handle the Barang "deleted" event.
     */
    public function deleted(Barang $barang): void
    {
        CacheService::clearBarangRelatedCache();
    }
}
