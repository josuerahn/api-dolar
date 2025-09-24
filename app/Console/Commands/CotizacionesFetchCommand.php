<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CotizacionFetch;

class CotizacionesFetchCommand extends Command
{
    protected $signature = 'cotizaciones:fetch';
    protected $description = 'Trae cotizaciones de APIs públicas y guarda histórico (anio/mes/fecha)';

    public function handle(): int
    {
        CotizacionFetch::dispatch();
        $this->info('Job CotizacionFetch despachado.');
        return self::SUCCESS;
    }
}
