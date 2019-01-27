<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptQrTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* This table implement product:merchant = m:n relationship */

		Schema::create('receiptqr', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('receipt_id')->unsigned();
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
		Schema::drop('receiptqr');
	}
}
