<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Observers\UserObserver;

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
        Vite::prefetch(concurrency: 3);
        
        // Force HTTPS in production
        if (app()->environment('production')) {
            $appUrl = config('app.url');
            URL::forceScheme('https');
            URL::forceRootUrl($appUrl);
            
            // Force correct asset URL
            if (str_contains($appUrl, 'sable-app.onrender.com')) {
                URL::forceRootUrl('https://sable-app.onrender.com');
            }
            
            // Configure Vite to use correct URL
            Vite::useStyleTagAttributes(['data-turbo-track' => 'reload']);
            Vite::useScriptTagAttributes(['data-turbo-track' => 'reload']);
            
            // Trust proxies for Render.com
            Request::setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO);
        }

        // Registrar observers
        User::observe(UserObserver::class);
    }
}
