<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CategoriaGlobal;
use App\Models\Proyecto;
use App\Models\Usuario;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CajasController extends Controller
{
    public function index()
    {
        //dd($request);
        $proyectos = Proyecto::all();
        //$cajas = Caja::all();
        $cajas = Caja::orderBy('id', 'desc')->get();
        $is_filter = false;

        return view('cajas.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'cajas' => $cajas]);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $tipo_operaciones = CategoriaGlobal::where('categoria_descripcion', 'INGRESOS')
            ->orWhere('categoria_descripcion', 'EGRESOS')
            ->get();
        $responsables = Usuario::whereNot('id', 1)->get();

        //dd($tipo_operaciones);
        return view('cajas.create',  ['proyectos' => $proyectos, 'tipo_operaciones' => $tipo_operaciones, 'responsables' => $responsables]);
    }

    public function prestamoInterno()
    {
        $proyectos = Proyecto::all();
        $responsables = Usuario::whereNot('id', 1)->get();

        return view('cajas.prestamo-interno', ['proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function savePrestamoInterno(Request $request)
    {
        //dd($request);
        $request->validate([
            'proyecto_emisor' => 'required',
            'proyecto_receptor' => 'required',
            'autorizado_por' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $id_proy_emis = $request->input('proyecto_emisor');
        $id_proy_recep = $request->input('proyecto_receptor');

        $proy_emis = Proyecto::find($id_proy_emis);
        $proy_emis = $proy_emis->nombre_proyecto;
        $proy_recep = Proyecto::find($id_proy_recep);
        $proy_recep = $proy_recep->nombre_proyecto;
        //dd($proy_emis.' --- '.$proy_recep);

        //INGRESO PRÉSTAMO
        $caja1 = new Caja();
        $caja1->proyecto_id = $request->input('proyecto_receptor');
        $caja1->operacion = 2; //OPERACION INGRESOS ID
        $caja1->tipo = 6; //TIPO INGRESO ID
        $caja1->subtipo = 9; //SUBTIPO PRÉSTAMO
        $caja1->autorizado_por = $request->input('autorizado_por');
        $caja1->realizado_a_favor = $proy_emis;
        $caja1->monto = $request->input('monto');
        $caja1->descripcion = $request->input('descripcion');
        $caja1->created_at = (new DateTime())->getTimestamp();

        //EGRESO PRÉSTAMO
        $caja2 = new Caja();
        $caja2->proyecto_id = $request->input('proyecto_emisor');
        $caja2->operacion = 3; //OPERACION EGRESOS ID
        $caja2->tipo = 15; //TIPO EGRESO ID
        $caja2->subtipo = 52; //SUBTIPO PRÉSTAMO
        $caja2->autorizado_por = $request->input('autorizado_por');
        $caja2->realizado_a_favor = $proy_recep;
        $caja2->monto = $request->input('monto');
        $caja2->descripcion = $request->input('descripcion');
        $caja2->created_at = (new DateTime())->getTimestamp();

        if ($caja1->save()) {
            if ($caja2->save()) {
                Alert::toast('Préstamo Registrado', 'success', 1500);
                //return view('roles.index');
                return redirect()->route('cajas.index');
            }
        }
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'proyecto_id' => 'required',
            'operacion' => 'required',
            'tipo' => 'required',
            'subtipo' => 'required',
            'autorizado_por' => 'required',
            'realizado_a_favor' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $nom_operacion = CategoriaGlobal::find($request->input('operacion'));
        $nom_operacion = $nom_operacion->categoria_descripcion;

        $caja = new Caja();
        $caja->proyecto_id = $request->input('proyecto_id');
        $caja->operacion = $request->input('operacion');
        $caja->tipo = $request->input('tipo');
        $caja->subtipo = $request->input('subtipo');
        $caja->autorizado_por = $request->input('autorizado_por');
        $caja->realizado_a_favor = $request->input('realizado_a_favor');
        $caja->monto = $request->input('monto');
        $caja->descripcion = $request->input('descripcion');
        $caja->created_at = (new DateTime())->getTimestamp();

        if ($caja->save()) {
            Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Registrado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('cajas.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Caja $caja)
    {
        $proyectos = Proyecto::all();
        $tipo_operaciones = CategoriaGlobal::where('categoria_descripcion', 'INGRESOS')
            ->orWhere('categoria_descripcion', 'EGRESOS')
            ->get();
        $responsables = Usuario::whereNot('id', 1)->get();

        return view('cajas.edit',  ['proyectos' => $proyectos, 'caja' => $caja, 'tipo_operaciones' => $tipo_operaciones, 'responsables' => $responsables]);
    }

    public function update(Request $request, Caja $caja)
    {
        $request->validate([
            'proyecto_id' => 'required',
            'operacion' => 'required',
            'tipo' => 'required',
            'subtipo' => 'required',
            'autorizado_por' => 'required',
            'realizado_a_favor' => 'required',
            'monto' => 'required',
            'descripcion' => 'required',
        ]);

        $nom_operacion = CategoriaGlobal::find($request->input('operacion'));
        $nom_operacion = $nom_operacion->categoria_descripcion;

        $caja = Caja::find($caja->id);
        $caja->proyecto_id = $request->input('proyecto_id');
        $caja->operacion = $request->input('operacion');
        $caja->tipo = $request->input('tipo');
        $caja->subtipo = $request->input('subtipo');
        $caja->autorizado_por = $request->input('autorizado_por');
        $caja->realizado_a_favor = $request->input('realizado_a_favor');
        $caja->monto = $request->input('monto');
        $caja->descripcion = $request->input('descripcion');
        $caja->updated_at = (new DateTime())->getTimestamp();


        if ($caja->save()) {
            Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Actualizado', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('cajas.index');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function totalIngresos($id)
    {

        $total_ingresos = Caja::where('proyecto_id', $id)->where('operacion', 2)->sum('monto');

        return $total_ingresos;
    }

    public function totalEgresos($id)
    {

        $total_egresos = Caja::where('proyecto_id', $id)->where('operacion', 3)->sum('monto');

        return $total_egresos;
    }

    public function filtro(Request $request)
    {
        //dd($request);
        $request->validate([
            'proyecto_id' => 'required',
        ]);

        $proyectos = Proyecto::all();
        $id_proyecto = $request->input('proyecto_id');
        $proyecto_ = Proyecto::find($id_proyecto);
        $cajas = Caja::where('proyecto_id', $id_proyecto)
            ->get();

        $total_ingresos = $this->totalIngresos($id_proyecto);
        $total_egresos = $this->totalEgresos($id_proyecto);
        $is_filter = true;
        //dd($proyecto_);
        return view('cajas.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'proyecto_' => $proyecto_, 'cajas' => $cajas, 'total_ingresos' => $total_ingresos, 'total_egresos' => $total_egresos]);
    }
}
