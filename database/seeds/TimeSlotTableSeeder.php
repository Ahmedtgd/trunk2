<?php

use Illuminate\Database\Seeder;

class TimeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $vouchers = App\Models\Voucher::take(15)->get();
        foreach ($vouchers as $voucher) {
            $this->createTimeSlot($voucher);
        }


    }


    /**
     * @param $voucher
     */
    private function createTimeSlot($voucher)
    {
        $timeSlot = factory(App\Models\TimeSlot::class)->make();
        $voucher->timeSlots()->save($timeSlot);
    }
    
}
