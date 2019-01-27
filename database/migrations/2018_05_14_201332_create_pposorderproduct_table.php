<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePposorderproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppos_orderproduct', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("pposporder_id")->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('order_price')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->enum("status",["pending","active","suspended","cancelled","inprogress","cooked","waitingforpickup","expired"]);
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
        Schema::drop('ppos_orderproduct');
    }
}
