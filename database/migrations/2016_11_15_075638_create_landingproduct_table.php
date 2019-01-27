<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landingproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unique()->unsigned();
            $table->softDeletes();
            $table->engine = 'MYISAM';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('landingproduct');
    }
}
