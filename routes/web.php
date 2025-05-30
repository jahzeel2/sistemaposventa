<?php

use Illuminate\Support\Facades\Route;

use App\User;
use App\Permission\Models\Role;
use App\Permission\Models\Permission;
//use Illuminate\Support\Facades\Gate;
/**use controller version 8 */
use App\Http\Controllers\Caja\CajainicioController;
use App\Http\Controllers\Caja\CortecajaController;
use App\Http\Controllers\Caja\CorteparcialController;
use App\Http\Controllers\Caja\HistoricocajaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserdashboardController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Reportes\GraphicsController;
use App\Http\Controllers\Configuracion\ConfiguracionController;
use App\Http\Controllers\Articulo\InventarioController;
use App\Http\Controllers\Articulo\ArticuloController;
use App\Http\Controllers\Quotes\QuotesController;
/**IMPORT DATA FROM EMAILS */
use App\Http\Controllers\Email\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
    //return view('welcome');
    //return view('connect.login');
//});
Route::get('/', 'ConnectController@index')->name('login');
/** */
Route::get('/ticket', function(){
 return view('ventas/venta/impresion');
});
/**Ruta principal */
//Route::get('dashboard','Admin\AdminController@index')->name('admin')->middleware(['auth','Isadmin']);
/**ROUTE FOR ADMIM */
Route::get('dashboard', [AdminController::class, 'index'])->name('admin')->middleware(['auth','Isadmin']);
Route::get('/get-data-sales', [AdminController::class, 'get_sales'])->name('get-data-sales')->middleware(['auth','Isadmin']);
/**ROUTE FOR USER */
Route::get('userdashboard', [UserdashboardController::class, 'index'])->name('userdashboard')->middleware('auth');
//Auth::routes();

/**RUTAS DE AUTENTICACION DEL LOGIN*/
Route::get('/login', 'ConnectController@index')->name('login');
Route::post('/login','ConnectController@postLogin')->name('login');
/**RUTA DE CERRAR CESION */
Route::get('/logout', 'ConnectController@getLogout')->name('logout')->middleware('auth');


//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

/**RUTAS DEL USUARIO PRINCIPAL*/
Route::resource('admin/role', 'RoleController')->names('role')->middleware('auth');
Route::resource('admin/user', 'UserController')->names('user')->middleware('auth');
Route::post('newuser', 'UserController@postRegister')->name('register')->middleware('auth');
Route::post('updatepasssword', 'UserController@updatepassword')->name('updatepasssword')->middleware('auth');
Route::get('delete-users/{id}', 'UserController@delete_user')->name('delete-users')->middleware('auth');
Route::post('/downrol', 'RoleController@downRol')->name('downrol')->middleware('auth');
//Route::post('savedevolucionproduct', 'Devolucion\DevolucionventaController@store')->name('savedevolucionproduct');

/**RUTAS DE CATEGORIA */
Route::get('almacen/categoria', 'Categoria\CategoriaController@index')->name('categoria')->middleware('auth');
Route::post('/savecategoria', 'Categoria\CategoriaController@store')->name('savecategoria')->middleware('auth');
Route::get('showcategoria', 'Categoria\CategoriaController@show')->name('showcategoria')->middleware('auth');
Route::post('/deletecategoria', 'Categoria\CategoriaController@destroy')->name('deletecategoria')->middleware('auth');
Route::get('categoria-list/{id}', 'Categoria\CategoriaController@edit')->name('categoria-list')->middleware('auth');
Route::post('categoriaupdate', 'Categoria\CategoriaController@update')->name('categoriaupdate')->middleware('auth');
//Route::get('product-list', 'Categoria\CategoriaController@show');

/**RUTAS PARA EL ARTICULO*/ 
Route::get('almacen/articulo', 'Articulo\ArticuloController@index')->name('articulo')->middleware('auth');
Route::post('savearticulo', 'Articulo\ArticuloController@store')->name('savearticulo')->middleware('auth');
Route::get('showproducto', 'Articulo\ArticuloController@show')->name('showproducto')->middleware('auth');
Route::get('product-list/{id}', 'Articulo\ArticuloController@edit')->name('product-list')->middleware('auth');
Route::post('updateproduct', 'Articulo\ArticuloController@update')->name('updateproduct')->middleware('auth');
Route::post('/delete-product', 'Articulo\ArticuloController@destroy')->name('delete-product')->middleware('auth');
Route::post('/send-articulo-excel', 'Articulo\ArticuloController@get_data_excel')->name('send-articulo-excel');
Route::post('/save_upload_products', 'Articulo\ArticuloController@save_products')->name('save_upload_products');
Route::post('/updateStock', 'Articulo\ArticuloController@update_stock')->name('updateStock');
Route::get('/excelarticulo', [ArticuloController::class, 'exportArticulo'])->name('excelexportarticulo')->middleware('auth');

