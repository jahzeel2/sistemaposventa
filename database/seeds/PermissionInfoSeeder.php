<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Proveedor;
use App\Permission\Models\Role;
use App\Permission\Models\Permission;
use App\Models\Categoria;
//use App\Models\Detalle_entrada_temp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PermissionInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate tables -- elimina todo y reinicia todo para las tablas role_user y permission_role
        DB::statement('SET foreign_key_checks=0');
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        //DB::table('detalle_entrada_temp')->truncate();
        Permission::truncate();
        Role::truncate();
        Proveedor::truncate();
        Categoria::truncate();
        User::truncate();
        DB::statement('SET foreign_key_checks=1');
        //user admin
        $useradmin = User::where('email','admin@gmail.com')->first();
        if ($useradmin) {
            $useradmin->delete();
        }
        $useradmin = User::create([
            'name' =>'admin', 
            'email' => 'admin@gmail.com',
            'password' =>Hash::make('admin')
        ]);
        //rol admin
        $roladmin = Role::create([
            'name'=>'Admin',
            'slug'=>'Admin',
            'description'=>'Administrador',
            'full-access'=>'Yes'
        ]);
        //table role_user
        $useradmin->roles()->sync([$roladmin->id]);

        //PERMISOS DEL MENU PRINCIPAL del administrador
        $permission =  Permission::create([
            'name'=>'listar el menu principal',
            'slug'=>'admin.index',
            'description'=>'un administrador puede ver el menu'
        ]);

        //PERMISOS PARA EL MENU DE ALMACÉN
        $permission =  Permission::create([
            'name'=>'listar el menu de almacen',
            'slug'=>'almacen.index',
            'description'=>'Un usuario puede ver el menu de almacen'
        ]);
        //PERMISOS PARA EL MENU DE COMPRAS
        $permission =  Permission::create([
            'name'=>'listar el menu de compras',
            'slug'=>'compras.index',
            'description'=>'Un usuario puede ver el menu de compras'
        ]);
        //PERMISOS PARA EL MENU DE VENTAS
        $permission =  Permission::create([
            'name'=>'listar el menu de ventas',
            'slug'=>'ventas.index',
            'description'=>'Un usuario puede ver el menu de ventas'
        ]);
        //PERMISOS PARA EL MENU DE CAJA 
        $permission =  Permission::create([
            'name'=>'listar el menu de caja',
            'slug'=>'caja.index',
            'description'=>'Un usuario puede ver el menu de caja'
        ]);
        //PERMISOS PARA EL MENU DE DEVOLUCION 
        $permission =  Permission::create([
            'name'=>'listar el menu de devoluciones',
            'slug'=>'devolucion.index',
            'description'=>'Un usuario puede ver el menu de devoluciones'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de roles',
            'slug'=>'admin_role.index',
            'description'=>'Un usuario puede ver la seccion de roles'
        ]);
        $permission =  Permission::create([
            'name'=>'listarla seccion de usuarios',
            'slug'=>'admin_user.index',
            'description'=>'Un usuario puede ver la seccion de usuarios'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de apertura de caja',
            'slug'=>'caja_apertura.index',
            'description'=>'Un usuario puede aperturar una caja para vender'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de corte de caja',
            'slug'=>'caja_corte.index',
            'description'=>'Un usuario puede realizar el corte de caja'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de corte parcial de caja',
            'slug'=>'caja_parcial.index',
            'description'=>'Un usuario puede realizar el corte de caja parcial'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de articulos',
            'slug'=>'almacen_articulo.index',
            'description'=>'Un usuario puede realizar la alta de productos'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de categorias',
            'slug'=>'almacen_categoria.index',
            'description'=>'Un usuario puede realizar la alta de categorias'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de entrada de mercancia',
            'slug'=>'compras_entrada.index',
            'description'=>'Un usuario puede realizar la entrada de productos'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de proveedores',
            'slug'=>'compras_proveedor.index',
            'description'=>'Un usuario puede realizar el registro de un proveedor'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de ventas',
            'slug'=>'ventas_venta.index',
            'description'=>'Un usuario puede realizar las ventas'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de clientes',
            'slug'=>'ventas_cliente.index',
            'description'=>'Un usuario puede realizar el registro de los clientes'
        ]);
        $permission =  Permission::create([
            'name'=>'listar la seccion de devoluciones',
            'slug'=>'devolucion_producto.index',
            'description'=>'Un usuario puede realizar la devolucion de productos'
        ]);
        /**comando para ejeutar el seeder*/
        //php artisan migrate --seed

        //comando para eliminar y crear todo de una sola vez   
        //php artisan migrate:refresh --seed
    }
}
