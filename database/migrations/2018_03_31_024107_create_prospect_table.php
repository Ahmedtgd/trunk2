<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('business_reg_no');
            $table->string('address_line1');
            $table->string('address_line2');
            $table->string('address_line3');
 			$table->integer('country_id')->default(150);
            $table->string('state')->default('Wilayah Persekututuan');
            $table->string('city')->default('Kuala Lumpur');
            $table->string('postcode'); 
            $table->string('brand');
            $table->integer('category_id')->unsigned();			//dropdown
            $table->string('subcat_level_1');
            $table->string('subcat_level_2');
            $table->integer('no_employees')->unsigned();
            $table->integer('annual_revenue')->unsigned();
             $table->string('first_name');
            $table->string('last_name');
            $table->string('designation');
            $table->string('mobile_no');
            $table->string('email');
            $table->string('office_number');
            $table->string('no_products');	//dropdown
            $table->string('no_stations');	//dropdown
            $table->string('website');
            $table->enum('relationship',['manufacturer','main-distributor','distributor','sub-distributor','retailer']);
            $table->integer('subscription_fee')->unsigned();
            $table->float('commission_percent')->unsigned();
            $table->integer('admin_fee')->unsigned();
            $table->integer('mc_user_id')->unsigned();
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
        Schema::drop('prospect');
    }
}