/**RUTAS PARA EL PROVEEDOR*/
Route::get('compras/proveedor', 'Proveedor\ProveedorController@index')->name('proveedor')->middleware('auth');
Route::post('saveproveedor', 'Proveedor\ProveedorController@store')->name('saveproveedor')->middleware('auth');
Route::get('showproveedor', 'Proveedor\ProveedorController@show')->name('showproveedor')->middleware('auth');
Route::get('provider-list/{id}', 'Proveedor\ProveedorController@edit')->name('provider-list')->middleware('auth');
Route::post('updateprovider', 'Proveedor\ProveedorController@update')->name('updateprovider')->middleware('auth');
Route::get('delete-provider/{id}', 'Proveedor\ProveedorController@destroy')->name('delete-provider')->middleware('auth');
/**RUTAS DE LOS INGRESOS COMPRAS DE LOS PRODUCTOS */
Route::resource('compras/entradas', 'Ingreso\IngresoController')->names('entradas')->middleware('auth');
Route::post('nombrearticuloentrada', 'Ingreso\IngresoController@find_nombre')->name('nombrearticuloentrada')->middleware('auth');
Route::post('temp_datos', 'Ingreso\IngresoController@save_temp')->name('temp_datos')->middleware('auth');
Route::post('showproveedores', 'Ingreso\IngresoController@searh_proveedores')->name('showproveedores')->middleware('auth');
// Route::post('', 'Ingreso\IngresoController@')->name('deleteproduct');
Route::post('deleteproduct', 'Ingreso\IngresoController@delete_prod')->name('deleteproduct')->middleware('auth');
Route::post('showproductostemp', 'Ingreso\IngresoController@show_prod')->name('showproductostemp')->middleware('auth');
Route::post('saveproductoentrada', 'Ingreso\IngresoController@store')->name('saveproductoentrada')->middleware('auth');
Route::get('showlistentradas', 'Ingreso\IngresoController@show')->name('showlistentradas')->middleware('auth');

Route::get('get-entrada/{id}', 'Ingreso\IngresoController@get_products')->name('get-entrada')->middleware('auth');

// Route::get('registro', 'Ingreso\IngresoController@create')->name('entradasproductos');

/**RUTAS DE LOS CLIENTES*/
Route::get('ventas/cliente', 'Cliente\ClienteController@index')->name('cliente')->middleware('auth');
Route::post('/savecliente', 'Cliente\ClienteController@store')->name('savecliente')->middleware('auth');
Route::get('showlistcustomers', [ClienteController::class, 'show'])->name('showlistcustomers')->middleware('auth');
Route::get('/get-data-cliente/{id}',[ClienteController::class, 'get_cliente'])->name('get-data-cliente')->middleware('auth'); 
Route::post('/updatecliente', 'Cliente\ClienteController@update')->name('updatecliente')->middleware('auth');
Route::get('/down-cliente/{id}',[ClienteController::class, 'down_cliente'])->name('down-cliente')->middleware('auth'); 
Route::post('findcustomer', [ClienteController::class, 'findCustomer'])->name('findcustomer')->middleware('auth');

/**RUTAS DEL MODULO DE VENTAS*/
Route::resource('ventas/venta', 'Venta\VentaController')->names('venta')->middleware('auth');
Route::post('findproducto', 'Venta\VentaController@find_product')->name('findproducto')->middleware('auth');
Route::post('saveprodtempvent', 'Venta\VentaController@save_product_temp')->name('saveprodventa')->middleware('auth');
Route::post('showproductosventatemp', 'Venta\VentaController@show_vent_prod_tmp')->name('showproductosventatemp')->middleware('auth');
Route::post('deleteventaproducto', 'Venta\VentaController@delete_venta_product')->name('deleteventaproduct')->middleware('auth');
Route::post('saveformventa', 'Venta\VentaController@store')->name('saveformventa')->middleware('auth');
Route::post('deleteventa', 'Venta\VentaController@delete_venta_general')->name('deleteventaproduct')->middleware('auth');
Route::get('showlistventas', 'Venta\VentaController@show')->name('showlistventas')->middleware('auth');
Route::get('venta-detalle/{id}', 'Venta\VentaController@show_edit')->name('venta-detalle')->middleware('auth');
Route::get('venta-detalle-print/{id}', 'Venta\VentaController@showDetailPrint')->name('venta-detalle-print')->middleware('auth');
//Route::get('ventas/venta', 'Venta\VentaController@index')->name('venta');
Route::get('ventas/print/{id}', 'Venta\VentaController@generateTicketPdf')->name('venta-print')->middleware('auth');

