<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryinvoiceqrTable extends Migration
{
	public function up() {
		Schema::create('deliveryinvoiceqr', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('deliveryinvoice_id')->unsigned();
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
		Schema::drop('deliveryinvoiceqr');
	}
}
