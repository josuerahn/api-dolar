<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promedio;
use Illuminate\Http\Request;

class PromedioController extends Controller
{
    // GET /api/promedios/mensual?tipo=blue&anio=2025&mes=9&valor=venta
    public function mensual(Request $r)
    {
        $tipo  = $r->query('tipo', 'blue');
        $anio  = (int) $r->query('anio', now()->year);
        $mes   = (int) $r->query('mes',  now()->month);
        $valor = $r->query('valor', 'venta'); // compra | venta

        $desde = now()->setYear($anio)->setMonth($mes)->startOfMonth()->toDateString();
        $hasta = now()->setYear($anio)->setMonth($mes)->endOfMonth()->toDateString();

        $row = Promedio::where([
            'tipo' => $tipo, 'periodo' => 'mensual', 'desde' => $desde, 'hasta' => $hasta,
        ])->first();

        if (!$row) return response()->json(['message'=>'sin datos'], 404);

        return response()->json([
            'tipo'     => $tipo,
            'anio'     => $anio,
            'mes'      => $mes,
            'valor'    => $valor,
            'promedio' => $valor === 'compra' ? $row->promedio_compra : $row->promedio_venta,
            'muestras' => $row->muestras,
            'periodo'  => 'mensual',
        ]);
    }
}
