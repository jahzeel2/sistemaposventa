<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta_producto extends Model
{
    protected $table='ventas';

    protected $primaryKey='idventa';

    public $timestamps= false;

    protected $fillable = [
        "user_id",
        "cliente_id",
        "tipo_comprobante",
        "num_folio",
        "fecha_hora",
        "efectivo",
        "total_venta",
        "estado"
    ];
}
