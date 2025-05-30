<?php

namespace App\Models\cotizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito_cotizacion extends Model
{
    use HasFactory;
    protected $table = 'carrito_cotizacion_temp';
    protected $fillable = [ 
        'producto_id',
        'cod',
        'id_user',
        'nombre',
        'cantidad',
        'descipcion',
        'precio',
        'descuento',
        'total'
    ];
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $hidden = ['created_at', 'updated_at'];
}
