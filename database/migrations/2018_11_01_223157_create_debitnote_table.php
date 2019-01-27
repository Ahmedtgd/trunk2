<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitnoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debitnote', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('debitnote_no')->unsigned();
			$table->integer('dealer_user_id')->unsigned();
			$table->string('description');
			/* This stores the monetary value in cents in the DB */
			$table->integer('total')->unsigned();

			$table->enum('payment_status', [
				'unpaid','partial','full','offset'
			])->default('unpaid');

			$table->enum('status', [
				'active','pending','approved','rejected'
			])->default('active');

            $table->timestamps();
            $table->softDeletes();
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
        Schema::drop('debitnote');
    }
}
