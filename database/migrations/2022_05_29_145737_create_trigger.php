<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER `tr_moving_technics_insert` AFTER INSERT ON `moving_technics` FOR EACH ROW
            BEGIN
                UPDATE `technics` LEFT JOIN `premises` ON `premises`.`id` = NEW.premise_id
                   SET technics.cabinet = premises.number
                   WHERE technics.id = NEW.technic_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_moving_technics_insert`');
    }
}
