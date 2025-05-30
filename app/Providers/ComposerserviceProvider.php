<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerserviceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*View::composer(
            'layouts.admin', 'App\Http\ViewComposers\DataComposer'
        );*/

        // Using Closure based composers...
        //View::composer('dashboard', function ($view) {
            //
        //});
        //View::composer(["layouts.admin"],"App\Http\ViewComposers\DataComposer");
    }
}
