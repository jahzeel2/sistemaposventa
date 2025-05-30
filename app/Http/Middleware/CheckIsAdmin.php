<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Validator, Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('roles.full-access as access')
        ->where('users.id', '=', Auth::user()->id)
        ->get();

        $access = $user[0]->access;
        if ($access === 'yes') {
            return $next($request);
            //return redirect('/dashboard');
        }else if ($access === 'no') {
            return redirect('/userdashboard');
        }

    }
}
