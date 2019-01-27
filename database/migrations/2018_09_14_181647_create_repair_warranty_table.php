<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairWarrantyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_warranty', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('serial_bcmgmt_id')->unsigned();
			$table->integer('warranty_bcmgmt_id')->unsigned();
			$table->integer('servicebk_id')->unsigned();
			$table->date('dealer_distribution_date');
			$table->date('enduser_warranty_activation_date');
			$table->date('warranty_end');
			$table->string('authentication');
			$table->integer('servicectr_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repair_warranty');
    }
}
