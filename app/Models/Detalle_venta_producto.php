<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_venta_producto extends Model
{
    protected $table='detalle_ventas';

    protected $primaryKey='iddetalle_venta';

    public $timestamps= false;

    protected $fillable = [
        "venta_id",
        "articulo_id",
        "apertura_id",
        "cantidad",
        "precio_venta",
        "descuento",
        "subtotal"
    ];
}
