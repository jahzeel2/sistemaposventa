<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'idproveedor';
    public $timestamps = false;
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email','estado'];
}
