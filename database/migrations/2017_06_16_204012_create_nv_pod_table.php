<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNvPodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nv_pod', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nv_order_id');
			$table->string('nv_tracking_id');
			$table->string('nv_shipper_order_ref_no'); // $nporder_id
            $table->string('nvpod_name');
			$table->string('nvpod_type');
			$table->string('nvpod_identityno');
			$table->string('nvpod_contact');
			$table->string('nvpod_uri');
			$table->string('nvpod_left_in_safe_place');
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
        Schema::drop('nv_pod');
    }
}
