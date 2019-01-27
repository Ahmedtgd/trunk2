<?php

use Illuminate\Database\Seeder;

class PorderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('porder')->truncate();
		$faker = Faker\Factory::create();

		for ($i=1; $i < 500; $i++) {
			DB::table('porder')->insert([
				'user_id'         =>	$i,
				'courier_id'      =>	$faker->numberBetween(1,80),
				'address_id'      =>	$faker->numberBetween(1,80),
				'payment_id'      =>	$faker->numberBetween(1,80),
				'checkout_tstamp' =>	$faker->dateTime(),
				'receipt_tstamp'  =>	$faker->dateTime(),
				'deleted_at'      =>	$faker->dateTime(),
				'created_at'      =>	$faker->dateTime(),
				'updated_at'      =>	$faker->dateTime(),
			]);
		}
    }
}

