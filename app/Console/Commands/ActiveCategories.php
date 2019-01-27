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
use App\Http\Controllers\UtilityController;
use Carbon;
use DateTime;
use DB;
class ActiveCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate categories status';

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
			$categories = DB::table('category')->
				select('category.*')->whereRaw("EXISTS (
				SELECT
					product.id FROM product, merchantproduct, merchant
				WHERE
					product.category_id = category.id AND
					product.id = merchantproduct.product_id AND
					product.oshop_selected = true AND
					merchant.id = merchantproduct.merchant_id AND
					product.available > 0 AND
					product.status = 'active' AND
					merchant.status = 'active'
				)")->orderBy('category.floor','ASC')->get();

			$floor = 1;
			foreach($categories as $category){
				DB::table('category')->
					where('id',$category->id)->
					update(['floor'=>$floor,'enable'=>true]);

				$floor++;
			}
			
			$notcategories = DB::table('category')->select('category.*')->whereRaw("NOT EXISTS
					(SELECT product.id FROM product, merchantproduct, merchant WHERE product.category_id = category.id AND product.id = merchantproduct.product_id AND product.oshop_selected = true AND merchant.id = merchantproduct.merchant_id AND product.available > 0 AND product.status = 'active' AND merchant.status = 'active')")
					->orderBy('category.floor','ASC')->get();
				
			foreach($notcategories as $category){
				DB::table('category')->where('id',$category->id)->update(['floor'=>$floor,'enable'=>false, 'color'=>'#AAAAAA']);
				$floor++;
			}	
        }catch(\Exception $e){
            dump($e);
			echo "Error for Update";
        }
    }
}
