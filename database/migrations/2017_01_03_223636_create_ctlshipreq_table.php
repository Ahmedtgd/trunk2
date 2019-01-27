<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtlshipreqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctlshipreq', function (Blueprint $table) {
            $table->increments('id');  
            $table->integer('porder_id')->unsigned();
            // Number of packages
            $table->integer('ctl_package_quantity');
            // Destination Station
            $table->string('ctl_dstation');

            $table->integer('ctl_pref_hour')->unsigned();
            $table->integer('ctl_pref_min')->unsigned();
            $table->date('ctl_pref_date');
            $table->string('ctl_consignment_number');
            $table->string('ctl_service_type');
            $table->string('ctl_package_type');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'MyISAM';
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ctlshipreq');
    }
}
