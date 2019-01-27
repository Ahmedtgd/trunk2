<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranddocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This is to relate a merchant and his brand authorization
		 * letters or certificates. This is to certify that this organization
		 * has the right to resell and distributors a product from the
		 * principal or manufacturer */
		Schema::create('branddocument', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('merchant_id')->unsigned();
			$table->integer('brand_id')->unsigned();
			$table->integer('document_id')->unsigned();

			/* A merchant can only carry one brand ONCE */ 
			$table->unique(['merchant_id','brand_id']);
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
        Schema::drop('branddocument');
    }
}
