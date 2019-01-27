<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('station_id')->unsigned();
            $table->float('logistic_commission')->unsigned();
			$table->float('surcharge')->unsigned();
            $table->boolean('api');
            $table->boolean('professional')->default(false);

            /* Status */
            $table->enum('status', array('pending','active','dormant',
                'barred','suspended','rejected'))->default('active');

			/* Access Token: for accessing their API */
			$table->string('access_token');

            /* restricted [true,false]
			 * If a logistic provider restricted is true , then it should 
			 * not be included in any Delivery Intelligence and as such,
			 * that logistic provider can only deliver products attached
			 * to his merchant_id */ 
            $table->boolean('restricted')->default(false);

            /* volfactor = volumetric factor:
			 * CitiLink -> 5000
			 * NinjaVan -> 5000
			 * KTMD -> 6000 */ 
            $table->integer('volfactor')->unsigned()->default(5000);

			/* FK to store the logistic grade via "lgrade" table */
			$table->integer('lgrade_id')->unsigned();
            
            /* Sequence for consignment_number*/
            //$table->integer('consignment_number')->unsigned();
            
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
         Schema::drop('logistic');
    }
}
