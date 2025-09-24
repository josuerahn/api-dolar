<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Cotizacion;

class ConsultarCotizacion extends Command
{
    protected $signature = 'cotizacion:consultar {tipo=oficial}';
    protected $description = 'Consulta la cotización del dólar y la guarda en la base de datos';

    public function handle()
    {
        $tipo = $this->argument('tipo');
        $baseUrl = config('services.dolarapi.url');
        $response = Http::get("{$baseUrl}/{$tipo}");
        if ($response->failed()) {
            $this->error('No se pudo obtener la cotización.');
            return 1;
        }
        $data = $response->json();
        $cotizacion = $data['venta'] ?? null;
        $compra = $data['compra'] ?? null;
        $fecha_actualizacion = $data['fechaActualizacion'] ?? $data['fecha'] ?? now();
        $fuente = $baseUrl;
        if (!$cotizacion) {
            $this->error('Cotización no disponible.');
            return 1;
        }
        Cotizacion::updateOrCreate([
            'tipo' => $tipo,
            'fecha_actualizacion' => $fecha_actualizacion,
        ], [
            'compra' => $compra,
            'venta' => $cotizacion,
            'fuente' => $fuente,
            'fecha_consulta' => now(),
        ]);
        $this->info('Cotización guardada o actualizada correctamente.');
        return 0;
    }
}
