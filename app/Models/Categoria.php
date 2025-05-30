<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // protected $table='categorias';
    // protected $primarykey='idcategoria';

    // protected $fillable = ['nombre','descripcion'];
    protected $table = 'categorias';
    protected $primaryKey = 'idcategoria';
    //public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion'];

    public $timestamps= false;

}
