<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmerchantproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This table implement product:merchant = m:n relationship */

			Schema::create('omerchantproduct', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('merchant_id')->unsigned();
				$table->index('merchant_id','mp_merchant_id_idx');

				/* One product can only be attached to one merchant
				 * This is a B2C product_id. If you are planning to validate a
				 * B2B product against merchantproduct table for a merchant.
				 * Your validation will fail.
				 * For reference:
				 * UtilityController::productMerchantId($product_id)
				 * will give you the actual merchant_id
				 */
				$table->integer('product_id')->unsigned()->unique();
				$table->index('product_id','mp_product_id_idx');

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
			Schema::drop('omerchantproduct');
		}
}
