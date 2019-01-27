<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// Modals
use App\Models\Ocredit;
use App\Models\POrder;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Merchant;

// Controllers

use use App\Http\Controllers\UtilityController;
class UpdateOcredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ocredit:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update the table (ocredit)"s status column from pending to other value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function orderValue($porder_id,$orderproduct_id="")
    {
        if ($orderproduct_id=="") {
            
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        // Get all eligible ocredits

            $ocs=Ocredit::where('status','pending')
                ->where('value','>',0)
                ->where('mode','credit')
                ->where('product_id','!=',null)
                ->orWhere('merchant_id','!=',null)
                ->orWhere('porder_id','!=',null)
                ->orWhere('value','!=',null)
                ->orWhere('usd','!=',null)
                ->orWhere('smmout_id','!=',null)
                ->orWhere('openwish_id','!=',null)
                ->orWhere('owarehouse_id','!=',null)
                ->orWhere('cre_id','!=',null)
                ->orWhere('mcredit_id','!=',null)
                ->orWhere('source','!=',null)
                ->get();
            foreach ($ocs as $oc) {
                switch ($oc->mode) {
                    case 'smm':
                        # code...
                        break;
                    case 'openwish':
                        
                        break;
                    case 'hyper':
                        # code...
                        break;
                    case 'cre':
                        # code...
                        break;
                    case 'mcredit':
                        # code...
                        break;
                    case 'purchase':
                        // Get porder id and payment id
                        break;
                    default:
                        # code...
                        break;
                }
            }

    }
}
