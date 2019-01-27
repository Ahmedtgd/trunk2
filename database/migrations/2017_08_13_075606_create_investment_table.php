<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('company_name');
			$table->string('url');
			$table->string('mobile');
			$table->string('description');
			$table->string('email');
			$table->integer('country_id')->unsigned();
			
			$table->enum('investor_type',array(
				'accreditor','angel','institutional','other'))->
				default('other');

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
        Schema::drop('investment');
    }
}
