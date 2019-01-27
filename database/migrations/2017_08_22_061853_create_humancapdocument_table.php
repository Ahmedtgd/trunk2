<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumancapdocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		/* This is to relate a merchant and his business documents */
		Schema::create('humancapdocument', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('humancap_id')->unsigned();
			$table->integer('document_id')->unsigned();
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
		Schema::drop('humancapdocument');
	}
}
