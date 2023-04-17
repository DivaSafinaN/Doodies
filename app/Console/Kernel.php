<?php

namespace App\Console;

use App\Jobs\SendMyDayReminder;
use App\Jobs\SendTaskReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new SendTaskReminder)->everyMinute();
        $schedule->job(new SendMyDayReminder)->everyMinute();
        $schedule->command('trash:deleteMyDay')->daily();
        $schedule->command('trash:deleteTasks')->daily();
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
