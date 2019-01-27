<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableSellerHelp extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("seller_help", function (Blueprint $table) {
			$table->increments('id');
			$table->integer('porder_id');
			$table->string('name');
			$table->string('phone');
			$table->string('email');
			$table->string('company_name');
			$table->string('business_reg_no');
			$table->text('remarks')->nullable();
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
	public function down() {
		Schema::drop("seller_help");
	}
}
