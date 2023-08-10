<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaControl;
use App\Models\PrestamoInterno;
use App\Models\Proyecto;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PrestamosInternosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:prestamos-internos.index')->only('index');
        $this->middleware('can:prestamos-internos.create')->only('create');
        $this->middleware('can:prestamos-internos.store')->only('store');
        $this->middleware('can:prestamos-internos.show')->only('show');
        $this->middleware('can:prestamos-internos.edit')->only('edit');
        $this->middleware('can:prestamos-internos.update')->only('update');
        $this->middleware('can:prestamos-internos.delete')->only('delete');

    }

    public function index()
    {
        //
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('prestamos-internos.create', ['proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function store(Request $request)
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

            $prestamoInterno = new PrestamoInterno();
            $prestamoInterno->proyecto_prestador = $request->input('proyecto_emisor');
            $prestamoInterno->proyecto_acreedor = $request->input('proyecto_receptor');
            $prestamoInterno->autorizado_por = $request->input('autorizado_por');
            $prestamoInterno->monto = $request->input('monto');
            $prestamoInterno->descripcion = $request->input('descripcion');
            $prestamoInterno->created_at = (new DateTime())->getTimestamp();

            if ($monto_total >= $monto_nuevo) {
                if ($prestamoInterno->save()) {
                    $prestamo_interno = PrestamoInterno::orderBy('id', 'desc')->first();

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
                    $caja1->is_inversion = false;
                    $caja1->is_caja_chica = false;
                    $caja1->is_viatico = false;
                    //$caja1->proyecto_prestador = $request->input('proyecto_emisor');
                    //$caja1->proyecto_acreedor = $request->input('proyecto_receptor');
                    $caja1->id_prestamos_internos = $prestamo_interno->id;
                    $caja1->id_control_caja = $control_caja->id;
                    $caja1->created_at = (new DateTime())->getTimestamp();

                    //INGRESO PRÉSTAMO
                    $caja2 = new Caja();
                    $caja2->proyecto_id = $request->input('proyecto_receptor');
                    $caja2->operacion = 2; //OPERACION INGRESOS ID
                    $caja2->tipo = 6; //TIPO INGRESO ID
                    $caja2->subtipo = 9; //SUBTIPO PRÉSTAMO
                    $caja2->autorizado_por = $request->input('autorizado_por');
                    $caja2->realizado_a_favor = $proy_recep;
                    $caja2->monto = $request->input('monto');
                    $caja2->descripcion = $request->input('descripcion');
                    $caja2->is_prestamo = true;
                    $caja2->is_inversion = false;
                    $caja2->is_caja_chica = false;
                    $caja2->is_viatico = false;
                    //$caja2->proyecto_prestador = $request->input('proyecto_emisor');
                    //$caja2->proyecto_acreedor = $request->input('proyecto_receptor');
                    $caja2->id_prestamos_internos = $prestamo_interno->id;
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
                    Alert::error('Lo sentimos', 'Ocurrio un error.');
                    return redirect()->route('prestamos-internos.create');
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un PRESTAMO. Saldo actual: S/. ' . number_format($monto_total, 2));
                return redirect()->route('prestamos-internos.create');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.create');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(PrestamoInterno $prestamoInterno)
    {
        //$prestamoInterno = PrestamoInterno::find($id);
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('prestamos-internos.edit', ['prestamoInterno' => $prestamoInterno, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function update(Request $request, PrestamoInterno $prestamoInterno)
    {
        $request->validate([
            'proyecto_emisor' => 'required',
            'proyecto_receptor' => 'required',
            'autorizado_por' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $cajas = Caja::where('id_prestamos_internos', $prestamoInterno->id)->get();

        //dd($cajas);

        foreach ($cajas as $caja) {
            if ($prestamoInterno != null) {
                $caja->delete();
            }
        }

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

        //dd($request);

        if ($fecha_caja_control == $hoy) {

            $prestamoInterno = PrestamoInterno::find($prestamoInterno->id);
            $prestamoInterno->proyecto_prestador = $request->input('proyecto_emisor');
            $prestamoInterno->proyecto_acreedor = $request->input('proyecto_receptor');
            $prestamoInterno->autorizado_por = $request->input('autorizado_por');
            $prestamoInterno->monto = $request->input('monto');
            $prestamoInterno->descripcion = $request->input('descripcion');
            $prestamoInterno->updated_at = (new DateTime())->getTimestamp();

            if ($monto_total >= $monto_nuevo) {
                if ($prestamoInterno->save()) {
                    $prestamo_interno = PrestamoInterno::orderBy('id', 'desc')->first();

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
                    $caja1->id_prestamos_internos = $prestamo_interno->id;
                    $caja1->id_control_caja = $control_caja->id;
                    $caja1->created_at = (new DateTime())->getTimestamp();

                    //INGRESO PRÉSTAMO
                    $caja2 = new Caja();
                    $caja2->proyecto_id = $request->input('proyecto_receptor');
                    $caja2->operacion = 2; //OPERACION INGRESOS ID
                    $caja2->tipo = 6; //TIPO INGRESO ID
                    $caja2->subtipo = 9; //SUBTIPO PRÉSTAMO
                    $caja2->autorizado_por = $request->input('autorizado_por');
                    $caja2->realizado_a_favor = $proy_recep;
                    $caja2->monto = $request->input('monto');
                    $caja2->descripcion = $request->input('descripcion');
                    $caja2->is_prestamo = true;
                    //$caja2->proyecto_prestador = $request->input('proyecto_emisor');
                    //$caja2->proyecto_acreedor = $request->input('proyecto_receptor');
                    $caja2->id_prestamos_internos = $prestamo_interno->id;
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
                    Alert::error('Lo sentimos', 'Ocurrio un error.');
                    return redirect()->route('prestamos-internos.create');
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para realizar un PRESTAMO. Saldo actual: S/. ' . number_format($monto_total, 2));
                return redirect()->route('prestamos-internos.create');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.index');
        }
    }

    public function destroy(PrestamoInterno $prestamoInterno)
    {
        $prestamoInterno = PrestamoInterno::find($prestamoInterno->id);
        $prestamoInterno->delete();
        Alert::toast('Prestamo Interno Eliminado', 'success');

        return redirect()->route('prestamos-internos.index');
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
}
