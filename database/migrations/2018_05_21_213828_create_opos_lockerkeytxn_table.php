<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposLockerkeytxnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_lockerkeytxn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lockerkey_ftype_id')->unsigned();
            $table->timestamp('checkin_tstamp')->nullable();
            $table->timestamp('checkout_tstamp')->nullable();
            $table->integer('custspa_id')->unsigned();
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
        Schema::drop('opos_lockerkeytxn');
    }
}
