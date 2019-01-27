<?php

use Illuminate\Database\Seeder;
class PCBGlobalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcb_global')->truncate();
		DB::table('pcb_global')->insert([
			'pcb_disabled'=>600000,
			'pcb_spouse_no_income'=>400000,
			'pcb_spouse_disabled'=>600000,
			'pcb_child_underage'=>200000,
			'pcb_child_aboveage'=>800000
		]);
    }
}


