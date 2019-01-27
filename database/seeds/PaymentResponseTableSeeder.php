<?php

use Illuminate\Database\Seeder;

class PaymentResponseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('paymentresponse')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('paymentresponse')->insert(array (
            0 => array(
                'id' => 1,
                'payment_id' => 6,
                'merchant_code' => 1,
                'ipay88_payment_id' => 1,
                'ref_no' => 'A00000001',
                'amount' => 1.00,
                'currency' => 'MYR',
                'remark' => 'Great1',
                'trans_id' => '12345',
                'auth_code' => '123456',
                'status' => '1',
                'err_desc' => 'Lorem ipsum dolor sit amet,pariatur.officia deserunt mollit anim id est laborum.',
                'signature' => 'Successfull',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'id' => 2,
                'payment_id' => 6,
                'merchant_code' => 1,
                'ipay88_payment_id' => 1,
                'ref_no' => 'A00000001',
                'amount' => 1.00,
                'currency' => 'MYR',
                'remark' => 'Great2',
                'trans_id' => '12345',
                'auth_code' => '123456',
                'status' => '1',
                'err_desc' => 'Lorem ipsum dolor sit amet,pariatur.officia deserunt mollit anim id est laborum.',
                'signature' => 'Successfull',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            2 => array(
                'id' => 3,
                'payment_id' => 6,
                'merchant_code' => 1,
                'ipay88_payment_id' => 1,
                'ref_no' => 'A00000001',
                'amount' => 1.00,
                'currency' => 'MYR',
                'remark' => 'Great3',
                'trans_id' => '12345',
                'auth_code' => '123456',
                'status' => '1',
                'err_desc' => 'Lorem ipsum dolor sit amet,pariatur.officia deserunt mollit anim id est laborum.',
                'signature' => 'Successfull',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            3 => array(
                'id' => 4,
                'payment_id' => 6,
                'merchant_code' => 1,
                'ipay88_payment_id' => 1,
                'ref_no' => 'A00000001',
                'amount' => 1.00,
                'currency' => 'MYR',
                'remark' => 'Great4',
                'trans_id' => '12345',
                'auth_code' => '123456',
                'status' => '1',
                'err_desc' => 'Lorem ipsum dolor sit amet,pariatur.officia deserunt mollit anim id est laborum.',
                'signature' => 'Successfull',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
        ) );
    }
}
