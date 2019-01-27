<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'occupation_id' => $faker->numberBetween(1,4314),
        'provider_id'   => $faker->randomNumber($nbDigits = NULL),
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
		'birthdate'     => Faker\Provider\DateTime::dateTimeThisCentury($max = 'now'),
        'mobile_no'     => $faker->phoneNumber,
        'email'         => $faker->email,
        'password'      => \Illuminate\Support\Facades\Hash::make('123456'),
		'gender'        => 'm',
		'salutation'    => 'Mr'|'Mrs'|'Ms',
        'annual_income' => '<30k'| '30-49k'| '50-59k'| '60-75k'|'75-99k'|'100-119k'|'120-149k'|'150-299k'|'>300k',
    ];
});


$factory->define(App\Models\Merchant::class, function (Faker\Generator $faker) {

    return [
        'user_id' => $faker->numberBetween(1, 30),
        'company_name' => $faker->company,
        'gst' => $faker->isbn10,
        'business_reg_no' => $faker->isbn10,
        'country_id' => $faker->numberBetween(1, 239),
        'business_type' => $faker->companySuffix,
        'address_id' => $faker->numberBetween(1, 10),
        'contact_person' => $faker->name,
        'office_no' => $faker->phoneNumber,
        'mobile_no' => $faker->phoneNumber,
        'oshop_name' => $faker->company,
        'oshop_address_id' => $faker->numberBetween(1, 100),
        'oshop_logo_1' => $faker->word,
        'oshop_logo_2' => $faker->word,
        'oshop_logo_3' => $faker->word,
        'oshop_logo_4' => $faker->word,
        'oshop_logo_5' => $faker->word,
        'oshop_adimage_1' => $faker->word,
        'oshop_adimage_2' => $faker->word,
        'oshop_adimage_3' => $faker->word,
        'oshop_adimage_4' => $faker->word,
        'oshop_adimage_5' => $faker->word,
        'description' => $faker->paragraph,
        'history' => $faker->paragraph,
        'license' => $faker->boolean($chanceOfGettingTrue = 50),
        'coverage' => $faker->numerify('ALB'),
        'ownership' => $faker->boolean($chanceOfGettingTrue = 50),
        'category_id' => $faker->numberBetween(1, 10),
        'planned_sales' => $faker->numberBetween(1000, 10000000),
        'bankaccount_id' => $faker->numberBetween(1, 10),
        'return_policy' => $faker->paragraph,
        'remarks' => $faker->paragraph
    ];

});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase,
        'brand_id' => $faker->numberBetween(1, 10),
        'category_id' => $faker->numberBetween(1, 1),
        'subcat_id' => $faker->numberBetween(1, 22),
        'subcat_level' => $faker->numberBetween(1, 1),
        'photo_1'   => $faker->word,
        'photo_2'   => $faker->word,
        'photo_3'   => $faker->word,
        'photo_4'   => $faker->word,
        'photo_5'   => $faker->word,
        'adimage_1' => $faker->word,
        'adimage_2' => $faker->word,
        'adimage_3' => $faker->word,
        'adimage_4' => $faker->word,
        'adimage_5' => $faker->word,
        'free_delivery' => $faker->boolean($chanceOfGettingTrue = 50),
        'del_worldwide' => $faker->numberBetween(1, 9),
        'del_west_malaysia' => $faker->numberBetween(1, 9),
        'del_sabah_labuan' => $faker->numberBetween(1, 9),
        'del_sarawak' => $faker->numberBetween(1, 9),
        'cov_country_id' => $faker->numberBetween(1, 239),
        'cov_state_id' => $faker->numberBetween(1, 16),
        'cov_city_id' => $faker->numberBetween(1, 4079),
        'retail_price' => $faker->numberBetween(1, 10000),
        'original_price' => $faker->numberBetween(1, 10000),
        'available' => $faker->numberBetween(50-500),
        'owarehouse_moq' => $faker->numberBetween(2-10),
        'owarehouse_price' => $faker->numberBetween(100-10000),
        'product_details' => $faker->paragraph,
        'type' => 'product',
    ];
});

