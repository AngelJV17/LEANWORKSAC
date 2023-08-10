<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create');
        $this->middleware('can:roles.store')->only('store');
        $this->middleware('can:roles.show')->only('show');
        $this->middleware('can:roles.edit')->only('edit');
        $this->middleware('can:roles.update')->only('update');
        $this->middleware('can:roles.delete')->only('delete');
    }

    public function index()
    {
        //$roles = Rol::latest()->paginate(5);
        $roles = Role::all();
        $usuarios = User::all();
        //$roles = DB::table('roles')->orderBy('nombre')->get();

        //dd($roles);

        return view('roles.index', ['roles' => $roles, 'usuarios' => $usuarios]);

        //return view('roles.index');
    }

    public function create()
    {
        $permisos = Permission::all();
        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $rol = new Role();

        /* $rol = Role::create(['name' => $request->input('name')]); */
        $rol->name = $request->input('nombre');
        if ($rol->save()) {
            $rol->syncPermissions($request->input('permission'));
            Alert::toast('Rol Registrado', 'success');
            //return view('roles.index');
            return redirect()->route('roles.index');
        }
    }

    public function show(Role $rol)
    {
        return view('roles.show', compact('rol'));
    }

    public function edit(Role $rol)
    {
        /* $permisos = Permission::all();
        return view('roles.edit', compact('rol', 'permisos')); */

        $rol = Role::find($rol->id);
        $permisos = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $rol->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('rol', 'permisos', 'rolePermissions'));
    }

    public function update(Request $request, Role $rol)
    {
        $request->validate([
            'name' => 'required|max:25|unique:roles,name,' . $rol->id,
            //'name' => 'required|unique:roles|max:25',
        ]);

        $permission = $request->input('permission');
        //dd($permission);

        $rol = Role::find($rol->id);


        $rol->givePermissionTo($permission);


        if ($rol->save()) {
            //dd($request->all());
            Alert::toast('Rol Actualizado', 'success');
            //return view('roles.index');
            return redirect()->route('roles.index');
        }
    }

    public function destroy(Role $rol)
    {
        $rol = Role::find($rol->id);
        $rol->delete();
        Alert::toast('Rol Eliminado', 'success');
        return redirect()->route('roles.index');
    }
}
