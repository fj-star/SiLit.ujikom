<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Directive untuk format Rupiah
            Blade::directive('rupiah', function ($expression) {
        return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
    });

    // Directive Angka (tanpa Rp)
    Blade::directive('angka', function ($expression) {
        return "<?php echo number_format($expression, 0, ',', '.'); ?>";
    });
    }
}
