<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table='productos';

    protected $primaryKey="idarticulo";

    public $timestamps=false;

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'stock',
        'pcompra',
        'pventa',
        'descripcion',
        'imagen',
        'estado',
        'descuento',
        'iva'

    ];
}
