<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesmemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('salesmemo', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('fairlocation_id')->unsigned();
			$table->integer('creator_user_id')->unsigned();
      $table->integer('buyer_user_id')->unsigned();
			$table->enum('status',['active','confirmed','printed','voided','frozen'])->default('active');

			$table->string('consignment_account_no');
			$table->timestamp('confirmed_on');
			$table->softDeletes();

			/* Order received = created_at */
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
        Schema::drop('salesmemo');
    }
}
