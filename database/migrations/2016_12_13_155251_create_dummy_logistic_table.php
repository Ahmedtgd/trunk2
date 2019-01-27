<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDummyLogisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dummylogistic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id');
            $table->integer('qr_management_id');
            $table->enum('priority',['low','normal','high','top'])->default('normal');
            
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
        Schema::drop('dummylogistic');
    }
}
