<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseorderitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorderitem', function (Blueprint $table) {
            $table->increments('id');
 			$table->integer('purchaseorder_id')->unsigned;
			$table->string('purchaseorderitem_no');
			$table->string('description');
			$table->integer('total')->unsigned;
            $table->softDeletes();
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
        Schema::drop('purchaseorderitem');
    }
}
