<?php

use Illuminate\Database\Seeder;

class CreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('cre')->truncate();
		$faker = Faker\Factory::create();
		for ($i = 1; $i < 50; $i++) {
			DB::table('cre')->insert([
				'user_id' => $faker->numberBetween(1, 8),
				'type' => $faker->randomElement($array =
					array ('cancel','return','exchange')),
				'crereason_id' => $faker->numberBetween(1, 8),
				'product_id' => $faker->numberBetween(1, 8),
				'status' => $faker->randomElement($array =
					array ('success','fail','pending')),
				'created_at'  => $now,
        		'updated_at'  => $now
			]);
		}
    }
}
