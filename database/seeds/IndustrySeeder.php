<?php

use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industry')->truncate();
        $faker= Faker\Factory::create();
        for ($i=0; $i <=10 ; $i++) { 
            DB::table('industry')->insert([
                'name'=>$faker->company,
                'station_id'=>$i + 1,
                'created_at'=>$faker->dateTime(),
                'updated_at'=>$faker->dateTime()
                ]);
        }
    }
}
