<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGlobal;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriasGlobalesController extends Controller
{
    public function index()
    {
        //$categorias = CategoriaGlobal::all();
        //$categorias = CategoriaGlobal::with('categoria_padre')->get();

        $categorias = CategoriaGlobal::select('categorias_globales.categoria_descripcion', 'categorias_globales.parent_id', 'categorias_globales.id', 'categorias_globales.modulo', 'p.categoria_descripcion as  categoria_padre')
            ->leftJoin('categorias_globales as p', 'p.id', '=', 'categorias_globales.parent_id')
            ->get();

        //dd($categorias);

        return view('categorias-globales.index', compact('categorias'));
    }

    public function create()
    {
        $categorias = CategoriaGlobal::select('categorias_globales.categoria_descripcion', 'categorias_globales.parent_id', 'categorias_globales.id', 'categorias_globales.modulo', 'p.categoria_descripcion as  categoria_padre')
            ->leftJoin('categorias_globales as p', 'p.id', '=', 'categorias_globales.parent_id')
            ->get();

        //dd($categorias);
        return view('categorias-globales.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_descripcion' => 'required|max:50',
            'modulo' => 'required|max:100',
            /* 'categoria_padre' => 'required', */
        ]);

        $is_categoria_padre = $request->input('is_cat_padre');

        $categoria = new CategoriaGlobal();
        $categoria->parent_id = ($is_categoria_padre == 'SI') ? 0 : $request->input('categoria_padre');
        $categoria->categoria_descripcion = $request->input('categoria_descripcion');
        $categoria->modulo = $request->input('modulo');
        $categoria->is_categoria_padre = ($is_categoria_padre == 'SI') ? true : false;
        $categoria->created_at = (new DateTime())->getTimestamp();

        if ($categoria->save()) {
            Alert::toast('Categoria Registrada', 'success');
            //return view('roles.index');
            return redirect()->route('categorias-globales.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(CategoriaGlobal $categoriaGlobal)
    {
        $categorias = CategoriaGlobal::select('categorias_globales.categoria_descripcion', 'categorias_globales.parent_id', 'categorias_globales.id', 'categorias_globales.modulo', 'p.categoria_descripcion as  categoria_padre')
            ->leftJoin('categorias_globales as p', 'p.id', '=', 'categorias_globales.parent_id')
            ->get();

        //dd($categorias);

        return view('categorias-globales.edit', ['categorias' => $categorias, 'categoriaGlobal' => $categoriaGlobal]);
    }

    public function update(Request $request, CategoriaGlobal $categoriaGlobal)
    {
        //dd($request);
        $request->validate([
            'categoria_descripcion' => 'required|max:50',
            'modulo' => 'required|max:100',
            /* 'categoria_padre' => 'required', */
        ]);

        $is_categoria_padre = $request->input('is_cat_padre');

        $categoriaGlobal = CategoriaGlobal::find($categoriaGlobal->id);
        $categoriaGlobal->parent_id = ($is_categoria_padre == 'SI') ? 0 : $request->input('categoria_padre');
        $categoriaGlobal->categoria_descripcion = $request->input('categoria_descripcion');
        $categoriaGlobal->modulo = $request->input('modulo');
        $categoriaGlobal->is_categoria_padre = ($is_categoria_padre == 'SI') ? true : false;
        $categoriaGlobal->updated_at = (new DateTime())->getTimestamp();

        if ($categoriaGlobal->save()) {
            Alert::toast('Categoria Actualizada', 'success');
            //return view('roles.index');
            return redirect()->route('categorias-globales.index');
        }
    }

    public function destroy(CategoriaGlobal $categoriaGlobal)
    {
        $categoriaGlobal = CategoriaGlobal::find($categoriaGlobal->id);
        //dd($categoriaGlobal);
        $categoriaGlobal->delete();
        Alert::toast('Categoria Eliminada', 'success');
        return redirect()->route('categorias-globales.index');
    }
}
