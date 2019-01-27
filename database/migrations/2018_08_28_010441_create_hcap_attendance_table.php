<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('terminal_id')->unsigned();
            $table->integer('staff_user_id')->unsigned();
            $table->dateTime("checkin")->nullable();
            $table->dateTime("checkout")->nullable();
            
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('hcap_attendance');
    }
}
