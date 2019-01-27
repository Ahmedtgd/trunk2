<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cre', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('type', array('cancel', 'return', 'exchange'));

			/* For now we are not taking any reason for cancellation
			 * on behalf of user. Might change. */
            //$table->integer('crereason_id')->unsigned();

            $table->integer('porder_id')->unsigned();

			/* Added product_id. This is defaulted to Null. But will
			 * hold value if a return product request is initiated and
			 * this it will hold the product id. */
            //$table->integer('product_id')->unsigned()->nullable();

            $table->enum('status', array('success', 'fail', 'pending'));
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
        Schema::drop('cre');
    }
}
