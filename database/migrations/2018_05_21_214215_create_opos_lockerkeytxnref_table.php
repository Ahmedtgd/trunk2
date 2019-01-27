<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposLockerkeytxnrefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_lockerkeytxnref', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receipt_no')->unsigned();
            $table->integer('lockerkeytxn_id')->unsigned();
            $table->integer('receipt_id')->unsigned();
            $table->string('ref_no');
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
        Schema::drop('opos_lockerkeytxnref');
    }
}
