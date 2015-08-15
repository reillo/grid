<?php namespace Reillo\Grid;

use Illuminate\Support\ServiceProvider;

class GridServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('reillo/grid', null, __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $routes = __DIR__ . '/Example/routes.php';
        if (file_exists($routes)) require $routes;
    }
}
