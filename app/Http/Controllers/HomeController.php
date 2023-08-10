<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

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
        return view('home.index', compact('proyectos'));
    }
}
