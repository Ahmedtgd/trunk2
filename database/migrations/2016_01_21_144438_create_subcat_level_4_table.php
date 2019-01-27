<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcatLevel4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcat_level_4', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('subcat_level_1_id')->unsigned();
			$table->integer('subcat_level_2_id')->unsigned();
			$table->integer('subcat_level_3_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->string('logo');
            $table->enum('type',array('product','voucher'))->default('product');
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
        Schema::drop('subcat_level_4');
    }
}