/*$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'logo' => $faker->word,
        'floor' => $faker->numberBetween(1,3),
        'color' => $faker->numerify('#')
    ];

});*/

$factory->define(App\Models\Dealer::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->numberBetween(1,10)
    ];
});

$factory->define(App\Models\ProductDealer::class, function (Faker\Generator $faker) {
    return [
        'product_id'   => $faker->numberBetween(1,25),
        'special_unit' => $faker->numberBetween(1,10),
        'special_price'=> $faker->numberBetween(1,10)
    ];
});

$factory->defineAs(App\Models\Address::class, 'shipping', function (Faker\Generator $faker) {
    return [
        'city_id' => $faker->numberBetween(1,4079),
        'postcode'=> $faker->postcode,
        'line1'=> $faker->cityPrefix,
        'line2'=> $faker->secondaryAddress,
        'line3'=> $faker->state,
        'line4'=> $faker->city,
        'type'=> 'delivery',
    ];
});

$factory->define(App\Models\Courier::class, function (Faker\Generator $faker) {
    return [
        'shipping_id'   => 1,
        'name' => $faker->word,
        'description'=> $faker->sentence,
        'progress_url'=> $faker->url,
    ];
});

$factory->define(App\Models\POrder::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->numberBetween(1,5),
        'courier_id' => 1,
		'checkout_tstamp'=>
			\Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
		'delivery_tstamp'=>
			\Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
		'receipt_tstamp'=>
			\Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
    ];
});

$factory->define(App\Models\Payment::class, function (Faker\Generator $faker) {
    return [
        'receivable'   => $faker->numberBetween(100,500),
        'osmall_commission' => $faker->numberBetween(5,30),
        'status' => $faker->word,
        'note' => $faker->sentence,
        'consignment'=>
            \Carbon\Carbon::now()->subDays($faker->numberBetween(100,1000)),

    ];
});

$factory->define(App\Models\OpenWish::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->numberBetween(1,10),
        'product_id' => $faker->numberBetween(1,3),
        'duration'=> $faker->numberBetween(1,10),
    ];
});

$factory->define(App\Models\OpenWishPledge::class, function (Faker\Generator $faker) {
    return [
        'smedia_id'   => $faker->numberBetween(1,100),
        'smedia_account' => $faker->email,
        'source_ip'=> $faker->ipv4,
        'pledged_amt'=> $faker->numberBetween(1,100)

    ];
});

$factory->define(App\Models\Specification::class, function (Faker\Generator $faker) {
    return [
        'name'   => $faker->word,
        'description' => $faker->sentence,

    ];
});

$factory->defineAs(App\Models\Autolink::class,'initiator', function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->numberBetween(1,10),
        'bought'   => $faker->numberBetween(1,100),
        'dealer_id' => $faker->numberBetween(1, 10),
        'sold' => $faker->numberBetween(1,100),
        'linked_tstamp' =>
            \Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
        'last_transaction_tstamp' =>
            \Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
        'description' => $faker->sentence,
        'remarks' => $faker->text(50),
        'type' => 'merchant'|'station'|'dealer'|'user',
        'direction' => 'initiator',
        'mode' => 'auto'|'manual',
        'status' => 'linked'|'unlinked',

    ];
});

$factory->defineAs(App\Models\Autolink::class,'responder', function (Faker\Generator $faker) {

    return [
        'user_id'   => $faker->numberBetween(1,10),
        'bought'   => $faker->numberBetween(1,100),
        'dealer_id' => $faker->numberBetween(1, 10),
        'sold' => $faker->numberBetween(1,100),
        'linked_tstamp' =>
            \Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
        'last_transaction_tstamp' =>
            \Carbon\Carbon::now()->subDays($faker->randomDigitNotNull),
        'description' => $faker->sentence,
        'remarks' => $faker->text(50),
        'type' => 'merchant'|'station'|'dealer'|'user',
        'direction' => 'responder',
        'mode' => 'auto'|'manual',
        'status' =>  'linked'|'unlinked',


    ];
});

