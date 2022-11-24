<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->exec('php artisan db:seed TagRoomSeeder')
            ->everyMinute()
            ->between('8:00', '20:00')
            ->description('Update TagRoomTable');

        $schedule
            ->call(fn() => DB::statement('REFRESH MATERIALIZED VIEW mv_tag_room;'))
            ->everyMinute()
            ->between('8:00', '20:00')
            ->description('Refresh Materialized View Tag Room');

        // $schedule->command('inspire')->hourly();
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
