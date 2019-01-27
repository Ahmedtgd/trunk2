<?php

use Illuminate\Database\Seeder;

class OshopTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('oshop_template')->truncate();
         $now = \Carbon\Carbon::now()->toDateTimeString();
         $faker = Faker\Factory::create();
         for ($i=1; $i <= 15 ; $i++) { 
	         \DB::table('oshop_template')->insert(array (
	             $i => array (
					 'merchant_id'     => $i,
					 'subcat_id'       => $faker->numberBetween(1,15),
					 'subcat_level'    => $faker->numberBetween(1,15),
					 'productreg_file' => $faker->sentence(),
					 'blade_file'      => 'oshoplist',
					 'data_table'      => $faker->sentence(),
					 'deleted_at'      => null,
					 'created_at'      => $now,
					 'updated_at'      => $now,
	             ),
	         ));
         }
    }
}
