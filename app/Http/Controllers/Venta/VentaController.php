<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Venta_producto;
use App\Models\Detalle_venta_producto;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use PDF;

class VentaController extends Controller
{
    public $datenow;
    public $datetimenow;
    public $year;
    public $month;
    public $day;

    public function __construct()
    {
        $datecontry = Carbon::now('America/Mexico_City');
        $this->datenow = $datecontry->toDateString();
        $this->datetimenow = $datecontry->toTimeString();
        $this->year = $datecontry->year;
        $this->month = $datecontry->month;
        $this->day = $datecontry->day;
    }

    public function index()
    {
        Gate::authorize('haveaccess','ventas_venta.index');
        return view('ventas.venta.index');
    }

    public function create()
    { 
        $datecontry = Carbon::now('America/Mexico_City');
        $datenow = $datecontry->toDateString();
        $id  = Auth::id();
        $cliente = DB::table('clientes')->where('idcliente', '=', 1)->get();
        //dd($cliente);
        //$folio = $this->folioid();
        $nomcliente = $cliente[0]->nombre;
        $clienteid = $cliente[0]->idcliente;
        
        $apertura = DB::select('select * from aperturacajas where user_id="'.$id.'" AND estatus="Abierta" AND CAST(fecha_hora AS DATE) = ?', [$datenow]);
        //$idaper = $apertura
        //$folio = $id;
        
        //$tipo_view = "sidebar-collapse";
        if ($apertura) {
            $ape = $apertura[0]->idapertura;
            $estatus = $apertura[0]->estatus;
            $folio = $this->folioid($ape);
            //dd($ape);
            //$folio = $this->year.$this->month.$this->day.$ape;
            return view("ventas.venta.create",["nomcliente"=>$nomcliente, "clienteid"=>$clienteid, "folio"=>$folio, "apertura"=>$ape, "estatus"=>$estatus]);
        }else{
             
            return view("ventas.venta.create",["nomcliente"=>$nomcliente, "clienteid"=>$clienteid, "folio"=>0, "apertura"=>0, "estatus"=>"Cerrada"]);
        }    
       
    }

    protected function folioid($ape){
        $arrayfolio = DB::table('corte_cajero_dia')
        ->select('seriefolio','numfolio')
        ->where('apertura_id', '=', $ape)
        ->get();
        $seriefolio= $arrayfolio[0]->seriefolio;
        $confolio = $arrayfolio[0]->numfolio;
        return $newfolio = $seriefolio.$confolio;
        /*$ultimo_folio = DB::table('ventas')
        ->select('idventa')
        ->orderby('idventa','DESC')->take(1)->get();
        $arrayultimo = $ultimo_folio[0]->idventa+1;
        return $folioid = "00".$arrayultimo;*/
    }

    /**OBTIENE EL FOLIO SIGUIENTE DE LA VENTA */
    protected function nowfolioid($ape,$num){
        $arrayfolio = DB::table('corte_cajero_dia')
        ->select('numfolio')
        ->where('apertura_id', '=', $ape)
        ->get();
        $confolio = $arrayfolio[0]->numfolio+$num;
        return $newfolio = $confolio;
    }

