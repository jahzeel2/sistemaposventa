<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Caja_inicio;
use App\Models\Corte_cajero;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CajainicioController extends Controller
{
    public $datenow;
    public $datetimenow;
    public $year;
    public $month;
    public $day;
    public $fecha_hora;


    public function __construct()
    {
        $datecontry = Carbon::now('America/Mexico_City');
        $this->datenow = $datecontry->toDateString();
        $this->datetimenow = $datecontry->toTimeString();
        $this->year = $datecontry->year;
        $this->month = $datecontry->month;
        $this->day = $datecontry->day;
        $this->fecha_hora = $datecontry->toDateTimeString();

    }
    
    public function index()
    {

        Gate::authorize('haveaccess','caja_apertura.index');
        $id  = Auth::id();
        $name = Auth::user()->name;
        $fech = Carbon::now('America/Mexico_City');
        $date = $fech->toDateString();
        $datacaja = DB::select('select * from aperturacajas where user_id="'.$id.'" AND estatus="Abierta" AND CAST(fecha_hora AS DATE) = ?', [$date]);
        if ($datacaja) {
            $fecha = $datacaja[0]->fecha_hora;
            $cantidad = $datacaja[0]->cantidad_inicial;
            //$estatus = $datacaja[0]->estatus;
            return view("caja.iniciocaja.index",["id"=>$id,"name_user"=>$name,"fecha"=>$fecha,"cantidad"=>$cantidad]);
        }else{
            return view("caja.iniciocaja.index",["id"=>$id,"name_user"=>$name, "fecha"=>"sin datos","cantidad"=>0]);
        }
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $rules = [
                'cantapertura' => 'required'
            ];

            $messages = [
                'cantapertura.required'=>'Necesita ingresar la cantidad con que apertura la caja',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                 return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class' => 'danger'
                ]);
            }
            /**IT IS VALIDAD IF THERE IS A CASH OPENING TODAY*/
            $user_id = $request->idnom;
            $fhora = Carbon::now('America/Mexico_City');
            $now = $fhora->toDateString();
            $data = DB::select('select * from aperturacajas where user_id="'.$user_id.'" AND estatus="Abierta" AND CAST(fecha_hora AS DATE) = ?', [$now]);
           
            if($data){
                return response()->json([
                    'estado'=>2,
                    'mensaje'=>'Error, Usted ya tiene una apertura de caja el dia de hoy',
                    'class'=>'danger'
                ]);
            }
            /**THE SAVE INFORMATION IN DATABASE */
            $caja = new Caja_inicio();
            $caja->user_id = $request->idnom;
            $caja->cantidad_inicial = $request->cantapertura;
            $caja->cantidad_final = 0;
            $caja->estatus = "Abierta";
            //$hora= Carbon::now('America/Mexico_City');
            $caja->fecha_hora=$this->fecha_hora;
            //$caja->fecha_hora_cierre = 'null';
            $caja->save();

            $cajero = new Corte_cajero();
            $cajero->apertura_id = $caja->idapertura;
            $cajero->total_acomulado = 0;
            $cajero->seriefolio = $this->year.$this->month.$this->day.$caja->idapertura;
            $cajero->numfolio= 1;
            $cajero->fecha = $this->datenow;
            $cajero->hora = $this->datetimenow;
            $cajero->save();
        
                //$datecaja = DB::select('select * from aperturacajas where user_id="'.$user_id.'" AND CAST(fecha_hora AS DATE) = ?', [$date]);
                //$dat = $datecaja[3]->fecha;
                
            $apertura = DB::table('aperturacajas')
            ->where('user_id','=',$user_id)
            ->where('estatus','=','Abierta')
            ->whereRaw("CAST(fecha_hora AS DATE) ='$now'")
            ->get();

            $idu = 0;
            $fecha = "";
            $cantidad = 0;
            foreach ($apertura as $ape) {
                $idu = $ape->user_id;
                $fecha = $ape->fecha_hora;
                $cantidad = $ape->cantidad_inicial;   
            }
                
            $usernom = DB::table('users')->select('name')->where('id','=',$idu)->get();
            $nombre = $usernom[0]->name;

            DB::commit();
            return response()->json([
                'estado'=>1,
                'mensaje'=>'Se genero la aperura de la caja con exito',
                'nombre'=>$nombre,
                'fecha'=>$fecha,
                'cantidad'=>$cantidad,
                //'now'=>$now,
                'datos'=>$apertura,
                'class'=>'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=>0,
                'mensaje'=>'Ocurrio un error, Vuelve a intentarlo',
                'class'=>'danger',
                'error' => (array) $m

            ]);    
        }
    }

   
}
