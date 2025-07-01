<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\SocialIcon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $settings = Setting::find(1);
            $socialIcons = SocialIcon::orderBy('created_at', 'desc')->get();

            $view->with([
                'currentUser' => Auth::user(),
                'settings' => $settings,
                'socialIcons' => $socialIcons,
            ]);
        });
    }
}
