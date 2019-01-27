<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Each category/subcategory have it's own set of specifications.
		 * category:specification = 1:1
		 * subcat_level_1:specification = 1:1
		 * subcat_level_2:specification = 1:1
		 * subcat_level_3:specification = 1:1
		 * subcat_level_n:specification = 1:1
		 */

        Schema::create('specification', function (Blueprint $table) {
            $table->increments('id');

			/* Relationship between Product & Specs is at productspec */
            $table->string('name');
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
        Schema::drop('specification');
    }
}
