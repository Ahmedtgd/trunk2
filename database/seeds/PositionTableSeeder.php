<?php
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $now = \Carbon\Carbon::now()->toDateTimeString();
        DB::table('position')->truncate();
        DB::table('position')->insert(array(
            0 =>array(
                'id'=>1,
                'code'=>'MGR',
                'description'=>'Manager',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            1 =>array(
                'id'=>2,
                'code'=>'HRE',
                'description'=>'Human Resource Executive',
                'created_at'=>$now,
                'updated_at'=>$now
            ),
            2 =>array(
                'id'=>3,
                'code'=>'OPE',
                'description'=>'Operations Executive',
                'created_at'=>$now,
                'updated_at'=>$now
            )
        ));
    }
}
