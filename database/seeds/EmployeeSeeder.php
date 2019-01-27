<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boolean_gen = [true,false];
        for($i = 0; $i < 10; $i++) {
            $boolean_gen_index = array_rand($boolean_gen);
            $emp = new \App\Models\Employee();
            $emp->user_id = mt_rand(1, 20);
            $emp->position_id = mt_rand(1, 20);
            $emp->visa_no = str_random(6);
            $emp->socso_no = str_random(6);
            $emp->epf_no = str_random(6);
            $emp->pcb = str_random(6);
            $emp->monthly_salary = mt_rand(10000, 60000);
            $emp->source_user_id = mt_rand(1, 20);
            $emp->bankaccount_id = mt_rand(1, 20);
            $emp->status = 'status';
            $emp->save();

        }
    }
}
