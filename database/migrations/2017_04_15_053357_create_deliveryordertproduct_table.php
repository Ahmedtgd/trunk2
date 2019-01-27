<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryordertproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryordertproduct', function(Blueprint $table) {
        	$table->increments('id');
			$table->integer('do_id')->unsigned();
			$table->integer('tproduct_id')->unsigned();
			$table->enum('status',
				array('delivered','undelivered', 'partial', 'pending'));
			$table->integer('quantity');
			$table->string('remark');
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
        Schema::drop('deliveryordertproduct');
    }
}
