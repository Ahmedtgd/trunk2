<?php

use Illuminate\Database\Seeder;

class CourierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courier')->truncate();
        $faker = Faker\Factory::create();

        DB::table('courier')->insert([
            'shipping_id'=>1,
            'name' =>'Fedex',
            'description'=>'Delivered',
            'progress_url'=>$faker->url(),
            'created_at'=>$faker->dateTime()
        ]);

//        for ($i=1; $i <200 ; $i++) {
//        	DB::table('courier')->insert([
//        		'shipping_id'=>$i,
//        		'name' =>$faker->text($maxNbChars=10),
//        		'description'=>$faker->randomElement($array=array('Delivered','Pending','Returned')),
//        		'progress_url'=>$faker->url(),
//        		'created_at'=>$faker->dateTime()
//        		]);
//        }
    }
}

