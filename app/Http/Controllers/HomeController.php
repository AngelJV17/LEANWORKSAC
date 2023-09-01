<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Proyecto;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:indicadores')->only('index');
    }

    public function index()
    {
        $proyectos = Proyecto::all();

        $inicioMes = Carbon::now()->startOfMonth();

        $inicioFormateado = $inicioMes->format('d/m/Y');

        $ingresos_mes = Caja::where('operacion', 2)->where('created_at', '>=', $inicioFormateado)->sum('monto');
        $egresos_mes = Caja::where('operacion', 3)->where('created_at', '>=', $inicioFormateado)->sum('monto');

        //dd($chart);

        //dd($inicioFormateado);
        return view('home.index', ['proyectos' => $proyectos, 'total_ingresos' => $ingresos_mes, 'total_egresos' => $egresos_mes]);
    }
}
