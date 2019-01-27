<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableBuyerHelp extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("buyer_help", function (Blueprint $table) {
			$table->increments('id');
			$table->integer('porder_id')->unsigned();
			$table->string('name');
			$table->string('phone');
			$table->string('email');
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
		Schema::drop("buyer_help");
	}
}
