<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaControl;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Viatico;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ViaticosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:viaticos.index')->only('index');
        $this->middleware('can:viaticos.create')->only('create');
        $this->middleware('can:viaticos.store')->only('store');
        $this->middleware('can:viaticos.show')->only('show');
        $this->middleware('can:viaticos.edit')->only('edit');
        $this->middleware('can:viaticos.update')->only('update');
        $this->middleware('can:viaticos.delete')->only('delete');
    }

    public function index()
    {
        $viaticos = Viatico::all();
        return view('viaticos.index', compact('viaticos'));
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('viaticos.create', ['proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proyecto' => 'required',
            'autorizado_por' => 'required',
            'responsable' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        $responsable = User::find($request->input('responsable'));
        //dd($responsable);

        $monto_nuevo = $request->input('monto');
        $id_proyecto = $request->input('proyecto');
        $total_ingresos = $this->obetenerTotalIngresos($id_proyecto);
        $total_egresos = $this->obetenerTotalEgresos($id_proyecto);
        $saldo_total = $total_ingresos - $total_egresos;

        if ($fecha_caja_control == $hoy && $control_caja->is_abierto) {

            if (number_format($saldo_total, 2, '.', '') >= number_format($monto_nuevo, 2, '.', '')) {
                $viatico = new Viatico();
                $viatico->proyecto_id = $request->input('proyecto');
                $viatico->responsable_id = $request->input('responsable');
                $viatico->autorizado_por = $request->input('autorizado_por');
                $viatico->monto = $request->input('monto');
                $viatico->descripcion = $request->input('descripcion');
                $viatico->created_at = (new DateTime())->getTimestamp();

                if ($viatico->save()) {
                    $getViatico = Viatico::orderBy('id', 'desc')->first();

                    //INGRESO PRÉSTAMO
                    $caja = new Caja();
                    $caja->proyecto_id = $request->input('proyecto');
                    $caja->operacion = 3; //OPERACION EGRESO ID
                    $caja->tipo = 13; //TIPO OFICINA ID
                    $caja->subtipo = 41; //SUBTIPO VIATICO
                    $caja->autorizado_por = $request->input('autorizado_por');
                    $caja->realizado_a_favor = $responsable->nombres . ' ' . $responsable->apellidos;
                    $caja->monto = $request->input('monto');
                    $caja->descripcion = $request->input('descripcion');
                    $caja->is_prestamo = false;
                    $caja->is_inversion = false;
                    $caja->is_caja_chica = false;
                    $caja->is_viatico = true;
                    $caja->id_viaticos = $getViatico->id;
                    $caja->id_control_caja = $control_caja->id;
                    $caja->created_at = (new DateTime())->getTimestamp();

                    if ($caja->save()) {
                        Alert::toast('Viático Registrado', 'success', 1500);
                        //return view('roles.index');
                        return redirect()->route('viaticos.index');
                    }
                } else {
                    Alert::error('Lo sentimos', 'Ocurrio un error.');
                    return redirect()->route('viaticos.create');
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para los VIÁTICOS. Saldo actual: S/. ' . number_format($saldo_total, 2));
                return redirect()->route('viaticos.create');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.create');
        }
    }

    public function show(Viatico $viatico)
    {
        $caja = Caja::where('id_viaticos', $viatico->id)->first();
        //dd($caja);
        return view('viaticos.show',  ['caja' => $caja, "sustentado" => $viatico->sustentado]);
    }

    public function edit(Viatico $viatico)
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('viaticos.edit', ['viatico' => $viatico, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function sustentar(Viatico $viatico)
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('viaticos.sustentar', ['viatico' => $viatico, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function update(Request $request, Viatico $viatico)
    {
        $is_sustentar = $request->input('sustentar');

        if ($is_sustentar) {
            $request->validate([
                'descripcion' => 'required',
            ]);
        } else {
            $request->validate([
                'proyecto' => 'required',
                'autorizado_por' => 'required',
                'responsable' => 'required',
                'monto' => 'required|numeric',
                'descripcion' => 'required',
            ]);
        }

        $responsable = User::find($request->input('responsable'));


        $caja = Caja::where('id_viaticos', $viatico->id)->first();

        $control_caja = CajaControl::where('id', $caja->id_control_caja)->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        $monto_nuevo = $request->input('monto');
        $id_proyecto = $request->input('proyecto');
        $total_ingresos = $this->obetenerTotalIngresos($id_proyecto);
        $total_egresos = $this->obetenerTotalEgresos($id_proyecto);
        $saldo_total = $total_ingresos - $total_egresos;

        //dd($fecha_caja_control);
        if ($is_sustentar) {
            if ($control_caja->is_abierto) {
                $viatico = Viatico::find($viatico->id);
                $viatico->descripcion = $request->input('descripcion');
                $viatico->sustentado = true;
                $viatico->updated_at = (new DateTime())->getTimestamp();

                if (number_format($saldo_total, 2, '.', '') >= number_format($monto_nuevo, 2, '.', '')) {

                    if ($viatico->update()) {
                        //INGRESO PRÉSTAMO
                        $caja->descripcion = $request->input('descripcion');
                        $caja->updated_at = (new DateTime())->getTimestamp();

                        if ($caja->update()) {
                            Alert::toast('Viático Sustentado', 'success', 1500);
                            //return view('roles.index');
                            return redirect()->route('viaticos.index');
                        }
                    } else {
                        Alert::error('Lo sentimos', 'Ocurrio un error.');
                        return redirect()->route('viaticos.edit');
                    }
                } else {
                    Alert::error('Lo sentimos', 'Saldo insuficiente para los VIÁTICOS. Saldo actual: S/. ' . number_format($saldo_total, 2));
                    return redirect()->route('viaticos.create');
                }
            } else {
                Alert::error('Lo sentimos', 'La caja esta cerrada, para poder sustentar comunicate con un encargado.');
                return redirect()->route('viaticos.sustentar', $viatico->id);
            }
        } else {
            if ($control_caja->is_abierto) {
                if ($saldo_total >= $monto_nuevo) {
                    $viatico = Viatico::find($viatico->id);
                    $viatico->proyecto_id = $request->input('proyecto');
                    $viatico->responsable_id = $request->input('responsable');
                    $viatico->autorizado_por = $request->input('autorizado_por');
                    $viatico->monto = $request->input('monto');
                    $viatico->descripcion = $request->input('descripcion');
                    $viatico->updated_at = (new DateTime())->getTimestamp();


                    if ($viatico->update()) {
                        //INGRESO PRÉSTAMO
                        $caja->proyecto_id = $request->input('proyecto');
                        $caja->operacion = 3; //OPERACION EGRESO ID
                        $caja->tipo = 13; //TIPO OFICINA ID
                        $caja->subtipo = 56; //SUBTIPO CAJA CHICA
                        $caja->autorizado_por = $request->input('autorizado_por');
                        $caja->realizado_a_favor = $responsable->nombres . ' ' . $responsable->apellidos;
                        $caja->monto = $request->input('monto');
                        $caja->descripcion = $request->input('descripcion');
                        $caja->is_viatico = true;
                        $caja->id_viaticos = $viatico->id;
                        $caja->id_control_caja = $control_caja->id;
                        $caja->updated_at = (new DateTime())->getTimestamp();

                        if ($caja->update()) {
                            Alert::toast('Viático Actualizado', 'success', 1500);
                            //return view('roles.index');
                            return redirect()->route('viaticos.index');
                        }
                    } else {
                        Alert::error('Lo sentimos', 'Ocurrio un error.');
                        return redirect()->route('viaticos.create');
                    }
                } else {
                    Alert::error('Lo sentimos', 'Saldo insuficiente para los VIÁTICOS. Saldo actual: S/. ' . number_format($saldo_total, 2));
                    return redirect()->route('viaticos.create');
                }
            } else {
                Alert::error('Lo sentimos', 'La caja esta cerrada, para poder editar o actualizar comunicate con un encargado.');
                return redirect()->route('viaticos.edit', $viatico->id);
            }
        }
    }

    public function destroy(Viatico $viatico)
    {
        $viatico = Viatico::find($viatico->id);
        $viatico->delete();
        Alert::toast('Viático Eliminado', 'success');

        return redirect()->route('viaticos.index');
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
