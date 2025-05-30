<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Models\cotizacion\Carrito_cotizacion;
use App\Models\cotizacion\Cotizacion;
use App\Models\cotizacion\Detail_cotizacion;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Gate;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','cotizaciones_cotizacion.index');
        return view('quotes.index');
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','cotizaciones_cliente.index');
        $id_user = Auth::user()->id;
        $carrito = Carrito_cotizacion::where('id_user',$id_user)->get();
        $total = Carrito_cotizacion::where('id_user',$id_user)->sum('total');
        return view('quotes.create', compact('carrito','total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $rules = [
                'clienteId' => 'required',
                'validez' => 'required',
                'total_quote' => 'required|gt:0',
            ];
            $messages = [
                'clienteId.required' => 'El nombre de el cliente es requerido',
                'validez.required' => 'La validez es requerido',
                'total_quote.required' => 'El total de la cotizacion es requerido',
                'total_quote.gt' => 'El total de la cotizacion debe de se mayor a 0',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'status' => 0,
                    'message' => $validator->errors()->all(),
                ]);
            }

            $folio = "";
            $comp = Cotizacion::select()->first();
            if ($comp === null) {
                $folio = "COTIZACION-1";
            }else {
                $compUltimo = Cotizacion::select()->latest()->first()->toArray();
                $serie = $compUltimo['id']+1;
                $folio = "COTIZACION-".$serie;
            }

            $id_user = Auth::user()->id;
            $coti = new Cotizacion();
            $coti->id_user = $id_user;
            $coti->id_cliente = $request->clienteId;
            $coti->serie = $folio;
            $coti->validez = $request->validez;
            $coti->total = $request->total_quote;
            $coti->estado = 1;
            $coti->save();

            $carritoQuote = Carrito_cotizacion::where('id_user',$id_user)->get();
            foreach($carritoQuote as $row){
                $detail = new Detail_cotizacion();
                $detail->id_cotizacion = $coti->id;
                $detail->id_producto = $row->producto_id;
                $detail->precio_venta = $row->precio;
                $detail->cantidad = $row->cantidad;
                $detail->descuento = 0;
                $detail->total = $row->total;
                $detail->item =  "1";
                $detail->save();
                $carr = Carrito_cotizacion::find($row->id);
                $carr->delete();
            }

            return response()->json([
                'status' => 1,
                "message"=> "Se realizo la cotizacion con exito",
                'cotizacionId' => $coti->id,
                //'total' => $request->total_quote,
                //'client' => $request->ventidcliente,
                //"getprod"=>$carritoQuote,
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "status" => 0,
                "message"=> (array) $m
            ]);
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
                $getdata = DB::table('cotizaciones as c')
                ->join('clientes as cli', 'c.id_cliente', '=', 'cli.idcliente')
                ->where('c.estado','=', 1)->get();
                return DataTables::of($getdata)
                ->addColumn('action', function($getdata){
                    $id = $getdata->id;
                    $button = '
                    <div class="text-center">
                        <button class="btn btn-light mr-3 btn-sm" onclick="getDetailQuote('.$id.');"><i class="fas fa-eye text-primary " id=""  title="Actualizar el cliente"></i></button>
                    </div>
                    ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            break;
            case 'no':
                $getdata = DB::table('cotizaciones as c')
                ->join('clientes as cli', 'c.id_cliente', '=', 'cli.idcliente')
                ->where([['c.estado','=', 1], ['c.id_user','=',$id]])->get();
                return DataTables::of($getdata)
                ->addColumn('action', function($getdata){
                    $id = $getdata->id;
                    $button = '
                    <div class="text-center">
                        <button class="btn btn-light mr-3 btn-sm" onclick="getDetailQuote('.$id.');"><i class="fas fa-eye text-primary " id=""  title="Actualizar el cliente"></i></button>
                    </div>
                    ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            break;
            default:
                # code...
            break;
        }


        /*$tipo_user = DB::table('users')
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
        }*/
    }

    public function getDetail($id)
    {
        try {
            $getdetalle=DB::table('cotizaciones as co')
            ->join('clientes as c', 'co.id_cliente','=','c.idcliente')
            ->join('users as u','co.id_user','=','u.id')
            ->select('co.id','co.created_at','c.nombre','co.serie','co.estado','co.total', 'u.name as nameCajero')
            ->where('co.id','=',$id)
            ->first();
            $detalles=DB::table('detalle_cotizacion as d')
            ->join('productos as a','d.id_producto','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.total')
            ->where('d.id_cotizacion','=',$id)
            ->get();
            return $details_now_qute =[
                "quote" => $getdetalle,
                "detail" => $detalles
            ];

        } catch (\Throwable $th) {
            return response()->json(["data" => $th]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function find_nombre(Request $request) {

        try {
            
            $nombre = trim($request->valor);

            $producto = DB::table('productos')
            ->where('nombre','like','%'.$nombre.'%')
            ->orwhere('codigo','like','%'.$nombre.'%')
            ->limit(5)
            ->get();
            $array_tags = [];
            foreach ($producto as $tag) {
                $id = $tag->idarticulo;
                $codigo = $tag->codigo;
                $nombre = $tag->nombre;
                $compra = $tag->pcompra;
                $venta = $tag->pventa; 
                $img = "/imagenes/articulos/".$tag->imagen;
                $array_tags[]=['id'=>$id,'codigo'=>$codigo,'nombre'=>$nombre,'img'=>$img,'pcompra'=>$compra,'pventa'=>$venta];
            }

            return response()->json([
                "status" => 1,
                "getprod"=>$array_tags
            ]);
            //return \Response::json($array_tags);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "status" => 0,
                "mensaje"=> (array) $m
            ]);
        }
        /*return response()->json([
            "success" => true,
        ]);*/
    }

    public function saveProdTemp(Request $request)
    {
        try {
            $id_user = Auth::user()->id;
            $array = json_decode($request->json, true);
            $getProd = Carrito_cotizacion::firstWhere([['producto_id', (int)$array['id']],['id_user',$id_user]]);
            if($getProd == null){
                $carrito = new  Carrito_cotizacion();
                $carrito->id_user = Auth::id();
                $carrito->producto_id = $array['id'];
                $carrito->cod = $array['codigo'];
                $carrito->nombre = $array['nombre'];
                $carrito->cantidad = 1;
                $carrito->precio = $array['pventa'];
                $carrito->total = $array['pventa'];
                $carrito->save();
            }else{
                $carrito = Carrito_cotizacion::firstWhere([['producto_id', (int)$array['id']],['id_user',$id_user]]);
                $cantidad=$carrito->cantidad + 1;                
                $subtotsl = $cantidad * $carrito->precio;  
                $total = $subtotsl;
                $carrito->cantidad = $cantidad;
                $carrito->total= $total;
                $carrito->save();
            }
            $getDataCarrito = Carrito_cotizacion::where('id_user',$id_user)->get();
            return response()->json([
                "status" => 1,
                "prod" => $getDataCarrito
            ]);

        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "status" => 0,
                "mensaje"=> (array) $m
            ]);
        }
    }

    public function updateProdTemp(Request $request)
    {
        try {
            $id_user = Auth::user()->id;
            $carrito=Carrito_cotizacion::find($request->id);
            $subtotsl = $request->cantidad * $request->precio;  
            $total = $subtotsl;
            $carrito->cantidad = $request->cantidad;
            $carrito->precio =  $request->precio;   
            $carrito->total= $total;
            $carrito->save();
            $getDataCarrito = Carrito_cotizacion::where('id_user',$id_user)->get();
            return response()->json([
                "status" => 1,
                "prod" => $getDataCarrito,
                "cantidad" => $request->cantidad,
            ]);
            
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "status" => 0,
                "mensaje"=> (array) $m
            ]);
        }
    }

    public function downProdTemp(Request $request)
    {
        try { 
            $id_user= Auth::user()->id;
            $carrito = Carrito_cotizacion::find($request->id);
            if($carrito->delete()){
                $car = Carrito_cotizacion::where('id_user',$id_user)->get();
                return response()->json([
                    "status" => 1,
                    "prod" => $car,
                ]);
            }
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                "status" => 0,
                "mensaje"=> (array) $m
            ]);
        }
    }

    public function generatePdf($id)
    {
        $cotizacion = DB::table('cotizaciones')
        ->join('users', 'cotizaciones.id_user', '=', 'users.id')
        ->join('clientes', 'cotizaciones.id_cliente', '=', 'clientes.idcliente')
        ->select('users.name as nomuser', 'clientes.nombre as nomcliente','clientes.direccion','clientes.telefono','clientes.email','cotizaciones.id as idcotizacion' ,'cotizaciones.serie as seriecotizacion' ,'cotizaciones.created_at as fechacotizacion','cotizaciones.total as totalcotizacion','cotizaciones.estado','cotizaciones.serie','cotizaciones.validez')
        ->where('cotizaciones.id','=', $id)
        ->get();
        $detalle=DB::table('detalle_cotizacion as dc')
        ->join('productos as p','dc.id_producto','=','p.idarticulo')
        ->select('p.codigo', 'p.nombre','dc.cantidad','dc.precio_venta','dc.total')
        ->where('dc.id_cotizacion','=',$id)
        ->get();
        //dd($cotizacion);
        //dd($detalle);
        $pdf = PDF::loadView('quotes/pdfquote', compact('cotizacion','detalle'));//, compact('id','cotizacion','detalle','totalcotizacion','abonocotizacion','apagar','vendedor','servicio','date_end'));
        return $pdf->stream('cotizacion.pdf');         
        //return $pdf->download('cotizacion.pdf');         
    }

    public function cancelQuote(Request $request)
    {
        try {
            $id_user= Auth::user()->id;
            $car = Carrito_cotizacion::where('id_user',$id_user)->delete();
            return response()->json([
                "status" => 1,
                "message" => "Se cancelo la cotizacion con exito"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "mensaje"=> (array) $m
            ]);
        }
    }
}
