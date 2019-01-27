<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantWizardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('merchant_wizard', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			
			$table->string('email');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('mobile');

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
		Schema::drop('merchant_wizard');
    }
}
