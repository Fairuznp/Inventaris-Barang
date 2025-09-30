<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Observers\BarangObserver;
use App\Observers\PeminjamanObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Register Observer untuk clear cache otomatis
        Barang::observe(BarangObserver::class);
        Peminjaman::observe(PeminjamanObserver::class);
    }
}
