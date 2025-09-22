<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DolarApiService;
use App\Models\Cotizacion;

class FetchCotizacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-cotizacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
