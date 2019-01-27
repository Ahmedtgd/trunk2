<?php

use Illuminate\Database\Seeder;

class DeliveryOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Delivered', 'UnDelivered','Partial','Pending'];
        \DB::table('deliveryorder')->insert([
            'receipt_id'=>1,
            'status'=>'Pending'
        ]);
        for($i = 1; $i < 21; $i++){
            $item_index = array_rand($status);
            \App\Models\DeliveryOrder::create([
                'receipt_id'     =>  mt_rand(1,20),
                'status'   =>  $status[$item_index]]);
        }
    }
}
