<?php

use Illuminate\Database\Seeder;

class PaymentRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('paymentrequest')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('paymentrequest')->insert(array (
            0 => array(
                'id' => 1,
                'payment_id' => 6,
                'merchant_code' => 1,
                'ipay88_payment_id' => 1,
                'ref_no' => 'A00000001',
                'amount' => 1.00,
                'currency' => 'MYR',
                'prod_desc' => 'awesome',
                'user_name' => 'john doe',
                'user_email' => 'john@gmail.com',
                'user_contact' => '+01567888999',
                'remark' => 'Great',
                'lang' => 'utf-8',
                'signature' => '84dNMbfgjLMS42IqSTPqQ99cUGA=',
                'response_url' => 'http://www.YourResponseURL.com/payment/response.asp',
                'backend_url' => 'http://www.YourBackendURL.com/payment/backend_response.asp',
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
                'prod_desc' => 'awesome2',
                'user_name' => 'john doe2',
                'user_email' => 'john@gmail.com',
                'user_contact' => '+01567888999',
                'remark' => 'Great',
                'lang' => 'utf-8',
                'signature' => '84dNMbfgjLMS42IqSTPqQ99cUGA=',
                'response_url' => 'http://www.YourResponseURL.com/payment/response.asp',
                'backend_url' => 'http://www.YourBackendURL.com/payment/backend_response.asp',
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
                'prod_desc' => 'awesome3',
                'user_name' => 'john doe3',
                'user_email' => 'john@gmail.com',
                'user_contact' => '+01567888999',
                'remark' => 'Great',
                'lang' => 'utf-8',
                'signature' => '84dNMbfgjLMS42IqSTPqQ99cUGA=',
                'response_url' => 'http://www.YourResponseURL.com/payment/response.asp',
                'backend_url' => 'http://www.YourBackendURL.com/payment/backend_response.asp',
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
                'prod_desc' => 'awesome4',
                'user_name' => 'john doe4',
                'user_email' => 'john@gmail.com',
                'user_contact' => '+01567888999',
                'remark' => 'Great',
                'lang' => 'utf-8',
                'signature' => '84dNMbfgjLMS42IqSTPqQ99cUGA=',
                'response_url' => 'http://www.YourResponseURL.com/payment/response.asp',
                'backend_url' => 'http://www.YourBackendURL.com/payment/backend_response.asp',
                'created_at' => $now,
                'updated_at' => $now
            )
        ) );
    }
}
