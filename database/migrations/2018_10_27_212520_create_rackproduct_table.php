<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRackproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rackproduct', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('product_id')->unsigned();
            $table->integer('rack_id')->unsigned();
            $table->integer('quantity')->unsigned()->default(0);
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
        Schema::drop('rackproduct');
    }
}
