<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerQrTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* This table implement buyer:qr = m:n relationship */

		Schema::create('buyerqr', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('buyer_id')->unsigned();
			$table->integer('qr_management_id')->unsigned()->unique();
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
		Schema::drop('buyerqr');
	}
}
