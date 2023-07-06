<?php

namespace App\Http\Controllers\UtilityControllers;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaUbigeosController extends Controller
{

    public function listaDepartamentos()
    {
        //$departamentos = DB::table('ubigeo_peru_departamentos')->get();
        $departamentos = Departamento::all();
        return $departamentos;
    }

    public function listaProvincias()
    {
        //$provincias = DB::table('ubigeo_peru_provincias')->get();
        $provincias = Provincia::all();
        return $provincias;
    }

    public function listaDistritos()
    {
        //$distritos = DB::table('ubigeo_peru_distritos')->get();
        $distritos = Distrito::all();
        return $distritos;
    }
}
