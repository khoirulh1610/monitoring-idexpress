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
        // $schedule->command('idexpress:resi')->everyFiveMinutes()->withoutOverlapping();
        // $schedule->command('wa:status')->everyMinute()->withoutOverlapping();
        // $schedule->command('message:send')->everyMinute()->withoutOverlapping(10);

        $schedule->call(function () {
            Artisan::call('idexpress:resi');
            Log::info('idexpress:resi runing at '.date('Y-m-d H:i:s'));
        })->name('idexpress_cek')->withoutOverlapping()->everyTenMinutes();

        $schedule->call(function () {
            Artisan::call('idexpress:resi2');
            Log::info('idexpress:resi2 runing at '.date('Y-m-d H:i:s'));
        })->name('idexpress_cek')->withoutOverlapping()->everyThirtyMinutes();

        $schedule->call(function () {
            Artisan::call('wa:status');
            Log::info('wa:status runing at '.date('Y-m-d H:i:s'));
         })->name('cek_status_wa')->withoutOverlapping()->everyFiveMinutes();

        $schedule->call(function () {
            Artisan::call('message:send');
            Log::info('message:send runing at '.date('Y-m-d H:i:s'));
         })->name('send_message')->withoutOverlapping()->everyMinute();

        $schedule->call(function () {
            Artisan::call('telat 7');
            Log::info('telat 7 runing at '.date('Y-m-d H:i:s'));
         })->name('telat_7')->withoutOverlapping()->dailyAt('07:00');

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
