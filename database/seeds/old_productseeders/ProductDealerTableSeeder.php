<?php

use Illuminate\Database\Seeder;
use App\Models\Dealer;

class ProductDealerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       \DB::table('productdealer')->truncate();
	   $faker= Faker\Factory::create();
	   $dealer = Dealer::all()->lists('id')->toArray();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('productdealer')->insert(array (
            0 => array (
                'product_id' => '1',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
				'special_unit'=>'20',
                'special_price' => '100',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
				'product_id' => '2',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
                'special_unit'=>'20',
                'special_price' => '300',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'product_id' => '3',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
                'special_unit'=>'20',
                'special_price' => '500',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                  'product_id' => '4',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'50',
                'special_unit'=>'100',
                'special_price' => '100',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                  'product_id' => '5',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
                'special_unit'=>'20',
                'special_price' => '200',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                  'product_id' => '6',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
                'special_unit'=>'20',
                'special_price' => '1000',
                'created_at' => $now,
                'updated_at' => $now,
            ), 
			6 => array (
                  'product_id' => '7',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'1',
                'special_unit'=>'50',
                'special_price' => '100',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            7 => array (
                  'product_id' => '8',
				'dealer_id'=>$faker->randomElement($dealer),
                'special_funit'=>'30',
                'special_unit'=>'100',
                'special_price' => '1200',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}
