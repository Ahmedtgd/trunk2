<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Barcode;
use Auth;
use Log;
use Carbon;
use DB;
class WebProductMapperController extends Controller
{

    public function create_blank_barcode(Request $r)
    {
        $batch=$r->batch;
        $product_id=$r->product_id;
        $barcode="";
        $productbc_ids=array();
		$b = new Barcode;

		$barcodeArray = [];
        $batchstart=$r->batchstart;
        for ($i=0; $i <$batch ; $i++) { 
			array_push($barcodeArray, $batchstart);
            $batchstart+=1;
		}

		/* Getting merchant_id from product */
		$merchant_id = DB::table('merchantproduct')->
			where('product_id',$product_id)->
			pluck('merchant_id');

		$pname = DB::table('product')->
			where('id', $product_id)->
			pluck('name');

		$validated = null;
		$duplicated = [];
		if (!empty($merchant_id)) {
			$validated = $b->verify($barcodeArray, $merchant_id);
		}

        $batchstart=$r->batchstart;
        for ($i=0; $i <$batch ; $i++) { 

			$found = false;
			if (!empty($validated)) {
				Log::debug('***** '.$i.':batchstart='.$batchstart.' *****');
				Log::debug('***** validated  ='.json_encode($validated).' *****');
				foreach ($validated as $prod) {
					if ($prod->barcode == "$batchstart") { 
						Log::debug('***** '.$batchstart.' detected! *****');
						array_push($duplicated, [
							'barcode'=>$prod->barcode,
					   		'name'   =>$prod->name
						]);
						$found = true;
						break;
					}
				}
			}

			if (!$found) {
				$id=$this->create_barcode($product_id,$batchstart);
				array_push($productbc_ids,$id);
			}
			$batchstart+=1;
        }

		Log::debug('***** productbc_ids='.
			json_encode($productbc_ids). ' *****');

		return [
			'fresh'=>$productbc_ids,
			'stale'=>$duplicated,
			'pname'=>$pname
		];
    }


    public function update_barcode(Request $r)
    {
        $id=$r->bcmanagement_id;
        $barcode=$r->barcode;
        
		DB::table("bc_management")->
			where("id",$id)->
			update([
				"updated_at"=>Carbon::now(),
				"barcode"=>$barcode
			]);

        return "ok";
    }


    public function create_and_save_barcode($filepath,$filename,
        $data,$rawtype="C128") {

        /* Intelligence to map raw barcode type to Milon's barcode library:
           https://github.com/milon/barcode/blob/master/readme.md */
        switch($rawtype) {
            case (preg_match('/CODE_*/', $rawtype) ? true : false):
                $type = str_replace('CODE_','C',$rawtype);
                break;
            default:
                $type = str_replace('_','',$rawtype);
        }

        Log::info('rawtype='.$rawtype.', type='.$type);

        try {
        
            try  {
                $base64 = DNS1D::getBarcodePNG($data,$type);
            } catch (\Exception $e) { 
                Log::error('Error! DNS1D::getBarcodePNG("'.
                    $data.'","'.$type.'"):'.
                    $e->getFile().':'.$e->getLine().': '.$e->getMessage());
            }

            $img = base64_decode($base64);
            if (!is_dir($filepath)) {
              // dir doesn't exist, make it
              mkdir($filepath,0775, true);
            }
            $filepath=$filepath."/".$filename;
            Log::info('filepath='.$filepath);
            try {
                file_put_contents($filepath, $img);
            } catch (\Exception $e) {
                Log::error("Error! file_put_content():".$e->getFile().':'.
                    $e->getLine().': '.$e->getMessage());
            }


        } catch (\Exception $e) {
            throw new Exception("Error in creating barcode".
                $e->getMessage(), 1);
            
            return $e->getMessage();
        }
    }


    public function create_barcode($product_id,$barcode)
    {
        $file_name="";

        $bc_management_id=DB::table('bc_management')->
			insertGetId([
				"barcode"=>$barcode,
				"barcode_type"=>"C128",
				"image_path"=>$file_name,
				"source"=>"web",
				"updated_at"=>Carbon::now(),
				"created_at"=>Carbon::now()
			]);

		$id=DB::table('productbc')->
			insertGetId([
				"bc_management_id"=>$bc_management_id,
				"product_id"=>$product_id,
				"updated_at"=>Carbon::now(),
				"created_at"=>Carbon::now()
			]);
        
        return $bc_management_id;
    }


