<?php

use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $now = \Carbon\Carbon::now()->toDateTimeString();
        DB::table('payment_method')->truncate();
        DB::table('payment_method')->insert(array(
            0 =>array(
                'code'=>'PAYP',
                'name'=>'paypal',
                'description'=>'Paypal',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            1 =>array(
                'code'=>'GOOW',
                'name'=>'google_wallet',
                'description'=>'Google Wallet',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ), 
            2 =>array(
                'code'=>'WEPY',
                'name'=>'wepay',
                'description'=>'WePay',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            3 =>array(
                'code'=>'2CKO',
                'name'=>'2checkout',
                'description'=>'2CheckOut',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            4 =>array(
                'code'=>'AUTH',
                'name'=>'authorize.net',
                'description'=>'Authorize.Net',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ), 
            5 =>array(
                'code'=>'SKRL',
                'name'=>'skrill',
                'description'=>'Skrill',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            6 =>array(
                'code'=>'ITUT',
                'name'=>'intuit',
                'description'=>'Intuit',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            7 =>array(
                'code'=>'PRPY',
                'name'=>'propay',
                'description'=>'ProPay',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ), 
            8 =>array(
                'code'=>'CK2S',
                'name'=>'click2sell',
                'description'=>'Click2Sell',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            9 =>array(
                'code'=>'DWLA',
                'name'=>'dwolla',
                'description'=>'Dwolla',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            10 =>array(
                'code'=>'BRNT',
                'name'=>'braintree',
                'description'=>'BrainTree',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ), 
            11 =>array(
                'code'=>'CKBK',
                'name'=>'clickbank',
                'description'=>'ClickBank',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            11 =>array(
                'code'=>'CKBK',
                'name'=>'clickbank',
                'description'=>'ClickBank',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ), 
            12 =>array(
                'code'=>'STRP',
                'name'=>'stripe',
                'description'=>'Stripe',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            13 =>array(
                'code'=>'PYNR',
                'name'=>'payoneer',
                'description'=>'Payoneer',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            14 =>array(
                'code'=>'ALIP',
                'name'=>'alipay',
                'description'=>'Alipay',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            15 =>array(
                'code'=>'PYDL',
                'name'=>'paydollar',
                'description'=>'PayDollar',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            16 =>array(
                'code'=>'PYBY',
                'name'=>'paysbuy',
                'description'=>'Paysbuy',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            17 =>array(
                'code'=>'SWIF',
                'name'=>'swiff',
                'description'=>'Swiff',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            18 =>array(
                'code'=>'MOLP',
                'name'=>'molpoints',
                'description'=>'Molpoints',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            19 =>array(
                'code'=>'TNPY',
                'name'=>'tenpay',
                'description'=>'TenPay',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            20 =>array(
                'code'=>'CNPY',
                'name'=>'chinapay',
                'description'=>'ChinaPay',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            21 =>array(
                'code'=>'99BL',
                'name'=>'99bill',
                'description'=>'99Bill',
                'logo'=>'',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
        ));
    }
}
