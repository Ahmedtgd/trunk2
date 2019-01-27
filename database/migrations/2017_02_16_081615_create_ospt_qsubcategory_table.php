<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOspt_qsubcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ospt_qsubcategory', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('parent_id');
			$table->string('name');
			$table->string('slug');
			$table->string('description');
			$table->enum('status', ['enabled', 'disabled']);
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
        Schema::drop('ospt_qsubcategory');
    }
}
