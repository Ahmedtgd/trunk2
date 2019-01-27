<?php

use Illuminate\Database\Seeder;

class BuyerHelp_table_seeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('buyer_help')->truncate();
		$faker = Faker\Factory::create();
		for ($i = 1; $i < 50; $i++) {
			DB::table('buyer_help')->insert([
				'porder_id' => $faker->numberBetween(1, 500),
				'name' => $faker->name,
				'phone' => $faker->phoneNumber,
				'email' => $faker->email,
			]);
		}
	}

}
