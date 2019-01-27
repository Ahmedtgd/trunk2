<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposBundleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_bundle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
			$table->dateTime('valid_start_dt');
			$table->dateTime('valid_end_dt');
			// Bundle price in cents
			$table->integer('bprice')->unsigned();
            $table->string('bundle_thumb_photo');
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
        Schema::drop('opos_bundle');
    }
}
