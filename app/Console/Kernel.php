<?php

namespace App\Console;

use App\EnChuKong;
use App\Facebook\FacebookSelenium;

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
        // $schedule->call(function() {
        //     EnChuKong::findOrFail(31)->delete();
        // })->everyMinute();

        // $schedule->call(function(){
        //     EnChuKong::create([
        //         'date' =>  'testdate',
        //         'status' => 'test status',
        //     ])->save();
        // })->everyMinute();
        
        $schedule->call(function(){
            $haoWebdriver = new FacebookSelenium();
            $haoWebdriver->index();
        })->everyMinute();
    
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
