<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Table to store the timeslots that make up a product voucher */
        Schema::create('timeslot', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('voucher_id');

			$table->date('booking');
			$table->time('from');
			$table->time('to');
			$table->integer('qty_left');
			$table->integer('qty_ordered');
			$table->integer('price');

			$table->softDeletes();
            $table->timestamps();

            $table->engine = 'MYISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timeslot');
    }
}
