<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;

use Illuminate\Support\Facades\DB;
//use DataTables;
use Yajra\Datatables\Datatables;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ClienteController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','ventas_cliente.index');
        return view('ventas.cliente.index');
    }

    public function store(Request $request)
    {
        try {
            
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

            $cliente = new Cliente;
            $cliente->nombre = $request->nombre;
            $cliente->direccion = $request->direccion;
            $cliente->telefono= $request->telefono;
            $cliente->email= $request->email;
            $cliente->estatus= "Activo";
            if($cliente->save()){
                return response()->json([
                    'estado'=> 1,  
                    'accion'=>'save',
                    'mensaje' => ' -> Se guardo el cliente con exito'
                ]);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'estado'=> 0,  
                'mensaje' => ' -> Ocurrio un error, intentalo de nuevo'
            ]);
        }
            
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
                $clientes = DB::table('clientes')->where('estatus','=','Activo')->get();
            break;
            case 'no':
                $clientes = [];
            break;
            
            default:
                # code...
                break;
        }

       return DataTables::of($clientes)
        ->addColumn('action', function($clientes){
            $id = $clientes->idcliente;
            $cliente_venta = DB::table('ventas')->where('cliente_id',$id)->first();
            if ($cliente_venta == null) {
                //$button = '<button class="btn btn-secondary btn-sm btn-flat" onclick="edit_cliente('.$id.');" ><i class="far fa-edit"></i></button> &nbsp;&nbsp;&nbsp;';
                //$button .= '<button class="btn btn-danger btn-sm btn-flat" onclick="down_cliente('.$id.');"><i class="fas fa-trash-alt"></i></button>';
                $button ='<button class="btn btn-light mr-3 btn-sm" onclick="edit_cliente('.$id.');"><i class="fas fa-edit text-primary " id=""  title="Actualizar el cliente"></i></button>';
                $button .='<button class="btn btn-light btn-sm" onclick="down_cliente('.$id.');"><i class="fas fa-trash-alt text-danger"  data-toggle="tooltip" title="Eliminar el cliente"></i></button>';
            }else{
                $button ='<button class="btn btn-light mr-3 btn-sm" onclick="edit_cliente('.$id.');"><i class="fas fa-edit text-primary " id=""  title="Actualizar el cliente"></i></button>';
                $button .='<button class="btn btn-light btn-sm"><i class="fas fa-trash-alt text-warning"  data-toggle="tooltip" title="El cliente tiene compras"></i></button>';
            }
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function get_cliente($id)
    {
        try {
           $cliente = DB::table("clientes")->where('idcliente', '=', $id)->get();
            return response()->json([
                'estado'=> 1,  
                'accion' => 'get_cliente',
                'mensaje' => 'exito',
                'detalle_cliente' => $cliente
            ]);
            
        } catch (\Throwable $th) {
           //throw $th;
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function update(Request $request)
    {
        try {

             $rules = [
                'clienteupdate'=>'required',
                "updnombre" => 'required',
                "upddireccion" => 'required',
                "updtelefono" => 'required|digits:10',
                "updemail" => 'required',
            ];

            $messages = [
                'clienteupdate.required'=>'El identificador del cliente es requerido',
                'updnombre.required'=>'El nombre es requerido',
                'upddireccion.required'=>'La direccion es requerida',
                'updtelefono.required'=>'El telefono es requerido',
                'updtelefono.digits'=>'El numero de telefono debe tener 10 digitos',
                'updemail.required'=>'El correo es requerido',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class_name' => 'danger'
                ]);
            }
             
            $updcliente= Cliente::where('idcliente', $request->clienteupdate)->get();
            $updcliente->toQuery()->update([
                'nombre'=>$request->updnombre,
                'direccion'=>$request->upddireccion,
                'telefono'=>$request->updtelefono,
                'email'=>$request->updemail,
            ]);

            return response()->json([
                'accion' => 'update',
                'estado' => 1,
                'mensaje'=>' -> Se actualizo el cliente con exito',
            ]);

        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function down_cliente($id)
    {
        try {

            $cli = Cliente::find($id);
            $cli->estatus="Inactivo";
            $cli->update();

            return response()->json([
                'estado'=> 1,  
                'accion' => 'down_cliente',
                'mensaje' => ' -> El cliente se dio de baja con exito',
            ]);
            
        } catch (\Throwable $th) {
           //throw $th;
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function findCustomer(Request $request)
    {
        $searchclientes = $request->valor;
        $result = DB::table('clientes')
        ->where([
            ['nombre','like','%'.$searchclientes.'%'],
            ['estatus', '=', 'Activo']
        ])
        //->orwhere('barcode','like','%'.$data.'%')
        ->limit(5)
        ->get();
        return response()->json([
            "estado"=>1,
            "result" => $result
        ]);

    }
}
