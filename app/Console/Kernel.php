<?php

namespace App\Console;

use App\Jobs\FindPicture;
use App\Jobs\UpdateTourismStatus;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->job(new FindPicture())->everyTenMinutes()->withoutOverlapping();
        $schedule->job(new UpdateTourismStatus())->everyFiveMinutes();
//        $schedule->command('status:update')->everyFi eMinutes();
//        $schedule->command('scrap:picture')->everyTenMinutes();
        $schedule->command('telescope:prune')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
