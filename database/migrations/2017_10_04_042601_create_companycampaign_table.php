<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanycampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companycampaign', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('owner_id')->unsigned();
            $table->string('name');
            $table->string('template_name');
            $table->string('image_path');
            $table->longtext('template');
			$table->enum('status', array('pending','active','dormant',
				'barred','suspended','rejected','sendpending'))->default('pending');
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
        Schema::drop('companycampaign');
    }
}
