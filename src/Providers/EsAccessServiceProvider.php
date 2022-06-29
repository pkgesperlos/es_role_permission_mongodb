<?php

namespace Esperlos98\EsAccess\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Esperlos98\EsAccess\Console\CreateAdmin;
class EsAccessServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateAdmin::class,
            ]);
        }

    }
}
