<?php

use Illuminate\Database\Seeder;

class BuyerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

	/*
	public function run()
	{
		//\DB::table('users')->truncate();

		// Generate portable password
		$password = \Illuminate\Support\Facades\Hash::make('12345678');


		// Create 5 Buyers
		$addresses = App\Models\Address::orderBy('id','desc')->take(5)->get();

		factory('App\Models\User', 20)->
		   create(['password'=>$password])->
		   each(function($u) {
			   $role = \Cartalyst\Sentinel\Laravel\Facades\Sentinel::findRoleBySlug('byr');

			   $role->users()->attach($u);
		   });
	}
	*/
   
   public function run()
   {
        \DB::table('buyer')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();

        $limit = 33;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('buyer')->insert([ //,
                'user_id' => $i+1,
                'photo_1' => '',
                'photo_2' => '',
                'bankaccount_id' => $i+1,
                'paypal_email' => 'user'.$i.'@gmail.com',
                'company_name' => 'OpenSupermall',
                'company_reg_no' => '1234567-X',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
   }
}
