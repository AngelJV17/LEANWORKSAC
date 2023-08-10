<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaChica;
use App\Models\CajaControl;
use App\Models\Proyecto;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CajaChicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:caja-chica.index')->only('index');
        $this->middleware('can:caja-chica.create')->only('create');
        $this->middleware('can:caja-chica.store')->only('store');
        $this->middleware('can:caja-chica.show')->only('show');
        $this->middleware('can:caja-chica.edit')->only('edit');
        $this->middleware('can:caja-chica.update')->only('update');
        $this->middleware('can:caja-chica.delete')->only('delete');
    }

    public function index()
    {
        $cajaChicas = CajaChica::all();
        return view('caja-chica.index', compact('cajaChicas'));
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('caja-chica.create', ['proyectos' => $proyectos, 'responsables' => $responsables]);
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

            if ($saldo_total >= $monto_nuevo) {
                $cajaChica = new CajaChica();
                $cajaChica->proyecto_id = $request->input('proyecto');
                $cajaChica->responsable_id = $request->input('responsable');
                $cajaChica->autorizado_por = $request->input('autorizado_por');
                $cajaChica->monto = $request->input('monto');
                $cajaChica->descripcion = $request->input('descripcion');
                $cajaChica->created_at = (new DateTime())->getTimestamp();

                if ($cajaChica->save()) {
                    $getCajaChica = CajaChica::orderBy('id', 'desc')->first();

                    //INGRESO PRÉSTAMO
                    $caja = new Caja();
                    $caja->proyecto_id = $request->input('proyecto');
                    $caja->operacion = 3; //OPERACION EGRESO ID
                    $caja->tipo = 13; //TIPO OFICINA ID
                    $caja->subtipo = 56; //SUBTIPO CAJA CHICA
                    $caja->autorizado_por = $request->input('autorizado_por');
                    $caja->realizado_a_favor = $responsable->nombres . ' ' . $responsable->apellidos;
                    $caja->monto = $request->input('monto');
                    $caja->descripcion = $request->input('descripcion');
                    $caja->is_prestamo = false;
                    $caja->is_inversion = false;
                    $caja->is_caja_chica = true;
                    $caja->is_viatico = false;
                    $caja->id_caja_chica = $getCajaChica->id;
                    $caja->id_control_caja = $control_caja->id;
                    $caja->created_at = (new DateTime())->getTimestamp();

                    if ($caja->save()) {
                        Alert::toast('Caja Chica Registrada', 'success', 1500);
                        //return view('roles.index');
                        return redirect()->route('caja-chica.index');
                    }
                } else {
                    Alert::error('Lo sentimos', 'Ocurrio un error.');
                    return redirect()->route('caja-chica.create');
                }
            } else {
                Alert::error('Lo sentimos', 'Saldo insuficiente para crear una CAJA CHICA. Saldo actual: S/. ' . number_format($saldo_total, 2));
                return redirect()->route('caja-chica.create');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.create');
        }
    }

    public function show(CajaChica $cajaChica)
    {
        $caja = Caja::where('id_caja_chica', $cajaChica->id)->first();
        //dd($cajaChica->sustentado);
        return view('caja-chica.show',  ['caja' => $caja, "sustentado" => $cajaChica->sustentado]);
    }

    public function edit(CajaChica $cajaChica)
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('caja-chica.edit', ['cajaChica' => $cajaChica, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function sustentar(CajaChica $cajaChica)
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('caja-chica.sustentar', ['cajaChica' => $cajaChica, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function update(Request $request, CajaChica $cajaChica)
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

        $caja = Caja::where('id_caja_chica', $cajaChica->id)->first();

        $control_caja = CajaControl::where('id', $caja->id_control_caja)->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($fecha_caja_control);

        $monto_nuevo = $request->input('monto');
        $id_proyecto = $request->input('proyecto');
        $total_ingresos = $this->obetenerTotalIngresos($id_proyecto);
        $total_egresos = $this->obetenerTotalEgresos($id_proyecto);
        $saldo_total = $total_ingresos - $total_egresos;

        if ($is_sustentar) {
            if ($control_caja->is_abierto) {
                $cajaChica = CajaChica::find($cajaChica->id);
                $cajaChica->descripcion = $request->input('descripcion');
                $cajaChica->sustentado = true;
                $cajaChica->updated_at = (new DateTime())->getTimestamp();

                if ($cajaChica->update()) {
                    //INGRESO PRÉSTAMO
                    $caja->descripcion = $request->input('descripcion');
                    $caja->updated_at = (new DateTime())->getTimestamp();

                    if ($caja->update()) {
                        Alert::toast('Caja Chica Sustentada', 'success', 1500);
                        //return view('roles.index');
                        return redirect()->route('caja-chica.index');
                    }
                } else {
                    Alert::error('Lo sentimos', 'Ocurrio un error.');
                    return redirect()->route('caja-chica.edit');
                }
            } else {
                Alert::error('Lo sentimos', 'La caja esta cerrada, para poder sustentar comunicate con un encargado.');
                return redirect()->route('caja-chica.sustentar', $cajaChica->id);
            }
        } else {
            if ($control_caja->is_abierto) {
                if ($saldo_total >= $monto_nuevo) {
                    $cajaChica = CajaChica::find($cajaChica->id);
                    $cajaChica->proyecto_id = $request->input('proyecto');
                    $cajaChica->responsable_id = $request->input('responsable');
                    $cajaChica->autorizado_por = $request->input('autorizado_por');
                    $cajaChica->monto = $request->input('monto');
                    $cajaChica->descripcion = $request->input('descripcion');
                    $cajaChica->updated_at = (new DateTime())->getTimestamp();

                    if ($cajaChica->update()) {
                        //INGRESO PRÉSTAMO
                        $caja->proyecto_id = $request->input('proyecto');
                        $caja->operacion = 3; //OPERACION EGRESO ID
                        $caja->tipo = 13; //TIPO OFICINA ID
                        $caja->subtipo = 56; //SUBTIPO CAJA CHICA
                        $caja->autorizado_por = $request->input('autorizado_por');
                        $caja->realizado_a_favor = $responsable->nombres . ' ' . $responsable->apellidos;
                        $caja->monto = $request->input('monto');
                        $caja->descripcion = $request->input('descripcion');
                        $caja->is_caja_chica = true;
                        $caja->id_caja_chica = $cajaChica->id;
                        $caja->id_control_caja = $control_caja->id;
                        $caja->updated_at = (new DateTime())->getTimestamp();

                        if ($caja->update()) {
                            Alert::toast('Caja Chica Actualizada', 'success', 1500);
                            //return view('roles.index');
                            return redirect()->route('caja-chica.index');
                        }
                    } else {
                        Alert::error('Lo sentimos', 'Ocurrio un error.');
                        return redirect()->route('caja-chica.edit');
                    }
                }else {
                    Alert::error('Lo sentimos', 'Saldo insuficiente para crear una CAJA CHICA. Saldo actual: S/. ' . number_format($saldo_total, 2));
                    return redirect()->route('caja-chica.create');
                }
            } else {
                Alert::error('Lo sentimos', 'La caja esta cerrada, para poder editar o actualizar comunicate con un encargado.');
                return redirect()->route('caja-chica.edit', $cajaChica->id);
            }
        }
    }

    public function destroy(CajaChica $cajaChica)
    {
        $cajaChica = CajaChica::find($cajaChica->id);
        $cajaChica->delete();
        Alert::toast('Caja Chica Eliminada', 'success');

        return redirect()->route('caja-chica.index');
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
