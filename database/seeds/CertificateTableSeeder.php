<?php

use Illuminate\Database\Seeder;

class CertificateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('certificate')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('certificate')->insert(array(
            0 => array(
                'merchant_id' => 1,
                'logo' => 'certificate1.png',
                'name' => 'SME RISING STAR AWARD',
                'awarded' => '2009',
                'description' => '',
                'deleted_at' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ),
            1 => array(
                'merchant_id' => 1,
                'logo' => 'certificate2.jpg',
                'name' => 'IFRC ASIA',
                'awarded' => '2010',
                'description' => 'Certificate of HALAL Proucts',
                'deleted_at' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ),
            2 => array(
                'merchant_id' => 3,
                'logo' => 'certificate3.jpg',
                'name' => 'ACUMEN',
                'awarded' => '2010',
                'description' => 'Certificate of analysis',
                'deleted_at' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ),
            3 => array(
                'merchant_id' => 4,
                'logo' => 'certificate4.jpg',
                'name' => 'ASIA PACIFIC GOLDEN BRAND PRODUCTS',
                'awarded' => '2010',
                'description' => 'Asia Pacific Golden Brand Products',
                'deleted_at' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ),
        ));
    }
}
