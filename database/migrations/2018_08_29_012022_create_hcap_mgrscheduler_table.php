<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapMgrschedulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_mgrscheduler', function (Blueprint $table) {
            $table->increments('id');
			// This is to contain the month
            $table->enum('month',[1,2,3,4,5,6,7,8,9,10,11,12]);
			// Location/branch FK is in another linktable
			// hcap_locationmgrscheduler
			$table->date('day');
			$table->integer('working')->unsigned();
			$table->integer('fullforce')->unsigned();
			$table->enum('status',['optimum','exceed','insufficient']);
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
        Schema::drop('hcap_mgrscheduler');
    }
}
