<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrdwarrantyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prdwarranty', function (Blueprint $table) {
            $table->increments('id');
			$table->string('brand');
			$table->string('serial_no');
			$table->string('imei');
			$table->string('model');
			$table->integer('merchant_id')->unsigned();
			$table->dateTime('purchase_date');
			$table->string('nric_passport');
			$table->enum('regtype',['corporate','individual']);
			$table->dateTime('end_warranty');
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
        Schema::drop('prdwarranty');
    }
}
