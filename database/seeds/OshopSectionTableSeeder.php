<?php

use Illuminate\Database\Seeder;

class OshopSectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('oshopsection')->truncate();
		$faker = Faker\Factory::create();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        for ($i=1; $i <= 15 ; $i++) { 
	        \DB::table('oshopsection')->insert(array (
	            $i => array (
	                'merchant_id' => $i,
	                'section_id' => $i,
	                'created_at' => $now,
	                'updated_at' => $now,
	            ),
	        ));
        }
    }
}
