<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposSaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_save', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lockerkey_no')->unsigned();
			$table->timestamp('lockerkey_start');
			$table->timestamp('lockerkey_end');
			$table->integer('sparoom_no')->unsigned();
			$table->timestamp('sparoom_start');
			$table->timestamp('sparoom_end');
			// This is where all the products, qty and discount are stored
			$table->integer('receipt_id')->unsigned();
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
        Schema::drop('opos_save');
    }
}
