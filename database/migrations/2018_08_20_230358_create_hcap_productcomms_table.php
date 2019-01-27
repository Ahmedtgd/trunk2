<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapProductcommsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcap_productcomm', function (Blueprint $table) {
            $table->increments('id');
 			$table->integer('product_id')->unsigned();

			// This is the salesperson which this commission is defined
			// for. Can be a masseur for the Spa business. This is a FK
			// to the member table, because the sales may not be registered
			// so that users.id may not exist
			$table->integer('sales_member_id')->unsigned();

			// This is fixed amount (eg. MYR 20.00) commission per product
			// in cents
			$table->integer('commission_amt')->unsigned();

			// This is the amount of time in MINUTES allocated for a
			// service product
			$table->integer('time')->unsigned();

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
        Schema::drop('hcap_productcomm');
    }
}
