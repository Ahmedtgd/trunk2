<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantQrTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* This table implement product:merchant = m:n relationship */

		Schema::create('merchantqr', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('merchant_id')->unsigned();
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
		Schema::drop('merchantqr');
	}
}
