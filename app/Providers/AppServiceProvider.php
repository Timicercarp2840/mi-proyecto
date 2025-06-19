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
            
            // Force HTTPS scheme regardless of proxy detection
            URL::forceScheme('https');
            URL::forceRootUrl($appUrl);
            
            // Force correct asset URL for Render.com - use relative URLs
            if (str_contains($appUrl, 'sable-app.onrender.com') || str_contains($appUrl, 'onrender.com')) {
                URL::forceRootUrl('https://sable-app.onrender.com');
                
                // Configure Vite to use relative asset URLs
                Vite::useHotFile(public_path('hot'));
            }
            
            // Trust ALL proxies for Render.com and force HTTPS detection
            Request::setTrustedProxies(['*'], '**');
            
            // Force HTTPS detection even if proxy headers are missing
            if (!request()->isSecure()) {
                request()->server->set('HTTPS', 'on');
                request()->server->set('SERVER_PORT', 443);
                request()->server->set('HTTP_X_FORWARDED_PROTO', 'https');
            }
            
            // Configure Vite to use correct URL
            Vite::useStyleTagAttributes(['data-turbo-track' => 'reload']);
            Vite::useScriptTagAttributes(['data-turbo-track' => 'reload']);
        }

        // Registrar observers
        User::observe(UserObserver::class);
    }
}
