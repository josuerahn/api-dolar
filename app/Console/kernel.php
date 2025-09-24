<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CotizacionFetch;
use App\Jobs\PromedioMensualRecalcular;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Consulta periódica cada 30 minutos
        $schedule->job(new CotizacionFetch())->everyThirtyMinutes()->onOneServer();

        // Promedio mensual del mes actual, diario 23:55 (ajustá tipos a gusto)
        foreach (['blue','oficial','mep','ccl'] as $tipo) {
            $schedule->job(new PromedioMensualRecalcular($tipo, now()->year, now()->month))
                     ->dailyAt('23:55')->onOneServer();
        }
    }
}
