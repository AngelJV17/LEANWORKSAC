<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\CajaControl;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ControlCajasController extends Controller
{
    public function index()
    {
        $control_caja = CajaControl::orderBy('id', 'desc')->first();
        $fecha_caja_control = ($control_caja != null) ? $control_caja->created_at->format('d-m-Y') :  '';
        $hoy = Carbon::now()->format('d-m-Y');

        //dd($hoy);

        if ($fecha_caja_control == $hoy) {
            return view('control-cajas.index', compact('control_caja'));
        } else {
            return view('control-cajas.index');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $control_caja = new CajaControl();

        $control_caja->hora_apertura = now()->isoFormat('H:mm:ss');
        $control_caja->is_abierto = true;
        $control_caja->responsable_id = 2;
        $control_caja->created_at = (new DateTime())->getTimestamp();

        //dd($control_caja);

        if ($control_caja->save()) {
            Alert::toast('Se aperturo la caja con éxito', 'success', 1500);
            //return view('roles.index');
            return redirect()->route('control-cajas.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
