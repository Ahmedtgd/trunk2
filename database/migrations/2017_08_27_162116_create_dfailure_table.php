<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDfailureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table stores the delivery failure for logistics */
        Schema::create('dfailure', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('delivery_id')->unsigned();
            $table->enum('type',['m2b','b2m']);
            $table->integer('attempt')->unsigned()->default(0);

			// We cannot have the same delivery having the same attempt
			$table->unique(['delivery_id', 'attempt']);

            $table->timestamp('failure_timestamp');
            $table->string('failure_comment');
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
        Schema::drop('dfailure');
    }
}
