<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReportProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockreportproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('stockreport_id')->unsigned();
            /*To be inputted by creator*/ 
            $table->integer('quantity')->unsigned();
            /*To be inputted by checker*/ 
            $table->integer('received')->unsigned();

            /* Opening Balance, copy of product.consignment at
			 * the point of write */
            $table->integer('opening_balance')->unsigned();

            $table->enum('status',['checked','unchecked'])->default('unchecked');
            $table->integer('lost')->unsigned();
            $table->integer('damaged')->unsigned();

			$table->string('remark');
			$table->string('image');
            
            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('stockreportproduct');
    }
}
