<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use App\Models\Caja_inicio;
use PDF;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Validator;

class CortecajaController extends Controller
{
    public $datenow;
    public $datetimenow;
    public $fecha_hora;

    public function __construct()
    {
        $datecontry = Carbon::now('America/Mexico_City');
        $this->datenow = $datecontry->toDateString();
        $this->datetimenow = $datecontry->toTimeString();
        $this->fecha_hora = $datecontry->toDateTimeString();


    }

    public function index()
    {

        Gate::authorize('haveaccess','caja_corte.index');
        /*$cajacorte = DB::table('aperturacajas')
        ->whereRaw("CAST(fecha_hora AS DATE) ='$this->datenow'")
        ->get();*/
        /*$cajacorte = DB::table('aperturacajas')
        ->join('users', function($join){
            $join->on('aperturacajas.user_id','=','users.id')
            ->select('aperturacajas.idapertura','users.name','aperturacajas.cantidad_inicial','aperturacajas.fecha_hora')
            ->whereRaw("CAST(aperturacajas.fecha_hora AS DATE) ='$this->datenow'");
        })
        ->get();*/
        return view("caja.cortecaja.index");

    }
    
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $rules = [

                'numapertura' => 'required',
                'cash' => 'required'

            ];

            $messages = [
                'numapertura.required'=>'No se cuenta con un identificador para la apertura',
                'cash.required'=>'Necesitas ingresar la cantidad de dinero que genero tu caja',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                 return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class' => 'danger'
                ]);
            }
                
            $idapertura =$request->numapertura; 
            $cantidad = $request->cash;

            $apertura =  Caja_inicio::find($idapertura);
            $apertura->cantidad_final = $cantidad;
            $apertura->estatus = "Cerrada";
            $apertura->fecha_hora_cierre = $this->fecha_hora;
            $apertura->update();
            /**************************************/
            $getcortecajero = DB::table('aperturacajas as ape')
            ->join('users as us', 'ape.user_id', '=', 'us.id')
            ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
            ->select('cor.idcortecaja', 'us.name', 'cor.total_acomulado', 'ape.cantidad_inicial', 'ape.cantidad_final', 'ape.fecha_hora_cierre')
            ->where("ape.idapertura","=",$idapertura)
            ->get();
            $total = $getcortecajero[0]->total_acomulado;    
            $name_cajero = $getcortecajero[0]->name;
            $inicio = $getcortecajero[0]->cantidad_inicial; 
            $final = $getcortecajero[0]->cantidad_final;     
            $cierre = $getcortecajero[0]->fecha_hora_cierre;
            if ($final > $total) {
            $sobrante = round($final - $total, 2);
            }else{
                $sobrante = "0.00";
            }
        
            if ($final < $total) {
                $faltante = round($total - $final, 2);
            }else{
                $faltante = "0.00";
            }

            DB::commit();

            return response()->json([
                'estado' => 1,
                'mensaje'=> 'Se realizo con exito el cierre de caja',
                "total"=>$total,
                "name_cajero"=>$name_cajero,
                "inicio"=>$inicio,
                "final"=>$final,
                "sobrante"=>$sobrante,
                "faltante"=>$faltante,
                "cierre"=>$cierre,
                "apert"=>$idapertura,
                'class'=>'success'
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
                'class'=>'danger'
                //'idcod'=>$idapertura
            ]);
        }
        
    }

    public function show()
    {
        /*$cajacorte = DB::table('aperturacajas as ape')
        ->join('users as us', function($join){
            $join->on('ape.user_id','=','us.id')
            ->select('ape.idapertura','us.name','ape.cantidad_inicial','ape.estatus')
            ->whereRaw("CAST(ape.fecha_hora AS DATE) ='$this->datenow'");
        })
        ->get();*/
        $id  = Auth::id();

        $cajacorte = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->select('ape.idapertura','us.name','ape.cantidad_inicial','ape.fecha_hora','ape.estatus')
        //->where('us.id','=',$id)
        ->whereRaw("CAST(ape.fecha_hora AS DATE) ='$this->datenow'")
        ->get();

        return DataTables::of($cajacorte)
        ->addColumn('action', function($cajacorte){
            $id = $cajacorte->idapertura;
            $estatus = $cajacorte->estatus;

            if ($estatus == "Abierta") {
                $button = '
                <button type="button" class="btn btn-info" onclick="show_modal_corte('.$id.');">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
                ';
                /*$button .= '
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalle-corte-Modal">
                    Launch 
                </button>
                ';*/
            }else if($estatus == "Cerrada"){
                $button = "
                <form method='get' action='/ticketcorte'>
                    <input type='number' name='idaper' value='$id' hidden='true' />
                    <button class='btn btn-secondary'>
                        <i class='fa fa-download' aria-hidden='true'></i>
                    </button>
                </form>
            ";

            }
            
            //$button .= '<button type="button" class="btn btn-danger" onclick="devolucion('.$id.');"><i class="fa fa-reply-all" aria-hidden="true"></i></button>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function ticket(Request $request)
    {
        $idaperturacaja = $request->idaper;
        /*$list = DB::table('corte_cajero_dia')
        ->where('apertura_id','=',$idaperturacaja)
        ->get();*/
        $getcortecajero = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
        ->select('cor.idcortecaja', 'us.name', 'cor.total_acomulado', 'ape.cantidad_inicial', 'ape.cantidad_final', 'ape.fecha_hora_cierre')
        ->where("ape.idapertura","=",$idaperturacaja)
        ->get();
        $total = $getcortecajero[0]->total_acomulado;    
        $name_cajero = $getcortecajero[0]->name;
        $inicio = $getcortecajero[0]->cantidad_inicial; 
        $final = $getcortecajero[0]->cantidad_final;     
        $cierre = $getcortecajero[0]->fecha_hora_cierre;
        if ($final > $total) {
           $sobrante = $final - $total;
        }else{
            $sobrante = "0.00";
        }
        
        if ($final < $total) {
            $faltante = $total - $final;
        }else{
            $faltante = "0.00";
        }

        $pdf = PDF::loadView("caja.cortecaja.ticket",["idaper"=>$idaperturacaja, "total"=>$total, "name_cajero"=>$name_cajero, "inicio"=>$inicio, "final"=>$final, "sobrante"=>$sobrante, "faltante"=>$faltante, "cierre"=>$cierre]);
        return $pdf->download('corte_caja.pdf');
    }
}


