<?php

use Illuminate\Database\Seeder;

class ncityid_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		\DB::table('ncityid')->truncate();
		$states = DB::table('state')->where('country_code','MYS')->get();
		$now = \Carbon\Carbon::now()->toDateTimeString();
		foreach($states as $state){
			$nstate=DB::table('nstateid')->
				where('state_id',$state->id)->
				first();

			if(!is_null($nstate)){
				$cities = DB::table('city')->
					where('state_code',$state->code)->
					where('country_code','MYS')->
					get();

				$id = 1;
				foreach($cities as $city){
					DB::table('ncityid')->
						insert([
							'city_id'=>$city->id,
							'ncity_id'=>$nstate->nstate_id .
							str_pad($id,3,"0",STR_PAD_LEFT),
							'created_at' => $now,
							'updated_at' => $now
						]);
					$id++;
				}				
			}
		}		
    }
}
