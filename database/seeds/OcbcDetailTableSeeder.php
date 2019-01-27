<?php

use Illuminate\Database\Seeder;

class OcbcDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('ocbc_detail')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ocbc_detail')->insert(array (
            0 => array(
                'id' => 1,
                'ocbc_header_id' => 1,
                'record_type' => '02',
                'account_number' => '123456',
                'amount' => '123000',
                'instruction' => 'C',
                'new_ic_number' => '178900X',
                'old_ic_no' => 'T1234',
                'txn_description' => 'test description',
                'business_registration_no' => '100002089',
                'reference_number' => '123456',
                'receiving_fi_id' => '1',
                'beneficiary_name' => 'Testing Sdn Bhd',
                'passport_no' => '123456',
                'email' => 'eandrew@testing.com',
                'fax_no' => '123456',
                'require_id_check' => 'N',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'id' => 2,
                'ocbc_header_id' => 1,
                'record_type' => '02',
                'account_number' => '546378987643',
                'amount' => '00000000000867020',
                'instruction' => 'C',
                'new_ic_number' => '66493X',
                'old_ic_no' => 'V1234',
                'txn_description' => 'test2 description',
                'business_registration_no' => '100002270',
                'reference_number' => '123456',
                'receiving_fi_id' => '1',
                'beneficiary_name' => 'Vista Trading Sdn Bhd',
                'passport_no' => '123456',
                'email' => 'eong@vista.com.my',
                'fax_no' => '123456',
                'require_id_check' => 'N',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            2 => array(
                'id' => 3,
                'ocbc_header_id' => 1,
                'record_type' => '02',
                'account_number' => '67946739091234',
                'amount' => '00000000000367200',
                'instruction' => 'C',
                'new_ic_number' => '456789X',
                'old_ic_no' => 'I6673',
                'txn_description' => 'test3 description',
                'business_registration_no' => '100002050',
                'reference_number' => '123456',
                'receiving_fi_id' => '1',
                'beneficiary_name' => 'IT Solution Sdn Bhd',
                'passport_no' => '123456',
                'email' => 'eservice@its.com',
                'fax_no' => '123456',
                'require_id_check' => 'N',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            3 => array(
                'id' => 4,
                'ocbc_header_id' => 1,
                'record_type' => '02',
                'account_number' => '78036287463546',
                'amount' => '00000000000205000',
                'instruction' => 'C',
                'new_ic_number' => '233434X',
                'old_ic_no' => 'N3224',
                'txn_description' => 'test4 description',
                'business_registration_no' => '100002050',
                'reference_number' => '123456',
                'receiving_fi_id' => '1',
                'beneficiary_name' => 'Northern Solution S/B',
                'passport_no' => '123456',
                'email' => 'eenquiry@northernsolution.com',
                'fax_no' => '123456',
                'require_id_check' => 'N',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
        ) );
    }
}
