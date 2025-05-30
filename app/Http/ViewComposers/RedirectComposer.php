<?php

namespace App\Http\ViewComposers;
use App\Repositories\UserRepository;
use Illuminate\View\View;
use Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class RedirectComposer{
    
    public function compose(View $view)
    {
        
        if (Auth::check()) {
            $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.full-access as access')
            ->where('users.id', '=', Auth::user()->id)
            ->get();

            $empresa = DB::table('configuracion')->first();
            $image = $empresa->image;
            $name= $empresa->name;
            $address = $empresa->adress;

            $logo = "imagenes/empresa/".$image;

            $access = $user[0]->access;
            if ($access === 'yes') {
		    $view->with(["link"=>"dashboard","logo"=>$logo, "name"=>$name, "address"=>$address]);
            }else if ($access === 'no') {
       		    $view->with(["link"=>"userdashboard", "logo"=>$logo, "name"=>$name, "address"=>$address]);
            }
        }

    }
}