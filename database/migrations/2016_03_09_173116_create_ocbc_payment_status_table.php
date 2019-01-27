<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcbcPaymentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocbc_payment_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porder_id');
            $table->integer('user_id');
            $table->integer('product_id');
			$table->enum('type',['str','sto','mct','mcp','smm','psh'])
				->default('mct');
            $table->unique(['porder_id', 'product_id', 'user_id','type']);
            $table->integer('ocbcgiro_return_id')->unsigned();
            $table->integer('ocbcgiro_reject_id')->unsigned();
            $table->boolean('success_indicator')->default(false);
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
        Schema::drop('ocbc_payment_status');
    }
}
