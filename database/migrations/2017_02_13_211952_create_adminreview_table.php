<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminreview', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderproduct_id')->unsigned();

            // Investigative Actions
            /*
            1) boef ->based on existing fact

            */ 
            $table->boolean('boef')->default(false);
            $table->boolean('call_merchant')->default(false);
            $table->boolean('call_buyer')->default(false);
            $table->text('conclusion');
            $table->enum('awarded',['merchant','buyer']);
            $table->enum('status',['success','pending','failed']);
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
        Schema::drop('adminreview');
    }
}
