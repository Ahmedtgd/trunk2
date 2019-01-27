<?php

use Illuminate\Database\Seeder;

class SproductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::table('sproduct')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();

        DB::table('sproduct')->insert([
            'product_id'=>1,
            'available'=>5,
            'stock'=>5,
            'shipping_cost'=>10
        ]);
        DB::table('sproduct')->insert([
            'product_id'=>2,
            'available'=>10,
            'stock'=>10,
            'shipping_cost'=>20
        ]);

//        for ($i=1; $i <20 ; $i++) {
//        	 \DB::table('sproduct')->insert([
//        			'product_id'=>$i,
//        			'available'=>$i*5,
//        			'stock'=>$i*6,
//        			'shipping_cost'=>$i*10
//        			]);
//        };
 
    }
}
