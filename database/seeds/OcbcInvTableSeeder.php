<?php

use Illuminate\Database\Seeder;

class OcbcInvTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ocbc_inv')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ocbc_inv')->insert(array (
            0 => array(
                'id' => 1,
                'ocbc_detail_id' => 1,
                'record_type' => '21',
                'invoice_details' => 'test1 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'id' => 2,
                'ocbc_detail_id' => 1,
                'record_type' => '21',
                'invoice_details' => 'test2 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            2 => array(
                'id' => 3,
                'ocbc_detail_id' => 1,
                'record_type' => '21',
                'invoice_details' => 'test3 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            3 => array(
                'id' => 4,
                'ocbc_detail_id' => 2,
                'record_type' => '21',
                'invoice_details' => 'test4 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            4 => array(
                'id' => 5,
                'ocbc_detail_id' => 2,
                'record_type' => '21',
                'invoice_details' => 'test5 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            5 => array(
                'id' => 6,
                'ocbc_detail_id' => 2,
                'record_type' => '21',
                'invoice_details' => 'test6 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            6 => array(
                'id' => 7,
                'ocbc_detail_id' => 2,
                'record_type' => '21',
                'invoice_details' => 'test7 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            7 => array(
                'id' => 8,
                'ocbc_detail_id' => 2,
                'record_type' => '21',
                'invoice_details' => 'test8 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            8 => array(
                'id' => 9,
                'ocbc_detail_id' => 3,
                'record_type' => '21',
                'invoice_details' => 'test9 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            9 => array(
                'id' => 10,
                'ocbc_detail_id' => 3,
                'record_type' => '21',
                'invoice_details' => 'test10 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            10 => array(
                'id' => 11,
                'ocbc_detail_id' => 3,
                'record_type' => '21',
                'invoice_details' => 'test11 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            11 => array(
                'id' => 12,
                'ocbc_detail_id' => 4,
                'record_type' => '21',
                'invoice_details' => 'test12 details',
                
                'created_at' => $now,
                'updated_at' => $now
            ),
            12 => array(
                'id' => 13,
                'ocbc_detail_id' => 4,
                'record_type' => '21',
                'invoice_details' => 'test13 details',
                
                'created_at' => $now,
                'updated_at' => $now
            )

        ) );
    }
}
