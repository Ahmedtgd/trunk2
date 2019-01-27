<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owarehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->unique();
            $table->integer('moq')->unsigned();
            $table->integer('moqperpax')->unsigned();
			/* The price for a colletion, can be a box, carton,
			   container or unit */
            $table->integer('collection_price')->unsigned();

			/* The number of units within a collection; i.e. number
			   of units in a container or box */
            $table->integer('collection_units')->unsigned();

			/* The duration of OWarehouse sale */
            $table->integer('duration')->unsigned()->default(30);
            $table->integer('deliverypax')->unsigned()->default(0);

			/* The average price of a unit. This will be used to
			   calculate the discount:
			   $ave_unit_price = collection_price / collection_units;
			   ((ori_price - ave_unit_price)/orig_price)*100% */
            //$table->integer('ave_unit_price')->unsigned();

			$table->enum('collection',array('box','carton',
				'container','unit'))->default("unit");

			/* This column will keep track of Owarehouse status.
			 * To be update preferably through a cron script. */
			$table->enum('status',array(
				'active','inactive','executed','expired','suspended'))->
				default('inactive');

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
        Schema::drop('owarehouse');
    }
}
