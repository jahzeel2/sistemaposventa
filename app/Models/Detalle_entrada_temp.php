<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_entrada_temp extends Model
{
    protected $table = 'detalle_entrada_temp';
    protected $primaryKey = 'identradatemp';
    public $timestamps = false;
    protected $fillable = ['idarticulo', 'codigo', 'nombre','cantidad','pcompra','pventa'];
}
