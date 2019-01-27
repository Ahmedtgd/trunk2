<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdpopupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adpopup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_path');
            $table->string('url');
            $table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','sendpending'))->default('pending');

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
        Schema::drop('adpopup');
    }
}
