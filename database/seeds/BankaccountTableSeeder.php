<?php

use Illuminate\Database\Seeder;

class BankaccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('bankaccount')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('bankaccount')->insert(array(
            0 => array(
                'bank_id' => 1,
                'account_name1' => 'KLEENSO RESOURCES SDN BHD',
                'account_number1' => '357000298101',
                'account_name2' => 'KLEENSO RESOURCES SDN BHD',
                'account_number2' => '357000298102',
                'iban' => 'Example',
                'swift' => 'Example',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}
