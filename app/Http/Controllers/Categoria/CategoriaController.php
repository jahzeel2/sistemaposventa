<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
//use DataTables;
use Yajra\Datatables\Datatables;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','almacen_categoria.index');
        // $categorias = DB::table('categorias')->where('estatus','=','1')->get();
        // return view('almacen.categoria.index',['categoria'=>$categorias]);
        return view('almacen.categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
       {
            $rules = [
                'nombre' => 'required',
                'descripcion' => 'required'
            ];

            $messages = [
                'nombre.required'=>'El nombre es requerido',
                'descripcion.required'=>'La descripción es requerida'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                
                return response()->json(['error'=>$validator->errors()->all()]);
            }
            
            $categoria = new Categoria;
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            if($categoria->save()){
                return response()->json([
                    'estado'=> '1',  
                    'mensaje' => 'Se guardo la categoria'
                ]);
            }else{
                return response()->json([
                    'estado'=> '0',
                    'mensaje' => 'Ocurrio un error, intentalo de nuevo'
                ]);
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = DB::table('categorias')->where('estatus','=','1')->get();

        return DataTables::of($data)
        ->addColumn('action', function($data){
            $id = $data->idcategoria;
            $categoria_producto = DB::table('productos')->where('categoria_id',$id)->first();
            if ($categoria_producto == null) {
                //$button = '<button class="btn btn-secondary btn-sm btn-flat" onclick="edit_categoria('.$id.');" ><i class="far fa-edit"></i></button> &nbsp;&nbsp;&nbsp;';
                //$button .= '<button class="btn btn-danger btn-sm btn-flat" onclick="delete_categoria('.$id.');"><i class="fas fa-trash-alt"></i></button>';
                $button ='<i class="fas fa-edit text-primary mr-3" id="" onclick="edit_categoria('.$id.');" title="Actualizar la categoria"></i>';
                $button .='<i class="fas fa-trash-alt text-danger" onclick="delete_categoria('.$id.');" data-toggle="tooltip" title="Eliminar la categoria"></i>';
            }else{
                $button ='<i class="fas fa-edit text-primary mr-3" id="" onclick="edit_categoria('.$id.');" title="Actualizar la categoria"></i>';
                $button .='<i class="fas fa-trash-alt text-warning" data-toggle="tooltip" title="Esta en uso la categoria"></i>';
            }
            return $button;

        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('idcategoria' => $id);
        $categoria = Categoria::where($where)->first();
        return Response::json($categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //https://www.itsolutionstuff.com/post/laravel-7-ajax-form-validation-exampleexample.html
        if ($request->ajax()) {
            $rules = [
                'upid' => 'required',
                'upnombre' => 'required',
                'updescripcion' => 'required'
            ];

            $messages = [
                'upid.required' => 'El id es requerido',
                'upnombre.required'=>'El nombre es requerido',
                'updescripcion.required'=>'La descripción es requerida'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $id = $request->upid;
            $categoria = Categoria::find($id);
            $categoria->nombre = $request->upnombre;
            $categoria->descripcion = $request->updescripcion;
            if($categoria->update()){
                return response()->json([
                    'estado'=> 1,  
                   'mensaje' => 'Se actualizo la categoria con exito'
               ]);
            }else{
                return response()->json([
                    'estado'=> 0,  
                   'mensaje' => 'Error, No se pudo actualizar la categoria. Intentalo de nuevo'
               ]);
            }
           
        }
        // actualizar con base en condiccion
        // $app = App\ModelName::find(1);
        // $app->where("status", 1)
        // ->update(["keyOne" => $valueOne, "keyTwo" => $valueTwo]);
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $idcategory = $request->id;
            $categoria = Categoria::find($idcategory);
            $categoria->estatus=0;
            $categoria->update();
            
            return response()->json([
                'estado'=> 1,  
                'mensaje' => 'Se elimino la categoria con exito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'estado'=> 0,  
                'mensaje' => 'Error: No se pudo eliminar intentalo de nuevo'
            ]);
        }

        // $categoria = Categoria::Where('idcategoria',$id)->delete();
        //return Response::json($id);
    }
}
