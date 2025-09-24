<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CotizacionClient
{
    public function fetchAll(): array
    {
        $items = [];

        // Bluelytics
        $bluely = Http::timeout(20)->get('https://api.bluelytics.com.ar/v2/latest');
        if ($bluely->ok()) {
            $js = $bluely->json();
            $fecha = now();
            if (isset($js['oficial'])) {
                $items[] = [
                    'fuente' => 'bluelytics',
                    'tipo' => 'oficial',
                    'compra' => $js['oficial']['value_buy'] ?? null,
                    'venta' => $js['oficial']['value_sell'] ?? null,
                    'fecha_cotizacion' => $fecha,
                    'payload' => $js['oficial'],
                ];
            }
            if (isset($js['blue'])) {
                $items[] = [
                    'fuente' => 'bluelytics',
                    'tipo' => 'blue',
                    'compra' => $js['blue']['value_buy'] ?? null,
                    'venta' => $js['blue']['value_sell'] ?? null,
                    'fecha_cotizacion' => $fecha,
                    'payload' => $js['blue'],
                ];
            }
        }

        // CriptoYa (MEP/CCL)
        $cripto = Http::timeout(20)->get('https://criptoya.com/api/dolar');
        if ($cripto->ok()) {
            $js = $cripto->json();
            $fecha = now();
            foreach (['mep','ccl'] as $k) {
                if (isset($js[$k])) {
                    $items[] = [
                        'fuente' => 'criptoya',
                        'tipo' => $k,
                        'compra' => $js[$k]['bid'] ?? null,
                        'venta' => $js[$k]['ask'] ?? null,
                        'fecha_cotizacion' => $fecha,
                        'payload' => $js[$k],
                    ];
                }
            }
        }

        return $items;
    }
}
