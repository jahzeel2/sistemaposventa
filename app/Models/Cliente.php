<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    
    protected $table = 'clientes';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email', 'estatus'];
}