    public function store(Request $request)
    {
        try {
          
            DB::beginTransaction();
            $rules = [
                'ventidcliente' => 'required',
                'venttipo_comprobante' => 'required',
                'ventfolio' => 'required',
                'venttotal_venta' => 'required|min:2',
                'ventdinero' => 'required',
                'ventsuelto' => 'required'
                // 'pcantidad' => 'required' 
            ];
            $messages = [
                'ventidcliente.required' => 'El nombre de el cliente es requerido',
                'venttipo_comprobante.required' => 'El tipo de comprobante es requerido',
                'ventfolio.required' => 'El folio es requerido',
                'venttotal_venta.required' => 'El total de la venta es requerido',
                'venttotal_venta.min' => 'El total de la venta debe de se mayor a 0',
                'ventdinero.required' => 'La cantidad de dinero para la venta es requerido $',
                'ventsuelto.required' => 'La cantidad que se ingreso es menor a la cantidad total de la venta',
                //'ventfolio.required' => 'El total de la venta es requerido'
                // 'pcantidad.required' => 'La cantidad es requerida',
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
           
            /**ID DEL USUARIO QUIEN REALIZA LA VENTA*/
            $id_user_venta =  $request->id_user_vent;
            /**se guardan los datos de la tabla Ventas en la DB */
            $venta = new Venta_producto();
            $venta->user_id = $id_user_venta;
            $venta->cliente_id = $request->ventidcliente;            
            $venta->tipo_comprobante = $request->venttipo_comprobante;            
            $venta->num_folio= $request->ventfolio;            
            $hora = Carbon::now('America/Mexico_City');
            $venta->fecha_hora=$hora->toDateTimeString();
            $venta->efectivo = $request->ventdinero;            
            $venta->total_venta=str_replace(' ', '', $request->venttotal_venta);            
            $venta->estado= "Activo";
            $venta->save();
            /**se guardan los datos de la tabla detalle_ventas en la DB*/
            $idarticulo=$request->idarticulo;
            $cantidad=$request->cantidad;
            $precio_venta=$request->precio_venta;
            $descuento=$request->descuento;
            $subtotal=str_replace(' ', '', $request->subtotal);
            $idapertura = $request->inicioapertura;

            $cont = 0;
            
            while ($cont < count($idarticulo)) {
            $detalle = new Detalle_venta_producto();
            $detalle->venta_id=$venta->idventa;
            $detalle->articulo_id=$idarticulo[$cont];
            $detalle->apertura_id=$request->inicioapertura;
            $detalle->cantidad=$cantidad[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->subtotal=$subtotal[$cont];
            $detalle->save();
            $cont=$cont+1;
                                    
            }
            /**una vez que se guardaron los articulos se procede a eliminarlos de la base temporal*/
            $cod_user= $id_user_venta;  
            /**se guardan los datos de la tabla Ventas en la DB */
            $eliminar_registros = DB::delete('delete from detalle_venta_temp where id_user= ?', [$cod_user]);
            /**function that call the new folio*/
            $num = 1;
            $ape = $request->inicioapertura;
            $folionow = $this->nowfolioid($ape,$num);
            $newfolio = $folionow;
            $updatefolio = DB::table('corte_cajero_dia')
            ->where('apertura_id',$request->inicioapertura)
            ->update(['numfolio' => $newfolio]);
            /**function that get  details sales of sale*/
            $id_now_sale =  $venta->idventa;
            $now_sale = $this->detalle_venta($id_now_sale);
            $folio = $this->folioid($ape);
            $suelto = $request->ventsuelto;

            $settings = DB::table('configuracion')->where('id', 1)->first();
            $users = DB::table('aperturacajas as ape')
            ->join('users as us', 'ape.user_id', '=', 'us.id')
            ->select('us.name')
            ->where('ape.idapertura', $ape)
            ->get();

            DB::commit();
            
            return response()->json([
                'estado' => 1,
                'mensaje'=>'La venta se genero con exito',
                'folio'=>$folio,
                'suelto'=>$suelto,
                'sale_now'=>$now_sale,
                'settings'=>$settings,
                'efectivo' => $request->ventdinero,
                'user' => $users,
            ]);

          
        } catch (\Throwable $th) {
            /**SI OCURREO UN ERROR EN LA VENTA*/
            DB::rollback();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
                //'idcod'=>$idapertura
            ]);


        }

    }

