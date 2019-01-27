<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directory', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('occupation_id')->unsigned();
			$table->string('company');
			$table->string('business_reg_no');
			$table->string('name')->nullable();
			$table->string('phone');
			$table->string('address');
			$table->string('email');
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
		Schema::drop("directory");}
}
