<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class DevolucionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->proyecto != null || $request->user != null) {
            $id_proyecto = $request->proyecto;
            $id_user = $request->user;
            
            $is_filter = true;

            if ($request->proyecto != null && $request->user != null) {
                $cajas = Caja::where('is_inversion', 1)->orWhere('subtipo', 53)->orderBy('autorizado_por', 'asc')->get()->filter(
                    fn ($caja) => $caja->proyecto_id == $request->proyecto && $caja->autorizado_por == $request->user
                );
            } elseif ($request->proyecto != null) {
                $cajas = Caja::where('is_inversion', 1)->orWhere('subtipo', 53)->orderBy('autorizado_por', 'asc')->get()->filter(
                    fn ($caja) => $caja->proyecto_id == $request->proyecto
                );
            } else {
                $cajas = Caja::where('is_inversion', 1)->orWhere('subtipo', 53)->orderBy('autorizado_por', 'asc')->get()->filter(
                    fn ($caja) => $caja->autorizado_por == $request->user
                );
            }

            $is_empty = $cajas->count() == 0 || $cajas == '' ? true : false;
            $proyectos = Proyecto::all();
            //$users = User::whereNot('id',1)->get();
            $users = User::with('roles')->get()->filter(
                fn ($user) => $user->roles->whereNotIn('name', ['Super Admin', 'Asistente Administrativo'])->toArray()
            );
            //dd($superAdminCount);
            return view('devoluciones.index', compact('is_filter', 'cajas', 'is_empty', 'proyectos', 'users', 'id_proyecto', 'id_user'));
        } else {
            $cajas = Caja::where('is_inversion', 1)->orWhere('subtipo', 53)->orderBy('autorizado_por', 'asc')->orderBy('id', 'asc')->get();

            $is_filter = false;
            $is_empty = $cajas->count() == 0 || $cajas == '' ? true : false;
            $proyectos = Proyecto::all();
            //$users = User::whereNot('id',1)->get();
            $users = User::with('roles')->get()->filter(
                fn ($user) => $user->roles->whereNotIn('name', ['Super Admin', 'Asistente Administrativo'])->toArray()
            );
            //dd($superAdminCount);
            return view('devoluciones.index', compact('is_filter', 'cajas', 'is_empty', 'proyectos', 'users'));
        }
    }
}
