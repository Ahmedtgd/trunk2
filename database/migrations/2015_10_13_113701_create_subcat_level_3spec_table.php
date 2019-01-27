<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcatLevel3specTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcat_level_3spec', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('subcat_level_3_id')->unsigned();
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
        Schema::drop('subcat_level_3spec');
    }
}
