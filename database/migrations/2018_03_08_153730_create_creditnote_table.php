<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Creditnote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditnote', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('creditnote_no')->unsigned();
            $table->integer('dealer_user_id')->unsigned();
            $table->integer('return_of_goods_id')->unsigned();
            $table->integer('orderproductreturn_id')->unsigned();
            //$table->integer('quantity');
			$table->enum('status', [
				'active','pending','approved','rejected','unpaid','partial','full','offset'
			])->default('active');

 			/* This stores the monetary value in cents in the DB */
			$table->integer('total')->unsigned();
 
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
        Schema::drop('creditnote');
    }
}
