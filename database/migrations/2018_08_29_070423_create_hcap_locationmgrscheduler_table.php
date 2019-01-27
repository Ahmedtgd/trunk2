<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapLocationmgrschedulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_locationmgrscheduler', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('location_id')->unsigned();
			$table->integer('mgrscheduler_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hcap_locationmgrscheduler');
    }
}
