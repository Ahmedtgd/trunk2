<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profileproduct', function (Blueprint $table) {
            $table->increments('id');

			/* M:N relationship between a Profile and Products */
            $table->integer('profile_id')->unsigned();
            $table->integer('product_id')->unsigned()->unique();

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
        Schema::drop('profileproduct');
    }
}
