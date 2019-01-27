<?php

namespace App\Http\Controllers;
use App\Models\OpenWish;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\MerchantProduct;
use App\Models\Currency;
use App\OWish;
use App\Models\OpenWishPledge;
use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OpenWishRequest;
use App\Http\Controllers\PriceController;
use Auth;
use DB;

// DB conversion happened
class OpenWishController extends Controller{

    public function pledgeValidation($openwishID)
    {
        # Returns True if pledge can be made. Otherwise returns false.
        $ret=False;
        try {
            $amt=DB::table('openwishpledge')
        ->where('openwish_id',$openwishID)
        ->select(DB::raw(
            '
            SUM(pledged_amt) as amt
            '
            ))
        ->first()->amt;
        
        } catch (\Exception $e) {
            $amt=0;
        }
        
        return $amt;
        return $ret;
    }

    public function openwish_log($openwish_id)
    {
        $user_id=Auth::user()->id;
        $openwish=OpenWish::find($openwish_id);
        $currency= DB::table('currency')->where('active', 1)->first()->code;
        $ret=array();
        $ret['status']="failure";
        if (empty($openwish)) {
            $ret['long_message']="Incorrect OpenWish Id";
            return response()->json($ret);
        }
        if ($user_id==$openwish->user_id) {
            $contribs=DB::table('openwishpledge')->
            join('users','users.id','=','openwishpledge.user_id')
            // where('openwish.user_id','!=',NULL)->
            ->where('openwish_id',$openwish->id)
            ->select(['users.name','openwishpledge.pledged_amt as amount','openwishpledge.created_at'])->get();

            //Formatting
            foreach ($contribs as $c) {
                 $c->amount=$currency." ".number_format($c->amount/100,2);
                 $c->created_at=UtilityController::s_date($c->created_at);
             } 
            $ret['status']="success";
            $ret['data']=$contribs;
        }else{

            $ret['long_message']="You do not have permission to view this openwish.";
        }
        return response()->json($ret);
    }
    public function trans_openwish($openwish_id)
    {
        $ret=array();
        $ret['status']='failure';
        $openwish=OpenWish::find($openwish_id);
        if (!is_null($openwish)) {
            try {
                $data=OpenWish::leftJoin('openwishpledge as op','op.openwish_id','=','openwish.id')
                ->leftJoin('product','product.id','=','openwish.product_id')
                ->where('openwish.id','=',$openwish_id)
                ->select(DB::raw('
                        product.id as productid,
                        op.message as message,
                        product.name as productname,
                        CASE
                        WHEN product.discounted_price>0 THEN product.discounted_price
                        ELSE 
                        product.retail_price 
                        END as productprice,
                        op.pledged_amt as bought
                    '))
                ->get();
                $ret['status']='success';
                $ret['data']=$data;
            } catch (\Exception $e) {
                $ret['short_message']=$e->getMessage();
            }
        }else{
            $ret['long_message']="Incorrect openwish id";
        }
        return response()->json($ret);
    }

    public function reshareOWish()
    {
       // if ( !$request->ajax() ) return redirect()->back();


        if(!Auth::check()) 

        {
            return "Not Authorized";
        }
        $OWish=new OWish;
        $productId =$_GET['itemId'];
        $message=$_GET['message'];
        // dd($productId);
        // Validation
        
        // This is the user_id of the SMM/OpenWisher, NOT the merchant!!! | Obviously Dev. Duh!
        $userId = Auth::user()->id;

        $product = Product::find($productId);
        $ow=OpenWish::where('user_id',$userId)->
        where('product_id',$productId)->
        where('status','active')->
        first();
        // Check for token
        $access_token= DB::table('oauth_session')->where('user_id',$userId)->pluck('access_token');
        if (is_null($access_token)) {
                return -1 ;
        }
        // Knowing the product we figure out who the merchant is
        $mprod = MerchantProduct::where('product_id', $productId)->first();
        if(isset($mprod)){
            $merchant = Merchant::find($mprod->merchant_id);
            if(isset($merchant)){
                
                $rp = $product->discounted_price;
                $op = $product->retail_price;
                if ($rp!=0) {
                    $pricing=$rp;
                    $discount=(($op-$rp)/$op)*100;
                }
                else {
                    $pricing=$op;
                    $discount=0;
                }

                $delivery=0;
                $pricing= $pricing+$delivery;
                $pid = $product->parent_id;
                $pname = $product->name;
                $base_url =url();
                $img_url = $base_url."/images/product/".$pid."/".
                            $product->photo_1;

                $data = array(
                    'product_id' => $productId,
                    'user_id' => $userId,
                    //'link_id' => $graphNode['id']
                );

                //Insert product selected to openwish list table with pending status
              
                $pledge = 0;
                $balance = $op;
                if(isset($ow))
                    $openWishPledge = OpenWishPledge::where('openwish_id', $ow->id)->get();
                        if(isset($openWishPledge) && !empty($openWishPledge))
                            foreach($openWishPledge as $owp){
                                $pledge += $owp->pledged_amt;
                            }else
                                $pledge = 0;
                $balance = number_format(($pricing/100) - ($pledge / 100) , 2);
                $pledge /= 100;
                //Prepare link data for facebook
                $us= new UrlShortenerController;
                $shortened_url= $base_url."/u/".$us->shorten($base_url."/productconsumer/".$pid . '/' . $ow->id,'owish',$ow->id);

                
            
                $description=strip_tags(substr($product->name,0,9000));
                $currency=Currency::where('active',1)->first()->code;
                $pricing= number_format($pricing/100,2);
                $discount=number_format($discount,2);
                $linkData = [
                    'link' => $shortened_url,
                    'from' => "FOO BAR BAZ",
                    'message' => $message,
                    'icon' => "http://beta.opensupermall.com/images/logo-white.png",
                    'picture' => $img_url,
                    'caption' => $merchant->oshop_name."@OpenSupermall",
                    'name' => "** OpenSupermall ** | ".ucwords($pname),
                    'description' => "Price:".$currency." ".$pricing.
					"|Discount:".$discount."%|Accumulated:".
					$currency." ".$pledge."|Balance:".$currency." ".$balance,
                ];
                // return $linkData;
                //Post selected product to facebook user's profile, from "app/OWish.php"
                $errorCheck = $OWish->facebook($linkData);
                $currency= DB::table('currency')->where('active', 1)->first()->code;

                if($errorCheck['ok']){
                    //    $errorCheck['ok'] = true;
                    OpenWish::where('id',$ow->id)->update(['shared_count'=>$ow->shared_count+1]);
                    $message = "Your OpenWish of ".$product->name." (".$currency."".$pricing.") has been posted to your Facebook account ";
                    
                    return response()->json(['status'=>'success','short_message'=>'Success','long_message'=>$message]);
                    //    return "Your OpenWish of ".$product->name." (MYR".$pricing.") has been posted to your Facebook account ";
                } else {
                    return response()->json(['status'=>'failure','short_message'=>'Token Failure','long_message'=>"Please register to use the feature"]);
                    $errorCheck['url'] = TokenController::connect();
                    return $errorCheck;
                }
            } else {
                return response()->json(['status'=>'failure','short_message'=>'Server Failure','long_message'=>"We could not add your OpenWish"]);
                return "We could not add your OpenWish";
            }
        } else {
            return response()->json(['status'=>'failure','short_message'=>' Failure','long_message'=>"Please try again later"]);
            return "We could not add your OpenWish";
        }
    }
    public function get_openwish($value='',$passed_user_id=NULL)
    {
        # code...
        if($value === 'merchant'){

        if (Auth::user()->hasRole('adm')) {
            $user_id=$passed_user_id;
        }else{
            $user_id=Auth::user()->id;
        }
        $merchant = Merchant::where('user_id',$user_id)->select('id')->first();
    		if(!is_null($merchant)){
    			$openwish = \DB::table('openwish')
    			->join('product' , 'product.id', '=' , 'openwish.product_id')
    			->join('category', 'product.category_id', '=', 'category.id')
    			->join('users','openwish.user_id','=', 'users.id')
    			->leftJoin('openwishpledge' , 'openwishpledge.openwish_id' , '=' , 'openwish.id')
    			->leftJoin('porder' , 'porder.id' , '=' , 'openwish.porder_id')
    			->join('merchantproduct' , 'merchantproduct.product_id' , '=' , 'product.parent_id')
    			->join('merchant' , 'merchant.id' , '=' , 'merchantproduct.merchant_id')
    			->where('merchantproduct.merchant_id' , '=' , $merchant->id)
    		
                ->orderBy('openwish.created_at',
                    'DESC')
                ->groupBy('openwish.id')
    			->select(
    					
    					)
                ->select(DB::raw(
                    'SUM(openwishpledge.pledged_amt) as pledged_amt,
                    openwish.id,
                    openwish.product_id,
                    openwish.user_id,
                    openwish.created_at,
                    openwish.duration,
                    openwish.status,
                    porder.created_at AS po_created_at,
                    product.name AS product_name,
                    category.name AS category_name,
                    users.first_name,
                    users.last_name,
                    product.retail_price,
                    product.discounted_price'
                    ))
    			->get();			
    		} else {
    			$openwish = "Merchant ID Not Correct";
    		}

        }else if(!empty($value)){
            $user_id = $value;
            $openwish = \DB::table('openwish')
                ->join('product' , 'product.id', '=' , 'openwish.product_id')
                ->join('category', 'product.category_id', '=', 'category.id')
                ->join('users','openwish.user_id','=', 'users.id')
                ->leftJoin('openwishpledge' , 'openwishpledge.openwish_id' , '=' , 'openwish.id')
                ->leftJoin('porder' , 'porder.id' , '=' , 'openwish.user_id')
                ->where('openwish.user_id' , $user_id)
                ->where('openwish.status','!=','pending')
                // ->orWhere('openwish.status','!=',null)
                ->orderBy('openwish.created_at','DESC')
                ->groupBy('openwish.id')
                ->select(
					DB::raw(
						'openwish.id,
						openwish.product_id,
						openwish.user_id,
						openwish.created_at,
						openwish.duration,
						openwish.status, 
						porder.created_at AS po_created_at,
						product.id as folder_number,
						product.name AS product_name,
						product.photo_1,
						category.name AS category_name,
						users.first_name,
						users.last_name,
						product.retail_price,
						product.discounted_price,
						SUM(openwishpledge.pledged_amt) as pledged_amt'
					)
                )
                ->get();
        }
        
        return $openwish;
    }
    public function index($status=true){
    //    $openwish= $this->get_openwish();
            $openwish = \DB::table('openwish')
                ->join('product' , 'product.id', '=' , 'openwish.product_id')
                ->leftJoin('category', 'product.category_id', '=', 'category.id')
                ->leftJoin('users','openwish.user_id','=', 'users.id')
                ->leftJoin('openwishpledge' , 'openwishpledge.openwish_id' , '=' , 'openwish.id')
                ->leftJoin('porder' , 'porder.id' , '=' , 'openwish.user_id')
               // ->where('openwish.user_id' , Auth::user()->id)
                ->select(
                    'openwish.id',
                    'openwish.product_id',
                    'openwish.user_id',
                    'openwish.created_at',
                    'openwish.duration',
                    'openwish.status', //changed from status to deleted/ 2) /?Reverted the change back to status , apparently there is a column.
                    'porder.created_at AS po_created_at',
                    'product.name AS product_name',
                    'category.name AS category_name',
                    'users.first_name',
                    'users.last_name',
                    'product.discounted_price',
                    'openwishpledge.pledged_amt'
                )
                ->groupBy('openwish.id')
                ->orderBy('openwish.created_at','desc')
                ->get();

        $currency = \DB::table('currency')
                ->where('currency.active' ,'=',1)
                ->select('currency.code')
                ->get();
            foreach ($currency as $value) {
            $currency = $value;
            }
        return view("admin.master.OpenWish")
            ->with('openwish' , $openwish)
            ->with('currency' , $currency);
    }
    public function edit(Request $request ,$id){
        {
            $ow = openwish::find($id);
            $ow->id = $request->get('id');
            $ow->user_id = $request->get('user_id');
            $ow->product_id = $request->get('product_id');
            $ow->link_id = $request->get('link_id');
            $ow->duration = $request->get('duration');
            $ow->save();
            return json_encode($ow);
    }

}
 public function destroy($id)
    {
        // delete
        $owRecord = openwish::find($id);
        $owRecord->delete();
        return json_encode(array('message'=>true));
    }
    public  function show($id){
      // Need some validations
        $owp = \DB::table('openwishpledge')
                ->leftjoin('social_media','social_media.id' , '=','openwishpledge.smedia_id')
                ->where('openwish_id', $id)

                ->select(
                        'openwishpledge.smedia_account',
                        'openwishpledge.source_ip',
                        'openwishpledge.created_at',
                        'openwishpledge.pledged_amt',
                        'social_media.name'
                        )
                ->get();
        $currency = \DB::table('currency')
            ->where('currency.active' ,'=',1)
            ->select('currency.code')
            ->get();
//        foreach ($currency as $key => $value) {
//            $currency = $value;
//        }
      //  dd($owp);
        return json_encode(array('currency' => $currency , 'owp' => $owp));
    }

    public function showBuyerOWPledgeDetails($openwish_id)
    {
        $m=[
        "status"=>"failure",
        "long_message"=>"The OpenWish pledge information could not be fetched. Please contact OpenSupport",
        "short_message"=>"ExceptionEncountered"
        ];
        try {
             $owp = \DB::table('openwishpledge')
                ->leftjoin('social_media','social_media.id' , '=','openwishpledge.smedia_id')
                ->where('openwish_id', $openwish_id)
                
                ->select(
                        'openwishpledge.smedia_account',
                        'openwishpledge.message',
                        'openwishpledge.created_at',
                        'openwishpledge.pledged_amt',
                        'social_media.name'
                        )
                ->get();
            // Format it.
            $m=[
            "status"=>"success"
            ];
            $m['payload']="";
            if (sizeof($owp) == 0) {
                $m['payload']="<tr><td colspan='5' class='text-center'><b>No records found ...</b></td></tr>";
            }
            $i=1;
            foreach ($owp as $o) {
                $temp="<tr><td>".$i."</td><td>".$o->smedia_account."</td><td>".$o->message."</td><td>Points ".number_format($o->pledged_amt/100,2)."</td><td>".$o->name."</td><td>".UtilityController::s_date($o->created_at)."</td></tr>";
                $m['payload'].=$temp;
                $i++;
            }
        } catch (\Exception $e) {
            
        }

        return $m;
    }
    public function owpledge($id){
        $owp = \DB::table('openwishpledge')->where('openwish_id', $id)->get();
         return $owp;
    }
}
