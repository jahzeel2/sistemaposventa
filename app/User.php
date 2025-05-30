<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permission\Traits\UserTrait;

class User extends Authenticatable
{
    use Notifiable,UserTrait ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estatus', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //es: desde aqui
    //en: from here 
    /**function que se ejecuta desde el seeder*/
    // public function roles(){
    //     return $this->belongsToMany('App\Permission\Models\Role')->withTimesTamps();
    // }

    // public function havePermission($permission){
    //     //return $this->roles;
    //     foreach($this->roles as $role){
    //         if($role['full-access'] == "yes"){
    //             return 'true full access';
    //         }
    //         foreach ($role->permissions as $perm) {
    //             if($perm->slug == $permission){
    //                 return 'true por permisos';
    //             }
    //         }
    //     }
    //     return 'false';
    // }
}