$factory->define(App\Models\Wholesale::class, function (Faker\Generator $faker) {

    return [
        'product_id'   => $faker->numberBetween(1,10),
        'unit'   => $faker->numberBetween(1,100),
        'price'   => $faker->numberBetween(100,500)



    ];
});

$factory->define(App\Models\AdslotProductHit::class, function (Faker\Generator $faker) {

    return [
        'views'     => $faker->numberBetween(400,500),
        'clicks'    => $faker->numberBetween(300,400),
        'buy'       => $faker->numberBetween(150,300),
        'remote_address'=> $faker->ipv4,
        'user_agent'=> 'merchant' | 'dealer'



    ];
});

$factory->define(App\Models\OcbcHeader::class, function (Faker\Generator $faker) {

    return [
        'ocbc_trailer_id'     => $faker->numberBetween(10,99),
        'record_type'     => $faker->numberBetween(10,99),
        'tape_id'    => $faker->numberBetween(100,999),
        'branch'       => $faker->numberBetween(150,300),
        'company_cif'       => $faker->text(20),
        'company_name'       => $faker->text(30),
        'company_ac_no'       => $faker->numberBetween(100,3000),
        'instruction'       => $faker->numberBetween(0,9),
        'reversal_indicator'       => $faker->numberBetween(0,9),
        'crediting_date'       => $faker->dateTime(),
        'customer_ref_no'       => $faker->numberBetween(1,100),
        'filler1'       => $faker->numberBetween(1,4000),
        'filler2'       => $faker->numberBetween(1,4000),
    ];
});

$factory->define(App\Models\OcbcDetail::class, function (Faker\Generator $faker) {

    return [
        'ocbc_header_id'     => $faker->numberBetween(10,99),
        'record_type'     => $faker->numberBetween(10,99),
        'account_number'    => $faker->numberBetween(100,4000),
        'amount'       => $faker->numberBetween(150,300),
        'instruction'       => $faker->numberBetween(0,9),
        'new_ic_number'       => $faker->numberBetween(1,100),
        'txn_description'       => $faker->text(20),
        'business_registration_no' => $faker->numberBetween(1,100),
        'reference_number'       => $faker->numberBetween(1,100),
        'receiving_fi_id'       => $faker->numberBetween(1,100),
        'beneficiary_name'       => $faker->text(20),
        'passport_no'       => $faker->numberBetween(1,100),
        'email'       => $faker->safeEmail,
        'fax_no'       => $faker->numberBetween(1,100),
        'require_id_check'       => $faker->numberBetween(1,9),
        'filler'       => $faker->numberBetween(1,4000),
    ];
});

$factory->define(App\Models\OcbcInv::class, function (Faker\Generator $faker) {

    return [
        'ocbc_detail_id'     => $faker->numberBetween(1,100),
        'record_type'    => $faker->numberBetween(10,99),
        'invoice_details'       => $faker->text(75)
    ];
});

$factory->define(App\Models\OcbcTrailer::class, function (Faker\Generator $faker) {

    return [
        'record_type'    => $faker->numberBetween(10,99),
        'total_count'    => $faker->numberBetween(10,4000),
        'total_amount'    => $faker->numberBetween(10,4000),
        'filler1'       => $faker->numberBetween(1,4000),
        'filler2'       => $faker->numberBetween(1,4000),
    ];
});

$factory->define(App\Models\Voucher::class, function (Faker\Generator $faker) {
    return [
        'address_id' => $faker->numberBetween(1,10),
        'validity' => $faker->randomElement($array = array('wyear', 'wmonth','wweek','wkdays','wkends')),
        'status' => $faker->randomElement($array = array('active', 'expired', 'executed')),
    ];
});

$factory->define(App\Models\TimeSlot::class, function (Faker\Generator $faker) {
    return [
        'booking' => $faker->dateTime(),
        'from' => $faker->time($format = 'H:i:s'),
        'to' => $faker->time($format = 'H:i:s'),
        'qty_left' => $faker->numberBetween(10,100),
        'qty_ordered' => $faker->numberBetween(10,100),
        'price' => $faker->numberBetween(10000,100000),
    ];
});
