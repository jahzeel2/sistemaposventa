<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class HistoricocajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','caja_historicolist.index');
        return view("caja.consultarcaja.index");
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

        $rules = [
            'dateOne' => 'required|date',
            'dateTwo' => 'required|date',
        ];
        $messages = [
            'dateOne.required' => 'La fecha inicial es requerida',
            'dateTwo.required' => 'La fecha final es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {  
            return response()->json([
                'status' => 0,
                'mensaje'=> $validator->errors()->all(),
                'alert' => 'Debes de seleccionar fecha inicial y final'
            ]);
        }

        $cajacorte = DB::table('aperturacajas as ape')
        ->join('users as us', 'ape.user_id', '=', 'us.id')
        ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
        ->select('ape.idapertura','us.name','ape.cantidad_inicial','ape.cantidad_final','ape.fecha_hora_cierre','ape.fecha_hora','ape.estatus','cor.total_acomulado')
        ->whereBetween('ape.fecha_hora', [$request->dateOne,$request->dateTwo])
        ->get();

        return response()->json([
            "status" => 1,
            "sas" => $request->dateOne,
            "sasss" => $request->dateTwo,
            "datacorte" => $cajacorte,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $getcortecajero = DB::table('aperturacajas as ape')
            ->join('users as us', 'ape.user_id', '=', 'us.id')
            ->join('corte_cajero_dia as cor', 'ape.idapertura', '=', 'cor.apertura_id')
            ->select('cor.idcortecaja', 'us.name', 'cor.total_acomulado', 'ape.cantidad_inicial', 'ape.cantidad_final', 'ape.fecha_hora_cierre')
            ->where("ape.idapertura","=",$id)
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

            $settings = DB::table('configuracion')->where('id', 1)->first();

            return response()->json([
                'status' => 1,
                'mensaje'=> 'exit',
                "total"=>$total,
                "name_cajero"=>$name_cajero,
                "inicio"=>$inicio,
                "final"=>$final,
                "sobrante"=>$sobrante,
                "faltante"=>$faltante,
                "cierre"=>$cierre,
                "apert"=>$id,
                "settings"=>$settings,
                'class'=>'success'
            ]);
        } catch (\Throwable $th) {
        return response()->json([
            'status' => 0,
            "message" => "Ocurrio un error",
        ]);
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
}
