<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adimage', function (Blueprint $table) {
            $table->increments('id');

            /* AdControl:AdImage= 1:M*/ 
            $table->integer('adcontrol_id')->unsigned();
            $table->integer('advertisement_id')->unsigned();

            /*relative path*/ 
            $table->string('path');

            /*target :default should be 'javascript void 0'*/
            $table->string('target')->default('javascript:void(0);'); 
			$table->boolean('updated')->default(false);
			$table->boolean('hide')->default(false);
			$table->boolean('hide_public')->default(false);
            
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
        Schema::drop('adimage');
    }
}
