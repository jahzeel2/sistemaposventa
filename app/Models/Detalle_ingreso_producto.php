<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_ingreso_producto extends Model
{
    protected $table='detalle_ingresos';

    protected $primaryKey='iddetalle_ingreso';

    public $timestamps = false;

    protected $fillable = [
        "ingreso_id",
        "articulo_id",
        "cantidad",
        "precio_compra",
        "precio_venta",
        "subtotal"
    ];
}
