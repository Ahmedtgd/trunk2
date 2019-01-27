<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOshopTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oshop_template', function (Blueprint $table) {
            $table->increments('id');

			/* FK back to O-Shop */
			$table->integer('merchant_id')->unsigned();

			/* Target subcategory, from which can find category */
			$table->integer('subcat_id')->unsigned();
			$table->integer('subcat_level')->unsigned();

			/* Actual Product Registration view Blade file for a
			 * particular template:
			 * Path: resources/view/oshop/templates/ */
			$table->string('productreg_file');

 			/* Actual Product Edit Blade file for a particular template:
			 * This is for editing of the data later
			 * Path: resources/view/oshop/templates/ */
			$table->string('productregedit_file');
 
			/* Actual Product Information view Blade file for a single product
			 * (detail view)
			 * Path: resources/view/oshop/templates/ */
			$table->string('productinfo_file');

			/* Actual O-Shop Customer view Blade file for all products
			 * (summary view)
			 * Path: resources/view/oshop/templates/ */
			$table->string('blade_file');

			/* Custom table for this particular template:
			 * this custom data table should have a merchant_id FK */
			$table->string('data_table');

			/* Custom Controller for this particular template:*/
			$table->string('controller');

			/* Custom Product Registration Function for this particular template:*/
			$table->string('init_productreg');

			/* Custom Oshop Function for this particular template:*/
			$table->string('init_oshop');	

			/* Custom Oshop Function for this particular template:*/
			$table->string('init_category');				
			
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
        Schema::drop('oshop_template');
    }
}
