<?php

use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = \App\Models\POrder::all();

		$c = 0;
        foreach ($orders as $order) {
			$c++;
            $payment = factory('App\Models\Payment')->create();
            $order->payment_id = $payment->id;
			$payment->status = "Paid ".$c*2;
			$payment->note = "Sample note ".$c;

			$payment->save();
            $order->save();
        }
    }
}
