<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walletlog', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('wallet_id')->unsigned();
			// The flow of the points
			$table->enum('mode',['in','out']);
			// Amount of points in question
			$table->integer('amount_pts')->unsigned();
			// For any purchases: FK to receipt
			$table->integer('receipt_id')->unsigned();
			$table ->softDeletes();
            $table->timestamps();
			$table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('walletlog');
    }
}
