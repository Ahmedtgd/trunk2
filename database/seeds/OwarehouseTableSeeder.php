<?php

use Illuminate\Database\Seeder;

class OwarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('owarehouse')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('owarehouse')->insert(array (
         0 => array(
            	'product_id' => '22',
				'moq' => '10',
        		'collection_price' => '10000',
        		'collection_units' => '10',
        		'duration' => '30',
        		'collection' => 'box',
        		'created_at'=>$now,
        		'updated_at'=>$now,
        ),
        1 => array(
            	'product_id' => '23',
				'moq' => '10',
        		'collection_price' => '10100',
        		'collection_units' => '10',
        		'duration' => '20',
        		'collection' => 'box',
        		'created_at'=>$now,
        		'updated_at'=>$now,
        ),

         2 => array(
                'product_id' => '24',
                'moq' => '10',
                'collection_price' => '20100',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

        3 => array(
                'product_id' => '25',
                'moq' => '20',
                'collection_price' => '10100',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

         4 => array(
                'product_id' => '26',
                'moq' => '10',
                'collection_price' => '10100',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

         5 => array(
                'product_id' => '27',
                'moq' => '10',
                'collection_price' => '10000',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

        6 => array(
                'product_id' => '28',
                'moq' => '30',
                'collection_price' => '30000',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

        7 => array(
                'product_id' => '29',
                'moq' => '30',
                'collection_price' => '30000',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),

        8 => array(
                'product_id' => '30',
                'moq' => '10',
                'collection_price' => '30000',
                'collection_units' => '10',
                'duration' => '20',
                'collection' => 'box',
                'created_at'=>$now,
                'updated_at'=>$now,
        ),
       
      ));
    }
}
