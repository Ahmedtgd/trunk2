<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditCardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_card', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('bank_id');
			$table->string('number');
			$table->string('name');
			$table->date('expiry');
			$table->string('cvv');
			$table->timestamps();
            $table->softDeletes();

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
		Schema::drop('credit_card');
	}

}
