<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcatLevel1specTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcat_level_1spec', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('subcat_level_1_id')->unsigned();
			$table->integer('spec_id')->unsigned();
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
        Schema::drop('subcat_level_1spec');
    }
}
