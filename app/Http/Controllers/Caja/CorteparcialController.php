<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use App\Models\Numero_corte_cajero;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Validator;

class CorteparcialController extends Controller
{
    public $datenow;
    public $datetimenow;

    public function __construct()
    {
        $datecontry = Carbon::now('America/Mexico_City');
        $this->datenow = $datecontry->toDateString();
        $this->datetimenow = $datecontry->toTimeString();


    }

    public function index()
    {
        Gate::authorize('haveaccess','caja_parcial.index');
         /*$getventadetails=DB::table('ventas as v')
            ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
            ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
            ->select('v.idventa','v.fecha_hora','c.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta')
            ->where('v.num_folio','=',$folio);*/

        /*$parcial = DB::table("corte_cajero_dia")
        ->where("fecha","=","$this->datenow")
        ->get();*/
        //////////////////////////////////////
        $parcial = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
        ->select('cor.idcortecaja', 'us.name', 'cor.total_acomulado', 'cor.fecha')
        ->where("cor.fecha","=","$this->datenow")
        ->get();
        ////////////////////////////////
        return view("caja.corteparcial.index",["parcial"=>$parcial]);
    }

    public function show()
    {
       //$getventas= DB::table('aperturacajas')->where('estado','=','Activo')->get();
       $getparcialacomulado = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
        ->select('cor.idcortecaja', 'us.name', 'cor.total_acomulado', 'cor.fecha')
        ->where([
            ["cor.fecha","=","$this->datenow"],
            ["ape.estatus","=","Abierta"]
        ])
        ->get();

        return DataTables::of($getparcialacomulado)
        ->addColumn('action', function($getparcialacomulado){
            $id = $getparcialacomulado->idcortecaja;
            $button = '<button type="button" class="btn btn-info" onclick="show_modal_parcial('.$id.');" ><i class="fa fa-eye" aria-hidden="true"></i></button>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function store(Request $request)
    {
        try {
            $rules = [
                'numparcial' => 'required',
                'cashcorte' => 'required'
            ];
 
            $messages = [
                'numparcial.required'=>'No se cuenta con un id para la apertura',
                'cashcorte.required'=>'Necesitas ingresar la cantidad del corte parcial',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                 return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class' => 'danger'
                ]);
            }

            $comprobar = DB::table('corte_cajero_dia')
            ->select('total_acomulado')
            ->where('idcortecaja','=',$request->numparcial)
            ->get();
            $dinero = $comprobar[0]->total_acomulado;

            if ($dinero <= 0.00) {
                return response()->json([
                    'estado'=>'errorcantidad',
                    'mensaje'=>'No se puede guardar por que aun no llegas a la cantidad acomulada',
                    'class'=>'danger'

                ]);
            }

            if ($request->cashcorte > $dinero) {
                return response()->json([
                    'estado'=>'errorcantidad',
                    'mensaje'=>'No se puede guardar por que ingresaste una cantidad mayor que el total acomulado de la venta',
                    'class'=>'danger'
                ]);
            }

            $cortenumero = new Numero_corte_cajero();
            $cortenumero->cortecaja_id = $request->numparcial;
            $cortenumero->cantidad = $request->cashcorte;
            $cortenumero->fecha = $this->datenow;
            $cortenumero->hora = $this->datetimenow;
            $cortenumero->save();

            return response()->json([
                'estado' => 1,
                'mensaje'=> 'Se realizo con exito el corte parcial del cajero',
                'class'=>'success'
            ]);
 
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
                'class'=>'danger'
                //'idcod'=>$idapertura
            ]);
        }
        
    }
}
