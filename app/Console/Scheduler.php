<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class Scheduler
{
    /**
     * Define the application's command schedule.
     */
    public function __invoke(Schedule $schedule): void
    {
        // Run the matches:cleanup command daily at midnight
        // $schedule->command('matches:cleanup')->daily();

        $schedule->command('matches:cleanup')->everyMinute(); // Will run every minute
        $schedule->command('matches:suggestions')->dailyAt('08:00');

        // You can add more scheduled commands here
        // $schedule->command('app:match-profiles')->hourly();
    }
}
