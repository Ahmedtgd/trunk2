<?php

use Illuminate\Database\Seeder;

class OcbcHeaderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ocbc_header')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ocbc_header')->insert(array (
            0 => array(
                'id' => 1,
                'ocbc_trailer_id' => 1,
                'record_type' => '01',
                'tape_id' => '002',
                'branch' => '00790',
                'company_cif' => 'A999999',
                'company_name' => 'Intermedius OpenSupermall',
                'company_ac_no' => '7901062119',
                'instruction' => 'D',
                'reversal_indicator' => 'N',
                'crediting_date' => '20012016',
                'customer_ref_no' => '12345678',
                'created_at' => $now,
                'updated_at' => $now
            )
        ) );
    }
}
