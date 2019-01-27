<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This records all the incoming clicks on the links which was
		 * posted out by SMM */
        Schema::create('smmin', function (Blueprint $table) {
            $table->increments('id');

			/* All incoming clicks must be related back to the original
			 * post by SMM */
			$table->integer('smmout_id')->unsigned();

			/* If possible relate to the clicker's account */
			$table->integer('smedia_id')->unsigned();

			/* Clicker's source IP address */
			$table->string('source_ip');

			/* Clicker's response */
			$table->enum('response', array('view','buy'));

            /* Save porder_id after a successful 'buy' */
            $table->integer('porder_id')->unsigned();

            /* Quantity of product bought*/
            $table->integer('quantity')->unsigned()->default(1);

			/* Has commmission been claimed by SMM? */
			$table->boolean('comm_claimed')->default(false);


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
        Schema::drop('smmin');
    }
}
