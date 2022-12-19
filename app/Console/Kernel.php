<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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
        // $schedule->command('cek:resi')->everyFiveMinutes();
        $schedule->command('idexpress:resi')->everyFiveMinutes();
        $schedule->command('wa:status')->everyFiveMinutes();
        $schedule->command('message:send')->everyTwoMinutes();
        $schedule->command('recek')->everyTwoHours();
        // $schedule->call(function () {
        //     Artisan::call('message:send');            
        //  })->name('send_message')->withoutOverlapping()->everyThreeMinutes();

        // $schedule->call(function () {
        //     Artisan::call('idexpress:resi');
        //     Log::info('idexpress:resi runing at '.date('Y-m-d H:i:s'));
        // })->name('idexpress_cek')->withoutOverlapping()->everyTenMinutes();

        // $schedule->call(function () {
        //     Artisan::call('idexpress:resi2');
        //     Log::info('idexpress:resi2 runing at '.date('Y-m-d H:i:s'));
        // })->name('idexpress_cek')->everyThirtyMinutes();

        // $schedule->call(function () {
        //     Artisan::call('wa:status');
        //     Log::info('wa:status runing at '.date('Y-m-d H:i:s'));
        //  })->name('cek_status_wa')->withoutOverlapping()->everyFiveMinutes();      

        $schedule->call(function () {
            Artisan::call('telat 7');
            Log::info('telat 7 runing at '.date('Y-m-d H:i:s'));
         })->name('telat_7')->dailyAt('07:00');

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
