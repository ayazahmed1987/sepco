<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Default web routes
        //Route::middleware('web')
            //->group(base_path('routes/web.php'));

        // Default API routes (optional)
        //Route::middleware('api')
            //->prefix('api')
            //->group(base_path('routes/api.php'));

        // ✅ Custom admin routes
        Route::middleware('web')->prefix('manager') //['web', 'auth'] //a2zxpspc@123
		//Route::prefix('manager')
            ->name('manager.')
            ->group(base_path('routes/admin.php'));
    }
}
