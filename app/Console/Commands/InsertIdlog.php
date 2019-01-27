<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\Ocredit;
// use App\Models\OAcc;
use App\Models\MerchantProduct;
use App\Models\POrder;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\DeliveryOrder;
use App\Models\Receipt;
use App\Models\Globals;
use Carbon;
use DB;

class InsertIdlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idlog:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts record in idlog hourly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
			$arr_def = Array();
			$year_rand = rand(1, 31);
			$arr_def[0] = $year_rand;
			$arr_def[1] = $year_rand + 1;
			$arr_def[2] = $year_rand - 1;
			while( in_array( ($month_rand = rand(1,31)), $arr_def ) );
			$arr_def[3] = $month_rand + 1;
			$arr_def[4] = $month_rand - 1;
			$arr_def[5] = $month_rand;
			while( in_array( ($day_rand = rand(1,31)), $arr_def ) );	
			$arr_def[5] = $day_rand;
			$arr_def[7] = $day_rand + 1;
			$arr_def[8] = $day_rand - 1;
			while( in_array( ($hour_rand = rand(1,31)), $arr_def ) );
			
			DB::table('idlog')->insert([
				'day_pos'=>$day_rand,
				'mth_pos'=>$month_rand,
				'yr_pos'=>$year_rand,
				'hr_pos'=>$hour_rand,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			]);

        } catch(\Exception $e){
			echo "Error for Insert";
        }
    }
}
