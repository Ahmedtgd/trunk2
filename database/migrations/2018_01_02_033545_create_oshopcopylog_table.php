<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOshopcopylogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oshopcopylog', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('old_oshop_id')->unsigned();
            $table->integer('oshop_id')->unsigned();
            $table->integer('old_merchant_id')->unsigned();
            $table->integer('new_merchant_id')->unsigned();
            $table->text('notes');
            /*The admin who processed the transfer*/ 
            $table->integer('admin_user_id')->unsigned();
			$table->enum('status',['success','failure','pending'])->
				default('pending');
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
        Schema::drop('oshopcopylog');
    }
}
