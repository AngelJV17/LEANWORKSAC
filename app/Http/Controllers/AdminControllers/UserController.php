<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;
use App\Models\Rol;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usuarios.index')->only('index');
        $this->middleware('can:usuarios.create')->only('create');
        $this->middleware('can:usuarios.store')->only('store');
        $this->middleware('can:usuarios.show')->only('show');
        $this->middleware('can:usuarios.edit')->only('edit');
        $this->middleware('can:usuarios.update')->only('update');
        $this->middleware('can:usuarios.delete')->only('delete');
    }

    public function index()
    {
        $usuarios = User::whereNot('id', 1)->get();
        //dd($usuarios);
        //$usuarios = User::orderBy('nombres', 'asc')->get();
        //$usuarios = Usuario::all();

        //return view('usuarios.index', ['usuarios' => $usuarios]);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        /* $sexos = DB::table('parametros_globales')
            ->select('id', 'categoria_hijo')
            ->where('categoria_padre', 'SEXO')
            ->whereNotNull('categoria_hijo')
            ->get(); */

        $sexos = CategoriaGlobal::where('parent_id', 1)
            ->get();

        //dd($sexos);
        return view('usuarios.create', ['roles' => $roles, 'sexos' => $sexos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            //'codigo' => 'required|unique:usuarios|max:10',
            'dni_ce' => 'required|unique:users|numeric',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:100',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required',
            'celular' => 'required|numeric',
            'direccion' => 'required|max:100',
            'email' => 'required|unique:users|email',
            'rol' => 'required',
        ]);

        $apellidos = $request->input('apellidos');
        $separadas = explode(" ", $apellidos);
        $iniciales = "";
        foreach ($separadas as $primera) {
            $iniciales .= substr($primera, 0, 1);
        }

        //dd($request->input('dni_ce') . $iniciales);

        $usuario = new User();
        $usuario->codigo = $request->input('dni_ce') . $iniciales;
        $usuario->dni_ce = $request->input('dni_ce');
        //$usuario->foto = $request->input('foto');
        $usuario->nombres = $request->input('nombres');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->sexo = $request->input('sexo');
        $usuario->celular = $request->input('celular');
        $usuario->direccion = $request->input('direccion');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('dni_ce') . $iniciales);
        $usuario->estado = true;
        $usuario->created_at = (new DateTime())->getTimestamp();

        if ($usuario->save()) {
            $usuario->assignRole($request->input('rol'));
            Alert::toast('Usuario Registrado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('usuarios.index');
        }
    }

    public function show(User $usuario)
    {

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $roles = Rol::all();
        /* $sexos = DB::table('parametros_globales')
            ->select('id', 'categoria_hijo')
            ->where('categoria_padre', 'SEXO')
            ->whereNotNull('categoria_hijo')
            ->get(); */

        $sexos = CategoriaGlobal::where('parent_id', 1)
            ->get();
        //dd($sexos);
        return view('usuarios.edit', ['usuario' => $usuario, 'roles' => $roles, 'sexos' => $sexos]);


        //return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        //dd($request);
        /* $request->validate([
            //'codigo' => 'required|unique:usuarios|max:10',
            //'dni_ce' => 'required|numeric|unique:usuarios,dni_ce,'.$this->$usuario->id,
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:100',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric',
            'direccion' => 'required|max:100',
            'correo' => 'required|email|unique:usuarios',
            'rol' => 'required',
        ]); */

        $apellidos = $request->input('apellidos');
        $separadas = explode(" ", $apellidos);
        $iniciales = "";
        foreach ($separadas as $primera) {
            $iniciales .= substr($primera, 0, 1);
        }


        $usuario = User::find($usuario->id);
        $usuario->codigo = $request->input('dni_ce') . $iniciales;
        $usuario->dni_ce = $request->input('dni_ce');
        //$usuario->foto = $request->input('foto');
        $usuario->nombres = $request->input('nombres');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->sexo = $request->input('sexo');
        $usuario->celular = $request->input('celular');
        $usuario->direccion = $request->input('direccion');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('dni_ce') . $iniciales);
        $usuario->estado = $request->input('estado');
        $usuario->updated_at = (new DateTime())->getTimestamp();

        if ($usuario->update()) {
            $usuario->roles()->detach();
            $usuario->assignRole($request->input('rol'));
            Alert::toast('Usuario Actualizado', 'success');
            //return view('roles.index');
            return redirect()->route('usuarios.index');
        }
    }

    public function destroy(User $usuario)
    {
        $usuario = User::find($usuario->id);
        $usuario->estado = false;
        $usuario->update();
        Alert::toast('Usuario Eliminado', 'success');
        return redirect()->route('usuarios.index');
    }
}
