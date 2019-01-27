<?php

use Illuminate\Database\Seeder;

class OwarehousepledgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('owarehousepledge')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('owarehousepledge')->insert(array (
         0 => array(
            'owarehouse_id'=>'1',
            'user_id'=>'1',
            'pledged_qty'=>'3'
            ),
			1 => array(
            'owarehouse_id'=>'1',
            'user_id'=>'2',
            'pledged_qty'=>'1'
            ),
            2 => array(
            'owarehouse_id'=>'2',
            'user_id'=>'1',
            'pledged_qty'=>'3'
            ),
            3 => array(
            'owarehouse_id'=>'2',
            'user_id'=>'2',
            'pledged_qty'=>'1'
            ),
            4 => array(
            'owarehouse_id'=>'3',
            'user_id'=>'2',
            'pledged_qty'=>'3'
            ), 
             5 => array(
            'owarehouse_id'=>'3',
            'user_id'=>'4',
            'pledged_qty'=>'3'
            ),
              6 => array(
            'owarehouse_id'=>'4',
            'user_id'=>'2',
            'pledged_qty'=>'3'
            ), 
             7 => array(
            'owarehouse_id'=>'4',
            'user_id'=>'2',
            'pledged_qty'=>'3'
            ),
        ));
    }
}
