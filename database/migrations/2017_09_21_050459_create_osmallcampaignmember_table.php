<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOsmallcampaignmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osmallcampaignmember', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('osmallmember_id')->unsigned();
            $table->integer('osmallcampaign_id')->unsigned();
            $table->boolean('send')->default(true);
            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('osmallcampaignmember');
    }
}
