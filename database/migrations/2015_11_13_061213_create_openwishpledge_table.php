<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenwishpledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* Table to store individual contribution towards an OpenWish.
		 * OpenWish:OpenWishPledge = 1:m */
        Schema::create('openwishpledge', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('openwish_id')->unsigned();

			/* Which social media platform is this contributor coming from? */
			$table->integer('smedia_id')->unsigned();

			/* Contributor's social media account name */
			$table->string('smedia_account');

            /*Pledger's user_id */ 
            $table->integer('user_id')->unsigned();
			/* Pledger's source IP */
			$table->string('source_ip');

			/* Pledged amount */
			$table->integer('pledged_amt');

            /*Message by the pledger to the pledgee*/
			$table->string('message')->
				default('Hi, I have contributed to your OpenWish!');

			/* Merchant help: a merchant can top up whatever remainder of the
			 * price in order to secure the sale */
			$table->integer('merchant_help');

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
        Schema::drop('openwishpledge');
    }
}
