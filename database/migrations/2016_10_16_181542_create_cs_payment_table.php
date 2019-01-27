<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCspaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cs_payment', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->integer('amount')->unsigned();

			/* This is the status of the order, which may be cancelled */
			$table->enum('status', 
				array('pending','awaiting','cancelled','executed'))
					->default('pending');

			$table->date('period_start');
			$table->date('period_end');
			$table->date('date_confirm')->nullable();
			$table->text('remark')->nullable();
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
		Schema::drop('cs_payment');
	}

}
