<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpensupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('opensupport', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('full_name');
			$table->string('contact_number');
			$table->string('email');
			$table->string('as_a');
			$table->string('company_name');
			$table->string('corporate_number');			
			$table->string('corporate_email');	
			$table->integer('order_id')->unsigned();			
			$table->string('remark');			
			$table->string('type');	

			$table->softDeletes();
			$table->timestamps();

            $table->engine = 'MYISAM';			
        });
		//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::drop('opensupport');
    }
}
