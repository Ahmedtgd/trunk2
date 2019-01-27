<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_session', function(Blueprint $table) {
			$table->increments('id')->unsigned();

			//Foreign Key Must Always be Integer (Unsigned)
			$table->integer('smedia_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('connections')->unsigned();
			$table->string('client_id');
			$table->string('auth_code');
			$table->string('client_secret');
			$table->string('username');
			$table->string('access_token');
			$table->string('password');
			$table->string('ftoken');
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
		Schema::drop('oauth_session');
	}

}
