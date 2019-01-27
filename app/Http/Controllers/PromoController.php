<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\DownloadAppRepo;
use App\Http\Requests\DownloadAppRequest;
use View;
use App\Models\OposBundle;
use App\HttpC\Requests;
use Carbon;
use DB;
use Log;
use Auth;
use File;
use Image;
use URL;

class PromoController extends Controller {

	public function getBundles(Request $r)
    {
    	$bundleList = OposBundle::with('bundleProduct')
			->join('opos_locationbundle','opos_locationbundle.bundle_id','=','opos_bundle.id')
			->join('opos_locationterminal','opos_locationterminal.location_id','=','opos_locationbundle.location_id')
			->select('opos_bundle.*')
			->where('opos_locationterminal.terminal_id',$r->terminal_id)
			->whereNull('opos_bundle.deleted_at')
            ->groupBy('opos_bundle.id')
			->orderBy('opos_bundle.id','desc')
			->get();
    	$currency= DB::table('currency')->
			where('active', 1)->first()->code;
    	
    	return view('opposum.trunk.promotion.promo_definition',
			compact('currency','bundleList'));
    }

    public function getBundleList(Request $r)
    {
        $bundleList = OposBundle::with('bundleProduct')
			->join('opos_locationbundle','opos_locationbundle.bundle_id','=','opos_bundle.id')
			->join('opos_locationterminal','opos_locationterminal.location_id','=','opos_locationbundle.location_id')
			->select('opos_bundle.*')
			->where('opos_locationterminal.terminal_id',$r->terminal_id)
			->whereNull('opos_bundle.deleted_at')
			->orderBy('opos_bundle.id','desc')
			->get();

		Log::debug(json_encode($bundleList));

    	$currency= DB::table('currency')->where('active', 1)->first()->code;
    	
    	return view('opposum.trunk.promotion.promo_definitionlist',
			compact('currency','bundleList'));
    }

