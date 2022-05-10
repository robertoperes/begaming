<?php

namespace App\Console;

use App\Console\Commands\CollectStravaActivitiesCommand;
use App\Console\Commands\CompanyTimePointCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CollectStravaActivitiesCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(CollectStravaActivitiesCommand::class)->cron('0 */4 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');
        $schedule->command(CompanyTimePointCommand::class)->cron('0 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
