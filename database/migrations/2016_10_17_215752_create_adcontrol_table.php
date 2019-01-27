<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdcontrolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adcontrol', function (Blueprint $table) {
            $table->increments('id');

            /* This decides the advertisment's position */ 
            $table->integer('adtarget_id')->unsigned();

            /* Gallery AD 's Height and Width'. */ 
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned();

            /* Show nav controls or not || When possible. */ 
            $table->enum('nav',['yes','no'])->default('yes');

            /* Images would be a long text connected via a limiter.
               in this case We will explode. If its null the ad will not
               be displayed. No matter if other params are okay */ 

            /*Image rotation speed in seconds*/
            $table->integer('rotation_time')->unsigned();

            /* This is tricky.
             * We will explode image based on limiter to array;
             * By priority we can set which image to show first on
             * user page visit. normally this is the first image in the
             * list. But using this we can change if value set more
             * than the array length of exploded array then 0 will be
             * taken as default. */ 
            $table->integer('priority')->unsigned(); 


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
        Schema::drop('adcontrol');
    }
}
