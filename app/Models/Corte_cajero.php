<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte_cajero extends Model
{
    //use HasFactory;
    protected $table='corte_cajero_dia';

    protected $primaryKey='idcortecaja';

    public $timestamps= false;

    protected $fillable = [
        "apertura_id",
        "total_acumulado",
        "seriefolio",
        "numfolio",
        "fecha",
        "hora"
    ]; 
}