    public function find_product(Request $request)
    {

        $searchproducto = $request->valor;

        $producto = DB::table('productos')
        ->where([
            ['nombre','like','%'.$searchproducto.'%'],
            ['stock', '>=', 0]
        ])
        ->orwhere([
            ['codigo','like','%'.$searchproducto.'%'],
            ['stock', '>=', 0]
        ])
        ->limit(5)
        ->get();

        /*$getventas = DB::table('ventas')->where([
            ['user_id','=',$id],
            ['estado','=','Activo'],
        ])->get();*/
        $array_pro = [];
        foreach ($producto as $tag) {
            $id = $tag->idarticulo;
            $codigo = $tag->codigo;
            $nombre = $tag->nombre;
            $iva = $tag->iva;
            $stock= $tag->stock;
            $venta = $tag->pventa;
            $descuento = $tag->descuento; 
            $img = "/imagenes/articulos/".$tag->imagen;
            $array_pro[]=['id'=>$id,'codigo'=>$codigo,'nombre'=>$nombre,'img'=>$img,'iva'=>$iva,'venta'=>$venta,'stock'=>$stock,"descuento"=>$descuento];
        }

        return response()->json([
            'alldata' => $array_pro,
            'modulo' => "venta"
        ]);
        /*$nombre = $request->nombre;
        $term = trim($request->q);

        if (empty($term)) {
            return Response::json([]);
        }

        $producto = DB::table('productos')
        ->where('nombre','like','%'.$term.'%')
        ->orwhere('codigo','like','%'.$term.'%')
        ->get();
        $array_tags = [];
        foreach ($producto as $tag) {
            $id = $tag->idarticulo;
            $codigo = $tag->codigo;
            $nombre = $tag->nombre;
            $iva = $tag->iva;
            $stock= $tag->stock;
            $venta = $tag->pventa;
            $descuento = $tag->descuento; 
            $img = "/imagenes/articulos/".$tag->imagen;
            $array_tags[]=['id'=>$id,'codigo'=>$codigo,'nombre'=>$nombre,'img'=>$img,'iva'=>$iva,'venta'=>$venta,'stock'=>$stock,"descuento"=>$descuento];
        }
        
        return Response::json($array_tags);*/
    }

