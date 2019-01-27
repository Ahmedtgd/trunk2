<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFsectionBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsection_b', function (Blueprint $table) {
            $table->increments('id');

			/* Download Apps: Images filename */
			$table->string('download_general');
			$table->string('download_ios');
			$table->string('download_android');

			/* All Rights Reserved */
			$table->string('all_rights_reserved');

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
        Schema::drop('fsection_b');
    }
}
