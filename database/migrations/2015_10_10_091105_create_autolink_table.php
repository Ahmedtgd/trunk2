<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAutolinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autolink', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			/* Initiator can be buyer, station or dealer:
			 * buyer_id, station_id */
			$table->integer('initiator')->unsigned();
			
			$table->boolean('b2c_enabled')->default(false);
			
			$table->boolean('visibility')->default(true);

			/* This is to support outlets in stations */
			$table->integer('sproperty_id')->unsigned();

			/* Responder can be merchant: merchant_id */
			$table->integer('responder')->unsigned();

			$table->enum('status', array('linked','unlinked', 'suspended',
				'requested'))->default('unlinked');
			$table->timestamp('linked_since');
			$table->unique(['initiator', 'responder', 'sproperty_id']);

			$table->softDeletes();
			$table->timestamps();
			$table->engine = "MyISAM";
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('autolink');
	}
}