    public function save_product_temp(Request $request)
    {
        $rules = [
            'NombreArticulo' => 'required',
            'idarticulo' => 'required',
            'CodigoArticulo' => 'required',
            'iva' => 'required',
            'cod_user' => 'required',
            'pvcantidad' => 'required',
            'pvstock' => 'required',
            'pvprecio_venta' => 'required',
            'pvdescuento' => 'required'
        ];
        $messages = [
            'NombreArticulo.required' => 'El nombre del articulo es requerido',
            'idarticulo.required' => 'El id del articulo es requerido',
            'CodigoArticulo.required' => 'El codigo del articulo es requerido',
            'iva.required' => 'La iva es requerida',
            'cod_user.required' => 'El codigo de usuario es requerido',
            'pvcantidad.required' => 'La cantidad es requerida',
            'pvstock.required' => 'El stock es requerido',
            'pvprecio_venta.required' => 'El precio de venta es requerido',
            'pvdescuento.required' => 'El descuento es requerido',
            
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
        
        try {
            DB::beginTransaction();
            $nombre = $request->NombreArticulo;
            $idarticulo= $request->idarticulo;
            $codigo= $request->CodigoArticulo;
            $iva= $request->iva;
            $iduser= $request->cod_user;
            $cantidad= $request->pvcantidad;
            $stock= $request->pvstock;
            $pventa= $request->pvprecio_venta;
            $descuento= $request->pvdescuento;

            $datos= DB::select("call add_detalle_venta_temp($iduser,$idarticulo,'$codigo','$nombre',$cantidad,$pventa,$descuento,$iva)");
            $detalleTabla = '';
            $sub_total = 0;
            $iva = 0;
            $total= 0;
            $desc_producto = 0;
            $subtotal_producto_global = 0;
            //VARIABLES IVA POR PRODUCTO
            $des_iva = 0;
            $total_iva = 0;
            /////////////////////////////
                $array_productos = [];
                foreach ($datos as $productos) {
                    /**se obtiene el total del descuento del producto*/
                    $desc_producto = round($productos->total_articulos * $productos->descuento,2);
                    /**se obtiene el total menos el descuento*/
                    $precio_total= round($productos->total_articulos * $productos->precio - $desc_producto,2);
                    $total_format = number_format($precio_total, 2, '.', ' ');
                    $sub_total = round($sub_total+$precio_total,2);
                    $total = round($total+$precio_total,2);
                    /**se obtiene el iva del producto si lleva*/
                    $des_iva = round($precio_total * ($productos->iva / 100),2);
                    $total_iva = round($total_iva+$des_iva,2);
                    /**se suma el precio total mas iva para sagar la venta global del producto*/
                    $subtotal_producto_global = round($precio_total + $des_iva,2);
                    /**variables*/
                    $idart = $productos->iddetalletemp;
                    $nombre = $productos->nombre;
                    $cantidad = $productos->total_articulos;
                    $precio = $productos->precio;
                    $descuento = $productos->descuento;
                    $id_producto = $productos->idarticulo; 

                    $array_productos[] = ["idart"=>$idart, "id_articulo"=>$id_producto,'precio_total'=>$precio_total, "subtotal"=>$sub_total,"total"=>$total,"nombre"=>$nombre,"cantidad"=>$cantidad, "precio"=>$precio, "des_iva"=>$des_iva, "descuento"=>$descuento, "desc_producto"=>$desc_producto, "subtotal_global"=>$subtotal_producto_global, "total_format"=>$total_format];
                }
                
            $impuesto = round($sub_total * (16 / 100),2);
            $total_siva = round($sub_total-$impuesto, 2);
            $total = number_format(round($total_siva + $impuesto,2),2, '.', ' ');

                
            $array_totales = [];
            $array_totales = ["total_siva"=>$total_siva, "impuesto"=>$impuesto, "total"=>$total, "total_iva"=>$total_iva];
            
            DB::commit();
            
            if ($datos) {
            return response()->json([
                "estado" => 1,
                "resultado"=>$datos,
                "productos"=>$array_productos,
                "totales"=>$array_totales
                ]);
            }
 
        } catch (\Throwable $th) {
            DB::rollBack();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "estado" => 0,
                "mensaje"=> (array) $m
            ]);

        }

    }

    public function show_vent_prod_tmp(Request $request)
    {
        try {
            

            $id_user = $request->id_user;
            $datos=DB::table('detalle_venta_temp')
            ->select('*',DB::raw('SUM(cantidad) as total_articulos')) 
            ->where('id_user','=',$id_user)
            ->groupBy('idarticulo')
            ->orderByDesc('iddetalletemp')
            ->get();
            $detalleTabla = '';
                $sub_total = 0;
                $iva = 0;
                $total= 0;
                $desc_producto = 0;
                $subtotal_producto_global = 0;
                //VARIABLES IVA POR PRODUCTO
                $des_iva = 0;
                $total_iva = 0;
                /////////////////////////////
                $array_productos = [];
                foreach ($datos as $productos) {
                    /**se obtiene el total del descuento del producto*/
                    $desc_producto = round($productos->total_articulos * $productos->descuento,2);
                    /**se obtiene el total menos el descuento*/
                    $precio_total = round($productos->total_articulos * $productos->precio - $desc_producto,2);
                    $total_format = number_format($precio_total, 2, '.', ' ');
                    $sub_total = round($sub_total+$precio_total,2);
                    $total = round($total+$precio_total,2);
                    /**se obtiene el iva del producto si lleva*/
                    $des_iva = round($precio_total * ($productos->iva / 100),2);
                    $total_iva = round($total_iva+$des_iva,2);
                    /**se suma el precio total mas iva para sagar la venta global del producto*/
                    $subtotal_producto_global = round($precio_total + $des_iva,2);
                    /**variables*/
                    $idart = $productos->iddetalletemp;
                    $nombre = $productos->nombre;
                    $cantidad = $productos->total_articulos;
                    $precio = $productos->precio;
                    $descuento = $productos->descuento;
                    $id_producto = $productos->idarticulo;

                    $array_productos[] = ["idart"=>$idart, "id_articulo"=>$id_producto,'precio_total'=>$precio_total, "subtotal"=>$sub_total,"total"=>$total,"nombre"=>$nombre,"cantidad"=>$cantidad, "precio"=>$precio, "des_iva"=>$des_iva, "descuento"=>$descuento, "desc_producto"=>$desc_producto, "subtotal_global"=>$subtotal_producto_global, "total_format"=>$total_format];
                }
                
                $impuesto = round($sub_total * (16 / 100),2);
                $total_siva = round($sub_total-$impuesto, 2);
                $total = number_format(round($total_siva + $impuesto,2), 2, '.', ' ');

                
                $array_totales = [];
                $array_totales = ["total_siva"=>$total_siva, "impuesto"=>$impuesto, "total"=>$total, "total_iva"=>$total_iva];

                if ($datos) {
                    return response()->json([
                    "estado" => 1,
                    "resultado"=>$datos,
                    "productos"=>$array_productos,
                    "totales"=>$array_totales
                    ]);
                }
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "estado" => 0,
                "mensaje"=> (array) $m
            ]);

        }
    }
    
    public function delete_venta_product(Request $request)
    {
        try {
            
            $id_user_temp = $request->id_user;
            $id_detalle_articulo_temp = $request->idprod;
            $id_articulo = $request->idArticulo;

            $datos = DB::select("call delete_detalle_venta_temp($id_detalle_articulo_temp, $id_user_temp,$id_articulo)");
            $detalleTabla = '';
                $sub_total = 0;
                $iva = 0;
                $total= 0;
                $desc_producto = 0;
                $subtotal_producto_global = 0;
                //VARIABLES IVA POR PRODUCTO
                $des_iva = 0;
                $total_iva = 0;
                /////////////////////////////
                $array_productos = [];
                foreach ($datos as $productos) {
                    /**se obtiene el total del descuento del producto*/
                    $desc_producto = round($productos->total_articulos * $productos->descuento,2);
                    /**se obtiene el total menos el descuento*/
                    $precio_total= round($productos->total_articulos * $productos->precio - $desc_producto,2);
                    $total_format = number_format($precio_total, 2, '.', ' ');
                    $sub_total = round($sub_total+$precio_total,2);
                    $total = round($total+$precio_total,2);
                    /**se obtiene el iva del producto si lleva*/
                    $des_iva = round($precio_total * ($productos->iva / 100),2);
                    $total_iva = round($total_iva+$des_iva,2);
                    /**se suma el precio total mas iva para sagar la venta global del producto*/
                    $subtotal_producto_global = round($precio_total + $des_iva,2);
                    /**variables*/
                    $idart = $productos->iddetalletemp;
                    $nombre = $productos->nombre;
                    $cantidad = $productos->total_articulos;
                    $precio = $productos->precio;
                    $descuento = $productos->descuento;
                    $id_producto = $productos->idarticulo;

                    $array_productos[] = ["idart"=>$idart, "id_articulo"=>$id_producto,'precio_total'=>$precio_total, "subtotal"=>$sub_total,"total"=>$total,"nombre"=>$nombre,"cantidad"=>$cantidad, "precio"=>$precio, "des_iva"=>$des_iva, "descuento"=>$descuento, "desc_producto"=>$desc_producto, "subtotal_global"=>$subtotal_producto_global, "total_format"=>$total_format];
                }
                
                $impuesto = round($sub_total * (16 / 100),2);
                $total_siva = round($sub_total-$impuesto, 2);
                $total = number_format(round($total_siva + $impuesto,2), 2, '.', ' ');
                
                $array_totales = [];
                $array_totales = ["total_siva"=>$total_siva, "impuesto"=>$impuesto, "total"=>$total, "total_iva"=>$total_iva];

                if ($datos != "") {
                    return response()->json([
                    "estado" => 1,
                    "resultado"=>$datos,
                    "productos"=>$array_productos,
                    "totales"=>$array_totales
                    ]);
                }
                if($datos == ""){
                    return response()->json([
                        "estado"=>"sinproductos"
                    ]);
                }
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "estado" => 0,
                "mensaje"=> (array) $m
            ]);
        }        

     
    }
    
    public function delete_venta_general(Request $request)
    {
        try {
            $id_user_elim = $request->id_user;
            $eliminar_registros_tempora = DB::delete('delete from detalle_venta_temp where id_user= ?', [$id_user_elim]);
            return response()->json([
               "estado"=>1,
               "mensaje"=> "La venta se cancelo con exito"
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
           $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m
            ]);
           
        }
    }
    
    public function show()
    {
        $id  = Auth::id();
        $now = $this->datenow;
        /*$getventas = DB::table('ventas')->where([
            ['user_id','=',$id],
            ['estado','=','Activo'],
        ])->get();*/

        $tipo_user = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->select('roles.full-access as access')
        ->where('users.id', '=', $id)
        ->get();

        $access = $tipo_user[0]->access;
        
        $getapertura = DB::table('aperturacajas')->where([
        ['user_id','=',$id],  
        ['estatus','=','Abierta'],
        ])
        ->whereRaw("CAST(fecha_hora AS DATE) ='$now'")
        ->get();

        switch ($access) {
            case 'yes':
                $geventasadmin = DB::table('ventas')->where('estado','=', 'Activo')->get();
                //dd($geventasadmin);
                return DataTables::of($geventasadmin)
                ->addColumn('action', function($geventasadmin){
                    $id = $geventasadmin->idventa;
                    $button = '
                    <div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mr-2" onclick="obtener_detalle_venta('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="obtener_print_detalle_venta('.$id.');" ><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    ';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            break;
            case 'no':
                if(count($getapertura) >= 1) {
            
                    $idapertura = $getapertura[0]->idapertura;
                    $ventaonly = DB::select('select venta_id from detalle_ventas where apertura_id="'.$idapertura.'" group by venta_id having count(*) >=1');
                    $arr = [];
                    foreach ($ventaonly as $vent) {
                        $idv = $vent->venta_id;
                        $getv = DB::table('ventas')->where('idventa','=',$idv)->get();
                        $idventa = $getv[0]->idventa;
                        $fecha_hora= $getv[0]->fecha_hora;
                        $num_folio= $getv[0]->num_folio;
                        $tipo_comprobante= $getv[0]->tipo_comprobante;
                        $total_venta= $getv[0]->total_venta;
                        $estado= $getv[0]->estado;
                        $arr[]=["idventa"=>$idventa,"fecha_hora"=>$fecha_hora,"num_folio"=>$num_folio,"tipo_comprobante"=>$tipo_comprobante,"total_venta"=>$total_venta,"estado"=>$estado];
                
                    }
                    return DataTables::of($arr)
                    ->addColumn('action', function($arr){
                        $id = $arr["idventa"];
                        $button = '
                        <div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mr-2" onclick="obtener_detalle_venta('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="obtener_print_detalle_venta('.$id.');" ><i class="fa fa-print" aria-hidden="true"></i></button>
                        </div>
                        ';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }else{
                    $idapertura = 0;
                    $getventass=DB::table('ventas as v')
                    ->join('detalle_ventas as dv', 'v.idventa','=','dv.venta_id')
                    ->where('dv.apertura_id','=',$idapertura)
                    ->get();

                    return DataTables::of($getventass)
                    ->addColumn('action', function(){
                        $id = 0;
                        $button = '<button type="button" class="btn btn-info btn-sm" onclick="obtener_detalle_venta('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
            break;
            
            default:
                # code...
                break;
        }
        /*************************************************** */
        /*if(count($getapertura) >= 1) {
            
            $idapertura = $getapertura[0]->idapertura;

            $ventaonly = DB::select('select venta_id from detalle_ventas where apertura_id="'.$idapertura.'" group by venta_id having count(*) >=1');
            $arr = [];
            foreach ($ventaonly as $vent) {
                $idv = $vent->venta_id;
                $getv = DB::table('ventas')->where('idventa','=',$idv)->get();
                $idventa = $getv[0]->idventa;
                $fecha_hora= $getv[0]->fecha_hora;
                $num_folio= $getv[0]->num_folio;
                $tipo_comprobante= $getv[0]->tipo_comprobante;
                $total_venta= $getv[0]->total_venta;
                $estado= $getv[0]->estado;
                $arr[]=["idventa"=>$idventa,"fecha_hora"=>$fecha_hora,"num_folio"=>$num_folio,"tipo_comprobante"=>$tipo_comprobante,"total_venta"=>$total_venta,"estado"=>$estado];
                
            }
            return DataTables::of($arr)
            ->addColumn('action', function($arr){
                $id = $arr["idventa"];
                $button = '<button type="button" class="btn btn-info btn-sm" onclick="obtener_detalle_venta('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }else{
            $idapertura = 0;
            $getventass=DB::table('ventas as v')
            ->join('detalle_ventas as dv', 'v.idventa','=','dv.venta_id')
            ->where('dv.apertura_id','=',$idapertura)
            ->get();

            return DataTables::of($getventass)
            ->addColumn('action', function(){
                $id = 0;
                $button = '<button type="button" class="btn btn-info btn-sm" onclick="obtener_detalle_venta('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }*/
        
    }

    public function show_edit($id)
    {
        /*$getventadetalle=DB::table('ventas as v')
        ->join('proveedores as p', 'v.cliente_id','=','p.idproveedor')
        ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
        ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta')
        ->where('v.idventa','=',$id)
        ->first();
        $detalles=DB::table('detalle_ventas as d')
        ->join('productos as a','d.articulo_id','=','a.idarticulo')
        ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
        ->where('d.venta_id','=',$id)
        ->get();*/
        $getventadetalle=DB::table('ventas as v')
        ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
        ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
        ->select('v.idventa','v.fecha_hora','c.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta')
        ->where('v.idventa','=',$id)
        ->first();
        $detalles=DB::table('detalle_ventas as d')
        ->join('productos as a','d.articulo_id','=','a.idarticulo')
        ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
        ->where('d.venta_id','=',$id)
        ->get();
        return response()->json(['result'=>$getventadetalle,'detalles'=>$detalles]);
        /*$where = array('idventa'=>$id);
        $venta = Venta_producto::where($where)->first();
        return Response::json($venta);*/

    }

    public function showDetailPrint($id)
    {
        $settings = DB::table('configuracion')->where('id', 1)->first();
        $getventadetalle=DB::table('ventas as v')
        ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
        ->join('users as u', 'v.user_id', '=', 'u.id')
        ->select('u.name','v.idventa','v.fecha_hora','v.efectivo','c.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta')
        ->where('v.idventa','=',$id)
        ->first();
        $detalles=DB::table('detalle_ventas as d')
        ->join('productos as a','d.articulo_id','=','a.idarticulo')
        ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
        ->where('d.venta_id','=',$id)
        ->get();
        return response()->json([
            'result'=>$getventadetalle,
            'detalles'=>$detalles,
            'settings'=>$settings,
        ]);

    }

    protected function detalle_venta($id_now_sale)
    {
        $getventadetalle=DB::table('ventas as v')
        ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
        ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
        ->join('users as u','v.user_id','=','u.id')
        ->select('v.idventa','v.fecha_hora','c.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta', 'u.name as nameCajero')
        ->where('v.idventa','=',$id_now_sale)
        ->first();
        $detalles=DB::table('detalle_ventas as d')
        ->join('productos as a','d.articulo_id','=','a.idarticulo')
        ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
        ->where('d.venta_id','=',$id_now_sale)
        ->get();
        return $details_now_sale =[
            "sale" => $getventadetalle,
            "detail" => $detalles
        ];
    }

    public function generateTicketPdf($data) 
    {
        $getData = json_decode($data, true);
        $settings = DB::table('configuracion')->where('id', 1)->first();
        $id_now_sale = $getData['idventa'];//695;
        $now_sale = $this->detalle_venta($id_now_sale);
        $sale = $now_sale['sale'];
        $detail = $now_sale['detail'];
        $suelto = $getData['suelto'];
        $efectivo = $getData['efectivo'];

        $pdf = PDF::loadView("ventas.venta.generateTicketPdf", compact('detail','sale','settings','suelto','efectivo'));
        $pdf->setPaper([0, 0, 226.772, 566.929]); //// Width: 80mm, Height: 297mm
        $pdfContent = $pdf->output();
        $base64Pdf = base64_encode($pdfContent);

        return response()->json(['pdf' => $base64Pdf]);
        
    }

}
