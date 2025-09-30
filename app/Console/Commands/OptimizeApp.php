<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Services\CacheService;

class OptimizeApp extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:optimize {--clear-cache : Clear application cache}';

    /**
     * The console command description.
     */
    protected $description = 'Optimize the application for production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting application optimization...');

        if ($this->option('clear-cache')) {
            $this->clearAllCache();
        }

        $this->optimizeForProduction();

        $this->info('✅ Application optimization completed!');
    }

    /**
     * Clear all cache
     */
    private function clearAllCache()
    {
        $this->info('🧹 Clearing all cache...');

        // Clear Laravel cache
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        // Clear application specific cache
        CacheService::clearCache();

        $this->line('Cache cleared successfully.');
    }

    /**
     * Optimize for production
     */
    private function optimizeForProduction()
    {
        $this->info('⚡ Optimizing for production...');

        // Cache configuration
        $this->line('Caching configuration...');
        Artisan::call('config:cache');

        // Cache routes
        $this->line('Caching routes...');
        Artisan::call('route:cache');

        // Cache views
        $this->line('Caching views...');
        Artisan::call('view:cache');

        // Optimize autoloader
        $this->line('Optimizing autoloader...');
        Artisan::call('optimize');

        $this->line('Production optimization completed.');
    }
}
