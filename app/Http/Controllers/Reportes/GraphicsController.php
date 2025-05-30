<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;
use Response;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GraphicsController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','reporte.index');
        return view("report.graph.index");
    }

    public function get_data(Request $request)
    {
        try {

            $rules = [
                'date_start' => 'required|date',
                'date_end' => 'required|date',
            ];
            $messages = [
                'date_start.required' => 'La fecha inicial es requerida',
                'date_end.required' => 'La fecha final es requerida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'estatus' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'alert' => 'Debes de seleccionar fecha inicial y final'
                ]);
            }

            $total_general_ventas =  DB::table('corte_cajero_dia')
            ->whereBetween('fecha', [$request->date_start,$request->date_end])
            ->sum('total_acomulado');

            $get_data = DB::table('corte_cajero_dia')
            ->select('fecha',DB::raw('SUM(total_acomulado) as total_sales'))
            ->groupBy('fecha')
            ->whereBetween('fecha', [$request->date_start,$request->date_end])
            ->get();


            return response()->json([
                "accion" => "get_for_day",
                "estatus" => 1,
                "dates"=>$get_data,
                "total_general" =>$total_general_ventas,
            ]);

        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estatus'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }

    public function get_data_mes(Request $request)
    {
        try {

            $rules = [
                'mes_start' => 'required|date',
                'mes_end' => 'required|date',
            ];
            $messages = [
                'mes_start.required' => 'El mes inicial es requerido',
                'mes_end.required' => 'El mes final es requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'estatus' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'alert' => 'Debes de seleccionar un mes inicial y final'
                ]);
            }
            /*$date = Carbon::parse($request->mes_end);
            $month = $date->month;
            $year = $date->year;*/

            //->whereDate('fecha', '=', date('2021-08'))
            /*->whereYear('fecha', '=', date($year))
            ->whereMonth('fecha', '=', date($month))
            ->get();*/
            
            $startonlymes = Carbon::parse($request->mes_start)->startOfMonth()->toDateString();
            $endonlymes = Carbon::parse($request->mes_end)->endOfMonth()->toDateString();

            $get_data_for_mes = DB::table('corte_cajero_dia')
            ->select(
                DB::raw('SUM(total_acomulado) as total_sales'),
                DB::raw("DATE_FORMAT(fecha,'%M %Y') as months")
            )
            ->groupBy('months')
            ->whereBetween('fecha', [$startonlymes,$endonlymes])
            ->get();
            
            $total_general_monts =  DB::table('corte_cajero_dia')
            ->whereBetween('fecha', [$startonlymes,$endonlymes])
            ->sum('total_acomulado');

            /*$get_data_for_mes = DB::table('corte_cajero_dia')
            ->select('fecha',DB::raw('SUM(total_acomulado) as total_sales'))
            ->groupBy('fecha')
            ->whereBetween('fecha', [$startonlymes,$endonlymes])
            ->get();*/

            return response()->json([
                "accion" => "get_for_month",
                "estatus" => 1,
                "endonlymes"=>$endonlymes,
                "startonlymes"=>$startonlymes,
                "dates_month"=>$get_data_for_mes,
                "total_general" =>$total_general_monts,
            ]);   

        } catch (\Throwable $th) {
            //throw $th;
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estatus'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }
}
