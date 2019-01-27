<?php

use Illuminate\Database\Seeder;

class JCTopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('merchant')->insert(array(
            0 => array(
                'user_id' => '1',
                'company_name' => 'J&C Mobile TopUp',
                'gst' => 'EXAMPLE',
                'business_reg_no' => 'tryjc',
                'country_id' => '150',
                'business_type' => 'sdn_bhd',
                'address_id' => '1',
                'office_no' => 'tryjc',
                'mobile_no' => 'Example',
                'oshop_name' => 'J&C Mobile TopUp',
                'oshop_address_id' => '0',
                'description' => 'tryjc',
                'license' => '1',
                'coverage' => 'internationally',
                'ownership' => '0',
                'category_id' => '5',
                'planned_sales' => '0',
                'bankaccount_id' => '1',
                'return_policy' => '<p>Example</p>',
                'remarks' => 'Example',
                'oshop_logo_1' => 'jclogo.png',
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
            ),)
        );

        \DB::table('product')->insert(array (
            0 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            1 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            2 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            3 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            4 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),
            5 => array (
                'name' => 'p1',
                'brand_id' => '1',
                'category_id' => '1',
                'photo_1' => 'home1-01-cc86ceb62402ea4f084078b4e66aa8c652c50a9ae53c624220680ac6ac7b9f19.jpg',
                'retail_price' => '150',
                'original_price' => '200',
                'type' => 'product',
                'created_at' => $now,
                'updated_at' => $now,
            ),)
        );

        \DB::table('merchantproduct')->insert(array (
            0 => array(
                'merchant_id' => 53,
                'product_id' => 124,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            1 => array(
                'merchant_id' => 53,
                'product_id' => 125,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            2 => array(
                'merchant_id' => 53,
                'product_id' => 126,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            3 => array(
                'merchant_id' => 53,
                'product_id' => 127,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            4 => array(
                'merchant_id' => 53,
                'product_id' => 128,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),
            5 => array(
                'merchant_id' => 53,
                'product_id' => 129,
                'created_at'  => $now,
                'updated_at'  => $now,
            ),)
        );
    }
}
