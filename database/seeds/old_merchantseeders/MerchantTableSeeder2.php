<?php

use Illuminate\Database\Seeder;

class MerchantTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        \DB::table('merchant')->truncate();
    	$now = \Carbon\Carbon::now()->toDateTimeString();
    	$faker = Faker\Factory::create();

        for($i=0 ; $i<20; $i++){

    	\DB::table('merchant')->insert(array (
	        $i => array(
	        'user_id' => $i + 1,
	        'bank_id' => $i + 1,
			'company_name' => $faker->sentence(3),
	        'gst' => 'EXAMPLE',
	        'business_reg_no' => '645400-X',
	        'country_id' => '150',
	        'business_type' => 'sdn_bhd',
	        'address_id' => '1',
	        'contact_person' => $faker->name(),
	        'office_no' => '+603 8023 1668',
			'mobile_no' => 'Example',
			'oshop_name' => 'KLEENSO',
			'oshop_address_id' => '0',
			'oshop_logo_1' => $faker->sentence(10),
			'oshop_logo_2' => $faker->sentence(10),
			'oshop_logo_3' => $faker->sentence(10),
			'oshop_logo_4' => $faker->sentence(10),
			'oshop_logo_5' => $faker->sentence(10),
			'oshop_adimage_1' => $faker->sentence(10),
			'oshop_adimage_2' => $faker->sentence(10),
			'oshop_adimage_3' => $faker->sentence(10),
			'oshop_adimage_4' => $faker->sentence(10),
			'oshop_adimage_5' => $faker->sentence(10),
			'description' => 'Kleenso Resources Sdn Bhd is involved in the manufacturing and marketing of total cleaning solution products. We manufacture full range of cleaning solution products under our house brand Kleenso and also our own Pesso brand of pest repellant products. <br><br> In addition to our own brands, we are also authorised distributors for other trusted brands including 3M, Dupont and ABC.<br><br><h3><u>Our Vision</u></h3><br>To be an innovative manufacturer, to market and promote the knowledge of healthy lifestyle in total cleaning solution products ranging from home care, skin care, car care to industrial care.<br><br><h3><u>Our Mission</u></h3><br>To beautify and enhance humanity through healthy, quality, environmental friendly solutions at affordable prices.',
			'license' => '1',
			'coverage' => 'internationally',
			'ownership' => '0',
			'category_id' => '5',
			'planned_sales' => '0',
			'bankaccount_id' => '1',
			'commission_type' => $faker->randomElement($array = array ('std','var')),
			'return_policy' => '<p>Example</p>',
			'osmall_commission' => 10.00,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'smm_quota_max' => 1,
			'mc_sales_staff_commission' => 0,
			'mc_with_ref_sales_staff_commission' => 0,
			'referral_sales_staff_commission' => 0,
			'mcp1_sales_staff_commission' => 0,
			'mcp2_sales_staff_commission' => 0,
			'smm_sales_staff_commission' => 0,
			'psh_sales_staff_commission' => 0,
			'str_sales_staff_commission' => 0,
			'status' => $faker->randomElement($array = array('pending','active','dormant',
				'barred','suspended','rejected')),
			'active_date' => $now,
	        'created_at'  => $now,
	        'updated_at'  => $now,
	        ),
        ));
        } 
    }
}
