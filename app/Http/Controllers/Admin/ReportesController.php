<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reportes.index')->only('index');
    }

    public function index()
    {
        $cajas = Caja::orderBy('id', 'asc')->get();
        $is_filter = false;
        return view('reportes.index', compact('is_filter', 'cajas'));

        /* if ($request->desde != null && $request->hasta != null) {
            $desde = date('Y-m-d', strtotime($request->desde));
            $hasta = date('Y-m-d 23:59:59', strtotime($request->hasta));
            //$cajas = Caja::where('created_at', 'BETWEEN ',  $desde .' AND '. $hasta)->get();
            $cajas = Caja::whereBetween('created_at', [$desde, $hasta])->get();
            $is_filter = true;
            //dd($cajas);
            return view('reportes.index', ['is_filter' => $is_filter, 'cajas' => $cajas]);
        } else {
            //$cajas = Caja::all();
            $cajas = Caja::orderBy('id', 'asc')->get();
            $is_filter = false;
            return view('reportes.index', ['is_filter' => $is_filter, 'cajas' => $cajas]);
        } */
    }

    public function reportResult(Request $request)
    {
        $desde = date('Y-m-d 00:00:00', strtotime($request->desde));
        $hasta = date('Y-m-d 23:59:59', strtotime($request->hasta));

        $cajas = Caja::whereBetween('created_at', [$desde, $hasta])->get();
        $is_filter = true;
        //dd($cajas);
        return view('reportes.index', compact('is_filter', 'cajas'));
    }

    public function reporte()
    {
        return view('reportes.reporte');
    }

    public function generarPdf(Request $request)
    {
        $desde = date('Y-m-d', strtotime($request->desde));
        $hasta = date('Y-m-d 23:59:59', strtotime($request->hasta));

        $cajas =  Caja::whereBetween('created_at', [$desde, $hasta])->get();
        $pdf = Pdf::loadView('reportes.generar-reporte', compact("cajas", "desde", "hasta"))->setPaper('A4', 'landscape');
        $options = new Options();
        $options->set('defaultFont', 'Verdana');
        $options->set('javascript-delay', 1500);
        $dompdf = new Dompdf($options);
        $nombre = 'REPORTE ' . $desde . ' AL ' . $hasta;
        return $pdf->download($nombre.'.pdf');
        // return $pdf->output();
        $dompdf->render();
    }
}
