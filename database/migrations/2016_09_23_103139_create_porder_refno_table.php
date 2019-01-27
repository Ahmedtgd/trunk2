<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorderRefnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porderrefno', function (Blueprint $table) {
            $table->increments('id');
            // The ref no generated via epochj
            $table->integer('ref_no')->unsigned();
            // ref_no:porder_id=1:m
            $table->integer('porder_id')->unsigned();
            $table->enum('delivery_mode',array('self','service'));
            // Hybrid : when some amount paid by oc and some by bank
            $table->enum('payment_mode',array('ocredit','hybrid','ipay88','paypal'));
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
        Schema::drop('porderrefno');
    }
}
