<?php

use Illuminate\Database\Seeder;

class OshopProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oshopproduct')->truncate();
		$faker = Faker\Factory::create();

		for ($i=1; $i < 123; $i++) {
			DB::table('oshopproduct')->insert([
				'merchant_id'=>$i,
				'product_id'=>$i,
				'deleted_at'=>$faker->dateTime(),
				'created_at'=>$faker->dateTime(),
				'updated_at'=>$faker->dateTime()
			]);
		}
    }
}
