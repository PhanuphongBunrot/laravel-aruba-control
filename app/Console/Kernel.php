<?php

namespace App\Console;

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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'your_command:run {--delay= : Number of seconds to delay command}';
    
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call('App\Http\Controllers\StatusController@stu')->everyMinute();
        // $schedule->call('App\Http\Controllers\TimeoutController@to')->everyMinute();
        // $schedule->call('App\Http\Controllers\TimediiffController@td')->everyMinute();
        //$schedule->call('App\Http\Controllers\StatusController@stu')->hourly();
        //$schedule->call('App\Http\Controllers\DataController@timeline')->everyMinute();
        $schedule->call('App\Http\Controllers\RequestArubaApi@reqaruba')->everyMinute();
        $schedule->call('App\Http\Controllers\dropController@drop')->TwoMinute();
        
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
