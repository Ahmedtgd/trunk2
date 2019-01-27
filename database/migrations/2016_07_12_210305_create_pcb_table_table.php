<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcbTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcb_table', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('p_min')->unsigned();
			$table->integer('p_max')->unsigned();
			$table->integer('m')->unsigned();
			$table->integer('r')->unsigned();
			$table->decimal('cat_1_3_b', 8, 2);
			$table->decimal('cat_2_b', 8, 2);
                                                        
            $table->softDeletes();
            $table->timeStamps();
            $table->engine = 'MyISAM';
        });	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pcb_table');
    }
}
