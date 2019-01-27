<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairchitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairchit', function (Blueprint $table) {
            $table->increments('id');
			$table->string('cust_name');
			$table->string('phone');
			$table->string('brand');
			$table->string('model_name');
			$table->string('serial_no');
			$table->string('imei');
			$table->enum('type',['walkin','dealer','courier']);
			$table->string('dealer');
			$table->string('branch');
			$table->text('remarks');
			$table->integer('requested_by_user_id')->unsigned();
			$table->dateTime('requested_by_dt');
			$table->integer('handled_by_user_id')->unsigned();
			$table->dateTime('handled_by_dt');

			$table->integer('picked_up_by_user_id')->unsigned();
			$table->dateTime('picked_up_by_dt');
			$table->integer('pu_verified_by_user_id')->unsigned();
			$table->dateTime('pu_verified_by_dt');

			$table->integer('delivered_by_user_id')->unsigned();
			$table->dateTime('delivered_by_dt');
			$table->integer('del_verified_by_user_id')->unsigned();
			$table->dateTime('del_verified_by_dt');

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
        Schema::drop('repairchit');
    }
}
