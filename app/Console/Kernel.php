<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

/**
 * Stub del Kernel para que los tests encuentren la clase.
 * Solo se definen los métodos necesarios para el scheduler.
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    public function schedule($app)
    {
        // Create a Schedule instance for the provided app instance.
        $schedule = new Schedule($app);
                $schedule->command('backup:run')->daily()->description('backup:run'); // Schedule backup command with description
        return $schedule;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Los comandos se registran automáticamente vía Artisan.
    }
}
?>
