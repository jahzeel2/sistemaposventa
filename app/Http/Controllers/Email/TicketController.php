<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendticketMailable;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TicketController extends Controller
{
    public function sendEmail(Request $request)
    {
        try {
            $idvent =  $request->cons_send_email;
            $suelto = $request->suelt_vent;
            $email_destino =$request->nowemail;

            $rules = [
                'cons_send_email' => 'required',
                'suelt_vent' => 'required',
                'nowemail' => 'required|email',
            ];

            $messages = [
                'cons_send_email.required' => 'El identificador es requerido',
                'suelt_vent.required' => 'El suelto es requerido',
                'nowemail.required' => 'El email es requerido',
                'nowemail.email' => 'Debe ser una dirección de correo electrónico válida'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {  
                return response()->json([
                    'estatus' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class_name' => 'alert-danger'
                ]);
            }

            $getventadetalle=DB::table('ventas as v')
            ->join('clientes as c', 'v.cliente_id','=','c.idcliente')
            ->join('detalle_ventas as dv','v.idventa','=','dv.venta_id')
            ->select('v.idventa','v.fecha_hora','c.nombre','v.tipo_comprobante','v.num_folio','v.estado','v.total_venta')
            ->where('v.idventa','=',$idvent)
            ->first();
            $detalles=DB::table('detalle_ventas as d')
            ->join('productos as a','d.articulo_id','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal')
            ->where('d.venta_id','=',$idvent)
            ->get();

            $fecha = $getventadetalle->fecha_hora;
            $cliente = $getventadetalle->nombre;
            $total_venta = $getventadetalle->total_venta;
            $folio = $getventadetalle->num_folio;

            $details=[
                "sale" => $getventadetalle,
                "detail" => $detalles,
                "fecha"=>$fecha,
                "cliente" => $cliente,
                "total_venta" => $total_venta,
                "folio" => $folio,
                "suelto" =>  $suelto,
            ];

            Mail::to($email_destino)->send(new SendticketMailable($details));

            return response()->json([
                'estatus' => 1,
                "mensaje"=>"El ticket se envio al correo",
            ]);
            
        } catch (\Throwable $th) {
            //th
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estatus'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
        //return "Correo electronico enviado";
    }
}
