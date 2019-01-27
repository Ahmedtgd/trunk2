<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_staff', function (Blueprint $table) {
            $table->increments('id');

			/* These are the FK for users.slug:
			 * users:sales_staff = 1:6
			 * social_media,marketeer, merchant_consultant,
			 * merchant_professional, pusher, station_recruiter */
			$table->enum('type', ['smm','mct','mcp','psh','str']);
			$table->integer('user_id')->unsigned();

			/* The person who recruited the sales staff */
			$table->integer('recruiter_user_id')->unsigned()->nullable();

			/* This is only for station recruiters */
			$table->integer('target_station')->unsigned();

			/* This is only for merchant consultants */
			$table->integer('target_merchant')->unsigned();
			$table->biginteger('target_revenue')->unsigned();

			/* These are commissions, stored as percentage: i.e. 10.25% */
			$table->float('commission')->unsigned();
			$table->float('bonus')->unsigned();

            /* Status */
            $table->enum('status', array('pending','active','dormant',
                'barred','suspended','rejected'))->default('active');
            $table->timestamp('active_date');

            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'MyISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_staff');
    }
}
