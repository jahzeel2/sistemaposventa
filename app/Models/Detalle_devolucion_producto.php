<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_devolucion_producto extends Model
{
    protected $table='detalle_devolucion_ventas';

    protected $primaryKey='iddetalledevolucion';

    public $timestamps= false;

    protected $fillable = [
        "devolucion_id",
        "articulo_id",
        "nombre",
        "cantidad",
        "pventa",
        "descuento",
        "subtotal",
        "motivo"
    ];
}
