<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
 use Illuminate\Console\Scheduling\Event;
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
        info('333');
       
      $schedule->command('queue:work --tries=3')->everyMinute()->withoutOverlapping();
        $schedule->command('queue:restart')->everyFiveMinutes(); 
       
  
       
  

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
