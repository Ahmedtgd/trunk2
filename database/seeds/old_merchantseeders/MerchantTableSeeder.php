<?php

use Illuminate\Database\Seeder;

class MerchantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $merchant = new \App\Models\Merchant();
        $mer = factory('App\Models\Merchant')->make()->toArray();
        $mer['user_id'] = 1;
        $merchant->fill($mer)->save();
        $mer = factory('App\Models\Merchant')->make()->toArray();
        $mer['user_id'] = 2;
        $merchant->fill($mer)->save();

        $mer = factory('App\Models\Merchant')->make()->toArray();
        $mer['user_id'] = 3;
        $merchant->fill($mer)->save();

		factory('App\Models\Merchant', 100)->create();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        
        
        \DB::table('product')->insert(array (
            0 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'name' => 'p2',
                'brand_id' => '2',
                'category_id' => '1',
                'photo_1' => 'Liv-Tyler-for-Givenchy.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'name' => 'p3',
                'brand_id' => '2',
                'category_id' => '1',
                'photo_1' => 'Liv-Tyler-for-Givenchy.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            )
            
        ));
    }
}
