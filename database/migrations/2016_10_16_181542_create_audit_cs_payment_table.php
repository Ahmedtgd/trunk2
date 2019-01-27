<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditcspaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_cs_payment', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('cs_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->integer('amount')->unsigned();

			/* This is the status of the invididual product within an order,
			 * which may be cancelled or returned */
			$table->enum('status', 
				array('pending','awaiting','cancelled','executed'))
					->default('pending');

			$table->date('period_start');
			$table->date('period_end');
			$table->date('date_confirm')->nullable();
			$table->integer('pfile_id')->nullable();
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
		Schema::drop('audit_cs_payment');
	}

}
