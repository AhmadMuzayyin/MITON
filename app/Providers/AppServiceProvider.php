<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('formatUang', function ($expression) {
            return "<?php echo number_format($expression,0,',','.'); ?>";
        });
        
        Blade::directive('format', function ($expression) {
            return "<?php number_format($expression,0,',','.'); ?>";
        });

    }
}
