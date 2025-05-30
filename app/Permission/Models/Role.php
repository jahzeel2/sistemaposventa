<?php

namespace App\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //es: desde aqui
    //en: from here
    protected $fillable = [
        'name', 'slug', 'description','full-access',
    ];

    /**relacion muchos a muchos */
    /*nos trae los usuarios relacionados con el rol*/
    public function users(){
        return $this->belongsToMany('App\User')->withTimesTamps();
    }
    /**un rol puede tener muchos permisos*/
    public function permissions(){
        return $this->belongsToMany('App\Permission\Models\Permission')->withTimesTamps();
    }
}
