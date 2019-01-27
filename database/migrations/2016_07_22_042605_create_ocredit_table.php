<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocredit', function (Blueprint $table) {
            $table->increments('id');

			/* Security ID */
			$table->string('security_id');

            $table->integer('product_id')->unsigned();
            $table->integer('merchant_id')->unsigned();
            $table->integer('porder_id')->unsigned();
            $table->integer('value')->unsigned();
            $table->integer('usd')->unsigned();
            $table->integer('smmout_id')->unsigned();
            $table->integer('openwish_id')->unsigned();
            $table->integer('owarehouse_id')->unsigned();
            $table->integer('cre_id')->unsigned();
            $table->integer('ref_no')->unsigned();
            $table->integer('mcredit_id')->unsigned();
			$table->enum('source',
				['smm','openwish','hyper','cre','mcredit','purchase']);

            /* Update: Added support for credit/debit for ocredit. 
                Not Nullable, No Default */
            $table->enum('mode',['credit','debit']);

            /* Update: Added support for ocredit status */
            $table->enum('status',['success','pending','failed'])->default('pending');
    

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
        Schema::drop('ocredit');
    }
}
