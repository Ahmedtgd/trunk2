<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Rack;

use QrCode;
use DB;
use Log;
use Carbon;
use File;
use Auth;
class SellerRackController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$uid=NULL)
    {
        //return $request;
        $ret=array();

        $ret["status"]="failure";
        /*Check if logged in*/
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access.";
            return response()->json($ret);
        }
        /* Check if rack_no is valid and is passed */
        if (empty($request->warehouse_id)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
        /* Check ownership of warehouse */
        $user_id=Auth::user()->id;
        if (!empty($uid) and((Auth::user()->hasRole("adm") ) or (Auth::user()->hasRole("byr") )))  {
            # code...
            $user_id=$uid;
        }
        $company =  DB::table('member')->select('company_id')->where('user_id', $user_id)->first();
        //   dd($user_id);
        $merchant = DB::table('company')->select('owner_user_id')->where('id', $company->company_id)->first();
        $is_owner=DB::table("warehouse")->join("fairlocation","fairlocation.id","=","warehouse.location_id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.user_id",$merchant->owner_user_id)
        ->where("warehouse.id",$request->warehouse_id)
        ->first();
        if (empty($is_owner)) {
            $ret["long_message"]="Unauthorized Access!!!";
            return response()->json($ret);
        }
        /* Prevent duplicate rack_no  Obsolete for now 
        $does_exist=Rack::where("rack_no",$request->rack_no)->where("warehouse_id",$request->warehouse_id)->whereNull("deleted_at")->first();
        if (!empty($does_exist)) {
            $ret["long_message"]="Rack No already exists";
            return response()->json($ret);
        }*/
        $warehouse_id=$request->warehouse_id;
        $rack_no=1;
        $max_rack=DB::table("rack")
        ->whereNull("deleted_at")
        ->where("warehouse_id",$warehouse_id)
        ->orderBy("rack_no","desc")
        ->first();
        
        
        if (!empty($max_rack)) {
            # code...
            $rack_no=$max_rack->rack_no+1;
        }

        try {
            $r= new Rack;
            $r->rack_no=$rack_no;
         /*   $r->name=$request->name;
            $r->description=$request->description;*/
            $r->warehouse_id=$warehouse_id;
            $r->save();
            $ret["status"]="success";
            $ret["rack_id"]=$r->id;
        } catch (\Exception $e) {
            $ret["long_message"]="Server error happened";
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
        }

        return response()->json($ret);
    }

    /**
     * Delete a rack if product in rack is 0,
     * other wise not delete
     */

    public function remove(Request $request,$uid=NULL){
        //return $request;
        
        $ret=array();

        $ret["status"]="failure";
        /*Check if logged in*/
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access.";
            return response()->json($ret);
        }
        /* Check if rack_no is valid and is passed */
        if (empty($request->warehouse_id)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
        /* Check ownership of warehouse */
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
        $is_owner=DB::table("warehouse")->join("fairlocation","fairlocation.id","=","warehouse.location_id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        // ->where("fairlocation.user_id",$user_id)
        ->where("warehouse.id",$request->warehouse_id)
        ->first();
        if (empty($is_owner)) {
            $ret["long_message"]="Unauthorized Access!";
            return response()->json($ret);
        }
        $fairlocation_id=$is_owner->id;
        /* Prevent duplicate rack_no  Obsolete for now 
        $does_exist=Rack::where("rack_no",$request->rack_no)->where("warehouse_id",$request->warehouse_id)->whereNull("deleted_at")->first();
        if (!empty($does_exist)) {
            $ret["long_message"]="Rack No already exists";
            return response()->json($ret);
        }*/
        $warehouse_id=$request->warehouse_id;

        $i=0;
            $query="SELECT
                
                    product.name,
                    product.thumb_photo,
                    '--' expiry_date,
                  
                    
                    stockreport.id,
                    product.id,
                    SUM(
                        CASE

                            WHEN stockreport.ttype=NULL then 0
                             WHEN stockreport.ttype = 'stocktake' THEN
                            CAST(stockreportproduct.received as SIGNED)-CAST(stockreportproduct.opening_balance AS SIGNED)
                            WHEN stockreport.ttype='tin' then stockreportproduct.quantity
                           WHEN stockreport.ttype='tout' then - stockreportproduct.quantity
                            WHEN stockreport.ttype='treport' then 
                               CASE WHEN 
                                    stockreport.creator_location_id=$fairlocation_id
                                    THEN -stockreportproduct.quantity
                                    ELSE
                                    stockreportproduct.quantity
                                END
                            ELSE 0
                        END
                    ) as quantity

                    FROM 
                  
                    rack
                    JOIN (SELECT DISTINCT stockreport_id,rack_id from stockreportrack) r on r.rack_id=rack.id

                    LEFT JOIN stockreport ON  stockreport.id= r.stockreport_id
                    
                    LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = r.stockreport_id
                    LEFT JOIN product ON product.id=stockreportproduct.product_id


                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=$warehouse_id 
                   
                    AND rack.rack_no=$request->rack_id
                    AND stockreport.status='confirmed'
                    AND stockreport.deleted_at IS NULL
                    AND stockreportproduct.deleted_at IS NULL
                    AND stockreportproduct.status='checked'
                    AND product.deleted_at IS NULL
                    AND stockreport.creator_location_id=$fairlocation_id

                  
                  
                    group by  product.name";
            /*return $query;*/
            $raw_data=DB::select(DB::raw($query));
            //return $raw_data;
            if(!empty($raw_data)){
                $ret["long_message"]="Rack still have allocated products.";
                return response()->json($ret);
            
            }
            else{
                try {
                    $d=DB::table('rack')->where('rack_no', $request->rack_id)
                    ->where('warehouse_id', $request->warehouse_id)->delete();
                    // $r= new Rack;
                    //return $d;
                    // $r->rack_no=$rack_no;
                /*   $r->name=$request->name;
                    $r->description=$request->description;*/
                    $ret["status"]="success";
                
                } catch (\Exception $e) {
                    $ret["long_message"]="Server error happened";
                    Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
                }

                return response()->json($ret);
                //return redirect('/sellerWarehouse');
            }
    } 

    /**
     * Displays all/or was part of  the product in the rack , along with their quantity.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rack_product_info(Request $request,$uid=NULL,$location_id=NULL)
    {
        $ret=array();
        
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access. Please login.";
            return response()->json($ret);
        }

        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;

        }else if(!empty($uid) and(Auth::user()->hasRole("byr") )){
            $user_id=$uid;
        }

		
    
		/*
        if (empty($request->warehouse_id) or empty($request->rack_no)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
		 */

        $warehouse_id=$request->warehouse_id;
        $rack_no=$request->rack_no;

        Log::debug('Warehouse_id is not empty' . $warehouse_id);
        /* Check ownership of warehouse */
      
		$is_owner=DB::table("warehouse")->
			join("fairlocation","fairlocation.id","=","warehouse.location_id")->
			whereNull("fairlocation.deleted_at")->
			whereNull("warehouse.deleted_at")->
			where("fairlocation.user_id",$user_id)->
			where("warehouse.id",$warehouse_id)->
			select("fairlocation.id")->
			first();

		

        if (empty($is_owner)) {
       
            $ret["long_message"]="Unauthorized Access. Please choose correct warehouse.";
			
            return response()->json($ret);
        }
        if (empty($location_id)) {
            $fairlocation_id=$is_owner->id;
        }else{
            $fairlocation_id=$location_id;
        }
        


        try{
            $i=0;
            $query="SELECT
                
			product.name,
			product.thumb_photo,
			'--' expiry_date,
			
		
			product.id,
			rackproduct.quantity as quantity

			FROM 
		  
			rack

			
			LEFT JOIN rackproduct ON rackproduct.rack_id = rack.id
			LEFT JOIN product ON product.id=rackproduct.product_id


			WHERE 
			rack.deleted_at IS NULL
			AND rack.warehouse_id=$warehouse_id 
		   
			AND rack.rack_no=$rack_no
			
			AND rackproduct.deleted_at IS NULL
			
			AND product.deleted_at IS NULL
			
			group by  product.name";
            /*return $query;*/
            $raw_data=DB::select(DB::raw($query));
           
            $ret["status"]="success";
            $ret["data"]=$raw_data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        if (!empty($location_id)) {
            # code...
            return $raw_data;
        }else{
            return response()->json($ret);
        }
        
    }

    public function rack_product_remove(Request $request,$uid=NULL){

        //return $request;

        $ret=array();
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access. Please login.";
            return response()->json($ret);
        }
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
    
        if (empty($request->warehouse_id) or empty($request->product_id)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
        $warehouse_id=$request->warehouse_id;
        $product_id=$request->product_id;
        /* Check ownership of warehouse */
       
        $is_owner=DB::table("warehouse")->join("fairlocation","fairlocation.id","=","warehouse.location_id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.user_id",$user_id)
        ->where("warehouse.id",$warehouse_id)
        ->select("fairlocation.id")
        ->first();
        if (empty($is_owner)) {

            $ret["long_message"]="Unauthorized Access. Please choose correct warehouse.";
            return response()->json($ret);
        }
        $fairlocation_id=$is_owner->id;

         try{
        //     $i=0;
        //     $query="SELECT
                
        //             product.name,
        //             product.thumb_photo,
        //             '--' expiry_date,
                  
                    
        //             stockreport.id,
        //             product.id,
        //             SUM(
        //                 CASE

        //                     WHEN stockreport.ttype=NULL then 0
        //                      WHEN stockreport.ttype = 'stocktake' THEN
        //                     CAST(stockreportproduct.received as SIGNED)-CAST(stockreportproduct.opening_balance AS SIGNED)
        //                     WHEN stockreport.ttype='tin' then stockreportproduct.quantity
        //                    WHEN stockreport.ttype='tout' then - stockreportproduct.quantity
        //                     WHEN stockreport.ttype='treport' then 
        //                        CASE WHEN 
        //                             stockreport.creator_location_id=$fairlocation_id
        //                             THEN -stockreportproduct.quantity
        //                             ELSE
        //                             stockreportproduct.quantity
        //                         END
        //                     ELSE 0
        //                 END
        //             ) as quantity

        //             FROM 
                  
        //             rack
        //             JOIN (SELECT DISTINCT stockreport_id,rack_id from stockreportrack) r on r.rack_id=rack.id

        //             LEFT JOIN stockreport ON  stockreport.id= r.stockreport_id
                    
        //             LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = r.stockreport_id
        //             LEFT JOIN product ON product.id=stockreportproduct.product_id


        //             WHERE 
        //             rack.deleted_at IS NULL
        //             AND rack.warehouse_id=$warehouse_id 
                   
        //             AND rack.rack_no=$rack_no
        //             AND stockreport.status='confirmed'
        //             AND stockreport.deleted_at IS NULL
        //             AND stockreportproduct.deleted_at IS NULL
        //             AND stockreportproduct.status='checked'
        //             AND product.deleted_at IS NULL
        //             AND stockreport.creator_location_id=$fairlocation_id

                  
                  
        //             group by  product.name";
        //     /*return $query;*/
        //     $raw_data=DB::select(DB::raw($query));
           
           

            
            

            // $query="Select quantity from stockreportproduct where product_id=$request->product_id";
            // $product_data=DB::select(DB::raw($query));
            $d=DB::table('stockreportproduct')->where('product_id', $product_id)
            ->where('quantity',0)->delete();
            if($d==1){
                $ret["status"]="success";
                return response()->json($ret);
            }
            else{
                $ret["long_message"]="Cant delete this Product!";
            return response()->json($ret);
            }
            // $user = DB::table('stockreportproduct')->where('product_id', $product_id)->get();
            // $data=json_encode($user);
           
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        
    }

    public function remarks(Request $request,$uid=NULL){
		Log::debug('************* remarks() **************');
        //return $request;
        $rack_id=$request->rack_id;
       
        $ret=array();
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access. Please login.";
            return response()->json($ret);
        }
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }

		Log::debug('uid          ='.$uid);
		Log::debug('user_id      ='.$user_id);
    
        if (empty($request->warehouse_id) or empty($rack_id)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }

        $warehouse_id=$request->warehouse_id;
        $remarks=$request->remarks;


		Log::debug('warehouse_id ='.$warehouse_id);
		Log::debug('remarks      ='.$remarks);


        /* Check ownership of warehouse */
        $merchant = DB::table('company')->
			where('owner_user_id', $uid)->
			first();

		Log::debug(json_encode($merchant));

        if(!$merchant->owner_user_id){
            $buyer_user_remarks = $user_id;
        }else{
            $buyer_user_remarks = $merchant->owner_user_id;
        }
       
		$is_owner=DB::table("warehouse")->
			join("fairlocation","fairlocation.id","=","warehouse.location_id")->
			whereNull("fairlocation.deleted_at")->
			whereNull("warehouse.deleted_at")->
			where("fairlocation.user_id",$buyer_user_remarks)->
			where("warehouse.id",$warehouse_id)->
			select("fairlocation.id")->
			first();

        if (empty($is_owner)) {
            $ret["long_message"]="Unauthorized Access for this operation. Please choose correct warehouse.";
            return response()->json($ret);
        }
        $fairlocation_id=$is_owner->id;

         try{
        
			Log::debug('rack_id='.$rack_id.', warehouse_id='.$warehouse_id);

			$d=DB::table('rack')->where('rack_no', $rack_id)->
				where('warehouse_id',$warehouse_id)->
				update(array("remarks"=>$remarks));

			Log::debug('result='. $d);

            if($d==1){
                $ret["status"]="success";
                return response()->json($ret);

            } else{
                $ret["status"]="success";
				return response()->json($ret);
            }

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
			Log::info("Error @ ".$e->getLine()." file ".$e->getFile().
				" ".$e->getMessage());
        }
    }

}
