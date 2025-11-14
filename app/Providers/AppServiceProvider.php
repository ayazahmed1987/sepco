<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\WebsiteSetting;

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
        Gate::before(function ($user, $ability) {
			// First user bypasses all permission checks
            //return $user->hasRole('Super Admin') ? true : null;
			//if($user->id === 1){return true;}
			if($user->is_admin === 1){return true;}
        });
		
		view()->composer('*', function ($view) {
        $view->with('setting', WebsiteSetting::first());
        });
	
    }
}
