<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
/**ADD PAGINATION ROLE AND PERMISSIONS */
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['ventas.venta.create','compras.ingreso.create','admin.role.create','admin.role.edit','quotes.create'],
            'App\Http\ViewComposers\DataComposer'
        );

        View::composer(
            ['*'],
            'App\Http\ViewComposers\RedirectComposer'
        );        
        //View::share('redirect', $link);
        /**ADD PAGINATION ROLE AND PERMISSIONS */
        Paginator::useBootstrap();
    }
}
