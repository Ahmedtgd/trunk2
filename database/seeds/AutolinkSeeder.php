<?php

use Illuminate\Database\Seeder;

class AutolinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {              
		DB::table('autolink')->truncate();
		$faker = Faker\Factory::create();

		for ($i=1; $i < 5; $i++) { 
			DB::table('autolink')->insert([
				'initiator'=>$faker->numberBetween(1,33),
				'responder'=>$faker->numberBetween(1,5),
				'status'=>$faker->randomElement($array =
					array ('linked','unlinked','request')),
				'deleted_at'=>$faker->dateTime(),
				'created_at'=>$faker->dateTime(),
				'updated_at'=>$faker->dateTime()
			]);
		}
    }
}
