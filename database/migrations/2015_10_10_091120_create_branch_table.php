<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branch', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('merchant_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->integer('address_id')->unsigned();
			$table->tinyInteger('valid_license')->unsigned();
			$table->tinyInteger('brand_ownership')->unsigned();
			$table->string('contact_name');
			$table->string('name');
			$table->string('code');
			$table->string('description');
			$table->enum('sales_quantity',array('<50','50-100','100-500','>500'))->nullable();
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
		Schema::drop('branch');
	}

}
