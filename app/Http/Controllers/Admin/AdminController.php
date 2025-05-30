<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\General\FechaController;

use Response,Validator;

use DB;

class AdminController extends Controller
{
    public function index(){

        $date = new FechaController();
        $date_now = $date->datenow();
        $ventas = DB::table('ventas')
        ->whereRaw("CAST(fecha_hora AS DATE) ='$date_now'")
        ->get();
        $total_ventas = count($ventas);
        $articulos= DB::table('productos')
        ->where('estado','=','Activo')
        ->get();
        $total_articulos = count($articulos);
        $entradas= DB::table('ingresos')
        ->whereRaw("CAST(fecha_hora AS DATE) ='$date_now'")
        ->get();
        $total_entradas = count($entradas);


        $getapertura = DB::table('aperturacajas')->where([
          ['estatus','=','Abierta'],
        ])
        ->whereRaw("CAST(fecha_hora AS DATE) ='$date_now'")
        ->get();
        $total_cajas = count($getapertura);

        return view('admin.admin.index',["ventas"=>$total_ventas, "productos"=>$total_articulos, "entradas"=>$total_entradas, "cajas"=>$total_cajas]);
    }

    public function get_sales()
    {
      try {
        $date = new FechaController();
        $date_now = $date->datenow();
        $date_yesterday = $date->yesterday();

        $sales_today = $sale = DB::table('ventas')
        ->whereRaw("CAST(fecha_hora AS DATE) ='$date_now'")
        ->sum('total_venta');

        $sales_yesterday = $sale = DB::table('ventas')
        ->whereRaw("CAST(fecha_hora AS DATE) ='$date_yesterday'")
        ->sum('total_venta');

        return response()->json([
          "sale_today"=> $sales_today,
          "today_date"=> $date_now,
          "sale_yesterday" => $sales_yesterday,
          "yesterday_date" => $date_yesterday
        ]);
      } catch (\Throwable $th) {
         $m = 'Excepción capturada: '.$th->getMessage(). "\n";
         return response()->json([
             'estatus'=> 0,  
             'mensaje' => (array) $m,
         ]);
      }
    }
}
