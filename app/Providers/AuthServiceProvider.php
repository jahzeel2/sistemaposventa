<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**creacion de gates al usuario que esta activo y se puede ocupar en cualquier controlador*/
        Gate::define('haveaccess', function(User $user, $perm){
            // dd($user->id);
            //dd($perm);
            return $user->havePermission($perm);
            // return $perm;
        });
    }
}
