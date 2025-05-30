<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConnectController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except(['getLogout']);
    }

    public function index()
    {
        $empresa = DB::table('configuracion')->first();
        $image = $empresa->image;
        $name= $empresa->name;
        $logo = "imagenes/empresa/".$image;

        return view("connect.login",["logo"=>$logo, "name"=>$name]);
    }

    public function postLogin(Request $request){
        $rules = [
            'email'=>'required|email',
            'password'=>'required'
        ];

        $messages = [
            'email.required'=>'Su correo electronico es requerido',
            'email.email'=>'El formato de su correo electronico es invalido',
            'password.required'=>'Por favor escriba una contraseña'
            // 'password.min'=>'La contraseña debe de contener al menos 8 caracteres'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            /**si fallo se regresa*/
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert', 'danger');
        }else{
            if (Auth::attempt(['email'=>$request->input('email'), 'password'=> $request->input('password')], true)) {
                if(Auth::user()->estatus == 1){
                    $user = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('roles.full-access as access')
                    ->where('users.id', '=', Auth::user()->id)
                    ->get();

                    $count = count($user);
                    if ($count == 1) {
                        $access = $user[0]->access;

                        if ($access === 'yes') {
                            return redirect('/dashboard');
                        }else if ($access === 'no') {
                            return redirect('/userdashboard');
                        }

                    }else{
                        Auth::logout();
                        $request->session()->invalidate();
                        return redirect('login')->with('message','El usuario no tiene un Rol asignado')->with('typealert', 'danger');
                    }

                }else{
                    Auth::logout();
                    $request->session()->invalidate();
                    return redirect('login')->with('message','El usuario no esta activo')->with('typealert', 'danger');
                    // return redirect('/');
                }
                
                
            }else{
                return back()->with('message','Correo electronico o contraseña errónea')->with('typealert', 'danger');
            }
        }

    }

    public function getLogout(){
        Auth::logout();
        return redirect('/');
    }

    
}
