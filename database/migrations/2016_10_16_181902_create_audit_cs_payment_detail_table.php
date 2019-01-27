<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditcspaymentdetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_cs_payment_detail', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('cs_id')->unsigned();
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
		Schema::drop('audit_cs_payment_detail');
	}

}
