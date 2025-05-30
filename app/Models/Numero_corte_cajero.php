<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numero_corte_cajero extends Model
{
    //use HasFactory;
    protected $table="numero_corte_por_cajero";
    protected $primaryKey='idnumerocorte';
    public $timestamps= false;
    
    protected $fillable = [
        "cortecaja_id",
        "cantidad",
        "fecha",
        "hora"
    ];

}
