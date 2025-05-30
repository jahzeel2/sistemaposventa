<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja_inicio extends Model
{
    //use HasFactory;
    protected $table='aperturacajas';

    protected $primaryKey='idapertura';

    public $timestamps= false;

    protected $fillable = [
        "user_id",
        "cantidad_inicial",
        "cantidad_final",
        "estatus",
        "fecha_hora",
        //"fecha_hora_cierre"
    ];
}
