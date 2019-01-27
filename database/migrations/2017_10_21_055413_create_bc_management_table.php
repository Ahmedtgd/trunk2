<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBcManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_management', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_path');
            $table->string('barcode');
            $table->string('barcode_type');
            $table->enum('source',['web','mobile'])->default('mobile');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('bc_management');
    }
}
