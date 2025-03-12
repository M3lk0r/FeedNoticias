<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Registre também manualmente se necessário:
        \App\Console\Commands\PublishScheduledPosts::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('posts:publish-scheduled')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}