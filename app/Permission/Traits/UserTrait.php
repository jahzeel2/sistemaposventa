<?php
namespace App\Permission\Traits;
trait UserTrait {
    //es: desde aqui
    //en: from here 
    public function roles(){
        return $this->belongsToMany('App\Permission\Models\Role')->withTimesTamps();
    }

    public function havePermission($permission)
    {
        foreach($this->roles as $role){
            if($role['full-access'] == "yes"){
                return true;
                // return 'true full access';
            }
            foreach ($role->permissions as $perm) {
                if($perm->slug == $permission){
                    return true;
                    // return 'true por permisos';
                }
            }
        }
        return false;
        // return $this->roles;
    }
}