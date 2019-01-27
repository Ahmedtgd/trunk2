<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->string('description');
			$table->string('footer_note');
			$table->string('email');
			$table->integer('price')->unsigned();
			$table->integer('merchant_id')->unsigned();
			$table->integer('admin_user_id')->unsigned();
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
        Schema::drop('adjustment');
    }
}
