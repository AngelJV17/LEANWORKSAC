<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\CajaControl;
use App\Models\Inversion;
use App\Models\Proyecto;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Toaster;

class InversionesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inversiones.index')->only('index');
        $this->middleware('can:inversiones.create')->only('create');
        $this->middleware('can:inversiones.store')->only('store');
        $this->middleware('can:inversiones.show')->only('show');
        $this->middleware('can:inversiones.edit')->only('edit');
        $this->middleware('can:inversiones.update')->only('update');
        $this->middleware('can:inversiones.delete')->only('delete');
    }

    public function index(Request $request)
    {
        /* $proyectos = Proyecto::all();
        $is_filter = true;
        return view('inversiones.index', compact('proyectos', 'is_filter')); */

        //$inversiones_group = Inversion::all()->groupBy('realizado_por');
        //dd($inversiones_group);

        if ($request->proyecto != null) {
            $proyectos = Proyecto::all();
            $filtro = $request->proyecto;
            $inversiones = Inversion::where('proyecto_id', 'LIKE', '%' . $filtro . '%')->get();
            $is_filter = true;
            $inversiones_group = $this->obetenerTotalInversion($filtro);

            return view('inversiones.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'inversiones' => $inversiones, 'inversiones_group' => $inversiones_group, 'proyecto_id' => $filtro]);
        } else {
            $inversiones_group = Inversion::groupBy('realizado_por')->selectRaw('realizado_por, sum(monto) as total_invertido')->get();
            $proyectos = Proyecto::all();
            //$cajas = Caja::all();
            $inversiones = Inversion::orderBy('id', 'desc')->get();
            $is_filter = false;
            return view('inversiones.index', ['is_filter' => $is_filter, 'proyectos' => $proyectos, 'inversiones' => $inversiones, 'inversiones_group' => $inversiones_group]);
        }
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('inversiones.create', ['proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'proyecto' => 'required',
            'realizado_por' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $proyecto = Proyecto::find($request->input('proyecto'));
        $a_favor = 'Realizado a favor del proyecto ' . $proyecto->nombre_proyecto . '.';

        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($monto_total);

        if ($fecha_caja_control == $hoy && $control_caja->is_abierto) {

            $inversion = new Inversion();
            $inversion->proyecto_id = $request->input('proyecto');
            $inversion->realizado_por = $request->input('realizado_por');
            $inversion->monto = $request->input('monto');
            $inversion->descripcion = $request->input('descripcion');
            $inversion->created_at = (new DateTime())->getTimestamp();

            if ($inversion->save()) {
                $get_inversion = Inversion::orderBy('id', 'desc')->first();

                //INGRESO PRÉSTAMO
                $caja = new Caja();
                $caja->proyecto_id = $request->input('proyecto');
                $caja->operacion = 2; //OPERACION INGRESOS ID
                $caja->tipo = 6; //TIPO INGRESO ID
                $caja->subtipo = 7; //SUBTIPO INVERSIÓN
                $caja->autorizado_por = $request->input('realizado_por');
                $caja->realizado_a_favor = $a_favor;
                $caja->monto = $request->input('monto');
                $caja->descripcion = $request->input('descripcion');
                $caja->is_prestamo = false;
                $caja->is_inversion = true;
                $caja->is_caja_chica = false;
                $caja->is_viatico = false;
                $caja->id_inversiones = $get_inversion->id;
                $caja->id_control_caja = $control_caja->id;
                $caja->created_at = (new DateTime())->getTimestamp();

                if ($caja->save()) {
                    Alert::toast('Inversión Registrada', 'success', 1500);
                    //return view('roles.index');
                    return redirect()->route('inversiones.index');
                }
            } else {
                Alert::error('Lo sentimos', 'Ocurrio un error.');
                return redirect()->route('inversiones.create');
            }
        } else {
            Alert::error('Lo sentimos', 'Debes aperturar una caja primero');
            return redirect()->route('control-cajas.create');
        }
    }

    public function show(Inversion $inversion)
    {
        $caja = Caja::where('id_inversiones', $inversion->id)->first();
        //dd($caja[0]);
        return view('inversiones.show',  ['caja' => $caja]);
    }

    public function edit(Inversion $inversion)
    {
        $proyectos = Proyecto::all();
        $responsables = User::whereNot('id', 1)->get();

        return view('inversiones.edit', ['inversion' => $inversion, 'proyectos' => $proyectos, 'responsables' => $responsables]);
    }

    public function update(Request $request, Inversion $inversion)
    {
        $request->validate([
            'proyecto' => 'required',
            'realizado_por' => 'required',
            'monto' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $caja = Caja::where('id_inversiones', $inversion->id)->first();

        $control_caja = CajaControl::where('id', $caja->id_control_caja)->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($fecha_caja_control);

        if ($control_caja->is_abierto) {

            $inversion = Inversion::find($inversion->id);
            $inversion->proyecto_id = $request->input('proyecto');
            $inversion->realizado_por = $request->input('realizado_por');
            $inversion->monto = $request->input('monto');
            $inversion->descripcion = $request->input('descripcion');
            $inversion->updated_at = (new DateTime())->getTimestamp();


            $proyecto = Proyecto::find($request->input('proyecto'));
            $a_favor = 'Realizado a favor del proyecto ' . $proyecto->nombre_proyecto . '.';

            if ($inversion->update()) {
                //INGRESO PRÉSTAMO
                $caja = Caja::find($inversion->id);
                $caja->proyecto_id = $request->input('proyecto');
                $caja->operacion = 2; //OPERACION INGRESOS ID
                $caja->tipo = 6; //TIPO INGRESO ID
                $caja->subtipo = 7; //SUBTIPO INVERSIÓN
                $caja->autorizado_por = $request->input('realizado_por');
                $caja->realizado_a_favor = $a_favor;
                $caja->monto = $request->input('monto');
                $caja->descripcion = $request->input('descripcion');
                $caja->is_prestamo = false;
                $caja->is_inversion = true;
                $caja->is_caja_chica = false;
                $caja->is_viatico = false;
                $caja->id_inversiones = $inversion->id;
                $caja->updated_at = (new DateTime())->getTimestamp();

                if ($caja->update()) {
                    Alert::toast('Inversión Actualizada', 'success', 1500);
                    //return view('roles.index');
                    return redirect()->route('inversiones.index');
                }
            } else {
                Alert::error('Lo sentimos', 'Ocurrio un error.');
                return redirect()->route('inversiones.create');
            }
        } else {
            Alert::error('Lo sentimos', 'La caja esta cerrada, para poder editar o actualizar comunicate con un encargado.');
            return redirect()->route('inversiones.edit', $inversion->id);
        }
    }

    public function destroy(Inversion $inversion)
    {
        $inversion = Inversion::find($inversion->id);
        $inversion->delete();
        Alert::toast('Inversion Eliminada', 'success');

        return redirect()->route('inversiones.index');
    }

    public function obetenerTotalInversion($id_proyecto)
    {
        //$total_invertido = Inversion::where('proyecto_id', $id_proyecto)->sum('monto');
        $total_invertido = Inversion::where('proyecto_id', $id_proyecto)->groupBy('realizado_por')->selectRaw('realizado_por, sum(monto) as total_invertido')->get();
        //dd($total_invertido);
        return $total_invertido;
    }
}
