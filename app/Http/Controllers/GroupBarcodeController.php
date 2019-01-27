<?php
/**
 * Created by PhpStorm.
 * User:Chris Uzor
 * Date: 11/10/2018
 * Time: 14:10
 */
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OposSpaCustomer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Globals;
use App\Models\OposSparoom;
use App\Models\OposReceiptproduct;
use App\Models\OposReceipt;
use App\Models\OposDiscount;
use App\Models\OposMerchantterminal;
use App\Models\OposTerminal;
use App\Models\OposBundle;
use App\Models\OposBundleProduct;
use Auth;
use DB;
use Log;
use Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Address;
use App\Models\OposSave;
use App\Models\RoleUser;
use App\Models\Buyer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Rhumsaa\Uuid\Console\Exception;

use App\Classes\Barcode;

class GroupBarcodeController extends Controller{

    public function groupbarcodes(Request $request){
		Log::debug('***** groupbarcodes() *****');

        $barcodes = $request['barcodes'];
        //get rid of white spaces
        $barcodes = trim($barcodes);

        $p_id = $request['product_id'];
        $data = [];
       // Log::debug($p_id);
        foreach (explode("\n",$barcodes) as $dat1) {
            foreach(explode(',',$dat1) as $dat2) {
                foreach (explode(';',$dat2) as $d) {
                    array_push($data, $d);
                }
            }
        }
        // Get rid of duplicates
        $data=array_values(array_unique($data));
        $merchant_user_id=Auth::user()->id;

        $merchant=DB::table("merchant")
        ->where('user_id',$merchant_user_id)
        ->whereNull('deleted_at')
        ->first();

        // Validate
        $b=new Barcode;
        $validation=$b->verify($data,$merchant->id);
       
        if (!empty($validation)) {
            
            // return response()->json([
            //     'status'=>'failure',
            //     'short_message'=>'inuse',
            //     'data'=>$validation
            // ]);

            foreach ($validation as $v) {
                if (($key = array_search($v->barcode, $data)) !== false) {
					Log::debug('data='.json_encode($data));
					Log::debug('barcode='.$v->barcode);

					Log::debug('Removing '.json_encode($data[$key]));
                    unset($data[$key]);
                }
            }
        }

        foreach ($data as $d){
            $bc_id = DB::table('bc_management')->
				insertGetId(array('barcode' => trim($d),
					'barcode_type' =>  'C128',
					'source' => 'web'));

            Log::debug("id = " . $bc_id);

            $product_bc = DB::table('productbc')->
				insert(['bc_management_id' => $bc_id,
					'product_id' => $p_id]);

            if($product_bc){
            }
        }

		Log::debug('***** $validation *****');
		Log::debug(json_encode($validation));

		return response()->json([
			'status' => 'success',
			'data'   => $validation
		]);
    }
}
