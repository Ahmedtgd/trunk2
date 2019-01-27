<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposServicechargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('opos_lockerkeyproducts', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('lockerkey_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('receipt_id')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->nullable();
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
        //
         Schema::drop('opos_lockerkeyproducts');
    }
}
