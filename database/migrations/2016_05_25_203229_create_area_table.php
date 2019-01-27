<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area', function(Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->string('name');
        $table->string('description');
        $table->integer('postcode')->unsigned();
        $table->integer('city_id')->unsigned();

        $table->softDeletes()->nullable;
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
		Schema::drop('area');
    }
}
