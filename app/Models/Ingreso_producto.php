<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso_producto extends Model
{
    protected $table="ingresos";
    protected $primaryKey='idingreso';
    public $timestamps= false;
    
    protected $fillable = [
        "user_id",
        "proveedor_id",
        "folio_comprobante",
        "fecha_hora",
        "total_ingreso",
        "estado"
    ];

}
