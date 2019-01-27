<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNdeliveryidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ndeliveryid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('ndelivery_id')->unique();
			$table->integer('delivery_id')->unsigned();
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
        Schema::drop('ndeliveryid');
    }
}
