<?php

namespace App\Http\Controllers\Proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Models\Proveedor;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProveedorController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','compras_proveedor.index');
        return view('compras.proveedor.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required|digits:10',
            'email' => 'required|email'
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'direccion.required' => 'La direccion es requerida',
            'telefono.required' => 'El telefono es requerido',
            'telefono.digits'=>'El numero de telefono debe tener 10 digitos',
            'email.required' => 'El email es requerido',
            'email.email' => 'El formato de su correo electronico es invalido'
            
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'estado' => 'errorvalidacion',
                'mensaje'=> $validator->errors()->all(),
                'uploaded_image' => '',
                'class_name' => 'alert-danger'
            ]);
        }

        $proveedor = new Proveedor;
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->estado="Activo";

        
        if($proveedor->save()){
            return response()->json([
                'estado'=> '1',  
                'mensaje' => ' -> Se guardo el proveedor con exito'
            ]);
        }else{
            return response()->json([
                'estado'=> '0',  
                'mensaje' => 'Ocurrio un error, intentalo de nuevo'
            ]);
        }
        // $nota ="jajajajjaajjajaj";
        // return Response::json($nota);
    }

    public function show()
    {

        $id  = Auth::id();
        $tipo_user = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('roles.full-access as access')
        ->where('users.id', '=', $id)
        ->get();

        $access = $tipo_user[0]->access;
        switch ($access) {
            case 'yes':
                $proveedor = DB::table('proveedores')->where('estado','=','Activo')->get();
            break;
            case 'no':
                //$proveedor = DB::table('proveedores')->where('estado','=','nosoyadmin')->get();
                $proveedor = [];
                break;
            default:
                # code...
                break;
        }

       return DataTables::of($proveedor)
        ->addColumn('action', function($proveedor){
            $id = $proveedor->idproveedor;
            $proveedor_ingreso = DB::table('ingresos')->where('proveedor_id',$id)->first();
            if ($proveedor_ingreso == null) {
                $button = '<button class="btn btn-light btn-sm" onclick="edit_provider('.$id.');" ><i class="fas fa-edit text-primary"></i></button> &nbsp;&nbsp;&nbsp;';
                $button .= '<button class="btn btn-light btn-sm" onclick="delete_provider('.$id.');"><i class="fas fa-trash-alt text-danger"></i></button>';
            }else{
                $button = '<button class="btn btn-light btn-sm" onclick="edit_provider('.$id.');" ><i class="fas fa-edit text-primary"></i></button> &nbsp;&nbsp;&nbsp;';
                $button .= '<button class="btn btn-light btn-sm" title="El proveedor tiene compras"><i class="fas fa-trash-alt text-warning"></i></button>';
            }
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function edit($id){
        $where = array('idproveedor'=>$id);
        $provider = Proveedor::where($where)->first();
        return Response::json($provider);


    }

    public function update(Request $request)
    {
        try {
            
            $rules = [
                'upnombre' => 'required',
                'updireccion' => 'required',
                'uptelefono' => 'required|digits:10',
                'upemail' => 'required|email'
            ];
            $messages = [
                'upnombre.required' => 'El nombre es requerido',
                'updireccion.required' => 'La direccion es requerida',
                'uptelefono.required' => 'El telefono es requerido',
                'updtelefono.digits'=>'El numero de telefono debe tener 10 digitos',
                'upemail.required' => 'El email es requerido',
                'upemail.email' => 'El formato de su correo electronico es invalido'
                
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'uploaded_image' => '',
                    'class_name' => 'alert-danger'
                ]);
            }

            $proveedor= Proveedor::findOrFail($request->upid);
            $proveedor->nombre = $request->upnombre;
            $proveedor->direccion = $request->updireccion;
            $proveedor->telefono = $request->uptelefono;
            $proveedor->email = $request->upemail;
            
            if($proveedor->update()){
                return response()->json([
                'estado'=> 1,  
                'mensaje' => ' -> Se actualizo el proveedor con exito'
                ]);
            }

        } catch (\Throwable $th) {
            $th; $m = 'Ocurrio un error: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,
                'mensaje' => (array) $m
            ]);
 
        }
       
    }
    
    public function destroy($id)
    {

        $provider = Proveedor::find($id);
        $provider->estado="Inactivo";
        if ($provider->update()) {
            return response()->json([
                "estado"=>1,
                "mensaje"=>" -> Se elimino correctamente el proveedor"
            ]);
        }else{
            return response()->json([
                "estado"=>0,
                "mensaje"=>"Ocurrio un error.Intentalo de nuevo"
            ]);
        }
        //return response()->json($provider);
        
    }

}
