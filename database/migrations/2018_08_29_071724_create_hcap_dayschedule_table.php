<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapDayscheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_dayschedule', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('mgrscheduler_id')->unsigned();
 			$table->dateTime('day');
			$table->integer('full_force')->unsigned();
			$table->enum('status',['optimum','exceed','insufficient','pubholiday','nonworkday']);
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
        Schema::drop('hcap_dayschedule');
    }
}
