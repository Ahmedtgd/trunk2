<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQrManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_management', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['qr','barcode'])->default('qr');
            $table->string('image_path');
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
        Schema::drop('qr_management');
    }
}
