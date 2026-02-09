<?php

namespace App\Console;

use App\Console\Commands\CreateDatabase;
use App\Console\Commands\DropDatabase;
use Illuminate\Foundation\Console\Kernel AS ConsoleKernal;
use Illuminate\Console\Scheduling\Schedule;

final class kernel extends ConsoleKernal
{
    // on rajoute la commande permmetant de créer la BD mysql si elle existe pas
    protected $commands = [
        CreateDatabase::class,
        DropDatabase::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // pour les tâches planifiées
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }


}