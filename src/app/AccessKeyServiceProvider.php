<?php

namespace Riobet\AccessKey\App;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Riobet\AccessKey\App\Http\Middleware\AccessKeyAuthenticationMiddleware;
use Riobet\AccessKey\App\Http\Middleware\ExceptionMiddleware;

class AccessKeyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(Router $router)
    {
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $router->middlewareGroup('accesskey', [
            AccessKeyAuthenticationMiddleware::class,
            ExceptionMiddleware::class
        ]);

        $router->middlewareGroup('accesskey_exception', [
            ExceptionMiddleware::class
        ]);
    }

    public function register()
    {
    }
}
