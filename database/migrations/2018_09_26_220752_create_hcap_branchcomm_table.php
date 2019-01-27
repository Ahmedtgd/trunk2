<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcapbranchcommTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('hcap_branchcomm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned(); //FK->fairlocation
            $table->integer('user_id')->unsigned();     //FK->users
            $table->string('commtext');     //name of commission

            /* This is commission in percentage for the branch sales */
            $table->float('commission_pct')->unsigned();
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
        Schema::drop('hcap_branchcomm');
    }
}
