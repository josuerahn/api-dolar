<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CotizacionController extends Controller
{
    public function convertir(Request $request)
    {
        $valorUSD = $request->query('valor');
        $tipo = $request->query('tipo', 'oficial'); // Por defecto usamos "oficial"
        if (!$valorUSD || !is_numeric($valorUSD)) {
            return response()->json(['error' => 'Debe enviar un valor numérico en
dólares.'], 400);
        }
        // Obtener la URL base desde config/services.php
        $baseUrl = config('services.dolarapi.url');
        // Consumir la API externa
        $response = Http::get("{$baseUrl}/{$tipo}");
        if ($response->failed()) {
            return response()->json(
                ['error' => 'No se pudo obtener la cotización.'],
                500
            );
        }
        $data = $response->json();
        $cotizacion = $data['venta'] ?? null;
        $compra = $data['compra'] ?? null;
        $fecha_actualizacion = $data['fechaActualizacion'] ?? $data['fecha'] ?? now();
        $fuente = $baseUrl;
        if (!$cotizacion) {
            return response()->json(['error' => 'Cotización no disponible.'], 500);
        }
        $resultado = $valorUSD * $cotizacion;
        // Guardar la consulta en la base de datos
        $consulta = Cotizacion::create([
            'tipo' => $tipo,
            'compra' => $compra,
            'venta' => $cotizacion,
            'fecha_actualizacion' => $fecha_actualizacion,
            'fuente' => $fuente,
            'fecha_consulta' => now(),
        ]);
        // Calcular promedios por mes y año
        $mes = now()->format('m');
        $anio = now()->format('Y');
        $promedioMes = Cotizacion::whereMonth('fecha_consulta', $mes)
            ->whereYear('fecha_consulta', $anio)
            ->avg('venta');
        $promedioAnio = Cotizacion::whereYear('fecha_consulta', $anio)
            ->avg('venta');
        return response()->json([
            'tipo' => $tipo,
            'valor_dolar' => $valorUSD,
            'cotizacion' => $cotizacion,
            'resultado_en_pesos' => round($resultado, 2),
            'fecha_consulta' => $consulta->fecha_consulta,
            'promedio_mes' => round($promedioMes, 2),
            'promedio_anio' => round($promedioAnio, 2)
        ]);
    }

    public function promedio(Request $request)
    {
        $tipo = $request->query('tipo', 'oficial');
        $valor = $request->query('valor', 'venta'); // 'venta' o 'compra'
        $mes = $request->query('mes', now()->format('m'));
        $anio = $request->query('anio', now()->format('Y'));

        if (!in_array($valor, ['venta', 'compra'])) {
            return response()->json(['error' => 'El tipo de valor debe ser "venta" o "compra".'], 400);
        }

        $promedioMes = Cotizacion::where('tipo', $tipo)
            ->whereMonth('fecha_consulta', $mes)
            ->whereYear('fecha_consulta', $anio)
            ->avg($valor);
        $promedioAnio = Cotizacion::where('tipo', $tipo)
            ->whereYear('fecha_consulta', $anio)
            ->avg($valor);

        return response()->json([
            'tipo' => $tipo,
            'valor' => $valor,
            'mes' => $mes,
            'anio' => $anio,
            'promedio_mes' => round($promedioMes, 2),
            'promedio_anio' => round($promedioAnio, 2)
        ]);
    }
}
