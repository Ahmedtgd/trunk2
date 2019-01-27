<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserstokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userstoken', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty')->default(1);
            $table->integer('user_id')->unsigned();
			$table->integer('facility_id')->unsigned();
            $table->enum('tied',array('term','salesman','warehouse'));
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
        Schema::drop('userstoken');
    }
}
