<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Each record represents a Bank */

		Schema::create('bank', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('code');
			$table->string('company_name');
			$table->string('logo');
			$table->string('status');
			$table->integer('address_id')->unsigned();

			/* Website for eBanking, FK points to website table */
			$table->string('ebanking_website_id');

			/* Website for eBanking API, FK points to website table */
			$table->string('ebanking_api_website_id');

			$table->string('description');
			$table->char('routing_id',9);
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
		Schema::drop('bank');
	}

}
