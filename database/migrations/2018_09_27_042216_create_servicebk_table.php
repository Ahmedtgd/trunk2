<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicebkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicebk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repairchit_id')->unsigned();
            $table->integer('tech_user_id')->unsigned();
            $table->integer('rating')->unsigned();
            $table->text('remarks');
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
        Schema::drop('servicebk');
    }
}
