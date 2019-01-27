<?php

use Illuminate\Database\Seeder;

class MerchantTableSeederFee extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
    $now = \Carbon\Carbon::now()->toDateTimeString();
   $user = \DB::table('users')->where('first_name', 'System')->first();

   \DB::table('merchant')->insert(array(
     1 => array(
        'user_id' => $user->id,
        'company_name' => 'System Merchant',
        'gst' => '',
        'business_reg_no' => '',
        'country_id' => '',
        'business_type' => '',
        'address_id' => '',
        'office_no' => '',
        'mobile_no' => '',
        'oshop_name' => 'System Merchant',
        'oshop_logo_1' => '',
        'oshop_address_id' => '0',
        'description' => 'System Merchant',
        'license' => '0',
        'coverage' => '0',
        'ownership' => '0',
        'category_id' => '0',
        'planned_sales' => '0',
        'bankaccount_id' => '0',
        'return_policy' => '',
        'osmall_commission' => 10.00,
        'mc_sales_staff_id' => 0,
        'referral_sales_staff_id' => 0,
        'smm_quota_max' => 0,
        'mc_sales_staff_commission' => 0,
        'mc_with_ref_sales_staff_commission' => 0,
        'referral_sales_staff_commission' => 0,
        'mcp1_sales_staff_id' => 0,
        'mcp2_sales_staff_id' => 0,
        'psh_sales_staff_id' => 0,
        'mcp1_sales_staff_commission' => 0,
        'mcp2_sales_staff_commission' => 0,
        'smm_sales_staff_commission' => 0,
        'psh_sales_staff_commission' => 0,
        'str_sales_staff_commission' => 0,
        'created_at' => $now,
        'updated_at' => $now,
      )
    ));
  }
}
