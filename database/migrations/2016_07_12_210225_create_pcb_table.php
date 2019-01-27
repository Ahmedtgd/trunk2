<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pcb', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->boolean('disabled')->default(false);
			
			$table->enum('status',
				array('single','married','divorced',
					'widowed'));			
			$table->integer('spouse')->unsigned();
			$table->integer('spouse_no_income')->unsigned();
			$table->integer('spouse_disabled')->unsigned();
			$table->integer('child')->unsigned();
			$table->integer('child_underage')->unsigned();
			$table->integer('child_aboveage')->unsigned();
			$table->integer('child_adopted')->unsigned();
                                                        
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
        Schema::drop('pcb');
    }
}
