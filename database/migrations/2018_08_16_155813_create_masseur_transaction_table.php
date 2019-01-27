<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasseurTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_masseurtxn', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('masseur_member_id')->unsigned();
            $table->integer('receipt_id')->unsigned();
            $table->timestamp('checkin_tstamp')->nullable();
            $table->timestamp('checkout_tstamp')->nullable();
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
        Schema::drop('opos_masseurtxn');
    }
}
