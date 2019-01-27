<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create("ocomment", function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('orderproduct_id')->unsigned();
			$table->text('comment');
			$table->softDeletes();
			$table->timestamps();
			$table->engine = 'MyISAM';

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
		Schema::drop("ocomment");
    }
}
