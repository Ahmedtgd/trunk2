<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposTerminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This tables tracks the individual OPOSsum POS systems */
        Schema::create('opos_terminal', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name");
			$table->string("description");
			$table->time("start_work");
            $table->time("close_work");
            
			$table->time("end_work");

			/* We'd probably have different types of POS:
			$table->enum("type", ['foo','bar','baz']); */

			/* We'd probably keep track of IP or Hardware addresses.
			 * Perhaps even asset tags, or IDs: */
			$table->string("ip_addr");
			$table->string("hardware_addr");
			$table->string("asset_id");

			/* Business function affecting OPOsum and PlatyPOS */
			$table->enum('bfunction', ['spa','table','hotel','car','retail']);
            /*Otherpoint type*/
            /*
                North is when Other Points is excluded from Service Tax
            */
            $table->enum('otherpointmode',['north','south'])->default('south');
            $table->enum('mode',['inclusive','exclusive'])->default('inclusive');
			$table->enum('status', ['pending','active','suspended'])->
				default('active');
			$table->string("counter");

			$table->integer('report_no')->unsigned();
			$table->integer('receipt_no')->unsigned();
			$table->integer('servicecharge_id')->unsigned();
            /*To check if a terminal in use*/
            $table->integer('logged_user_id')->unsigned()->nullable();
            $table->string("local_logo");

            /*For address preference*/
            $table->integer('address_id')->unsigned();
            
            $table->boolean('show_sst_no')->default(false);

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
        Schema::drop('opos_terminal');
    }
}
