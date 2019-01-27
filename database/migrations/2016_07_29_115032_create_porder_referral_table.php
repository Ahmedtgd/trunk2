<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorderReferralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porder_referral',function(Blueprint $table){
            $table->increments('id');
            // FK to porder
            $table->integer('porder_id')->unsigned();
            // Just defaulted
            $table->enum('referrer',array('hyper','smm','openwish','autolink','normal'))->default('normal');
            // Referrer ID 
            /*if ref is hyper , then refererrer id would be the related hyper id */
            $table->integer('referrer_id');
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
        Schema::drop('porder_referral');
    }
}
