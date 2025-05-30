<?php

namespace App\Http\Controllers\Articulo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Articulo;
use Yajra\Datatables\Datatables;
use File;
use Str,Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Imports\ArticulosImport;
use App\Exports\articuloExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','almacen_articulo.index');
        $categoria = DB::table('categorias')->where('estatus','=','1')->get();
        return view('almacen.articulo.index',['categoria'=>$categoria]);
    }

    public function store(Request $request)
    {   
        try {
            $articulo = new Articulo;

            if($Vfiles = $request->file('imagen') == null){
                $articulo->imagen='productogeneral.png';
                $rules = [
                    'nombre' => 'required',
                    'idcategoria' => 'required',
                    'codigo' => 'required|unique:productos,codigo',
                    'stock' => 'required',
                    'pcompra'=>'required',
                    'pventa'=>'required',
                    'descripcion' => 'required',
                    'articulo_des' => 'required'
                ];

                $messages = [
                    'nombre.required' => 'El nombre es requerido',
                    'idcategoria.required' => 'La categoria es requerida',
                    'codigo.required' => 'El codigo del producto es requerido',
                    'codigo.unique' => 'EL codigo para el producto ya existe, agrege otro nuevo codigo para el producto',
                    'stock.required' => 'El stock del producto es requerido',
                    'pcompra.required' => 'El precio de compra es requerido',
                    'pventa.required' => 'El precio de venta es requerido',
                    'descripcion.required' => 'La descripcion es requerida',
                    'articulo_des.required' => 'Debes de poner el descuento, si este no lleva descuento solo agrega un 0' 
                ];
            }else{

                $rules = [
                    'nombre' => 'required',
                    'idcategoria' => 'required',
                    'codigo' => 'required|unique:productos,codigo',
                    'stock' => 'required',
                    'pcompra'=>'required',
                    'pventa'=>'required',
                    'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'descripcion' => 'required',
                    'articulo_des' => 'required'
                ];

                $messages = [
                    'nombre.required' => 'El nombre es requerido',
                    'idcategoria.required' => 'La categoria es requerida',
                    'codigo.unique' => 'EL codigo para el producto ya existe, agrege otro nuevo codigo para el producto',
                    'stock.required' => 'El stock del producto es requerido',
                    'pcompra.required' => 'El precio de compra es requerido',
                    'pventa.required' => 'El precio de venta es requerido',
                    'descripcion.required' => 'La descripcion es requerida',
                    'imagen.required' => 'Debes de agregar una imagen',
                    'imagen.image' => 'Debe de ser una imagen del producto',
                    'imagen.mimes' => 'La imagen dede de contener una de la siguientes extensiones, jpeg,png,jpg',
                    'imagen.max' => 'La imagen debe de pesar menos de 2048',
                    'descripcion.required' => 'La descripcion es requerida',
                    'articulo_des.required' => 'Debes de poner el descuento, si este no lleva descuento solo agrega un 0' 
                ];
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'uploaded_image' => '',
                    'class_name' => 'alert-danger'
                ]);
            }

            $articulo->categoria_id=$request->get('idcategoria');
            $articulo->codigo=$request->get('codigo');
            $articulo->nombre=$request->get('nombre');
            $articulo->stock=$request->get('stock');
            $articulo->pcompra=$request->get('pcompra');
            $articulo->pventa=$request->get('pventa');
            $articulo->descripcion=$request->get('descripcion');
            $articulo->estado="Activo";
            $articulo->descuento=$request->get('articulo_des');
            $articulo->iva='0.00';
            if ($files = $request->file('imagen')) {
                $destinationPath = public_path('/imagenes/articulos');
                //$profileImagen = $files->getClientOriginalExtension();
                $profileImagen = trim($files->getClientOriginalName());
                $files->move($destinationPath, $profileImagen);
                $articulo->imagen=$profileImagen;
            }

            $articulo->save();
            
            return response()->json([
                'estado'=> 1,  
                'mensaje' => 'Se guardo el articulo con exito'
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,
                'mensaje' => (array) $m,
            ]);
        }

        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       
        $articulo = DB::table('productos')->where('estado','=','Activo')->get();

        return DataTables::of($articulo)
        ->addColumn('img', function($articulo){
            $url = "/imagenes/articulos/".$articulo->imagen;
            $image ='<img src="'.$url.'" class="img-rounded" alt="Cinque Terre" width="80" height="60">';
            return $image;
        })
        ->addColumn('stock_producto', function($articulo){
            $stock = number_format($articulo->stock, 3, '.', '');
            if ($stock > 0) {
                $status = '<div class="container text-center"><span class="badge badge-success">'.$stock.'</span></div>';
            }else{
                $status= '<div class="container text-center"><span class="badge badge-danger">'.$stock.'</span></div>';
            }
            return $status;
        })
        ->addColumn('compra', function($articulo){
            $compra = $articulo->pcompra;
            $pre_compra= '<div class="container text-center"><span class="badge badge-info">'.$compra.'</span></div>';
            
            return $pre_compra;
        })
        ->addColumn('venta', function($articulo){
            $venta = $articulo->pventa;
            $pre_venta = '<div class="container text-center"><span class="badge badge-primary">'.$venta.'</span></div>';
            
            return $pre_venta;
        })
        ->addColumn('action', function($articulo){
            $id = $articulo->idarticulo;
            $articulo_venta = DB::table('detalle_ventas')->where('articulo_id',$id)->first();
            if ($articulo_venta == null) {
                //$button = '<button type="button" class="btn btn-secondary btn-sm btn-flat" onclick="edit_product('.$id.');" ><i class="far fa-edit"></i></button> &nbsp;&nbsp;&nbsp;';
                //$button .= '<button type="button" class="btn btn-danger btn-sm btn-flat" onclick="delete_product('.$id.');"><i class="fas fa-trash-alt"></i></button>';
                $button ='<i class="fas fa-edit text-primary mr-3" id="" onclick="edit_product('.$id.');" title="Actualizar el articulo"></i>';
                $button .='<i class="fas fa-trash-alt text-danger" onclick="delete_product('.$id.');" data-toggle="tooltip" title="Eliminar el articulo"></i>';
            }else{
                $button ='<i class="fas fa-edit text-primary mr-3" id="" onclick="edit_product('.$id.');" title="Actualizar el articulo"></i>';
                $button .='<i class="fas fa-trash-alt text-warning" data-toggle="tooltip" title="El articulo tiene ventas"></i>';
            }

            return $button;
        })
        ->rawColumns(['action','img','stock_producto','compra','venta'])
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
        $where = array('idarticulo'=>$id);
        $producto = Articulo::where($where)->first();
        return Response::json($producto);

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
        try {
            $articulo = Articulo::findOrFail($request->idprod);
            
            if($file = $request->file('upimagen') == null){
                //$articulo->imagen='productogeneral.png';
                $rules = [
                    'upnombre' => 'required',
                    'upidcategoria' => 'required',
                    'upcodigo' => 'required|unique:productos,codigo,'.$request->idprod.',idarticulo',
                    'upstock' => 'required',
                    'uppcompra'=>'required',
                    'uppventa'=>'required',
                    'updescripcion' => 'required',
                    'uparticulo_des' => 'required'
                ];        
                

                $messages = [
                    'upnombre.required' => 'El nombre es requerido',
                    'upidcategoria.required' => 'La categoria es requerida',
                    'upcodigo.required' => 'El codigo del producto es requerido',
                    'upcodigo.unique'=>'El codigo ya existe en otro articulo',
                    'upstock.required' => 'El stock del producto es requerido',
                    'uppcompra.required' => 'El precio de compra es requerido',
                    'uppventa.required' => 'El precio de venta es requerido',
                    'updescripcion.required' => 'La descripcion es requerida',
                    'uparticulo_des.required' => 'Debes de poner el descuento, si este no lleva descuento solo agrega un 0' 
                ];
                
            }else{
                $rules = [
                    'upnombre' => 'required',
                    'upidcategoria' => 'required',
                    'upcodigo' => 'required|unique:productos,codigo,'.$request->idprod.',idarticulo',
                    'upstock' => 'required',
                    'uppcompra'=>'required',
                    'uppventa'=>'required',
                    'upimagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'updescripcion' => 'required',
                    'uparticulo_des' => 'required'
                ];

                $messages = [
                    'upnombre.required' => 'El nombre es requerido',
                    'upidcategoria.required' => 'La categoria es requerida',
                    'upcodigo.unique'=>'El codigo ya existe en otro articulo',
                    'upcodigo.required' => 'El codigo del producto es requerido',
                    'upstock.required' => 'El stock del producto es requerido',
                    'uppcompra.required' => 'El precio de compra es requerido',
                    'uppventa.required' => 'El precio de venta es requerido',
                    'updescripcion.required' => 'La descripcion es requerida',
                    'upimagen.required' => 'Debes de agregar una imagen',
                    'upimagen.image' => 'Debe de ser una imagen del producto',
                    'upimagen.mimes' => 'La imagen dede de contener una de la siguientes extensiones, jpeg,png,jpg',
                    'upimagen.max' => 'La imagen debe de pesar menos de 2048',
                    'updescripcion.required' => 'La descripcion es requerida',
                    'uparticulo_des.required' => 'Debes de poner el descuento, si este no lleva descuento solo agrega un 0' 
                ];

            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'uploaded_image' => '',
                    'class_name' => 'alert-danger'
                ]);
            }

            $articulo->categoria_id=$request->get('upidcategoria');
            $articulo->codigo=$request->get('upcodigo');
            $articulo->nombre=$request->get('upnombre');
            $articulo->stock=$request->get('upstock');
            $articulo->pcompra=$request->get('uppcompra');
            $articulo->pventa=$request->get('uppventa');
            $articulo->descripcion=$request->get('updescripcion');
            $articulo->estado="Activo";
            $articulo->descuento=$request->get('uparticulo_des');

            if ($file = $request->file('upimagen')) {
                $destinationPath = public_path('/imagenes/articulos');
                $profileImagen = trim($file->getClientOriginalName());
                $file->move($destinationPath, $profileImagen);
                $articulo->imagen=$profileImagen;
            }

            if($articulo->update()){
                return response()->json([
                    'estado'=> 1,  
                    'mensaje' => 'Se actualizo correctamente el articulo'
                ]);
            }    
            
        } catch (\Throwable $th) {
            $m = 'Ocurrio un error: '.$th->getMessage(). "\n";
            return response()->json([
                    'estado'=> 0,
                    'mensaje' => (array) $m
            ]);
        }
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
            $articulo = Articulo::find($request->id);
            $articulo->estado="Inactivo";
            $articulo->update();
            return response()->json([
                "estado"=>1,
                "mensaje"=>"Se elimino correctamente el articulo"
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
        
    }

    public function get_data_excel(Request $request)
    {
        try {

            $rules = [
                'category_excel' => 'required',
                'file_excel_articulos' => 'required|mimes:xlsx',
            ];

            $messages = [
                'category_excel.required' => 'Debes seleccionar una categoria',
                'file_excel_articulos.required' => 'Debes de elegir un archivo excel',
                'file_excel_articulos.mimes' => 'No es un archivo excel',
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

            $file = $request->file("file_excel_articulos");
            $array = Excel::toArray(new ArticulosImport, $file);
            $arraydata = [];
            $count = 0;
            for ($i=0; $i <count($array) ; $i++) { 
                for ($j=0; $j < count($array[$i]); $j++) { 
                    $count++;
                    if ($count != 1) {
                        $position_zero = $array[$i][$j][0];
                        $position_one = $array[$i][$j][1];
                        $position_two = $array[$i][$j][2];
                        $position_three = $array[$i][$j][3];
                        $position_four = $array[$i][$j][4];
                        $position_five = $array[$i][$j][5];
                        $position_six = $array[$i][$j][6];

                        $arraydata[] = [
                            "codigo"=>$position_zero,
                            "name"=>$position_one,
                            "stock"=>$position_two,
                            "pcompra"=>$position_three,
                            "pventa"=>$position_four,
                            "descripcion"=>$position_five,
                            "descuento"=>$position_six,
                        ];
                    }


                }
            }
            return response()->json([
                "estado"=>1,
                "categoria" => $request->category_excel,
                "datos"=>$arraydata
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function save_products(Request $request)
    {
        try {
            $categoria = $request->upload_category;
            $codigo = $request->upload_codigo;
            $name = $request->upload_name;
            $stock = $request->upload_stock;
            $pcompra = $request->upload_compra;
            $pventa = $request->upload_venta;
            $description = $request->upload_description;
            $descuento = $request->upload_descuento;

            $count = 0;
            $arraycodigo = [];
            while ($count < count($categoria)) {
                $validate_codigo = $codigo[$count];

                $searchcodigo = DB::table('productos')->where('codigo','=', $validate_codigo)->get();
                $true = count($searchcodigo);
                if ($true > 0) {
                    $arraycodigo[] = ["codigo_existente"=>$true, "num_codigo" => $validate_codigo];
                }
                $count=$count+1;
            }
            $total_registros = count($arraycodigo);
            if ($total_registros > 0) {
                return response()->json([
                    "estado" => "error_codigo",
                    "existente" => $arraycodigo,
                ]);
            }
            $row = 0;
            for ($i=0; $i < count($categoria); $i++) { 
                //echo $i;
                if ($stock[$i] != "") {
                    $articulos = new Articulo;
                    $articulos->categoria_id= $categoria[$i];             
                    $articulos->codigo = $codigo[$i];             
                    $articulos->nombre = $name[$i];             
                    $articulos->stock = $stock[$i];             
                    $articulos->pcompra = $pcompra[$i];             
                    $articulos->pventa= $pventa[$i];             
                    $articulos->descripcion= $description[$i];             
                    $articulos->imagen='productogeneral.png';
                    $articulos->estado="Activo";
                    $articulos->descuento = $descuento[$i];
                    $articulos->iva='0.00';
                    $articulos->save();
                    $row++;
                }
            }

            return response()->json([
                'estado'=> 1,  
                'mensaje' => 'Exito. Se importaron <strong>'.$row.'</strong> articulos',
                //"request" =>  $categoria,
                //"codigo" => $codigo,
                //"rows" => $row
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function update_stock(Request $request)
    {
        try {
            
            $id = $request->articuloId;
            $newstock = $request->newStock;

            $articulo = Articulo::find($id);
            $articulo->stock = $newstock;
            $articulo->save();

            return response()->json([
                "status" => 1,
                "message" => "Se actualizo el artículo con exito",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message" => "Ocurrio un error: ". $th->getMessage(),
            ]);
        }
    }

    public function exportArticulo()
    {
        return Excel::download(new articuloExport, 'articulos.xlsx');
    }
}
