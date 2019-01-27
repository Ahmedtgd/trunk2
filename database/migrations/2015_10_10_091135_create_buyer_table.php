<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyer', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('photo_1');
			$table->string('photo_2');
			$table->string('photo_3');
			$table->string('photo_4');
			$table->string('photo_5');
			$table->string('photo_6');
			$table->string('photo_7');

			$table->integer('bankaccount_id')->unsigned();
			$table->string('paypal_email');
			$table->string('company_name');
			$table->string('company_reg_no');
			$table->string('potential_industry');
			$table->string('products');
			$table->string('amount');
			$table->boolean('mct_appt')->default(false);
			$table->boolean('str_appt')->default(false);
			$table->boolean('emp_appt')->default(false);
			/* Status */
			$table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','closed','terminated'))->default('pending');
			$table->timestamp('active_date');
			$table->timestamp('closed_date');

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
		Schema::drop('buyer');
	}

}