/**DEVOLUCIONES DE UNA VENTA*/
Route::resource('devoluciones/venta', 'Devolucion\DevolucionventaController')->names('devolucion')->middleware('auth');
Route::get('/products_devolucion/{folio}', 'Devolucion\DevolucionventaController@show_devolucion_venta')->name('products_devolucion')->middleware('auth');
Route::post('/savedevolucionproduct', 'Devolucion\DevolucionventaController@store')->name('savedevolucionproduct')->middleware('auth');

/**RUTAS DE CAJA INICIO*/
Route::get('caja/cajainicio', [CajainicioController::class, 'index'])->name('cajainicio')->middleware('auth');
Route::post('/saveapertura', [CajainicioController::class, 'store'])->name('saveapertura')->middleware('auth');

/**HISTORY CAJA */
Route::get('caja/historial', [HistoricocajaController::class, 'index'])->name('cajahistorico')->middleware('auth');
Route::post('caja/showlista', [HistoricocajaController::class, 'store'])->name('cajashowlista')->middleware('auth');
Route::get('caja/showHistoryDetalle/{id}', [HistoricocajaController::class, 'show'])->name('cajashowDetalle')->middleware('auth');

/**RUTAS DE CORTE DE CAJA*/
Route::get('caja/corte', [CortecajaController::class, 'index'])->name('corte')->middleware('auth');
Route::post('/savecortecaja', [CortecajaController::class, 'store'])->name('savecortecaja')->middleware('auth');
Route::get('showlistcortes', [CortecajaController::class, 'show'])->name('showlistcortes')->middleware('auth');

Route::get('caja/corteparcial', [CorteparcialController::class, 'index'])->name('corteparcial')->middleware('auth');
Route::get('showlistcajeros', [CorteparcialController::class, 'show'])->name('showlistcajeros')->middleware('auth');
Route::post('/saveformparcial', [CorteparcialController::class, 'store'])->name('saveformparcial')->middleware('auth');

/**TICKET FOR THE CUTTING OF THE CASHIER'S DAY*/
Route::get('/ticketcorte', [CortecajaController::class, 'ticket'])->name('ticketcorte')->middleware('auth');

/**REPORTS*/
Route::get('/graph', [GraphicsController::class, 'index'])->name('graph')->middleware('auth');
Route::post('/getdatagraph', [GraphicsController::class, 'get_data'])->name('getdatagraph')->middleware('auth');
Route::post('/getmesgraph', [GraphicsController::class, 'get_data_mes'])->name('getmesgraph')->middleware('auth');

/******QUOTES****** */
Route::get('/quote', [QuotesController::class, 'index'])->name('quote.index')->middleware('auth')->middleware('auth');
Route::get('quote/create', [QuotesController::class, 'create'])->name('quote')->middleware('auth')->middleware('auth');
Route::post('nombrearticuloquote', [QuotesController::class, 'find_nombre'])->name('quote.nombrearticuloquote')->middleware('auth');
Route::post('quote/saveProdTemp', [QuotesController::class, 'saveProdTemp'])->name('quote.saveProdTemp')->middleware('auth');
Route::post('quote/updateProdTemp', [QuotesController::class, 'updateProdTemp'])->name('quote.updateProdTemp')->middleware('auth');
Route::post('quote/downProdTemp', [QuotesController::class, 'downProdTemp'])->name('quote.downProdTemp')->middleware('auth');
Route::post('quote/store', [QuotesController::class, 'store'])->name('quote.store')->middleware('auth')->middleware('auth');
Route::get('/quote/print/{id}', [QuotesController::class, 'generatePdf'])->name('printpdf')->middleware('auth');         
Route::post('/quote/cancel', [QuotesController::class, 'cancelQuote'])->name('quote.cancel')->middleware('auth');         
Route::get('showlistquote', [QuotesController::class, 'show'])->name('quote.showlist')->middleware('auth');         
Route::get('/quote/detail/{id}', [QuotesController::class, 'getDetail'])->name('quote.detail')->middleware('auth');         

/**INVENTORY */
Route::get('/inventory', [InventarioController::class, 'index'])->name('inventory');//->middleware('auth');
Route::get('/pdfinventario', [InventarioController::class, 'store'])->name('inventariopdf')->middleware('auth');

/*ROUTE FOR SEND EMAIL */
Route::post('/contact', [TicketController::class, 'sendEmail'])->name('contact')->middleware('auth');

/**ROUTE FOR CONFIGURATION*/
Route::get('/config', [ConfiguracionController::class, 'index'])->name('config')->middleware('auth');
Route::post('/saveconf', [ConfiguracionController::class, 'update'])->name('saveconf')->middleware('auth');