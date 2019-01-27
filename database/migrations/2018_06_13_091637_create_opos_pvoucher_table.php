<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposPvoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_pvoucher', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('staff_user_id');
			$table->integer('voucher_id');
			$table->string('doc_no');
			$table->enum('platform',['lazada','11st','shopee']);
			$table->string('description');
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
        Schema::drop('opos_pvoucher');
    }
}
