<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;
use App\Models\CustomPost;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        
		/* If you need the same data on multiple views, you can use a wildcard:
		View::composer(['frontend.partials.sidebar', 'frontend.partials.footer'], function ($view) {
           $view->with('posts', CustomPost::where('status', 1)->get());
        });
		*/
		
		View::composer('frontend.partials.header', function ($view) {
            Cache::forget('menu_items');
            $menus = Cache::remember('menu_items', now()->addHours(2), function () {
                return Menu::whereNull('parent_id')
                    ->with('children')
                    ->where('type', 1)
                    ->active()
                    ->orderBy('sorting')
                    ->get();
            });
            $view->with('menus', $menus);
        });
		
		/*
        View::composer('frontend.partials.footer', function ($view) {
            Cache::forget('footer_menu_items');
            $menus = Cache::remember('footer_menu_items', now()->addHours(2), function () {
                return Menu::whereNull('parent_id')
                    ->with('children')
                    ->where('type', 2)
                    ->active()
                    ->orderBy('sorting')
                    ->get();
            });
            $view->with('menus', $menus);
        });
		*/
		
		
	View::composer('frontend.partials.footer', function ($view) {
    $menuTypes = [
        'footer_menu_2' => 2,
        'footer_menu_3'   => 3,
    ];

    $menus = [];
    foreach ($menuTypes as $key => $type) {
        Cache::forget($key);
        $menus[$key] = Cache::remember($key, now()->addMinutes(5), function () use ($type) {
            return Menu::whereNull('parent_id')
                //->with('children')
                ->where('type', $type)
                ->active()
                ->orderBy('sorting')
                ->get();
        });
    }

    // Share menus with the view
    $view->with('footer_menus', $menus);
    });
		
		
		
		
		View::composer('backend.partials.sidebar', function ($view) {
			$customposts = CustomPost::where('status', 1)->get();
			$view->with('customposts', $customposts);
		});
		
		
    }
}
