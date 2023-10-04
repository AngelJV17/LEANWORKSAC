<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permisos.index')->only('index');
        $this->middleware('can:permisos.create')->only('create');
        $this->middleware('can:permisos.store')->only('store');
        $this->middleware('can:permisos.show')->only('show');
        $this->middleware('can:permisos.edit')->only('edit');
        $this->middleware('can:permisos.update')->only('update');
        $this->middleware('can:permisos.delete')->only('delete');
    }

    public function index()
    {
        $permisos = Permission::all();
        //$all_roles_in_database = Role::where()->pluck('name');
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'permiso' => 'required|unique:permissions,name',
        ]);

        $permiso = new Permission();

        $permiso->name = $request->input('permiso');
        //Permission::create(['name' => $request->input('permiso')]);
        //dd($request->input('permiso'));
        if ($permiso->save()) {
            Alert::toast('Permiso Registrado', 'success');
            //return view('roles.index');
            return redirect()->route('permisos.index');
        }
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Permission $permission)
    {
        //
    }

    public function update(Request $request, Permission $permission)
    {
        //
    }

    public function destroy(Permission $permission)
    {
        //
    }
}
