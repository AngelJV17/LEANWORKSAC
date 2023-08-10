<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;
use App\Models\Departamento;
use App\Models\Proyecto;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProyectosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proyectos.index')->only('index');
        $this->middleware('can:proyectos.create')->only('create');
        $this->middleware('can:proyectos.store')->only('store');
        $this->middleware('can:proyectos.show')->only('show');
        $this->middleware('can:proyectos.edit')->only('edit');
        $this->middleware('can:proyectos.update')->only('update');
        $this->middleware('can:proyectos.delete')->only('delete');

    }

    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        $departamentos = Departamento::all();

        return view('proyectos.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_proyecto' => 'required|unique:proyectos|max:10',
            'nombre_proyecto' => 'required|max:50',
            'monto_proyectado' => 'required|numeric',
            'departamento_select' => 'required',
            'provincias_select' => 'required',
            'distritos_select' => 'required',
        ]);

        $proyecto = new Proyecto();
        $proyecto->codigo_proyecto = $request->input('codigo_proyecto');
        $proyecto->nombre_proyecto = $request->input('nombre_proyecto');
        $proyecto->monto_proyectado = $request->input('monto_proyectado');
        $proyecto->departamento_id = $request->input('departamento_select');
        $proyecto->provincia_id = $request->input('provincias_select');
        $proyecto->distrito_id = $request->input('distritos_select');
        $proyecto->created_at = (new DateTime())->getTimestamp();

        //dd($request->input('departamento_select'));

        if ($proyecto->save()) {
            Alert::toast('Proyecto Registrado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('proyectos.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Proyecto $proyecto)
    {
        $departamentos = Departamento::all();

        return view('proyectos.edit', ['proyecto' => $proyecto, 'departamentos' => $departamentos]);
    }

    public function update(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            //'codigo_proyecto' => 'required|unique:proyectos|max:10',
            'nombre_proyecto' => 'required|max:50',
            'monto_proyectado' => 'required|numeric',
            'departamento_select' => 'required',
            'provincias_select' => 'required',
            'distritos_select' => 'required',
        ]);

        $proyecto = Proyecto::find($proyecto->id);
        $proyecto->codigo_proyecto = $request->input('codigo_proyecto');
        $proyecto->nombre_proyecto = $request->input('nombre_proyecto');
        $proyecto->monto_proyectado = $request->input('monto_proyectado');
        $proyecto->departamento_id = $request->input('departamento_select');
        $proyecto->provincia_id = $request->input('provincias_select');
        $proyecto->distrito_id = $request->input('distritos_select');
        $proyecto->created_at = (new DateTime())->getTimestamp();

        //dd($request->input('departamento_select'));

        if ($proyecto->save()) {
            Alert::toast('Proyecto Actualizado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('proyectos.index');
        }
    }

    public function destroy($id)
    {
        //
    }
}
