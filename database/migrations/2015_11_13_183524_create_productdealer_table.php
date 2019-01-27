<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductdealerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This is to implement Product:Dealer relationship for Wholesale
		 * pricing: Product:Dealer = m:n */
        Schema::create('productdealer', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('product_id')->unsigned();

			/* This is the dealer who has different pricing from resellers */
			$table->integer('dealer_id')->unsigned();

			/* For standard resellers, he/she is only entitled to multi-tieired
			 * pricing in the wholesale. There is only a single class of
			 * dealers/resellers */

			/* This is a special pricing available to invidual dealers.
			 * Individual has really special price */
 			/* E.g.:
			 *  20-49  units, $100
			 *  50-99  units, $80
			 * 100-149 units, $60
			 * funit=20,  unit=49,  price=100
			 * funit=50,  unit=99,  price=80
			 * funit=100, unit=149, price=60
			 */
			$table->integer('special_funit')->unsigned();
			$table->integer('special_unit')->unsigned();
            $table->integer('special_price')->unsigned();

            //newly added 
			//$table->integer('deleted');

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
        Schema::drop('productdealer');
    }
}
