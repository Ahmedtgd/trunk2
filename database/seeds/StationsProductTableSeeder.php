<?php

use Illuminate\Database\Seeder;

class StationsProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stationsproduct')->truncate();
		$faker = Faker\Factory::create();
		DB::table('stationsproduct')->insert([
				'station_id'      =>	1,
				'sproduct_id'      =>	1,
				'deleted_at'      =>	null,
				'created_at'      =>	$faker->dateTime(),
				'updated_at'      =>	$faker->dateTime(),
		]);
    }
}
