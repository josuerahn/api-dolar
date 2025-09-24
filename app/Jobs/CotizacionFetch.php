<?php
namespace App\Jobs;

use App\Models\Cotizacion;
use App\Services\CotizacionClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CotizacionFetch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [30, 60, 120];

    public function handle(CotizacionClient $client): void
    {
        $items = $client->fetchAll();
        foreach ($items as $it) {
            Cotizacion::updateOrCreate(
                [
                    'fuente' => $it['fuente'],
                    'tipo'   => $it['tipo'],
                    'fecha_cotizacion' => $it['fecha_cotizacion'],
                ],
                [
                    'compra' => $it['compra'],
                    'venta'  => $it['venta'],
                    'payload'=> $it['payload'],
                ]
            );
        }
    }
}
