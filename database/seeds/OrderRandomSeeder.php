<?php

use Illuminate\Database\Seeder;

class OrderRandomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = \App\Models\POrder::all();

        foreach ($orders as $order) {

            $start_date = '2015-1-1 19:39:34';
            $end_date = '2015-12-31 19:39:34';
            $order->created_at = \Carbon\Carbon::parse($this->randomDate($start_date, $end_date));
            $order->save();

        }

    }
    public function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = mt_rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}
