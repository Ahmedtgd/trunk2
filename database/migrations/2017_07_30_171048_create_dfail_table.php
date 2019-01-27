<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDfailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This to capture the state of a delivery failure */
        Schema::create('dfail', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('delivery_id')->unsigned();

			// Store which direction delivery is going:
			// Merchant2Buyer or Buyer2Merchant
			$table->enum('dtype',['m2b','b2m'])->default('m2b');

			// Store which delivery failure this is
			$table->enum('fail_status',
				['dfailed1','dfailed2','return_to_sender']);
			// Toggle for display in MRT
			$table->boolean('dtoggle')->default(false);
			// Reason of delivery failure
			$table->string('comment');
			// When did this delivery attempt fail?
			$table->datetime('attempt');
			// When has this delivery been rescheduled to?
			$table->datetime('rescheduled');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'MYISAM';
        });
    }

    /** * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dfail');
    }
}
