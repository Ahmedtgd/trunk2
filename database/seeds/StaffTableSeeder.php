<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('sales_staff')->truncate();
        \DB::table('sales_staff')->insert(array (
            0 => array (
                'type' => 'mct',
                'user_id' => 1,
                'recruiter_user_id' => 1,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'type' => 'mct',
                'user_id' => 2,
                'recruiter_user_id' => 2,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'type' => 'mct',
                'user_id' => 3,
                'recruiter_user_id' => 3,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            3 => array (
                'type' => 'mct',
                'user_id' => 4,
                'recruiter_user_id' => 4,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            4 => array (
                'type' => 'mct',
                'user_id' => 5,
                'recruiter_user_id' => 5,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            5 => array (
                'type' => 'mct',
                'user_id' => 6,
                'recruiter_user_id' => 6,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            6 => array (
                'type' => 'mcp',
                'user_id' => 7,
                'recruiter_user_id' => 7,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            7 => array (
                'type' => 'mcp',
                'user_id' => 8,
                'recruiter_user_id' => 8,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            8 => array (
                'type' => 'str',
                'user_id' => 9,
                'recruiter_user_id' => 9,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            ),
            9 => array (
                'type' => 'str',
                'user_id' => 10,
                'recruiter_user_id' => 10,
                'target_station' => 500,
                'target_merchant' => 100,
                'target_revenue' => 25000,
                'commission' => 10.25,
                'bonus' => 5.00,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now, 
            )
        ));
    }
}
