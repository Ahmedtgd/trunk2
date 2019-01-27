<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users", function(Blueprint $table){
			$table->increments('id');
			$table->integer('occupation_id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('name');
			$table->char('nric', 12);
			
			$table->string('username')->nullable();
			$table->string('email')->unique();
			$table->string('alt_email');
			$table->integer('language_id')->unsigned();

			/* FK to table country */
			$table->integer('nationality_country_id')->unsigned();

			$table->string('avatar');
			$table->string('provider');
			$table->string('provider_id');
			$table->string('access_token');
			
			$table->date('birthdate');
			$table->string('mobile_no');
			$table->string('password');
			$table->string('access_code');
			$table->enum('gender',array('male','m','female','f'))->nullable();
			$table->enum('annual_income',array('<30k','30-49k','50-59k','60-75k','75-99k','100-119k','120-149k','150-299k','>300k'))->nullable();
			$table->enum('salutation',array('Mr','Mrs','Ms','Ir','Dr','Dato','Tan Sri','Dato Seri'))->nullable();

			$table->integer('default_address_id')->unsigned();
			$table->integer('billing_address_id')->unsigned();
			$table->integer('shipping_address_id')->unsigned();
			
			/*** Password Continuos Attemps ***/
			$table->integer('password_fail')->default(0)->unsigned();

			$table->rememberToken()->nullable();
			$table->text('permissions')->nullable();
			$table->timestamp('last_login')->nullable();

			$table->integer('password_fail')->unsigned();
			$table->string('cc_token');

			$table->softDeletes();
			$table->timestamps();
			$table->engine = 'MyISAM';

		});

		DB::statement('ALTER TABLE users ADD FULLTEXT search(first_name,last_name,username,email)');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 // Schema::table('users', function($table) {

   //          $table->dropIndex('search');

   //      });

		Schema::drop("users");
	}

}
