<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcbGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcb_global', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('pcb_disabled')->unsigned();
			$table->integer('pcb_spouse_no_income')->unsigned();
			$table->integer('pcb_spouse_disabled')->unsigned();
			$table->integer('pcb_child_underage')->unsigned();
			$table->integer('pcb_child_aboveage')->unsigned();
                                                        
            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('pcb_global');
    }
}
