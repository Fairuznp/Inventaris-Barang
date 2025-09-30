<?php

namespace App\Observers;

use App\Models\Barang;
use Illuminate\Support\Facades\Cache;

class BarangObserver
{
    /**
     * Clear cache ketika ada perubahan data barang
     */
    private function clearDashboardCache()
    {
        Cache::forget('dashboard_statistics');
    }

    /**
     * Handle the Barang "created" event.
     */
    public function created(Barang $barang): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Barang "updated" event.
     */
    public function updated(Barang $barang): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Barang "deleted" event.
     */
    public function deleted(Barang $barang): void
    {
        $this->clearDashboardCache();
    }
}
