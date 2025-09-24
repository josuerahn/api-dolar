<?php
namespace App\Jobs;

use App\Models\Cotizacion;
use App\Models\Promedio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PromedioMensualRecalcular implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $tipo;
    public int $anio;
    public int $mes;

    public function __construct(string $tipo, int $anio, int $mes)
    {
        $this->tipo = $tipo;
        $this->anio = $anio;
        $this->mes  = $mes;
    }

    public function handle(): void
    {
        $desde = now()->setYear($this->anio)->setMonth($this->mes)->startOfMonth()->toDateString();
        $hasta = now()->setYear($this->anio)->setMonth($this->mes)->endOfMonth()->toDateString();

        $rows = Cotizacion::query()
            ->where('tipo', $this->tipo)
            ->whereBetween('fecha_cotizacion', [$desde.' 00:00:00', $hasta.' 23:59:59'])
            ->get(['compra','venta']);

        $muestras = $rows->count();
        $promCompra = $muestras ? $rows->avg('compra') : null;
        $promVenta  = $muestras ? $rows->avg('venta')  : null;

        Promedio::updateOrCreate(
            [
                'tipo' => $this->tipo,
                'periodo' => 'mensual',
                'desde' => $desde,
                'hasta' => $hasta,
            ],
            [
                'promedio_compra' => $promCompra,
                'promedio_venta'  => $promVenta,
                'muestras' => $muestras,
            ]
        );
    }
}
