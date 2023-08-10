<?php

namespace App\Http\Controllers\UtilityControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;

class ListaCategoriasController extends Controller
{
    public function listaCategorias()
    {
        //$categoriaGlobales = CategoriaGlobal::all();
        $categoriaGlobales = CategoriaGlobal::whereNot('categoria_descripcion', 'INVERSIÓN')
            ->whereNot('categoria_descripcion', 'CAJA CHICA')
            ->whereNot('categoria_descripcion', 'VIÁTICOS')
            ->get();
        return $categoriaGlobales;
    }
}
