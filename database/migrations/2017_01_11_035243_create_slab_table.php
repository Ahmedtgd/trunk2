<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slab', function (Blueprint $table) {
            $table->increments('id');

			/* FK to which logistic provider.
			 * Note: logisticslab is now OBSOLETED
			 */
            $table->integer('logistic_id')->unsigned();

            $table->integer('weight')->unsigned();	// g
            $table->integer('height')->unsigned();	// cm
            $table->integer('width')->unsigned();	// cm
            $table->integer('length')->unsigned();	// cm

            $table->integer('base_price')->unsigned();
            /*
                The incremental_price is the price applied per extra unit.
				Suppose product weight is 1500g  but logistic says for 1000g
				we have fixed rate of 1 MYR and for each 500g increment we
				charge 1MYR so increment_price is 1 MYR increment_unit is 500g
            */ 
            $table->integer('incremental_price');	// MYR
            $table->integer('incremental_unit');	// g
            $table->integer('incremental_unit');	// g
            /*
				Optional: to fix the rate for a region if coverage_area is
				'all' it means the pricing is for all region
            */
            $table->enum('coverage_area',['all','del_malaysia']);
            /*
				Optional: The special delivery pricing could be pricing for a
				certain time or period, like winters sale done by LOGISTIC
				PROVIDER AND NOT US.

				EXPERIMENTAL
            */ 
            $table->integer('specialdeliveryoffer')->unsigned();
			
			$table->boolean('locked')->default(false);

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
        Schema::drop('slab');
    }
}
