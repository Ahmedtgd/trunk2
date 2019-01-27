<?php

use Illuminate\Database\Seeder;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('receipt')->insert([
            'porder_id'         =>    1,
            'do_password'   =>  mt_rand(100,900),
            'created_at' =>    $now,
            'updated_at'  =>    $now
        ]);
        for($i = 1; $i < 21; $i++){
           \App\Models\Receipt::create([
                'porder_id'     =>  $i,
                'do_password'   =>  mt_rand(100,900),
                'created_at' => $now,
                'updated_at' => $now]);
        }
    }
}
