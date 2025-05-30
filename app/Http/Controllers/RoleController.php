<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Permission\Models\Role;
use App\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

use Response,Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','admin_role.index');
        $roles = Role::where('estatus',1)->orderBy('id','Desc')->paginate(6);
        return view('admin.role.index',compact('roles'));
        //return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('slug','like','%admin%')->get();
        $permission_caja = Permission::where('slug','like','%caja%')->get();
        $permission_almacen = Permission::where('slug','like','%almacen%')->get();
        $permission_compras = Permission::where('slug','like','%compras%')->get();
        $permission_ventas= Permission::where('slug','like','%ventas%')->get();
        $permission_devolucion= Permission::where('slug','like','%devolucion%')->get();
        $permission_reports= Permission::where('slug','like','%reporte%')->get();
        $permission_configuracion = Permission::where('slug','like','%configuracion%')->get();
        $permission_cotizaciones = Permission::where('slug','like','%cotizaciones%')->get();
        //dd($permission_configuracion);
        return view('admin.role.create',compact('permissions','permission_caja','permission_almacen','permission_compras','permission_ventas','permission_devolucion','permission_reports','permission_configuracion','permission_cotizaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $request->validate([
            'name'=>'required|max:50|unique:roles,name',
            'slug'=>'required|max:50|unique:roles,slug',
            'description'=>'required',
            'full-access'=>'required|in:yes,no'
        ],[
            'name.required' => 'EL nombre es requerido',
            'name.max' => 'EL nombre excede los 50 caracteres',
            'name.unique' => 'El nombre debe ser unico',
            'slug.required' => 'El slug es requerido',
            'slug.max'=> 'El slug excede los 50 caracteres',
            'slug.unique' => 'El slug debe ser unico',
            'description.required' => 'Debes de realizar una descripcion del nuevo rol',
            'full-access.required' => 'El tipo de acceso es requerido'
        ]);
        
        $role = Role::create($request->all());

        // if ($request->get('permission')) {
            //return $request->all();
            $role->permissions()->sync($request->get('permission'));
        // }

        //else{
        //     return 'no exit';
        // }
        return redirect()->route('role.index')->with('status_success','El rol se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        /**array de roles $array = [1,2,3,4,5,6]*/
        $permission_role = [];
        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }
        

        //return $permission_role;
        // return $role->permissions;
        $permissions = Permission::get();
        
        return view('admin.role.view',compact('permissions','role','permission_role'));
        //$role = Role::findOrFail($id);
        //return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //model bilding en la function 
    public function edit(Role $role)
    {
        /**array de roles $array = [1,2,3,4,5,6]*/
        $permission_role = [];
        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }
        
        //return $permission_role;
        // return $role->permissions;
        //$permissions = Permission::get();
        $permissions = Permission::where('slug','like','%admin%')->get();
        $permission_caja = Permission::where('slug','like','%caja%')->get();
        $permission_almacen = Permission::where('slug','like','%almacen%')->get();
        $permission_compras = Permission::where('slug','like','%compras%')->get();
        $permission_ventas= Permission::where('slug','like','%ventas%')->get();
        $permission_devolucion= Permission::where('slug','like','%devolucion%')->get();
        $permission_reports= Permission::where('slug','like','%reporte%')->get();
        $permission_configuracion = Permission::where('slug','like','%configuracion%')->get();
        $permission_cotizaciones = Permission::where('slug','like','%cotizaciones%')->get();
        //dd($permissions);
        return view('admin.role.edit',compact('permissions','permission_caja','permission_almacen','permission_compras','permission_ventas','permission_devolucion','role','permission_role','permission_reports','permission_configuracion','permission_cotizaciones'));
        //$role = Role::findOrFail($id);
        //return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required|max:50|unique:roles,name,'.$role->id,
            'slug'=>'required|max:50|unique:roles,slug,'.$role->id,
            'description'=>'required',
            'full-access'=>'required|in:yes,no'
        ],[
            'name.required' => 'EL nombre es requerido',
            'name.max' => 'EL nombre excede los 50 caracteres',
            'name.unique' => 'El nombre debe ser unico',
            'slug.required' => 'El slug es requerido',
            'slug.max'=> 'El slug excede los 50 caracteres',
            'slug.unique' => 'El slug debe ser unico',
            'description.required' => 'Debes de realizar una descripcion del nuevo rol',
            'full-access.required' => 'El tipo de acceso es requerido'
        ]);
        $role->update($request->all());
        $role->permissions()->sync($request->get('permission'));
        return redirect()->route('role.index')->with('status_success','El rol se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index')->with('status_success','EL rol se elimino con exito');
    }

    public function downRol(Request $request)
    {
        try {
            
            $where = $request->id;

            $role_user = DB::table('role_user')->where('role_id',$where)->first();
            if ($role_user == null) {
                //$users = DB::table('users')->where('estatus',0)->get();
                ////$rolAsignado = $role_user->role_id;
                $role = Role::find($request->id);
                $role->estatus=0;
                $role->update();
                $execute = "exito";
                $mensaje = "El Rol se elimino con exito";
            }else{
                /**select to users join roles and select users active with rol asignado*/
                $numUserActive = 0;
                $users = DB::table('role_user')->where('role_id',$where)->get();
                foreach ($users as $down) {
                    $idUser = $down->user_id;
                    $usersDown = DB::table('users')->where([
                        ['id', '=', $idUser],
                        ['estatus', '=', 1]
                    ])->get();

                    if (!$usersDown->isEmpty()) {
                        $numUserActive= $numUserActive+1;
                    }
                }

                if ($numUserActive == 0) {
                    $role = Role::find($request->id);
                    $role->estatus=0;
                    $role->update();
                    $execute = "exito";
                    $mensaje = "El Rol se elimino con exito";
                }else{
                    $execute = "error";
                    $mensaje = "Error: El Rol esta asignado a un usuario activo";
                }
            }

            return response()->json([
                "estado"=>1,
                "mensaje"=> $mensaje,
                "execute" => $execute,
                //"users" => $users,
                //"UsersActives" =>$numUserActive,
                //"num"=>$numUser
                //"roleAsignado" => $rolAsignado,
                //"roles" => $role_user
            ]);
        } catch (\Throwable $th) {
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }
    }
}
