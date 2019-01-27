<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumancapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('humancap', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned()->unique();
			$table->string('company_name');

			/* gst holds the GST registration number */ 
			$table->string('gst')->nullable();
			$table->string('business_reg_no');
			$table->integer('country_id')->unsigned();
			$table->enum('business_type',array('sole_proprietorship',
				'partnership','sdn. bhd.','bhd.'))->nullable();

			/* merchant:director = 1:m */
			/* merchant:document = 1:m */
			/* merchant:website  = 1:m */

			$table->integer('address_id')->unsigned();
			$table->string('office_no');
			$table->string('mobile_no');

			/* Status */
			$table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected'))->default('pending');

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
        //
    }
}
