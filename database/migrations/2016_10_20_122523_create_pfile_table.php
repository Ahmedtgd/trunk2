<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pfile', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->text('path')->nullable();
			$table->mediumText('gzipped_pfile')->nullable();
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
		Schema::drop('pfile');
	}

}
