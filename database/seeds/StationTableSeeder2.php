<?php

use Illuminate\Database\Seeder;

class StationTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('station')->truncate();
    	$now = \Carbon\Carbon::now()->toDateTimeString();
    	$faker = Faker\Factory::create();

        for($i=0 ; $i<15; $i++){

    	\DB::table('station')->insert(array (
	        $i => array(
	        'user_id' => $i + 1,
			'company_name' => $faker->sentence(3),
	        'gst' => 'EXAMPLE',
	        'business_reg_no' => '645400-X',
	        'country_id' => '150',
	        'business_type' => $faker->randomElement($array = array ('sole_proprietorship','partnership','sdn_bhd','bhd.')),
	        'address_id' => '1',
	        'contact_person' => $faker->name(),
	        'office_no' => '+603 8023 1668',
			'mobile_no' => 'Example',
			'station_name' => $faker->sentence(6),
			'station_description' => $faker->paragraph(),
			'station_address_id' => $i + 1,
			'shop_size' => $faker->numberBetween(4000,10000),
			'description' => $faker->paragraph(),
			'history'=> $faker->paragraph(),
			'property_owner' => $faker->name(),
			'prop_owner_mobile' => '0999555666',
			'license' => '1',
			'coverage' => $faker->randomElement($array = array ('klang_valley','peninsula_malaysia','east_malaysia','international')),
			'ownership' => $faker->boolean(),
			'category_id' => $faker->numberBetween(1,10),
			'planned_sales' => $faker->numberBetween(1,10),
			'bankaccount_id' => $faker->numberBetween(1,10),
			'commission_type' => $faker->randomElement($array = array ('std','var')),
			
			'mc_sales_staff_id' => $faker->numberBetween(1,10),
			'referral_sales_staff_id' => $faker->numberBetween(1,10),
			'mcp1_sales_staff_id' => $faker->numberBetween(1,10),
			'mcp2_sales_staff_id' => $faker->numberBetween(1,10),
			'psh_sales_staff_id' => $faker->numberBetween(1,10),
			'str_sales_staff_id' => $faker->numberBetween(1,10),
			'smm_quota_max' => $faker->numberBetween(1,10),
			'smm_max_post' => $faker->numberBetween(1,10),
			'smm_min_duration' => $faker->numberBetween(1,10),
			'return_policy' => $faker->paragraph(),
			'remarks' => $faker->paragraph(),
			'osmall_commission' => 10.00,

			'mc_sales_staff_commission' => $faker->numberBetween(1,10),
			'mc_with_ref_sales_staff_commission' => $faker->numberBetween(1,10),
			'referral_sales_staff_commission' => $faker->numberBetween(1,10),
			'mcp1_sales_staff_commission' => $faker->numberBetween(1,10),
			'mcp2_sales_staff_commission' => $faker->numberBetween(1,10),
			'smm_sales_staff_commission' => $faker->numberBetween(1,10),
			'psh_sales_staff_commission' => $faker->numberBetween(1,10),
			'str_sales_staff_commission' => $faker->numberBetween(1,10),
			'status' => $faker->randomElement($array = array('pending','active','dormant',
                'barred','suspended','rejected')),
			'active_date' => $now,
			'deleted_at' => $now,
	        'created_at'  => $now,
	        'updated_at'  => $now,
	        ),
        ));
        } 
    }
}
