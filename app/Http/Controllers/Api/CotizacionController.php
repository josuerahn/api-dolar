<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function latest(Request $r)
    {
        $tipo = $r->query('tipo', 'blue');
        $row = Cotizacion::where('tipo',$tipo)
            ->orderByDesc('fecha_cotizacion')
            ->first();

        return $row ? response()->json($row) : response()->json(['message'=>'sin datos'], 404);
    }

    public function history(Request $r)
    {
        $tipo  = $r->query('tipo', 'blue');
        $desde = $r->query('desde'); // YYYY-MM-DD
        $hasta = $r->query('hasta'); // YYYY-MM-DD

        $q = Cotizacion::where('tipo',$tipo);
        if ($desde) $q->where('fecha_cotizacion','>=',$desde.' 00:00:00');
        if ($hasta) $q->where('fecha_cotizacion','<=',$hasta.' 23:59:59');

        return $q->orderBy('fecha_cotizacion')->paginate(200);
    }
}
