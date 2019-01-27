<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmmVisitorLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('smm_visitor_log', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('smm_id')->unsigned();
			$table->integer('porder_id')->unsigned();
			$table->string('media_name');
			$table->string('no_of_click');
			$table->string('ip_address');
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
        Schema::drop('smm_visitor_log');
        //
    }
}
