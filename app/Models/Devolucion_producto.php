<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion_producto extends Model
{
    protected $table='devolucion_ventas';

    protected $primaryKey='iddevolucion';

    public $timestamps= false;

    protected $fillable = [
        "venta_id",
        "observacion",
        "fecha",
    ];
}
