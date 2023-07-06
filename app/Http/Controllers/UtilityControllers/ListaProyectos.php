<?php

namespace App\Http\Controllers\UtilityControllers;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ListaProyectos extends Controller
{
    public function listaProyectos() {
        $proyectos = Proyecto::all();
        return $proyectos;
    }
}
