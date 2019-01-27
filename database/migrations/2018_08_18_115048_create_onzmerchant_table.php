<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnzmerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onzmerchant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('onz_owner_merchant_id')->unsigned();
            $table->integer('user_merchant_id')->unsigned();
            $table->enum('status',['active','suspended','pending'])->default('active');
            $table->enum('access',['mps','all'])->default('all');
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
        Schema::drop('onzmerchant');
    }
}
