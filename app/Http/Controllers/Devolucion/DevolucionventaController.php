<?php

namespace App\Http\Controllers\devolucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\General\FechaController;
use App\Models\Venta_producto;
use App\Models\Detalle_venta_producto;
use App\Models\Devolucion_producto;
use App\Models\Detalle_devolucion_producto;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DevolucionVentaController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','devolucion_producto.index');
        $date = new FechaController();
        $date_now = $date->datenow();
        $cajas = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->select('ape.idapertura','us.name','ape.cantidad_inicial','ape.fecha_hora','ape.estatus','ape.user_id as user')
        ->where('ape.estatus','=','Abierta')
        ->whereRaw("CAST(ape.fecha_hora AS DATE) ='$date_now'")
        ->get();
        return view("devolucion.devolucion_venta.index",["cajas" => $cajas]);
    }

    public function show_devolucion_venta($folio)
    {
        try {

            $collection = Str::of($folio)->explode('|||');
            $onlyfolio = $collection[0];
            $onlycajaape = $collection[1];
            $onlyuser = $collection[2];

            $getventadetails=DB::table('ventas as v')
            ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
            ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
            ->select('v.idventa')
            ->where([
                ['v.num_folio','=',$onlyfolio],
                ['v.user_id','=',$onlyuser]
            ])
            ->first();
                //dd($getventadetails);
            if($getventadetails === null){
                return response()->json([
                    "estado"=>null,
                    "mensaje"=>'Error. No se encontro ninguna venta asociado con el usuario de la caja',
                    "class"=>"danger",
                ]);
            }

            $id = $getventadetails->idventa;
            $detalles=DB::table('detalle_ventas as d')
            ->join('productos as a','d.articulo_id','=','a.idarticulo')
            ->select('a.idarticulo','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
            ->where('d.venta_id','=',$id)
            ->get();

            return Response::json([
                'estado'=>1,
                'getventa'=>$getventadetails,
                'detalles'=>$detalles,
                'onlyapecaja'=>$onlycajaape
            ]);

        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=>0,
                'mensaje'=>'Error. No se encontro ninguna venta con este folio',
                'class'=>'danger',
                'error' => (array) $m
            ]);  
        }

         
    }

    protected function totalventa($caja){
        $total = DB::table('corte_cajero_dia')
        ->select('total_acomulado')
        ->where('apertura_id', '=', $caja)
        ->get();
        return $total[0]->total_acomulado;
    }

    public function store(Request $request){
        try {
           //dd($total_acum);
            //START THE TANSACTION
            DB::beginTransaction();
            
            //THE RETURN DATA IS SAVED
            $dev = new Devolucion_producto();
            $dev->venta_id = $request->idventades;
            $dev->observacion = "Devolucion de productos";
            $hora = Carbon::now('America/Mexico_City');
            $dev->fecha=$hora->toDateTimeString();
            $dev->save();
            //VARIABLE THAT HAS THE CONSECUTIVE NUMBER OF PRODUCTS   
            $num = $request->numero;
            //THE VARIABLES ARE OBTAINED TO SAVE IN THE TABLE DETALLE_DEVOLCUCION_PRODUCTO    
            $nombre = $request->nombre;
            $cantidad = $request->cantidad;
            $pventa= $request->pventa;
            $descuento = $request->descue;
            $subtotal = $request->subtotal;
            $desc = $request->descripcion;
            //dd($desc);

            $cont = 0;
            $devc = 0;
            $restar_acumulado= 0;
            while ($cont < count($num)) {
                $descript = $desc[$cont];
                //si la varible $descript en su actual valor no esta vacio entonces significa que se tiene que devolver. y entonces entra al if y se devuelve 
                if ($descript != "") {
                    $detalle = new  Detalle_devolucion_producto();
                    $detalle->devolucion_id = $dev->iddevolucion;
                    $detalle->articulo_id = $num[$cont];
                    $detalle->nombre = $nombre[$cont];      
                    $detalle->cantidad = $cantidad[$cont];
                    $detalle->pventa= $pventa[$cont];
                    $detalle->descuento= $descuento[$cont];
                    $detalle->subtotal = $subtotal[$cont];
                    $detalle->motivo = $descript;
                    $detalle->save();
                    /**THE UPDATE TOTAL_ACOMULADO FROM CAJERO YOUR BOX ACTIVE*/
                    $caja = $request->nowcaja;
                    $total_acum = $this->totalventa($caja);
                    $restar_acumulado = round($total_acum-$subtotal[$cont],2);
                    $updatetotal = DB::table('corte_cajero_dia')
                    ->where('apertura_id', $caja)
                    ->update(['total_acomulado'=>$restar_acumulado]);

                    $devc=$devc+1;
                    //echo $descript;
                }
                $cont=$cont+1;
            }
            
            DB::commit();
            /**IT IS VALID THAT SOME PRODUCT WILL BE RETURNED*/
            if ($devc == 0) {
                return Response::json([
                    "estado"=>"errorvalidacion",
                    "mensaje"=>"Error: No has seleccionado un producto para la devolucion",
                    "class"=>"danger",
                ]);
            }else{
                return Response::json([
                    "estado"=>1,
                    "mensaje"=>"Se realizo la devolucion con exito",
                    "class"=>"success",
                    "total"=>$restar_acumulado
                ]);    
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=>0,
                'mensaje'=>'Ocurrio un error, No se puede realizar la devolucion de los productos seleccionados',
                'class'=>'danger',
                'error' => (array) $m
            ]);      

        }
       
    }
}