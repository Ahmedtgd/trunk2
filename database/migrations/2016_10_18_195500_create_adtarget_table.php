<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdtargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adtarget', function (Blueprint $table) {
            $table->increments('id');

            // Target ->Short form , smm or lpage
			$table->enum('target', [
				'category',
				'subcategory',
				'brand',
				'lpage_slider',
				'lpage_internal_top',
				'lpage_internal_bottom',
				'lpage_hyper',
				'lpage_oshop',
				'cat_adv1',
				'cat_adv2',
				'cat_adv3',
				'cat_adv4',
				'cat_adv5',
				'subcat_adv1',
				'subcat_adv2',
				'subcat_adv3',
				'subcat_adv4',
				'subcat_adv5'
			]);

            // Description ->Redable description, Landing Page for lpage
            $table->string('description');

            // Route. Not absolute. eg: foo/bar and not /foo/bar 
            $table->string('route');

            // Flags for ['Hide'/'Show'] button
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_hidden_updated')->default(false);

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
        Schema::drop('adtarget');
    }
}
