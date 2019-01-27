<?php namespace App\Classes;

use DB;
use App\Exceptions\CustomException;
use QueryException;

class SecurityIDGenerator{

	/* use use App\Classes\SecurityIDGenerator;
	 * $a = new SecurityIDGenerator;
	 * $a->generate("2016-12-05");
	 * $a->generate(Carbon::now()->toDateString());
	 */

    public function generate($date){
		$DEBUG = false;

		$uuid_natural =  sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);

		if ($DEBUG) {
			echo "uuid_natural = $uuid_natural\n";
		}

		$year_hex = str_pad(dechex(date('y')),2,'0',STR_PAD_LEFT);
		$month_hex = str_pad(dechex(date('m')),2,'0',STR_PAD_LEFT);
		$day_hex = str_pad(dechex(date('d')),2,'0',STR_PAD_LEFT);
		$hour_hex = str_pad(dechex(date('H')),2,'0',STR_PAD_LEFT);

		if ($DEBUG) {
			echo "year_hex  = $year_hex\n";
			echo "month_hex = $month_hex\n";
			echo "day_hex   = $day_hex\n";
			echo "hour_hex  = $hour_hex\n";
		}
		
		/* Get the latest record */
		$positions = DB::table('idlog')->
			orderby('created_at','desc')->first();

		if ($DEBUG) {
			dump($positions);
		}

		if(!is_null($positions)){
			$original = $uuid_natural;
			$uuid_natural = substr_replace($uuid_natural,
				$year_hex, ($positions->yr_pos - 1), 2);

			$uuid_natural = substr_replace($uuid_natural,
				$month_hex, ($positions->mth_pos - 1), 2);

			$uuid_natural = substr_replace($uuid_natural,
				$day_hex, ($positions->day_pos - 1), 2);

			$uuid_natural = substr_replace($uuid_natural,
				$hour_hex, ($positions->hr_pos - 1), 2);

			$uuid_new = $uuid_natural;			

		} else {
			$uuid_new = null;
		}

		return $uuid_new;
    }
}
