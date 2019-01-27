<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposSaleslogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_saleslog', function (Blueprint $table) {
            $table->increments('id');
            /*Product ID is not unique*/
            $table->integer('product_id')->unsigned();
            $table->integer('terminal_id')->unsigned();

			/* The start/end time for a service */
			$table->timestamp('start');
			$table->timestamp('end');

			/* FKs to track the OPTIONAL usage of keys and sparoom */
			$table->integer('lockerkeytxn_id')->unsigned();
			$table->integer('sparoom_ftype_id')->unsigned();
            $table->integer('masseur_id')->unsigned();

			$table->integer('quantity')->unsigned()->default(1);
			$table->integer('price')->unsigned();
			$table->float('discount')->unsigned();
			$table->integer('discount_id')->unsigned();


			/*$table->enum('status',['active','unpaid','pending','paid'])->
				default('active');*/
            $table->enum('status',['active','completed','pending'])->
                default('active');


			/* Note that not all records are paid, so this may be null 
            FK to opos_receiptproduct
            */
            $table->integer('receiptproduct_id')->unsigned();
            $table->integer('commission_amt')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('opos_saleslog');
    }
}
