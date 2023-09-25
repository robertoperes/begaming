<?php

namespace App\Console;

use App\Console\Commands\CollectStravaActivitiesCommand;
use App\Console\Commands\CompanyTimePointCommand;
use App\Console\Commands\CreateBadgeCommand;
use App\Console\Commands\CulturePointCommand;
use App\Console\Commands\ImportUsersCommand;
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
        CollectStravaActivitiesCommand::class,
        CompanyTimePointCommand::class,
        CulturePointCommand::class,
        CreateBadgeCommand::class,
        ImportUsersCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(CollectStravaActivitiesCommand::class)->cron('0 */2 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CompanyTimePointCommand::class)->cron('0 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CulturePointCommand::class)->cron('0 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CreateBadgeCommand::class)->cron('30 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(ImportUsersCommand::class)->cron('0 */2 * * *')
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
