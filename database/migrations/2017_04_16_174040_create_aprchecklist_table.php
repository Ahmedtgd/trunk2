<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprchecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Table to store the results of a Product and Merchant
		 * Approval Checklists */
        Schema::create('aprchecklist', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('merchant_id')->unsigned();
			$table->integer('admin_user_id')->unsigned();
			$table->integer('aprsection_id')->unsigned();
			$table->enum('status',['approved','rejected','pending']);

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
        Schema::drop('aprchecklist');
    }
}
