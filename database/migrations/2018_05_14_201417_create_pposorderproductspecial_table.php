<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePposorderproductspecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppos_orderproductspecial', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pposorderproduct_id')->unsigned();
            $table->integer('platyposproductspecial_id')->unsigned();
            $table->integer('order_price');
            $table->integer('quantity');
            $table->enum('status',["pending","active","cancelled"]);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('ppos_orderproductspecial');
    }
}
