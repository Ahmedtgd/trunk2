<?php

use Illuminate\Database\Seeder;

class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('role_users')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('role_users')->insert(array (
            0 => array( 'user_id' => '1', 'role_id' => '1',),
            1 => array( 'user_id' => '1', 'role_id' => '3',),
            2 => array( 'user_id' => '1', 'role_id' => '11',),
            3 => array( 'user_id' => '2', 'role_id' => '1',),
            4 => array( 'user_id' => '1', 'role_id' => '6',),
            5 => array( 'user_id' => '2', 'role_id' => '3',),
            6 => array( 'user_id' => '2', 'role_id' => '11',),
		));
    }
}
