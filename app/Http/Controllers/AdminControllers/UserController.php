<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;
use App\Models\ParametrosGlobales;
use App\Models\Rol;
use App\Models\Usuario;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Termwind\Components\Dd;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();

        //return view('usuarios.index', ['usuarios' => $usuarios]);

        return view('usuarios.index', compact('usuarios'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
            'dni_ce' => 'required|numeric|unique:usuarios|digits:8',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:100',
            'sexo' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric|digits:9',
            'direccion' => 'required|max:100',
            'correo' => 'required|unique:usuarios|email',
            'rol' => 'required',
        ]);

        $apellidos = $request->input('apellidos');
        $separadas = explode(" ", $apellidos);
        $iniciales = "";
        foreach ($separadas as $primera) {
            $iniciales .= substr($primera, 0, 1);
        }

        //dd($request->input('dni_ce') . $iniciales);

        $usuario = new Usuario();
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
        $usuario->password = Crypt::encryptString($request->input('codigo'));
        $usuario->rol_id = $request->input('rol');
        $usuario->created_at = (new DateTime())->getTimestamp();

        if ($usuario->save()) {
            Alert::toast('Usuario Registrado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('usuarios.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Usuario $usuario)
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

    public function update(Request $request, Usuario $usuario)
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

        $usuario = Usuario::find($usuario->id);
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
        $usuario->rol_id = $request->input('rol');
        $usuario->updated_at = (new DateTime())->getTimestamp();

        if ($usuario->save()) {
            //dd($request->all());
            Alert::toast('Usuario Actualizado', 'success');
            //return view('roles.index');
            return redirect()->route('usuarios.index');
        }
    }

    public function destroy($id)
    {
        //
    }
}
