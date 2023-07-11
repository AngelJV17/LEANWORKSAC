<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaControl;
use App\Models\CategoriaGlobal;
use App\Models\PrestamoInterno;
use App\Models\Proyecto;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

        $monto_nuevo = $request->input('monto');
        //$id_proyecto = $request->input('proyecto_id');
        $total_ingresos = $this->obetenerTotalIngresos($id_proy_emis);
        $total_egresos = $this->obetenerTotalEgresos($id_proy_emis);
        $monto_total = $total_ingresos - $total_egresos;

        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($monto_total);

        if ($fecha_caja_control == $hoy) {
            if ($monto_total >= $monto_nuevo) {

                //EGRESO PRÉSTAMO
                $caja1 = new Caja();
                $caja1->proyecto_id = $request->input('proyecto_emisor');
                $caja1->operacion = 3; //OPERACION EGRESOS ID
                $caja1->tipo = 15; //TIPO EGRESO ID
                $caja1->subtipo = 52; //SUBTIPO PRÉSTAMO
                $caja1->autorizado_por = $request->input('autorizado_por');
                $caja1->realizado_a_favor = $proy_recep;
                $caja1->monto = $request->input('monto');
                $caja1->descripcion = $request->input('descripcion');
                $caja1->is_prestamo = true;
                //$caja1->proyecto_prestador = $request->input('proyecto_emisor');
                //$caja1->proyecto_acreedor = $request->input('proyecto_receptor');
                $caja1->id_control_caja = $control_caja->id;
                $caja1->created_at = (new DateTime())->getTimestamp();

                //INGRESO PRÉSTAMO
                $caja2 = new Caja();
                $caja2->proyecto_id = $request->input('proyecto_receptor');
                $caja2->operacion = 2; //OPERACION INGRESOS ID
                $caja2->tipo = 6; //TIPO INGRESO ID
                $caja2->subtipo = 9; //SUBTIPO PRÉSTAMO
                $caja2->autorizado_por = $request->input('autorizado_por');
                $caja2->realizado_a_favor = $proy_emis;
                $caja2->monto = $request->input('monto');
                $caja2->descripcion = $request->input('descripcion');
                $caja2->created_at = (new DateTime())->getTimestamp();
                $caja2->is_prestamo = true;
                //$caja2->proyecto_prestador = $request->input('proyecto_emisor');
                //$caja2->proyecto_acreedor = $request->input('proyecto_receptor');
                $caja2->id_control_caja = $control_caja->id;
                $caja2->created_at = (new DateTime())->getTimestamp();

                if ($caja1->save()) {
                    if ($caja2->save()) {
                        Alert::toast('Préstamo Registrado', 'success', 1500);
                        //return view('roles.index');
                        return redirect()->route('cajas.index');
                    }
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un PRESTAMO. Saldo actual: ' . $monto_total);
                return redirect()->route('cajas.prestamo-interno');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.index');
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

        $monto_nuevo = $request->input('monto');
        $id_proyecto = $request->input('proyecto_id');
        $total_ingresos = $this->obetenerTotalIngresos($id_proyecto);
        $total_egresos = $this->obetenerTotalEgresos($id_proyecto);
        $saldo_total = $total_ingresos - $total_egresos;

        $nom_operacion = CategoriaGlobal::find($request->input('operacion'));
        $nom_operacion = $nom_operacion->categoria_descripcion;

        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        if ($fecha_caja_control == $hoy) {

            $caja = new Caja();
            $caja->proyecto_id = $request->input('proyecto_id');
            $caja->operacion = $request->input('operacion');
            $caja->tipo = $request->input('tipo');
            $caja->subtipo = $request->input('subtipo');
            $caja->autorizado_por = $request->input('autorizado_por');
            $caja->realizado_a_favor = $request->input('realizado_a_favor');
            $caja->monto = $request->input('monto');
            $caja->descripcion = $request->input('descripcion');
            $caja->is_prestamo = false;
            $caja->id_control_caja = $control_caja->id;
            $caja->created_at = (new DateTime())->getTimestamp();

            if ($nom_operacion == 'EGRESOS') {
                if ($saldo_total >= $monto_nuevo) {
                    /* $id_caja = Caja::orderBy('id', 'desc')->first();
                dd($id_caja); */

                    if ($caja->save()) {
                        $caja = Caja::orderBy('id', 'desc')->first();
                        Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Registrado', 'success', 1500);

                        return redirect()->route('cajas.show', compact('caja'));
                    }
                } else {
                    Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un registro de EGRESO. Saldo actual: ' . $saldo_total);
                    return redirect()->route('cajas.create');
                }
            } else {
                if ($caja->save()) {
                    $caja = Caja::orderBy('id', 'desc')->first();
                    Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Registrado', 'success', 1500);

                    return redirect()->route('cajas.show', compact('caja'));
                }
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.index');
        }
    }

    public function show(Caja $caja)
    {
        return view('cajas.show',  compact('caja'));
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

        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $fecha_caja = $caja->created_at->format('d-m-Y');

        if ($fecha_caja_control == $fecha_caja) {
            $caja = Caja::find($caja->id);
            $caja->proyecto_id = $request->input('proyecto_id');
            $caja->operacion = $request->input('operacion');
            $caja->tipo = $request->input('tipo');
            $caja->subtipo = $request->input('subtipo');
            $caja->autorizado_por = $request->input('autorizado_por');
            $caja->realizado_a_favor = $request->input('realizado_a_favor');
            $caja->monto = $request->input('monto');
            $caja->descripcion = $request->input('descripcion');
            $caja->is_prestamo = false;
            $caja->id_control_caja = $control_caja->id;
            $caja->updated_at = (new DateTime())->getTimestamp();


            if ($caja->save()) {
                Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Actualizado', 'success', 1500);
                //return view('roles.index');
                return redirect()->route('cajas.index');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.index');
        }
    }

    public function destroy(Caja $caja)
    {
        $caja = Caja::find($caja->id);

        if ($caja->is_prestamo) {
            $cajas_prestamo = Caja::where('id_prestamos_internos', $caja->id_prestamos_internos)->get();
            $prestamo = PrestamoInterno::find($caja->id_prestamos_internos);
            foreach ($cajas_prestamo as $caja) {
                $caja->delete();
            }
            //dd($prestamo);
            $prestamo->delete();
            Alert::toast('Caja de Registro y Préstamo eliminado', 'success');
            return redirect()->route('cajas.index');
        } else {
            //dd($caja);
            $caja->delete();
            Alert::toast('Caja de Registro Eliminada', 'success');
            return redirect()->route('cajas.index');
        }
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

    public function obetenerTotalIngresos($id_proyecto)
    {
        $total_ingresos = Caja::where('proyecto_id', $id_proyecto)->where('operacion', 2)->sum('monto');
        return $total_ingresos;
    }

    public function obetenerTotalEgresos($id_proyecto)
    {
        $total_ingresos = Caja::where('proyecto_id', $id_proyecto)->where('operacion', 3)->sum('monto');
        return $total_ingresos;
    }

    public function generarPdf(Caja $caja)
    {
        //dd($caja->id);
        $caja = Caja::find($caja->id);
        //dd($caja);
        $pdf = Pdf::loadView('cajas.generar-pdf', compact('caja'))->setPaper('a5', 'landscape');
        //Pdf::loadHTML($html)->setPaper('a5', 'landscape')->setWarnings(false)->save('myfile.pdf')
        //return $pdf->stream();
        $operacion = CategoriaGlobal::find($caja->operacion);
        $tipo = CategoriaGlobal::find($caja->tipo);
        $subtipo = CategoriaGlobal::find($caja->subtipo);
        $nombre = $caja->id . '-' . $operacion->categoria_descripcion . '-' . $tipo->categoria_descripcion . '-' . $subtipo->categoria_descripcion;
        return $pdf->download($nombre . '.pdf');
    }
}
