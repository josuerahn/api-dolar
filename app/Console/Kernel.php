<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Ejecuta la consulta cada hora
        $schedule->command('cotizacion:consultar oficial')->hourly();
        $schedule->command('cotizacion:consultar blue')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
