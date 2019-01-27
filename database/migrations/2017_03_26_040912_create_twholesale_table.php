<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwholesaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twholesale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tproduct_id')->unsigned();

			/* E.g.:
			 *  20-49  units, $100
			 *  50-99  units, $80
			 * 100-149 units, $60
			 * funit=20,  unit=49,  price=100
			 * funit=50,  unit=99,  price=80
			 * funit=100, unit=149, price=60
			 */

			/* From this unit: */
            $table->integer('funit')->unsigned();

			/* To this unit */
            $table->integer('unit')->unsigned();

            $table->integer('price')->unsigned();
            $table->integer('delivery_cost')->unsigned();


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
        Schema::drop('twholesale');
    }
}