    public function delete_barcode(Request $r)
    {
		$bcmanagement_id=$r->bcmanagement_id;

		Log::debug('bc_management_id='.$bcmanagement_id);

        DB::table("bc_management")->
			where("id",$bcmanagement_id)->
			delete();

        DB::table("productbc")->
			where("bc_management_id",$bcmanagement_id)->
			delete();

        return 0;
    }


    public function map_product(Request $r)
    {
        /*Validation*/
        $ret=array();
        $ret['status']="failure";
        $ret['long_message']="Validation failure";
   
        if (!$r->has('pid') or !$user ) {
            $ret['debug']=$r->pid;
            return response()->json($ret);
        }

        $user_id=$user->id;
        $product_id=$r->pid;
        $barcode=$r->barcode;
        $barcode_type=$r->barcode_type;
        $company_id=$r->company_id;

        try {
            $owner_user_id=DB::table("company")->
                where('id',$company_id)->
                pluck("owner_user_id");
        } catch (\Exception $e) {
            Log::error($e->getFile().":".$e->getLine().", ".
                $e->getMessage());
            $owner_user_id=0;
        }

        /*
        Log::info('user_id      ='.$user_id);
        Log::info('product_id   ='.$product_id);
        Log::info('barcode      ='.$barcode);
        Log::info('barcode_type ='.$barcode_type);
        Log::info('company_id   ='.$company_id);
        Log::info('owner_user_id='.$owner_user_id);
        */

        $validator=DB::table('merchantproduct')->
            join('product','product.id','=',
                'merchantproduct.product_id')->
            join('merchant','merchant.id','=','merchantproduct.merchant_id')->
            join('users','users.id','=','merchant.user_id')->
            whereNull('users.deleted_at')->
            where('users.id','=',$owner_user_id)->
            where('product.id','=',$product_id)->first();

        // Log::info(json_encode($validator));

        if (empty($validator)) {
            $ret['debug']="Validator empty";
            return response()->json($ret);
        }

        // Log::info('Passed validator');

        try {
            
            /*  Check if a record with barcode exists*/
            $productbc=DB::table('productbc')->
                join('bc_management','bc_management.id','=',
                    'productbc.bc_management_id')->
                join("merchantproduct","merchantproduct.product_id","=",
                    "productbc.product_id"
                    )->
                join("merchant","merchant.id","=","merchantproduct.merchant_id")->
                join("users","users.id","=","merchant.user_id")->
                where("users.id",$owner_user_id)->
                where('bc_management.barcode',$r->barcode)->
                whereNull('productbc.deleted_at')->
                orderBy("productbc.created_at")->
                first();
            // Log::info($productbc);exit();
            if (!empty($productbc)) {
                $product=DB::table("product")->
                where("id",$productbc->product_id)->
                
                select("product.id","product.photo_1","product.name")->
                first();

                    $product->image_uri='https://opensupermall.com/images/product/'.$product->id.'/'.$product->photo_1;
           
                $ret["error"]="Barcode already mapped. To remap, please remove the mapping.";
                $ret["product"]=$product;
                return response()->json($ret,505);
            }

			$file_name=str_random(10).".png";
			$path="images/barcode/".$product_id;
			$file_path=public_path($path);
			$this->create_and_save_barcode(
				$file_path,$file_name,$r->barcode,$r->barcode_type);

			$bc_management_id=DB::table('bc_management')->
				insertGetId([
					"barcode"=>$r->barcode,
					"barcode_type"=>$r->barcode_type,
					"image_path"=>$file_name,
					"updated_at"=>Carbon::now(),
					"created_at"=>Carbon::now()
				]);

			DB::table('productbc')->
				insert([
					"bc_management_id"=>$bc_management_id,
					"product_id"=>$product_id,
					"updated_at"=>Carbon::now(),
					"created_at"=>Carbon::now()
				]);

			$ret['status']="success";
			$ret['long_message']="Product's mapping has been completed.";
            
        } catch (\Exception $e) {
            Log::info($e);
            $ret['short_message']=$e->getMessage();
        }

        return response()->json($ret);
    }
}
