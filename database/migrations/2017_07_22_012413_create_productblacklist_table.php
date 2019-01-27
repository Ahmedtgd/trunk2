<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductblacklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('productblacklist', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('user_id')->unsigned();
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
        Schema::drop('productblacklist');
    }
}
