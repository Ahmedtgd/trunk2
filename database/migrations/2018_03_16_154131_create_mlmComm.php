<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatMlmComm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlmcomm', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('sales_amount')->unsigned();
            $table->integer('clan_def')->unsigned();
            $table->integer('family_def')->unsigned();
            $table->integer('scbonus_sales')->unsigned();
            $table->integer('scbonus_amount')->unsigned();

            $table->softdeletes();
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
        Schema::drop('mlmcomm');
    }
}
