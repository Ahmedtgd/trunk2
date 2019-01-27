<?php

use Illuminate\Database\Seeder;

class GlobalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

      $now = \Carbon\Carbon::now()->toDateTimeString();
      DB::table('global')->truncate();

      \DB::table('global')->insert(array (
            0 => array (
				'pmrb_table' => 'pmrb_table: [{"pmrb_p":"5001-20000""pmrb_m":"5000""pmrb_r":"1""pmrb_b1":"-400""pmrb_b2":"-800"}{"pmrb_p":"20001-35000""pmrb_m":"20000""pmrb_r":"5""pmrb_b1":"-250""pmrb_b2":"-650"}{"pmrb_p":"35001-50000""pmrb_m":"35000""pmrb_r":"10""pmrb_b1":"900""pmrb_b2":"900"}{"pmrb_p":"50001-70000""pmrb_m":"50000""pmrb_r":"16""pmrb_b1":"2400""pmrb_b2":"2400"}{"pmrb_p":"70001-100000""pmrb_m":"70000""pmrb_r":"21""pmrb_b1":"5600""pmrb_b2":"5600"}{"pmrb_p":"100001-250000""pmrb_m":"100000""pmrb_r":"24""pmrb_b1":"11900""pmrb_b2":"11900"}{"pmrb_p":"250001-400000""pmrb_m":"250000""pmrb_r":"24.5""pmrb_b1":"47900""pmrb_b2":"47900"}{"pmrb_p":"400001-600000""pmrb_m":"400000""pmrb_r":"25""pmrb_b1":"84650""pmrb_b2":"84650"}{"pmrb_p":"600001-1000000""pmrb_m":"600000""pmrb_r":"26""pmrb_b1":"134650""pmrb_b2":"134650"}{"pmrb_p":"> 1000000""pmrb_m":"1000000""pmrb_r":"28""pmrb_b1":"238650""pmrb_b2":"238650"}]',
                'created_at' => $now,
                'updated_at' => $now,
            )
        ));
    }
}
