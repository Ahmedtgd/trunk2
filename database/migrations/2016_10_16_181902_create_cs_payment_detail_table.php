<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCspaymentdetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cs_payment_detail', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('cs_payment_id')->unsigned();
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
		Schema::drop('cs_payment_detail');
	}

}
