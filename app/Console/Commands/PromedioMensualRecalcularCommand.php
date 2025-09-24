<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PromedioMensualRecalcular;

class PromedioMensualRecalcularCommand extends Command
{
    protected $signature = 'promedios:mensual {tipo} {anio} {mes}';
    protected $description = 'Calcula y guarda promedio mensual por tipo (compra/venta)';

    public function handle(): int
    {
        $tipo = (string) $this->argument('tipo');
        $anio = (int) $this->argument('anio');
        $mes  = (int) $this->argument('mes');
        PromedioMensualRecalcular::dispatch($tipo, $anio, $mes);
        $this->info("Job PromedioMensualRecalcular despachado ($tipo,$anio,$mes)");
        return self::SUCCESS;
    }
}
