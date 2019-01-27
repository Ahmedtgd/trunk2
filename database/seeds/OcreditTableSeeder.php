<?php

use Illuminate\Database\Seeder;

class OcreditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {              
		DB::table('ocredit')->truncate();
		$faker = Faker\Factory::create();
		$now = Carbon::now();
		for ($i=1; $i < 50; $i++) { 
			DB::table('ocredit')->insert([
				'product_id'=>$faker->numberBetween(1,12),
				'merchant_id'=>$faker->numberBetween(1,20),
				'porder_id'=>$faker->numberBetween(1,20),
				'value'=>$faker->numberBetween(150,1000),
				'usd'=>$faker->numberBetween(1,20),
				'smmout_id'=>$faker->numberBetween(1,20),
				'openwish_id'=>$faker->numberBetween(1,20),
				'owarehouse_id'=>$faker->numberBetween(1,20),
				'cre_id'=>$faker->numberBetween(1,20),
				'mcredit_id'=>$faker->numberBetween(1,20),
				'source'=>$faker->randomElement($array =
					array ('smm','openwish','hyper','cre','mcredit')),
				'created_at' => $now,
				'updated_at' => $now
			]);
		}
    }
}
