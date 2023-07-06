<?php

namespace App\Http\Controllers\UtilityControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;

class ListaCategoriasController extends Controller
{
    public function listaCategorias()
    {
        $categoriaGlobales = CategoriaGlobal::all();
        return $categoriaGlobales;
    }
}
