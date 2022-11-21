<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MviewTagRooom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE MATERIALIZED VIEW mv_tag_room AS
                SELECT DISTINCT ON (tr.tag_id, tr.people_id)
                    tr.created_at,
                    tr.tag_id,
                    tr.people_id,
                    tr.room_id,
                    t.company_id
                FROM tag_room tr
                JOIN tags t ON tr.tag_id = t.id
                ORDER BY tr.tag_id, tr.people_id, tr.created_at DESC;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW mv_tag_room');
    }
}
