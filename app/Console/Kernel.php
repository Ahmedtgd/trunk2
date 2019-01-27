<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Api\SendMail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\UpdateOWish::class,
        \App\Console\Commands\MakeViewCommand::class,
        \App\Console\Commands\UpdateOWish::class,
        \App\Console\Commands\InsertIdlog::class,
        \App\Console\Commands\UpdateOrders::class,
        \App\Console\Commands\SearchIndex::class,
        \App\Console\Commands\TermEmail::class,
        \App\Console\Commands\HyperUpdate::class,
        \App\Console\Commands\FPXUpdate::class,
        \App\Console\Commands\EodNatural::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->call(function() {
			SendMail::sendmails();
		})->name('sendmails')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('owish:update')->daily();
		$schedule->call(function () {
            $ows = DB::table('owarehouse')->where('status','active')->get();
			foreach($ows as $ow){
				$date = $ow->created_at;
				$date = strtotime($date);
				$current_date = strtotime(date('Y-m-d H:i:s'));
				$date1 = new DateTime('now');
				$date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $ow->duration day", $date)));
				$dDiff = $date1->diff($date2);	
				$status=1;
				if ($dDiff->format("%r") == '-') {
					$status=0;
				}
				$product = DB::table('product')->where('id',$ow->product_id)->first();
				$available = 0;
				if(!is_null($product)){
					$available = $product->available;
				}
				if($available == 0){
					$status=0;
				}
				if($status == 0){
					DB::table('owarehouse')->where('id',$ow->id)->
						oupdate(['status','expired']);
					$pledges = DB::table('owarehousepledge')->
						where('owarehouse_id',$ow->id)->count();

					if($pledges < $ow->moq){
						/************* OPEN CREDIT**************/
						$pledges = DB::table('owarehousepledge')->
							where('owarehouse_id',$ow->id)->get();

						/*foreach($pledges as $pledge){
						}*/
					} else {
						/************* PROCESS PLEDGES **************/
						DB::table('owarehouse')->
							where('id',$ow->id)->update(['status','excecuted']);
					}
				}
			}
			
			$ows = DB::table('owarehouse')->
				where('status','active')->get();
        })->daily();
    }
}
