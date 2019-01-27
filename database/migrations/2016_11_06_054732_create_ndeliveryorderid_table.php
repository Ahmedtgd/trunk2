<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNdeliveryorderidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ndeliveryorderid', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('ndeliveryorder_id')->unique();
			$table->integer('deliveryorder_id')->unsigned();
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
        Schema::drop('ndeliveryorderid');
    }
}
