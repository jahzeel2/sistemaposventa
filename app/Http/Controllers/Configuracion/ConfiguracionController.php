<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Gate;

use Validator;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','configuracion.index');
        $empresa = DB::table('configuracion')->first();
        $id = $empresa->id;
        $name = $empresa->name;
        $image = $empresa->image;
        $adress = $empresa->adress;
        $email = $empresa->email;
        $phone = $empresa->phone;
        $array = [
            'num' => $id,
            'name'=>$name,
            'image'=> "imagenes/empresa/".$image,
            'adress'=>$adress,
            'email'=>$email,
            'phone'=>$phone,
        ];
        //dd($empresa);
        return view('admin.configuracion.index',["empresa"=>$array]);
    }

    public function update(Request $request)
    {
        $conf = Configuracion::findOrFail($request->identificador); 

        if ($request->file('file') == null) {
            $request->validate([
                'name'=>'required',
                'adress'=>'required',
                'email'=>'required|email',
                'phone'=>'required|digits:10|numeric',

            ],[
                'name.required'=>'Es necesario escribir el nombre de la empresa',
                'adress.required'=>'Es necesario escribir la direccion de la empresa',
                'email.required'=>'El correo electronico es requerido',
                'email.email'=>'El formato de su correo electronico es invalido',
                'phone.required'=>'Es necesario escribir un telefono de contacto',
                'phone.digits'=>'El minimo de digitos para el numero de telefono es 10',
                'phone.numeric'=>'El numero de telefono debe ser numerico',
            ]);
        }else{
            $request->validate([
                'name'=>'required',
                'file' => 'required|mimes:png,jpg,jpeg|max:2048',
                'adress'=>'required',
                'email'=>'required|email',
                'phone'=>'required|digits:10|numeric',

            ],[
                'name.required'=>'Es necesario escribir el nombre de la empresa',
                'file.required'=>'La imagen del logo es requerido',
                'file.mimes'=>'Debe de ser una imagen png,jpg o jpeg',
                'adress.required'=>'Es necesario escribir la direccion de la empresa',
                'email.required'=>'El correo electronico es requerido',
                'email.email'=>'El formato de su correo electronico es invalido',
                'phone.required'=>'Es necesario escribir un telefono de contacto',
                'phone.digits'=>'El minimo de digitos es 10',
                'phone.numeric'=>'El numero de telefono debe ser numerico',
            ]);
        }

        $conf->name = $request->name;

        if ($file = $request->file('file')) {
            $destinationPath = public_path('/imagenes/empresa');
            $empresaImagen = trim($file->getClientOriginalName());
            $file->move($destinationPath, $empresaImagen);

            $conf->image = $empresaImagen;
        }
        $conf->adress = $request->adress;
        $conf->email = $request->email;
        $conf->phone = $request->phone;
        $conf->update();

        return redirect()->route('config')->with('status_success','Los datos generales de la empresa se guardaron con exito');
    }
}
