<?php

use App\Http\Controllers\Admin\PermisosController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\AdminControllers\CajaChicaController;
use App\Http\Controllers\AdminControllers\CajasController;
use App\Http\Controllers\AdminControllers\CategoriasGlobalesController;
use App\Http\Controllers\AdminControllers\ControlCajasController;
use App\Http\Controllers\AdminControllers\InversionesController;
use App\Http\Controllers\AdminControllers\PrestamosInternosController;
use App\Http\Controllers\AdminControllers\ProyectosController;
use App\Http\Controllers\AdminControllers\RolController;
use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\AdminControllers\ViaticosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtilityControllers\ListaCategoriasController;
use App\Http\Controllers\UtilityControllers\ListaProyectos;
use App\Http\Controllers\UtilityControllers\ListaUbigeosController;
use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('index');
});
 */


Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/indicadores', [HomeController::class, 'index'])->name('indicadores');

    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RolController::class, 'create'])->name('roles.create');
    Route::post('roles', [RolController::class, 'store'])->name('roles.store');
    Route::get('roles/{rol}', [RolController::class, 'show'])->name('roles.show');
    Route::get('roles/{rol}/edit', [RolController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{rol}', [RolController::class, 'update'])->name('roles.update');
    Route::delete('roles/{rol}', [RolController::class, 'destroy'])->name('roles.delete');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.delete');

    Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');
    Route::get('proyectos/create', [ProyectosController::class, 'create'])->name('proyectos.create');
    Route::post('proyectos', [ProyectosController::class, 'store'])->name('proyectos.store');
    Route::get('proyectos/{proyecto}', [ProyectosController::class, 'show'])->name('proyectos.show');
    Route::get('proyectos/{proyecto}/edit', [ProyectosController::class, 'edit'])->name('proyectos.edit');
    Route::put('proyectos/{proyecto}', [ProyectosController::class, 'update'])->name('proyectos.update');
    Route::delete('proyectos/{proyecto}', [ProyectosController::class, 'destroy'])->name('proyectos.delete');

    Route::get('/categorias-globales', [CategoriasGlobalesController::class, 'index'])->name('categorias-globales.index');
    Route::get('categorias-globales/create', [CategoriasGlobalesController::class, 'create'])->name('categorias-globales.create');
    Route::post('categorias-globales', [CategoriasGlobalesController::class, 'store'])->name('categorias-globales.store');
    Route::get('categorias-globales/{categoriaGlobal}', [CategoriasGlobalesController::class, 'show'])->name('categorias-globales.show');
    Route::get('categorias-globales/{categoriaGlobal}/edit', [CategoriasGlobalesController::class, 'edit'])->name('categorias-globales.edit');
    Route::put('categorias-globales/{categoriaGlobal}', [CategoriasGlobalesController::class, 'update'])->name('categorias-globales.update');
    Route::delete('categorias-globales/{categoriaGlobal}', [CategoriasGlobalesController::class, 'destroy'])->name('categorias-globales.delete');

    //PDF
    Route::get('cajas/generar-pdf/{caja}', [CajasController::class, 'generarPdf'])->name('cajas.generar-pdf');
    Route::get('/cajas', [CajasController::class, 'index'])->name('cajas.index');
    Route::get('cajas/create', [CajasController::class, 'create'])->name('cajas.create');
    Route::post('cajas', [CajasController::class, 'store'])->name('cajas.store');
    Route::get('cajas/{caja}', [CajasController::class, 'show'])->name('cajas.show');
    Route::get('cajas/{caja}/edit', [CajasController::class, 'edit'])->name('cajas.edit');
    Route::put('cajas/{caja}', [CajasController::class, 'update'])->name('cajas.update');
    Route::delete('cajas/{caja}', [CajasController::class, 'destroy'])->name('cajas.delete');

    Route::get('/control-cajas', [ControlCajasController::class, 'index'])->name('control-cajas.index');
    Route::get('control-cajas/create', [ControlCajasController::class, 'create'])->name('control-cajas.create');
    Route::post('control-cajas', [ControlCajasController::class, 'store'])->name('control-cajas.store');
    Route::get('control-cajas/{cajaControl}', [ControlCajasController::class, 'show'])->name('control-cajas.show');
    Route::get('control-cajas/{cajaControl}/edit', [ControlCajasController::class, 'edit'])->name('control-cajas.edit');
    Route::put('control-cajas/{cajaControl}', [ControlCajasController::class, 'update'])->name('control-cajas.update');
    Route::delete('control-cajas/{cajaControl}', [ControlCajasController::class, 'destroy'])->name('control-cajas.delete');

    Route::get('/prestamos-internos', [PrestamosInternosController::class, 'index'])->name('prestamos-internos.index');
    Route::get('prestamos-internos/create', [PrestamosInternosController::class, 'create'])->name('prestamos-internos.create');
    Route::post('prestamos-internos', [PrestamosInternosController::class, 'store'])->name('prestamos-internos.store');
    Route::get('prestamos-internos/{prestamoInterno}', [PrestamosInternosController::class, 'show'])->name('prestamos-internos.show');
    Route::get('prestamos-internos/{prestamoInterno}/edit', [PrestamosInternosController::class, 'edit'])->name('prestamos-internos.edit');
    Route::put('prestamos-internos/{prestamoInterno}', [PrestamosInternosController::class, 'update'])->name('prestamos-internos.update');
    Route::delete('prestamos-internos/{prestamoInterno}', [PrestamosInternosController::class, 'destroy'])->name('prestamos-internos.delete');

    Route::get('/inversiones', [InversionesController::class, 'index'])->name('inversiones.index');
    Route::get('inversiones/create', [InversionesController::class, 'create'])->name('inversiones.create');
    Route::post('inversiones', [InversionesController::class, 'store'])->name('inversiones.store');
    Route::get('inversiones/{inversion}', [InversionesController::class, 'show'])->name('inversiones.show');
    Route::get('inversiones/{inversion}/edit', [InversionesController::class, 'edit'])->name('inversiones.edit');
    Route::put('inversiones/{inversion}', [InversionesController::class, 'update'])->name('inversiones.update');
    Route::delete('inversiones/{inversion}', [InversionesController::class, 'destroy'])->name('inversiones.delete');

    Route::get('/caja-chica', [CajaChicaController::class, 'index'])->name('caja-chica.index');
    Route::get('caja-chica/create', [CajaChicaController::class, 'create'])->name('caja-chica.create');
    Route::post('caja-chica', [CajaChicaController::class, 'store'])->name('caja-chica.store');
    Route::get('caja-chica/{cajaChica}', [CajaChicaController::class, 'show'])->name('caja-chica.show');
    Route::get('caja-chica/{cajaChica}/edit', [CajaChicaController::class, 'edit'])->name('caja-chica.edit');
    Route::put('caja-chica/{cajaChica}', [CajaChicaController::class, 'update'])->name('caja-chica.update');
    Route::delete('caja-chica/{cajaChica}', [CajaChicaController::class, 'destroy'])->name('caja-chica.delete');
    Route::get('caja-chica/{cajaChica}/sustentar', [CajaChicaController::class, 'sustentar'])->name('caja-chica.sustentar');

    Route::get('/viaticos', [ViaticosController::class, 'index'])->name('viaticos.index');
    Route::get('viaticos/create', [ViaticosController::class, 'create'])->name('viaticos.create');
    Route::post('viaticos', [ViaticosController::class, 'store'])->name('viaticos.store');
    Route::get('viaticos/{viatico}', [ViaticosController::class, 'show'])->name('viaticos.show');
    Route::get('viaticos/{viatico}/edit', [ViaticosController::class, 'edit'])->name('viaticos.edit');
    Route::put('viaticos/{viatico}', [ViaticosController::class, 'update'])->name('viaticos.update');
    Route::delete('viaticos/{viatico}', [ViaticosController::class, 'destroy'])->name('viaticos.delete');
    Route::get('viaticos/{viatico}/sustentar', [ViaticosController::class, 'sustentar'])->name('viaticos.sustentar');

    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::post('reportes/filtro', [ReportesController::class, 'reportResult'])->name('reportes.filtro');
    //PDF
    Route::get('reportes/pdf', [ReportesController::class, 'generarPdf'])->name('reportes.pdf');

    
    Route::get('/permisos', [PermisosController::class, 'index'])->name('permisos.index');
    Route::get('permisos/create', [PermisosController::class, 'create'])->name('permisos.create');
    Route::post('permisos', [PermisosController::class, 'store'])->name('permisos.store');

    //DEPARTAMENTOS - PROVINCIAS Y DISTRITOS
    //Route::get('proyectos/lista/departamentos', [ListaUbigeosController::class, 'listaDepartamentos'])->name('lista.departamentos');
    Route::get('lista-provincias', [ListaUbigeosController::class, 'listaProvincias'])->name('lista-provincias')->middleware('can:lista-provincias');
    Route::get('lista-distritos', [ListaUbigeosController::class, 'listaDistritos'])->name('lista-distritos')->middleware('can:lista-distritos');


    //CATEGORIAS GLOBALES
    Route::get('lista-categorias-globales', [ListaCategoriasController::class, 'listaCategorias'])->name('lista-categorias-globales')->middleware('can:lista-categorias-globales');
    //Route::post('cajas/filtro', [CajasController::class, 'filtro'])->name('cajas.filtro');

    //PROYECTOS
    Route::get('lista-proyectos', [ListaProyectos::class, 'listaProyectos'])->name('lista-proyectos')->middleware('can:lista-proyectos');

    //CAJAS
    Route::get('cajas-all', [CajasController::class, 'getAll'])->name('cajas-all');
});
