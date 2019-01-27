<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNcustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncustomer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id');
            $table->string('company_name')->nullable();
            $table->string('business_reg_no')->nullable();
            $table->string('sst_reg_no')->nullable();
			$table->string('address_line1')->nullable();
			$table->string('address_line2')->nullable();
			$table->string('address_line3')->nullable();
            
            $table->integer('country_id')->default(150);
            $table->string('state')->default('Wilayah Persekutuan');
            $table->string('city')->default('Kuala Lumpur');
            $table->string('postcode')->nullable();
			$table->string('name')->nullable();
			/*$table->string('last_name');*/
			/*Contact Address*/
            $table->string('c_address_line1')->nullable();
            $table->string('c_address_line2')->nullable();
            $table->string('c_address_line3')->nullable();
            $table->string('c_state')->default('Wilayah Persekutuan');
            $table->string('c_city')->default('Kuala Lumpur');
			$table->string('c_postcode')->nullable();
            $table->string('mobile_no')->nullable();
			$table->string('email')->nullable();
			$table->boolean('registered')->default(false);
            
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
        Schema::drop('ncustomer');
    }
}
