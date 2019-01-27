<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapOtptrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_otptrate', function (Blueprint $table) {
            $table->increments('id');

			// Rate in cents per hour
            $table->integer('rate_hr')->unsigned();

			// Over Time Block in minutes
			$table->integer('block')->unsigned();

            // Mode can be either 'OT' (OverTime) or 'PT' (PartTime)
			$table->enum('mode',['ot','pt']);

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
        Schema::drop('hcap_otptrate');
    }
}
