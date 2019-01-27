<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmmoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		/* This table records all the outgoing SMM posts */
        Schema::create('smmout', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();
            /* Total number of friends/connections for the user who posted 
               connections is a much generic word  */
            $table->integer('connections')->unsigned();

			/* Records the number of shares that has been attributed
			 * to this link */
			$table->integer('shares')->unsigned();

			/* Generic Social Media: object_id */
			$table->string('object_id');

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
        Schema::drop('smmout');
    }
}
