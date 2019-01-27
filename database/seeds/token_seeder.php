<?php

use Illuminate\Database\Seeder;

class token_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		/* Initialize */
		\DB::table('users')->
			where('last_name', '=', 'Token User')->delete();
		\DB::table('merchant')->
			where('company_name', '=', 'Internal Token Merchant')->delete();
		\DB::table('category')-> where('name', '=', 'internal')->delete();
		\DB::table('subcat_level_1')-> where('name', '=', 'token')->delete();
		\DB::table('product')-> where('name', 'like', 'Token %')->delete();


		$now = \Carbon\Carbon::now()->toDateTimeString();
		$passwd = \Illuminate\Support\Facades\Hash::make('abcd1234');
		$token_user = DB::table('users')->insertGetId([
			'occupation_id' => '0',
			'first_name' => 'Internal',
			'last_name' => 'Token User',
			'name' => '',
			'email' => 'token_user@opensupermall.com',
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

  		$token_merchant = DB::table('merchant')->insertGetId([
			'user_id' => $token_user,
			'company_name' => 'Internal Token Merchant',
			'gst' => '',
			'business_reg_no' => '',
			'country_id' => '150',
			'business_type' => 'sdn_bhd',
			'address_id' => '1',
			'office_no' => '0',
			'mobile_no' => '0',
			'oshop_name' => 'Internal Token Merchant',
			'oshop_logo_1' => '',
			'oshop_address_id' => '0',
			'description' => 'Internal Token Merchant',
			'license' => '1',
			'ownership' => '0',
			'category_id' => '5',
			'planned_sales' => '0',
			'bankaccount_id' => '1',
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


		$token_category = DB::table('category')->insertGetId([
			'name' => 'internal',
			'description' => 'Internal',
			'logo_white'=>'',
			'logo_green'=>'',
			'floor'=>20,
			'color'=>'#000',
			'enable'=>0,
			'created_at' => $now,
			'updated_at' => $now,
		]);
			
		$token_subcategory = DB::table('subcat_level_1')->insertGetId([
			'category_id' => $token_category,
			'name' => 'token',
			'description' => "Token",
			'created_at' => $now,
			'updated_at' => $now,
		]);
		
		$token_product1 = DB::table('product')->insertGetId([
			'name' => 'Token 1000',
			'brand_id' => '0',
			'category_id' => $token_category,
			'subcat_id' => $token_subcategory,
			'subcat_level' => '1',
			'photo_1' => '',
			'free_delivery' => '1',
			'del_worldwide' => '0',
			'del_west_malaysia' => '0',
			'del_sabah_labuan' => '0',
			'del_sarawak' => '0',
			'cov_country_id' => '0',
			'cov_state_id' => 11,
			'cov_city_id' => 2467,
			'retail_price' => '100000',
			'discounted_price' => '100000',
			'available' => 100,
			'owarehouse_moq' => 5,
			'owarehouse_price' => '120',
			'owarehouse_ave_unit_price'=>100,
		   // 'product_details' => 'test',
			'type' => 'product',
			'owarehouse_duration' => 7,
			'oshop_selected' => 1,
			'status' => 'active',
			'smm_selected' => 0,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);
			
		$token_product2 = DB::table('product')->insertGetId([
			'name' => 'Token 2000',
			'brand_id' => '0',
			'category_id' => $token_category,
			'subcat_id' => $token_subcategory,
			'subcat_level' => '1',
			'photo_1' => '',
			'free_delivery' => '1',
			'del_worldwide' => '0',
			'del_west_malaysia' => '0',
			'del_sabah_labuan' => '0',
			'del_sarawak' => '0',
			'cov_country_id' => '150',
			'cov_state_id' => 11,
			'cov_city_id' => 2467,
			'retail_price' => '200000',
			'discounted_price' => '200000',
			'available' => 100,
			'owarehouse_moq' => 5,
			'owarehouse_price' => '120',
			'owarehouse_ave_unit_price'=>100,
		   // 'product_details' => 'test',
			'type' => 'product',
			'owarehouse_duration' => 7,
			'oshop_selected' => 1,
			'status' => 'pending',
			'smm_selected' => 0,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);

		$token_product3 = DB::table('product')->insertGetId([
			'name' => 'Token 5000',
			'brand_id' => '0',
			'category_id' => $token_category,
			'subcat_id' => $token_subcategory,
			'subcat_level' => '1',
			'photo_1' => '',
			'free_delivery' => '0',
			'del_worldwide' => '0',
			'del_west_malaysia' => '0',
			'del_sabah_labuan' => '0',
			'del_sarawak' => '0',
			'cov_country_id' => '150',
			'cov_state_id' => 11,
			'cov_city_id' => 2467,
			'retail_price' => '500000',
			'discounted_price' => '500000',
			'available' => 100,
			'owarehouse_moq' => 5,
			'owarehouse_price' => '120',
			'owarehouse_ave_unit_price'=>100,
		   // 'product_details' => 'test',
			'type' => 'product',
			'owarehouse_duration' => 7,
			'oshop_selected' => 1,
			'status' => 'pending',
			'smm_selected' => 0,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);

		$token_product4 = DB::table('product')->insertGetId([
			'name' => 'Token 10000',
			'brand_id' => '0',
			'category_id' => $token_category,
			'subcat_id' => $token_subcategory,
			'subcat_level' => '1',
			'photo_1' => '',
			'free_delivery' => '1',
			'del_worldwide' => '0',
			'del_west_malaysia' => '0',
			'del_sabah_labuan' => '0',
			'del_sarawak' => '0',
			'cov_country_id' => '150',
			'cov_state_id' => 11,
			'cov_city_id' => 2467,
			'retail_price' => '1000000',
			'discounted_price' => '1000000',
			'available' => 100,
			'owarehouse_moq' => 5,
			'owarehouse_price' => '120',
			'owarehouse_ave_unit_price'=>100,
		   // 'product_details' => 'test',
			'type' => 'product',
			'owarehouse_duration' => 7,
			'oshop_selected' => 1,
			'status' => 'pending',
			'smm_selected' => 0,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);	

 		$token_product5 = DB::table('product')->insertGetId([
			'name' => 'Token 20000',
			'brand_id' => '0',
			'category_id' => $token_category,
			'subcat_id' => $token_subcategory,
			'subcat_level' => '1',
			'photo_1' => '',
			'free_delivery' => '1',
			'del_worldwide' => '0',
			'del_west_malaysia' => '0',
			'del_sabah_labuan' => '0',
			'del_sarawak' => '0',
			'cov_country_id' => '150',
			'cov_state_id' => 11,
			'cov_city_id' => 2467,
			'retail_price' => '2000000',
			'discounted_price' => '2000000',
			'available' => 100,
			'owarehouse_moq' => 5,
			'owarehouse_price' => '120',
			'owarehouse_ave_unit_price'=>100,
		   // 'product_details' => 'test',
			'type' => 'product',
			'owarehouse_duration' => 7,
			'oshop_selected' => 1,
			'status' => 'pending',
			'smm_selected' => 0,
			'mc_sales_staff_id' => 0,
			'referral_sales_staff_id' => 0,
			'created_at' => $now,
			'updated_at' => $now,
		]);	
 

		DB::table('merchantproduct')->insert([
			'merchant_id' => $token_merchant,
			'product_id'  => $token_product1,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);		
		
		DB::table('merchantproduct')->insert([
			'merchant_id' => $token_merchant,
			'product_id'  => $token_product2,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);	
		
		DB::table('merchantproduct')->insert([
			'merchant_id' => $token_merchant,
			'product_id'  => $token_product3,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);	
		
		DB::table('merchantproduct')->insert([
			'merchant_id' => $token_merchant,
			'product_id'  => $token_product4,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);	
		
 		DB::table('merchantproduct')->insert([
			'merchant_id' => $token_merchant,
			'product_id'  => $token_product5,
			'created_at'  => $now,
			'updated_at'  => $now,
		]);	
 
		DB::table('global')->update([
			'token_merchant_id'=>$token_merchant,
			'token_product_id1'=>$token_product1,
			'token_product_id2'=>$token_product2,
			'token_product_id3'=>$token_product3,
			'token_product_id4'=>$token_product4,
			'token_product_id5'=>$token_product5
		]);
    }
}
