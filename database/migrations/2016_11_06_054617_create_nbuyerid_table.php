<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNbuyeridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nbuyerid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('nbuyer_id')->unique();
			$table->integer('user_id')->unsigned();
			$table->integer('buyer_id')->unsigned();
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
        Schema::drop('nbuyerid');
    }
}
