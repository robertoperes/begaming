<?php

namespace App\Console;

use App\Console\Commands\CacheDashboardCommand;
use App\Console\Commands\CollectStravaActivitiesCommand;
use App\Console\Commands\CompanyTimePointCommand;
use App\Console\Commands\CreateBadgeCommand;
use App\Console\Commands\CulturePointCommand;
use App\Console\Commands\ImportUsersCommand;
use App\Console\Commands\RefeshStravaTokenCommand;
use App\Console\Commands\ResetPointCommand;
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
        ImportUsersCommand::class,
        ResetPointCommand::class,
        CacheDashboardCommand::class,
        RefeshStravaTokenCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command(RefeshStravaTokenCommand::class)->cron('* * * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CacheDashboardCommand::class)->cron('0 * * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CollectStravaActivitiesCommand::class)
            ->timezone('America/Campo_Grande')
            ->cron('0 0 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CompanyTimePointCommand::class)->cron('0 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CulturePointCommand::class)->cron('0 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(CreateBadgeCommand::class)->cron('30 5 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(ImportUsersCommand::class)->cron('0 */2 * * *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(ResetPointCommand::class)->cron('0 5 1 1 *')
            ->appendOutputTo(storage_path() . '/logs/schedule.log');

        $schedule->command(ImportUsersCommand::class)
            ->timezone('America/Sao_Paulo')
            ->cron('55 * * * *')
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
