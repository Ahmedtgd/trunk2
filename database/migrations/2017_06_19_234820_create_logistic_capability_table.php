<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticCapabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('logisticcapability', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('logistic_id')->unsigned();
			$table->integer('capability_id')->unsigned();
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
        Schema::drop('logisticcapability');
    }
}
