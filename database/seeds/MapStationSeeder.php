<?php

use Illuminate\Database\Seeder;

class MapStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\DB::table('address')->where('longitude', '!=', 101.97580000)->where('latitude', '!=', 4.21050000)->delete();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $city = array(
            'name' => 'Penang',
            'state_code' => 'MY06',
            'country_code' => 'MYS',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47600',
            'line1' => 'NO.37 & 39, JALAN INDUSTRI USJ 1/11, TAMAN PERINDUSTRIAN USJ 1,',
            'line2' => '47400 SUBANG JAYA',
            'line3' => 'SELANGOR',
            'line4' => 'MALAYSIA',
            'type' => 'billing',	
            'latitude' => 5.4381102,
            'longitude' => 100.2889992,
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '1',
            'company_name' => 'Penang Station',
            'gst' => 'EXAMPLE',
            'business_reg_no' => '645400-X',
            'country_id' => 150,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
            'mobile_no' => 'Example',
            'station_name' => 'Penang',
            'description' => ' ',
            'license' => '1',
            'coverage' => 'internationally',
            'ownership' => '0',
            'category_id' => '5',
            'planned_sales' => '0',
            'bankaccount_id' => '1',
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
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
        $city = array(
            'name' => 'Kuala Lumpur',
            'state_code' => 'MY14',
            'country_code' => 'MYS',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47601',
            'line1' => 'try2',
            'line2' => 'try2',
            'line3' => 'try2',
            'line4' => 'try2',
            'type' => 'billing',		
            'created_at'  => $now,
            'updated_at'  => $now,
            'latitude' => 3.1489833,
            'longitude' =>  101.711256,
            
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '2',
            'company_name' => 'INFO@CLUSTER-Kuala Lumpur',
            'gst' => 'EXAMPLE1',
            'business_reg_no' => '645400-X',
            'country_id' => 2,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
            'mobile_no' => 'Example',
            'station_name' => 'Kuala Lumpur',
            'description' => ' ',
            'license' => '1',
            'coverage' => 'internationally',
            'ownership' => '0',
            'category_id' => '5',
            'planned_sales' => '0',
            'bankaccount_id' => '1',
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
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
        $city = array(
            'name' => 'Johor Baru',
            'state_code' => 'MY01',
            'country_code' => 'MYS',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47602',
            'line1' => 'try2',
            'line2' => 'try2',
            'line3' => 'try2',
            'line4' => 'try2',
            'type' => 'billing',		
            'created_at'  => $now,
            'updated_at'  => $now,
            'latitude' => 1.4634997,
            'longitude' => 103.7589293,
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '3',
            'company_name' => 'OXOXNIYA-Johor Baru',
            'gst' => 'EXAMPLE1',
            'business_reg_no' => '645400-X',
            'country_id' => 2,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
			'mobile_no' => 'Example',
			'station_name' => 'Johor Baru',
			'description' => ' ',
			'license' => '1',
			'coverage' => 'internationally',
			'ownership' => '0',
			'category_id' => '5',
			'planned_sales' => '0',
			'bankaccount_id' => '1',
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
			'created_at'  => $now,
			'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
        
        /* Hong kong */
        $city = array(
            'name' => 'Central',
            'state_code' => 'MY06',
            'country_code' => 'HKG',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47600',
            'line1' => 'NO.37 & 39, JALAN INDUSTRI USJ 1/11, TAMAN PERINDUSTRIAN USJ 1,',
            'line2' => '47400 SUBANG JAYA',
            'line3' => 'SELANGOR',
            'line4' => 'HONG KONG',
            'type' => 'billing',	

            'latitude' => 22.2847,
            'longitude' => 114.1582,
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '4',
            'company_name' => 'Central Pte Ltd',
            'gst' => 'EXAMPLE',
            'business_reg_no' => '645400-X',
            'country_id' => 150,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
            'mobile_no' => 'Example',
            'station_name' => 'Central',
            'description' => ' ',
            'license' => '1',
            'coverage' => 'internationally',
            'ownership' => '0',
            'category_id' => '5',
            'planned_sales' => '0',
            'bankaccount_id' => '1',
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
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
        $city = array(
            'name' => 'Mongkok',
            'state_code' => 'MY14',
            'country_code' => 'HKG',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47601',
            'line1' => 'try2',
            'line2' => 'try2',
            'line3' => 'try2',
            'line4' => 'try2',
            'type' => 'billing',		
            'created_at'  => $now,
            'updated_at'  => $now,
            'latitude' => 22.3193628,
            'longitude' => 114.1589395,
            
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '5',
            'company_name' => 'Mongkok Pte Ltd',
            'gst' => 'EXAMPLE1',
            'business_reg_no' => '645400-X',
            'country_id' => 2,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
            'mobile_no' => 'Example',
            'station_name' => 'Mongkok',
            'description' => ' ',
            'license' => '1',
            'coverage' => 'internationally',
            'ownership' => '0',
            'category_id' => '5',
            'planned_sales' => '0',
            'bankaccount_id' => '1',
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
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
        $city = array(
            'name' => 'Tai Po Market',
            'state_code' => 'MY01',
            'country_code' => 'HKG',
            'created_at'  => $now,
            'updated_at'  => $now,
        );
        $cityID = \DB::table('city')->insertGetId($city);
        $address = array(
            'city_id' => $cityID,
            'postcode' => '47602',
            'line1' => 'try2',
            'line2' => 'try2',
            'line3' => 'try2',
            'line4' => 'try2',
            'type' => 'billing',		
            'created_at'  => $now,
            'updated_at'  => $now,
            'latitude' => 22.4445,
            'longitude' => 114.1705,
        );
        $addressID = \DB::table('address')->insertGetId($address);
        $station = array(
            'user_id' => '6',
            'company_name' => 'Tai Poster HK Pte Ltd',
            'gst' => 'EXAMPLE1',
            'business_reg_no' => '645400-X',
            'country_id' => 2,
            'business_type' => 'sdn_bhd',
            'address_id' => $addressID,
            'station_address_id' => $addressID,
            'office_no' => '+603 8023 1668',
			'mobile_no' => 'Example',
			'station_name' => 'Tai Po Market',
			'description' => ' ',
			'license' => '1',
			'coverage' => 'internationally',
			'ownership' => '0',
			'category_id' => '5',
			'planned_sales' => '0',
			'bankaccount_id' => '1',
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
			'created_at'  => $now,
			'updated_at'  => $now,
        );
        \DB::table('station')->insert($station);
    }
}
