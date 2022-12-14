<?php

namespace App\Console;

use App\Models\TagRoom;
use App\Models\Tags;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
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
            ->weekdays()
            ->description('Update TagRoomTable');

        $schedule
            ->call(fn() => $this->insertNullTagRoomRegister())
            ->everyMinute()
            ->weekdays()
            ->between('8:01', '20:30')
            ->description('random insert on tag_room');

        $schedule
            ->call(fn() => DB::statement('REFRESH MATERIALIZED VIEW mv_tag_room;'))
            ->everyMinute()
            ->weekdays()
            ->description('Refresh Materialized View Tag Room');

        $schedule
            ->exec('php artisan db:seed PeopleSeeder')
            ->hourly()
            ->between('10:00', '16:00')
            ->weekdays()
            ->description('creating people on database');

        $schedule
            ->exec('php artisan db:seed TagsSeeder')
            ->daily()
            ->weekdays()
            ->description('creating tags on database');

        $schedule
            ->call(fn() => $this->updateTagsStatus())
            ->everyMinute()
            ->weekdays()
            ->description('update tag status');

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

    protected function updateTagsStatus()
    {
        Tags::whereRaw('id IN (SELECT tag_id FROM people WHERE tag_id IS NOT NULL)')
            ->update(['status' => 'Ativo', 'sub_status' => 'Em uso']);
    }

    protected function insertNullTagRoomRegister()
    {
        $tag = TagRoom::inRandomOrder()->first(['tag_id', 'people_id']);
        TagRoom::create([
            'tag_id' => $tag->tag_id,
            'room_id' => null,
            'people_id' => $tag->people_id,
        ]);
    }
}
