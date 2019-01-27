<?php

namespace App\Console\Commands;
use App\Classes\FPX;
use App\Http\Controllers\CartController;
use DB;
use App\Models\FPXREF;
use App\Models\FPXAC;
use Illuminate\Console\Command;

class FPXUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fpx:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Posts AE to FPX server for getting transaction status';

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
        /* Get all pending transactions.
           Post Request. Do Magic */
		$limit=4;
		$pendings=FPXREF::where('tries','<',$limit)->get(); 
		foreach ($pendings as $p) {
			$fpx=new FPX;
			$response=$fpx->post_ae($p->fpx_ar_id);
		}
		echo "success";
    }
}
