<?php

use App\Http\Controllers\AdminControllers\CajasController;
use App\Http\Controllers\AdminControllers\CategoriasGlobalesController;
use App\Http\Controllers\AdminControllers\ParametrosGlobalesController;
use App\Http\Controllers\AdminControllers\ProyectosController;
use App\Http\Controllers\AdminControllers\RolController;
use App\Http\Controllers\AdminControllers\UserController;
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



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/indicadores', [HomeController::class, 'index'])->name('home');

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

Route::get('/parametros-globales', [ParametrosGlobalesController::class, 'index'])->name('parametros-globales.index');
Route::get('parametros-globales/subcategoria', [ParametrosGlobalesController::class, 'subcategoria'])->name('parametros-globales.subcategoria');
Route::get('parametros-globales/create', [ParametrosGlobalesController::class, 'create'])->name('parametros-globales.create');
Route::post('parametros-globales', [ParametrosGlobalesController::class, 'store'])->name('parametros-globales.store');
Route::post('parametros-globales/subcategoria', [ParametrosGlobalesController::class, 'subCategoriaStore'])->name('parametros-globales.subCategoriaStore');
Route::get('parametros-globales/{parametroGlobal}', [ParametrosGlobalesController::class, 'show'])->name('parametros-globales.show');
Route::get('parametros-globales/{parametroGlobal}/edit', [ParametrosGlobalesController::class, 'edit'])->name('parametros-globales.edit');
Route::put('parametros-globales/{parametroGlobal}', [ParametrosGlobalesController::class, 'update'])->name('parametros-globales.update');
Route::delete('parametros-globales/{parametroGlobal}', [ParametrosGlobalesController::class, 'destroy'])->name('parametros-globales.delete');


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


Route::get('/cajas', [CajasController::class, 'index'])->name('cajas.index');
Route::get('caja/prestamo-interno', [CajasController::class, 'prestamoInterno'])->name('cajas.prestamo-interno');
Route::post('caja/savePrestamoInterno', [CajasController::class, 'savePrestamoInterno'])->name('cajas.savePrestamoInterno');
Route::get('cajas/create', [CajasController::class, 'create'])->name('cajas.create');
Route::post('cajas', [CajasController::class, 'store'])->name('cajas.store');
Route::get('cajas/{caja}', [CajasController::class, 'show'])->name('cajas.show');
Route::get('cajas/{caja}/edit', [CajasController::class, 'edit'])->name('cajas.edit');
Route::put('cajas/{caja}', [CajasController::class, 'update'])->name('cajas.update');
Route::delete('cajas/{caja}', [CajasController::class, 'destroy'])->name('cajas.delete');


//DEPARTAMENTOS - PROVINCIAS Y DISTRITOS
//Route::get('proyectos/lista/departamentos', [ListaUbigeosController::class, 'listaDepartamentos'])->name('lista.departamentos');
Route::get('lista-provincias', [ListaUbigeosController::class, 'listaProvincias'])->name('lista-provincias');
Route::get('lista-distritos', [ListaUbigeosController::class, 'listaDistritos'])->name('lista-distritos');


//CATEGORIAS GLOBALES
Route::get('lista-categorias-globales', [ListaCategoriasController::class, 'listaCategorias'])->name('lista-categorias-globales');
//Route::post('cajas/filtro', [CajasController::class, 'filtro'])->name('cajas.filtro');

//PROYECTOS
Route::get('lista-proyectos', [ListaProyectos::class, 'listaProyectos'])->name('lista-proyectos');