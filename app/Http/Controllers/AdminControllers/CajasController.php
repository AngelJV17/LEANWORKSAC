<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaChica;
use App\Models\CajaControl;
use App\Models\CategoriaGlobal;
use App\Models\Inversion;
use App\Models\PrestamoInterno;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Viatico;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cajas.index')->only('index');
        $this->middleware('can:cajas.create')->only('create');
        $this->middleware('can:cajas.store')->only('store');
        $this->middleware('can:cajas.show')->only('show');
        $this->middleware('can:cajas.edit')->only('edit');
        $this->middleware('can:cajas.update')->only('update');
        $this->middleware('can:cajas.delete')->only('delete');
    }

    public function index(Request $request)
    {
        if ($request->proyecto != null) {
            $proyectos = Proyecto::all();
            $filtro = $request->proyecto;
            $cajas = Caja::where('proyecto_id', 'LIKE', '%' . $filtro . '%')->get();
            $is_filter = true;
            $total_ingresos = $this->obetenerTotalIngresos($filtro);
            $total_egresos = $this->obetenerTotalEgresos($filtro);
            $saldo = $total_ingresos - $total_egresos;
            //dd($request->proyecto);
            return view('cajas.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'cajas' => $cajas, 'total_ingresos' => $total_ingresos, 'total_egresos' => $total_egresos, 'saldo' => $saldo, 'proyecto_id' => $filtro]);
        } else {
            $proyectos = Proyecto::all();
            //$cajas = Caja::all();
            $cajas = Caja::orderBy('id', 'desc')->get();
            $total_ingresos = Caja::where('operacion', 2)->where('is_prestamo', 0)->sum('monto');
            $total_egresos = Caja::where('operacion', 3)->where('is_prestamo', 0)->sum('monto');
            $saldo = $total_ingresos - $total_egresos;
            $is_filter = false;
            return view('cajas.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'cajas' => $cajas, 'total_ingresos' => $total_ingresos, 'total_egresos' => $total_egresos, 'saldo' => $saldo]);
        }
    }

    public function getAll(){
        $cajas = Caja::all();
        return $cajas;
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $tipo_operaciones = CategoriaGlobal::where('categoria_descripcion', 'INGRESOS')
            ->orWhere('categoria_descripcion', 'EGRESOS')
            ->get();
        $responsables = User::whereNot('id', 1)->get();

        //dd($tipo_operaciones);
        return view('cajas.create',  ['proyectos' => $proyectos, 'tipo_operaciones' => $tipo_operaciones, 'responsables' => $responsables]);
    }

    public function prestamoInterno()
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('cajas.prestamo-interno', ['proyectos' => $proyectos, 'responsables' => $responsables]);
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

        //FECHA DE PAGO
        $fecha_created_at = $request->input('created_at') != null ? $request->input('created_at') : (new DateTime())->getTimestamp();
        //dd($fecha_created_at);

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
            $caja->is_inversion = false;
            $caja->is_caja_chica = false;
            $caja->is_viatico = false;
            $caja->id_control_caja = $control_caja->id;
            $caja->created_at = $fecha_created_at;

            if ($nom_operacion == 'EGRESOS') {
                if (number_format($saldo_total, 2, '.', '') >= number_format($monto_nuevo, 2, '.', '')) {
                    /* $id_caja = Caja::orderBy('id', 'desc')->first();
                dd($id_caja); */

                    if ($caja->save()) {
                        $caja = Caja::orderBy('id', 'desc')->first();
                        Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Registrado', 'success', 1500);

                        return redirect()->route('cajas.show', compact('caja'));
                    }
                } else {
                    Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un registro de EGRESO. Saldo actual: S/. ' . number_format($saldo_total, 2));
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
            return redirect()->route('control-cajas.create');
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
        $responsables = User::whereNot('id', 1)->get();

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

        $monto_nuevo = $request->input('monto');
        $id_proyecto = $request->input('proyecto_id');
        $total_ingresos = $this->obetenerTotalIngresos($id_proyecto);
        $total_egresos = $this->obetenerTotalEgresos($id_proyecto);
        $saldo_total = $total_ingresos - $total_egresos;

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
            $caja->id_control_caja = $control_caja->id;
            $caja->updated_at = (new DateTime())->getTimestamp();

            if (number_format($saldo_total, 2, '.', '') >= number_format($monto_nuevo, 2, '.', '')) {
                /* $id_caja = Caja::orderBy('id', 'desc')->first();
            dd($id_caja); */

                if ($caja->update()) {
                    Alert::toast(ucfirst(strtolower($nom_operacion)) . ' Actualizado', 'success', 1500);

                    return redirect()->route('cajas.index');
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un registro de EGRESO. Saldo actual: S/. ' . number_format($saldo_total, 2));
                return redirect()->route('cajas.create');
            }

        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.index');
        }
    }

    public function destroy(Caja $caja)
    {
        $caja = Caja::find($caja->id);

        $prestamo = $caja->is_prestamo ? 1 : 0;

        $tipo = '';

        if ($caja->is_prestamo) {
            $tipo = 'PRESTAMO';
        } elseif ($caja->is_inversion) {
            $tipo = 'INVERSION';
        } elseif ($caja->is_caja_chica) {
            $tipo = 'CAJA CHICA';
        } elseif ($caja->is_viatico) {
            $tipo = 'VIATICO';
        } else {
            $tipo = 'CAJA';
        }

        //dd($prestamo);

        switch ($tipo) {
            case 'PRESTAMO':
                $cajas_prestamo = Caja::where('id_prestamos_internos', $caja->id_prestamos_internos)->get();
                $prestamo = PrestamoInterno::find($caja->id_prestamos_internos);
                foreach ($cajas_prestamo as $caja) {
                    $caja->delete();
                }
                //dd($prestamo);
                $prestamo->delete();
                Alert::toast('Caja de Registro y Préstamo eliminado', 'success');
                return redirect()->route('cajas.index');
                break;
            case 'INVERSION':
                $inversion = Inversion::find($caja->id_inversiones);
                $inversion->delete();
                Alert::toast('Inversion Eliminada', 'success');
                return redirect()->route('cajas.index');
                break;
            case 'CAJA CHICA':
                $cajaChica = CajaChica::find($caja->id_caja_chica);
                $cajaChica->delete();
                Alert::toast('Caja Chica Eliminada', 'success');
                return redirect()->route('cajas.index');
                break;
            case 'VIATICO':
                $viatico = Viatico::find($caja->id_viaticos);
                $viatico->delete();
                Alert::toast('Viático Eliminado', 'success');
                return redirect()->route('cajas.index');
                break;
            default:
                $caja->delete();
                Alert::toast('Caja de Registro Eliminada', 'success');
                return redirect()->route('cajas.index');
                break;
        }

        /* if ($caja->is_prestamo) {
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
        } */
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
