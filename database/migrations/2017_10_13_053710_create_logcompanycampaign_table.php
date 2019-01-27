<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogcompanycampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logcompanycampaign', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('companycampaign_id')->unsigned();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
			$table->boolean('approved')->default(true);
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
        Schema::drop('logcompanycampaign');
    }
}
