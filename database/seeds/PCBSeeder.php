<?php

use Illuminate\Database\Seeder;
class PCBTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcb')->truncate();
    	$now = \Carbon\Carbon::now()->toDateTimeString();
    	$faker = Faker\Factory::create();		
        for ($i=0; $i < 10 ; $i++) { 
        	DB::table('pcb')->insert([
        		'employee_id'=>$i,
                'disabled'=>false,
        		'status'=>$faker->randomElement($array = array('single', 'married', 'divorced', 'widowed')),
        		'spouse'=>$faker->numberBetween(0,3),
        		'spouse_no_income'=>$faker->numberBetween(0,3),
        		'spouse_disabled'=>$faker->numberBetween(0,1),
        		'child'=>$faker->numberBetween(0,6),
        		'child_underage'=>$faker->numberBetween(0,2),
        		'child_aboveage'=>$faker->numberBetween(0,2),
        		'child_adopted'=>$faker->numberBetween(0,1),
        		'created_at'=>$faker->dateTime(),
        		'updated_at'=>$faker->dateTime()
        	]);
        }
    }
}


