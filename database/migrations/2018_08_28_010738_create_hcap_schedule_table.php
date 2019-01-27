<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_schedule', function (Blueprint $table) {
            $table->increments('id');
			// Schedule is for this staff
			$table->integer('staff_user_id')->unsigned();
			// Day being scheduled
			$table->date('scheduled_day');
			// FK to hcap_shift
			$table->integer('shift_id')->unsigned();
			// FK to hcap_leavetype
			$table->integer('leavetype_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hcap_schedule');
    }
}
