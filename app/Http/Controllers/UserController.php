<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Permission\Models\Role;
use App\User;
use Response;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('haveaccess','admin_user.index');
        $roles = DB::table('roles')->get();
        $users = User::with('roles')->where('estatus','=',1)->orderBy('id','Desc')->paginate(6);
        //return $users;
        return view('admin.user.index',compact('users','roles'));
    }

    public function edit(User $user)
    {
        
        $roles = Role::orderBy('name')->get();
        // return $roles;
        return view('admin.user.edit',compact('roles','user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([

            'name'=>'required|max:50|unique:users,name,'.$user->id,
            'email'=>'required|max:50|unique:users,email,'.$user->id,
            
        ]);

        $rol = e($request->input('roles'));

        if ($rol === "selecciona") {

            return back()->with('status_success','Necesitas selecionar un rol para el usuario');
        }
        // dd($request->all());
        $user->update($request->all());
        // $user = new User;
        // $user->name = e($request->input('name'));
        // $user->email = e($request->input('email'));
        // $user->password = Hash::make($request->input('password'));
        
        $user->roles()->sync($request->get('roles'));

        return redirect()->route('user.index')->with('status_success', 'Datos actualizados correctamente');
    }

    public function show(User $user)
    {
        $roles = Role::orderBy('name')->get();
        // return $roles;
        return view('admin.user.view',compact('roles','user'));
    }

    /**por el momento esta function no se utiliza*/
   /*public function destroy(User $user)
    {
        $this->authorize('haveaccess','user.destroy');
        $user->delete();
        return redirect()->route('user.index')->with('status_success','User success removed');
    }*/

    public function postRegister(Request $request)
    {
        try {

            DB::beginTransaction();
            $rules = [
                'name'=>'required',
                'email'=>'required|email|unique:App\User,email',
                'npassword'=>'required|min:8',
                'cpassword'=>'required|same:npassword',
                'rol'=>'required'
            ];

            $messages = [
                'name.required'=>'Su nombre es requerido',
                'email.required'=>'Su correo electronico es requerido',
                'email.email'=>'El formato de su correo electronico es invalido',
                'email.unique'=>'Ya existe un usuario registrado con este correo',
                'npassword.required'=>'Por favor escriba una contraseña',
                'npassword.min'=>'La contraseña debe de contener al menos 8 caracteres',
                'cpassword.required'=>'Es necesario confirmar el password',
                'cpassword.min'=>'La confirmación de la contraseña debe de tener al menos 8 caracteres',
                'cpassword.same'=>'Las contraseñas no coinciden',
                'rol.required'=>'Necesitas seleccionar un rol para el usuario',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                //return back()->withErrors($validator)->with('status_success','Se ha producido un error');
                return response()->json([
                    'estado' => 'errorvalidacion',
                    'mensaje'=> $validator->errors()->all(),
                    'class_name' => 'danger'
                ]);
            }

            $user = new User;
            $user->name = e($request->input('name'));
            $user->email = e($request->input('email'));
            $user->password = Hash::make($request->input('npassword'));
            $user->save();
            /**RELATIONS USERS WITH ROLES*/
            $user->roles()->sync($request->get('rol'));

            DB::commit();           

            return response()->json([
                'estado' => 1,
                'mensaje'=>'El usuario se genero con exito',
                'class_name' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $m = 'Excepción capturada: '.$th->getMessage(). "\n";
            return response()->json([
                'estado'=> 0,  
                'mensaje' => (array) $m,
            ]);
        }

    }

    public function updatepassword(Request $request)
    {
        
        $rules = [

            'password'=>'required|min:8'
        ];
        $messages = [

            'password.required'=>'Por favor escriba una contraseña',
            'password.min'=>'La contraseña debe de contener al menos 8 caracteres'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'estado' => 'errorvalidacion',
                'mensaje'=> $validator->errors()->all(),
                'class_name' => 'danger'
            ]);
            //return back()->withErrors($validator)->with('status_success','Se ha producido un error');
        }else{

            $id = e($request->input('id_user_now'));
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->input('password'));

            if($user->save()) {
                return response()->json([
                    'estado' => 1,
                    'mensaje'=>'El password se actualizo con exito',
                    'class_name' => 'success'
                ]);
             //return redirect()->route('user.index')->with('status_success','El password se actualizo con exito');
            }
        }
    }

    public function delete_user($id){
        $user = User::find($id);
        $user->estatus=0;
        if ($user->update()) {
            return response()->json([
                "estado"=>1,
                "mensaje"=>"El usuario se dio de baja en el sistema"
            ]);
        }else{
            return response()->json([
                "estado"=>0,
                "mensaje"=>"Ocurrio un error. Intentalo de nuevo"
            ]);
        }
    }

}
