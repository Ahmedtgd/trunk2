<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sproperty', function (Blueprint $table) {
            $table->increments('id');

			/* station:sproperty = 1:m */
			$table->integer('station_id')->unsigned();

			$table->integer('shop_size')->unsigned();
			$table->string('prop_owner_first_name');
			$table->string('prop_owner_last_name');
			$table->string('prop_owner_contact');
			$table->integer('address_id')->unsigned();

			$table->string('biz_owner_first_name');
			$table->string('biz_owner_last_name');
			$table->string('biz_owner_contact');
			$table->string('biz_name');
			$table->string('outlet_name');

             /* Status */
            $table->enum('status', array('pending','active','dormant',
                'barred','suspended','rejected'))->default('pending'); 

 			/* Note for station */
			$table->string('note');

 			/* Station industry: For different industries of stations */
			$table->enum('industry', ['logistic','carpark','cafedining',
				'shopping'])->default('shopping');

			/* Station type: For different industries of stations */
			$table->integer('stationtype_id')->unsigned();

			/* Station character: Either consumer or network */
			$table->enum('scharacter', ['network','consumer']);
 

 			/* Delivery capability of a station */
			$table->enum('delivery_mode', array('pickup','pickup;sys_delivery',
				'pickup;own_delivery'))->default('pickup;sys_delivery');

			/* sproperty:outlet = 1:1 */
			$table->integer('outlet_id')->unsigned();

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
        Schema::drop('sproperty');
    }
}
