<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AsignarContenidoANuevoUsuario;

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
        
        // Forzar HTTPS en producción (para Render y otros proxies)
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
            
            // Detectar proxy headers para HTTPS
            $this->app['request']->server->set('HTTPS', 'on');
        }
        
        // Registrar event listeners
        Event::listen(
            Registered::class,
            AsignarContenidoANuevoUsuario::class,
        );
    }
}
