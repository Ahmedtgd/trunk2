<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oshop', function (Blueprint $table) {
            $table->increments('id');
			$table->string('oshop_name');
			$table->integer('brand_id')->unsigned();
			$table->integer('address_id')->unsigned();
			$table->integer('shop_size')->unsigned();
			$table->string('url');
			$table->string('original_url');
			$table->string('contact_first_name');
			$table->string('contact_last_name');
			$table->string('contact_mobile_no');

             /* Status */
            $table->enum('status',
				array('pending','inactive','active','dormant',
				'barred','suspended','rejected','transferred'))->
				default('pending'); 

			$table->boolean('single')->default(false);
			$table->timestamp('active_date');
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
        Schema::drop('oshop');
    }
}
