<?php

use Illuminate\Database\Seeder;

class NinjaVan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('users')->
			where('first_name', '=', 'Ninja')->delete();
		\DB::table('station')->
			where('company_name', '=', 'NinjaVan')->delete();
		\DB::table('company')->
			where('dispname', '=','Ninja Logistics Sdn. Bhd.')->delete();
		\DB::table('logistic')->
			where('logistic_commission', '=', '1.00')->delete();
		
		$now = \Carbon\Carbon::now()->toDateTimeString();
		$passwd = \Illuminate\Support\Facades\Hash::make('abcd1234');
		$nv_user = DB::table('users')->insertGetId([
			'occupation_id' => '0',
			'first_name' => 'Ninja',
			'last_name' => 'Van',
			'name' => '',
			'email' => 'ninjavan@opensupermall.com',
			'avatar' => '',
			'provider' => '',
			'provider_id' => '',
			'access_token' => '',
			'birthdate' => '0000-00-00',
			'mobile_no' => '',
			'password' => $passwd,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);
		
		 $nv_station = DB::table('station')->insertGetId([
			'user_id' => $nv_user,
			'station_name' => 'NinjaVan',
			'company_name' => 'Ninja Logistics Sdn. Bhd.',
			'gst' => '',
			'business_reg_no' => '',
			'country_id' => '150',
			'business_type' => 'sdn_bhd',
			'address_id' => '1',
			'office_no' => '0',
			'mobile_no' => '0',
			'description' => 'NinjaVan',
			'license' => '1',
			'ownership' => '0',
			'category_id' => '15',
			'planned_sales' => '0',
			'bankaccount_id' => '1',
			'stationtype_id' => '2',
			'return_policy' => '',
			'osmall_commission' => 10.00,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'smm_quota_max' => 1,
			'mc_sales_staff_commission' => 0,
			'mc_with_ref_sales_staff_commission' => 0,
			'referral_sales_staff_commission' => 0,
			'mcp1_sales_staff_id' => 5,
			'mcp2_sales_staff_id' => 6,
			'psh_sales_staff_id' => 7,
			'mcp1_sales_staff_commission' => 0,
			'mcp2_sales_staff_commission' => 0,
			'smm_sales_staff_commission' => 0,
			'psh_sales_staff_commission' => 0,
			'str_sales_staff_commission' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);
		
		$nv_company = DB::table('company')->insertGetId([
			'sysname' => 'nv',
			'dispname' => 'Ninja Logistics Sdn. Bhd.',
			'description' => 'Ninja Logistics Sdn. Bhd.',
			'owner_user_id' => $nv_user,
			'created_at' => $now,
			'updated_at' => $now,
		]);
		
		$nv_logistic = DB::table('logistic')->insertGetId([
			'station_id' => $nv_station,
			'logistic_commission' => '10.00',
			'company_id' => $nv_company,
			'volfactor' => '5000',
			'api' => '1',
			'status' => 'active',
			'created_at' => $now,
			'updated_at' => $now,
		]);
    }
}
