<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CajaControl;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ControlCajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:control-cajas.index')->only('index');
        $this->middleware('can:control-cajas.create')->only('create');
        $this->middleware('can:control-cajas.store')->only('store');
        $this->middleware('can:control-cajas.show')->only('show');
        $this->middleware('can:control-cajas.edit')->only('edit');
        $this->middleware('can:control-cajas.update')->only('update');
        $this->middleware('can:control-cajas.delete')->only('delete');
    }

    public function index()
    {
        $control_cajas = CajaControl::all();
        return view('control-cajas.index', compact('control_cajas'));

        /* $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($hoy);

        if ($fecha_caja_control == $hoy) {
            return view('control-cajas.index', compact('control_caja'));
        } else {
            return view('control-cajas.index');
        } */
    }

    public function create()
    {
        //$control_cajas = CajaControl::all();
        return view('control-cajas.create');
    }

    public function store(Request $request)
    {
        /* $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]); */

        $c_caja = CajaControl::orderBy('id', 'desc')->first();
        
        if ($c_caja != null) {
            $fecha_caja = date('d-m-Y', strtotime($c_caja->created_at));
            $is_abierto = $c_caja->is_abierto;
            $today = (new DateTime())->format('d-m-Y');

            if (!$is_abierto) {
                if ($fecha_caja != $today) {
                    $control_caja = new CajaControl();
                    $control_caja->hora_apertura = now()->isoFormat('H:mm:ss');
                    $control_caja->is_abierto = true;
                    $control_caja->responsable_id = Auth::user()->id;
                    $control_caja->created_at = (new DateTime())->getTimestamp();

                    //dd($control_caja);

                    if ($control_caja->save()) {
                        Alert::toast('Se aperturo la caja con éxito', 'success', 1500);
                        //return view('roles.index');
                        return redirect()->route('control-cajas.index');
                    }
                } else {
                    Alert::error('Lo Sentimos', 'La caja ya se encuentra cerrada, comunícate para volver aperturar la caja.');
                    return redirect()->route('control-cajas.index');
                }
            } else {
                Alert::error('Lo Sentimos', 'Hay una caja abierta, cierra la caja para continuar.');
                return redirect()->route('control-cajas.edit', $c_caja->id);
            }
        } else {
            $control_caja = new CajaControl();
            $control_caja->hora_apertura = now()->isoFormat('H:mm:ss');
            $control_caja->is_abierto = true;
            $control_caja->responsable_id = Auth::user()->id;
            $control_caja->created_at = (new DateTime())->getTimestamp();

            //dd($control_caja);

            if ($control_caja->save()) {
                Alert::toast('Se aperturo la caja con éxito', 'success', 1500);
                //return view('roles.index');
                return redirect()->route('control-cajas.index');
            }
        }
    }

    public function show(CajaControl $cajaControl)
    {
        return view('control-cajas.show', compact('cajaControl'));
    }

    public function edit(CajaControl $cajaControl)
    {
        return view('control-cajas.edit', compact('cajaControl'));
    }

    public function update(Request $request, CajaControl $cajaControl)
    {
        //dd($request);

        $request->validate([
            'volver_aperturar' => 'required'
        ]);

        $control_cajas = CajaControl::all();
        $cajas_abiertas = 0;
        foreach ($control_cajas as $control_caja) {
            if ($control_caja->is_abierto) {
                $cajas_abiertas++;
            }
        }

        //dd($cajas_abiertas);

        if ($request->input('volver_aperturar')) {
            if ($cajas_abiertas == 0) {
                $cajaControl = CajaControl::find($cajaControl->id);
                $cajaControl->hora_cierre = null;
                $cajaControl->is_abierto = true;
                if ($cajaControl->update()) {
                    Alert::toast('Se aperturó
                     la caja nuevamente.', 'success', 1500);
                    //return view('roles.index');
                    return redirect()->route('control-cajas.index');
                }
            } else {
                Alert::error('LLo sentimos', 'No se puede volver a aperurar esta caja, hay cajas abiertas.', 1500);
                //return view('roles.index');
                return redirect()->route('control-cajas.index');
            }
        } else {
            $cajaControl = CajaControl::find($cajaControl->id);
            $cajaControl->hora_cierre = now()->isoFormat('H:mm:ss');
            $cajaControl->is_abierto = false;
            $cajaControl->updated_at = (new DateTime())->getTimestamp();
            if ($cajaControl->update()) {
                Alert::toast('Caja cerrada.', 'success', 1500);
                //return view('roles.index');
                return redirect()->route('control-cajas.index');
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}
