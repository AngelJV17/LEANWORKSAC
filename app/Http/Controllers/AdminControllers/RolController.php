<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\View\View;



class RolController extends Controller
{
    public function index()
    {
        //$roles = Rol::latest()->paginate(5);
        $roles = Rol::all();
        //$roles = DB::table('roles')->orderBy('nombre')->get();

        //dd($roles);

        return view('roles.index', compact('roles'));

        //return view('roles.index');
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:roles|max:25',
            'descripcion' => 'required|max:100',
            'gestionUsuario' => 'required',
            'gestionRoles' => 'required',
            'gestionProyectos' => 'required',
            'gestionIngresoEgreso' => 'required',
            'getionCategoriasGlobales' => 'required',
        ]);

        $rol = new Rol();
        $rol->nombre = $request->input('nombre');
        $rol->descripcion = $request->input('descripcion');
        $rol->gestion_usuario = $request->input('gestionUsuario');
        $rol->gestion_caja = $request->input('gestionIngresoEgreso');
        $rol->gestion_roles = $request->input('gestionRoles');
        $rol->gestion_proyectos = $request->input('gestionProyectos');
        $rol->gestion_parametros_globales = $request->input('getionCategoriasGlobales');
        $rol->created_at = (new DateTime())->getTimestamp();

        /* if ($request->fails()) {
            //return response()->json();
            $error = $request->messages()->toJson();
        } */

        //dd($rol);

        //$rol->save();

        if ($rol->save()) {
            Alert::toast('Rol Registrado', 'success');
            //return view('roles.index');
            return redirect()->route('roles.index');
        }
    }

    public function show(Rol $rol)
    {
        return view('roles.show',compact('rol'));
    }

    public function edit(Rol $rol)
    {
        //dd($rol);
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            //'nombre' => 'required|max:25|unique:roles,nombre,' . $rol->id,
            'nombre' => 'required|unique:roles|max:25',
            'descripcion' => 'required|max:100',
            'gestionUsuario' => 'required',
            'gestionRoles' => 'required',
            'gestionProyectos' => 'required',
            'gestionIngresoEgreso' => 'required',
            'getionCategoriasGlobales' => 'required',
        ]);

        $rol = Rol::find($rol->id);
        $rol->nombre = $request->input('nombre');
        $rol->descripcion = $request->input('descripcion');
        $rol->gestion_usuario = $request->input('gestionUsuario');
        $rol->gestion_caja = $request->input('gestionIngresoEgreso');
        $rol->gestion_roles = $request->input('gestionRoles');
        $rol->gestion_proyectos = $request->input('gestionProyectos');
        $rol->gestion_parametros_globales = $request->input('getionCategoriasGlobales');
        //$rol->update_at = (new DateTime())->getTimestamp();


        if ($rol->save()) {
            //dd($request->all());
            Alert::toast('Rol Actualizado', 'success');
            //return view('roles.index');
            return redirect()->route('roles.index');
        }
    }

    public function destroy(Rol $rol)
    {
        $rol = Rol::find($rol->id);
        $rol->delete();
        Alert::toast('Rol Eliminado', 'success');
        return redirect()->route('roles.index');
    }
}
