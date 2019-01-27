<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerComplaintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyercomplaint', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id');
            $table->integer('reference_id');
            $table->integer('complaint_reason_id');
            $table->enum('share_with_merchant',array('yes','no'))->default('no');
            $table->enum('priority',array('low','normal','high','top'))->default('normal');
            $table->string('description');
            $table->enum('status',['resolved','unresolved']);
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
        Schema::drop('buyercomplaint');
    }
}
