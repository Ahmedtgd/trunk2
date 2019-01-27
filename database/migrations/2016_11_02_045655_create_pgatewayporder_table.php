<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePgatewayporderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('pgatewayporder', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('payment_gateway_id');
            $table->integer('porder_id');
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
        Schema::drop('pgatewayporder');
    }
}
