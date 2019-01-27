<?php

use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee')->truncate();
        $faker= Faker\Factory::create();
        for ($i=0; $i <=20 ; $i++) { 
        	DB::table('employee')->insert([
        		'user_id'=>$i + 1,
        		'position_id'=>$i + 1,
				'visa_no'=>$faker->creditCardNumber,
				'socso_no'=>$faker->numberBetween(10000,9000),
				'epf_no'=>$faker->numberBetween(10000,9000),
				'pcb'=>$faker->numberBetween(10000,1000000),
        		'monthly_salary'=>$faker->numberBetween(500000,1500000),
        		'source_user_id'=>$i+1,
        		'bankaccount_id'=>$i+1,
        		'status'=>'active',
        		'payment'=>0,
        		'created_at'=>$faker->dateTime(),
        		'updated_at'=>$faker->dateTime()
        		]);
        }
    }
}