    public function saveBundle(Request $r)
    {	
    	$user_id = Auth::user()->id;

    	$location =  DB::table("opos_locationterminal")
						->where("terminal_id",$r->bundle_terminal_id)
						->whereNull("deleted_at")
						->orderBy("created_at","DESC")
						->pluck("location_id");

    	$fromdate = date_create($r->valid_start_dt);
		$valid_start_dt = date_format($fromdate, 'Y-m-d H:i:s');

		$enddate = date_create($r->valid_end_dt);
		$valid_end_dt = date_format($enddate, 'Y-m-d H:i:s');

    	$bpids = explode(",",$r->selectedBuyProduct);
    	$dpids = explode(",",$r->selectedDiscountProduct);
    	array_pop($bpids);
    	array_pop($dpids);

    	$bpcount = array_count_values($bpids);
    	$dpcount = array_count_values($dpids);        

    	$savebundleId =
			DB::table('opos_bundle')
				->insertgetId([
					"title" => $r->title,
					"bprice" => $r->bprice * 100,
					"valid_start_dt" => $valid_start_dt,
					"valid_end_dt" => $valid_end_dt,
					"created_at" =>Carbon::now(),
					"updated_at" =>Carbon::now()
				]);

        $folder = base_path() . '/public/images/bundle/' .
			$savebundleId;

        $folder_thumb = base_path() . '/public/images/bundle/' .
			$savebundleId . '/thumb';

        File::makeDirectory($folder, 0777, true, true);
        File::makeDirectory($folder_thumb, 0777, true, true);
        $destination = $folder . '/';

        $image = $r->file('bundleimage');

        if (isset($image)) {

            $image_split = explode(".", $image->getClientOriginalName());
            $arr_size = count($image_split);
            $image_format = $image_split[$arr_size - 1];
            $image_name = "b".
                str_pad($savebundleId, 10, '0', STR_PAD_LEFT)."-".
                rand(1000, 9999) . "." . $image_format;

            if ($image->move($destination, $image_name)) {

                $imgpath = URL::to('/')."/images/bundle/".$savebundleId.
                    "/".$image_name;
                $t30path = public_path('images/bundle/'.$savebundleId.
                    '/thumb/'.$image_name);

                Image::make($imgpath)->
                    resize(30, 30, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($t30path);

                $saveimage = DB::table('opos_bundle')->
					where('id',$savebundleId)->
					update(['bundle_thumb_photo' => $image_name]);
            }
        }

    	$savelocationbundleId =
			DB::table('opos_locationbundle')
				  ->insertgetId([
						"location_id" => $location,
						"bundle_id" => $savebundleId,
						"created_at" =>Carbon::now(),
						"updated_at" =>Carbon::now()
					]);

		if($savebundleId > 0) {
    		if(count($bpcount) > 0) {
    			foreach($bpcount as $key => $count) {
    				$savebundleproduct =
						DB::table('opos_bundleproduct')
						  ->insert([
								"bundle_id" => $savebundleId,
								"product_id" => $key,
								"bpdiscount" => 0,
								"bpqty" => $count,
								"created_at" =>Carbon::now(),
								"updated_at" =>Carbon::now()
							]);
				}
    		}

    		if(count($dpcount) > 0) {
               	foreach($dpcount as $key => $count) {
                    $bundlediscount = $r['bpdiscount_'.$key];
                    $savebundleproduct =
						DB::table('opos_bundleproduct')
						  ->insert([
								"bundle_id" => $savebundleId,
								"product_id" => $key,
								"bpdiscount" => $bundlediscount,
								"bpqty" => $count,
								"created_at" =>Carbon::now(),
								"updated_at" =>Carbon::now()
							]);
    			}
    		}
    	}

    	$currency= DB::table('currency')->where('active', 1)->first()->code;
    	$bundleList = OposBundle::with('bundleProduct')->
			where('id',$savebundleId)->
			whereNull('deleted_at')->get();

    	$view = view('opposum.trunk.promotion.bundleproducts',
			compact('currency','bundleList'))->render();

        return response()->json(array('view'=> $view));
    }

    public function getBundleLocation(Request $r,$id=null)
    {
    	$bundleId = $r->bundleId;
    	
    	if ($id != null and Auth::user()->hasRole("adm")) {
			$user_id= $id;
		} else {
			$user_id= Auth::user()->id;	
		}

    	// $locationss=DB::table("fairlocation")
			  //       ->where("fairlocation.user_id",$user_id)
			  //       ->whereNull("fairlocation.deleted_at")
			  //       ->select("fairlocation.id","fairlocation.location as location")
			  //       ->distinct("location")
			  //       ->orderBy("fairlocation.location")
			  //       ->get();

		$locations = DB::table("fairlocation")
			->join('locationusers','locationusers.location_id','=','fairlocation.id')
            ->join('opos_locationterminal','opos_locationterminal.location_id','=','fairlocation.id')
			->select('fairlocation.id','fairlocation.location')
            // ->where('opos_locationterminal.terminal_id',$r->terminal_id)
			->where('locationusers.user_id',$user_id)
			// ->where('fairlocation.id',$location)
			->whereNull("fairlocation.deleted_at")
			->whereNull('locationusers.deleted_at')
			->groupBy('fairlocation.id')
			->get();

			// echo '<pre>'; print_r($locations); die();

		$selectedLocation = DB::table('opos_locationbundle')->
			select("location_id")->
			where('bundle_id',$bundleId)->
			whereNull('deleted_at')->get();

        return view("opposum.trunk.promotion.bundlelocations",
			compact('locations','bundleId','selectedLocation'));
    }

    public function saveBundleLocation(Request $r)
    {
    	$locations = $r->locationids;

    	$allLocation =
			DB::table('opos_locationbundle')
				->select("location_id")
				->where('bundle_id',$r->bundleId)
				->whereNull('deleted_at')
				->get();

    	$array = array();
    	if(count($allLocation) > 0) {
		    foreach($allLocation as $lid) {
		        $array[] = $lid->location_id;
		    }
		}

    	$insert = array_diff($locations,$array);
    	$delete = array_diff($array,$locations);
    	
    	if(count($insert) > 0) {
    		foreach($insert as $location) {
    			$insertedId =
					DB::table('opos_locationbundle')
					  ->insertgetId([
							"location_id" => $location,
							"bundle_id" => $r->bundleId,
							"created_at" =>Carbon::now(),
							"updated_at" =>Carbon::now()
					  ]);
    		}
    	}

    	if(count($delete) > 0) {
    		$deleted =
				DB::table('opos_locationbundle')
					->whereIn('location_id',$delete)
					->where('bundle_id',$r->bundleId)
					->update(["deleted_at" => Carbon::now()]);
    	}

    	return response()->
			json(["status"=>"success","data"=>$locations]);
    }

    public function deteteBundle(Request $r)
    {
    	$deletebundle =
			DB::table('opos_bundle')
				->where('id',$r->bundleId)
				->update(["deleted_at" => Carbon::now()]);

		$deletebundleproducts =
			DB::table('opos_bundleproduct')
				->where('bundle_id',$r->bundleId)
				->update(["deleted_at" => Carbon::now()]);

    	$deletebundlelocation =
			DB::table('opos_locationbundle')
				->where('bundle_id',$r->bundleId)
				->update(["deleted_at" => Carbon::now()]);

		return response()->json(["status"=>"success"]);
    }

    public function showBundleProducts(Request $r)
    {
    	$products =
			DB::table('opos_bundle')
				// ->leftjoin('opos_bundleproduct','opos_bundleproduct.bundle_id','=','opos_bundle.id')
				// ->leftjoin('product','product.id','=','opos_bundleproduct.product_id')
				->select('opos_bundle.id as product_id','opos_bundle.title as name','opos_bundle.bprice as price','opos_bundle.bundle_thumb_photo as thumb_photo')
				->where('opos_bundle.id',$r->bundleId)
				->whereNull('opos_bundle.deleted_at')
				->get();

    	return response()->json($products);
    }
}
?>
