<?php

use Illuminate\Database\Seeder;

class ProductTableSeederFee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('product')->insert(array (
            0 => array (
                'name' => 'Merchant Annual Subscription Fee',
                'brand_id' => '0',
                'category_id' => '0',
                'photo_1' => '',
                'retail_price' => '500000',
                'original_price' => '0',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'name' => 'Station Annual Subscription Fee',
                'brand_id' => '0',
                'category_id' => '0',
                'photo_1' => '',
                'retail_price' => '0',
                'original_price' => '0',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));

		$merchant = \DB::table('merchant')->where('company_name', 'System Merchant')->first();
		$p1 = \DB::table('product')->where('name', 'Merchant Annual Subscription Fee')->first();
		$p2 = \DB::table('product')->where('name', 'Station Annual Subscription Fee')->first();

        \DB::table('merchantproduct')->insert(array (
            0 => array (
                'product_id' => $p1->id,
                'merchant_id' => $merchant->id,
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'product_id' => $p2->id,
                'merchant_id' => $merchant->id,
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));

		\DB::update("Update product SET parent_id = id WHERE segment = 'b2c'");
    }

}
