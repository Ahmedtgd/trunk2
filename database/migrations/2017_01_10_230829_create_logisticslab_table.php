<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticslabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void

		THIS TABLE IS OBSOLETE.
		logistic_id has been subsumed into slab as a FK itself.
     */
    public function up()
    {
        Schema::create('logisticslab', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slab_id')->unsigned();
            $table->integer('logistic_id')->unsigned();
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
        Schema::drop('logisticslab');
    }
}
