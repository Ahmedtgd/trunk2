<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ErrorMessagesController;
use App\Http\Controllers\IdController;
use App\Models\Merchant;
use App\Models\Globals;
use App\Models\Product;
use App\Models\MerchantProduct;
use App\Models\SMMout;
use App\Models\SMMin;
use App\Models\SMMALog;
use App\Models\SMMCLog;
use App\Models\SalesStaff;
use App\Models\User;
use App\Models\Currency;
use App\Models\Address;
use App\Models\SubCatLevel1;
use Illuminate\Support\Facades\Auth;
use Input;
use App\OWish;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Socialize;
//use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use DB;


class SMMController extends Controller
{
    public function facebook(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
//        $this->app->instance('SammyK\LaravelFacebookSdk\LaravelFacebookSdk',$fb);
        $app_id = env('FACEBOOK_CLIENT_ID');
        $app_secret = env('FACEBOOK_CLIENT_SECRET');
        $app_graph = env('FACEBOOK_API_VERSION');

        $fb = new Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => $app_graph,
            'default_access_token' => '903539709730443|d46fd1d4d733eda0600f3f29b1d818eb'
        ]);
        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['publish_actions']; // optional
        //$helper->getLoginUrl($params);

        return Redirect::to($helper->getLoginUrl('http://localhost/opensupermall/public/smm/callback',$permissions));
    }

    public function callback()
    {
        $app_id = env('FACEBOOK_APP_ID');
        $app_secret = env('FACEBOOK_APP_SECRET');
        $app_graph = env('default_graph_version');

        $fb = new Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => $app_graph,
            'default_access_token' => '903539709730443|d46fd1d4d733eda0600f3f29b1d818eb'
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $token = $helper->getAccessToken();
        //echo  $token;
    }


    public function smediaMarketer(Request $request)
    {
        $button_status=True;
        $merchant=False;
        $role="";
       if(Auth::check()){

            $user_id = Auth::user()->id;
            $role=DB::table('role_users')->where('user_id',$user_id)->pluck('role_id');
            if ($role==3) {
                # Merchant is Yes now.
                $role="mer";
                $merchant=True;
                // $button_status=False;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
            }
            if ($role==1){
                // Lazy Bypass. Bad
                $button_status=False;
            }
        }
        // Check user role


        // $temp_products = Product::smm_pr(); //Get all Prdocuts with smm status ==1
        // $temp_smm=SMMout::where('user_id',$user_id)->get(); //Find a shortcut , hint : list
        // $temp_smm_pr_ids=array();
        // foreach ($temp_smm as $ts) {
        //     # code...
        //     array_push($temp_smm_pr_ids, $ts->product_id);
        // }

        // $products=Product::where('smm_selected',1)->whereNotIn('id',$temp_smm_pr_ids)->get();
            # code...
        $products= Product::smm_pr();

        // Remove those products which are in smm_our

        $total_results= count($products);
        // return $products;
        // $role=False;
        // $r=DB::table('role_users')->where('user_id',$user_id)->first()->role_id;
        // if ($r==2 or $r==10) {
        //     $role=True;
        // }
        $currency= Currency::where('active',1)->first();
        return view('SMM')->with('products', $products)
        ->with('count',$total_results)
        ->with('currency',$currency)
        ->with('button_status',$button_status)
        ->with('role',$role)
        // ->with ('admin',True)
        // ->with('role',$role)
        ;
    }

    public function saveSMM(Request $request)
    {
        // return $request->pids;
        if (!Auth::check()) {
            # code...
            return response()->json(['message'=>'Anauthorized access']);
        }
        $user_id = Auth::user()->id;
        $role=False;
        $r=DB::table('role_users')->where('user_id',$user_id)->first()->role_id;
        if ($r==2 or $r==10) {
            $role=True;
            return "Not Authorized";
        }
        $selectedProducts = $request->pids;
        $products = SMMout::where('user_id', $user_id)->whereIn('product_id', $selectedProducts)->get();
        $thisPluralOrSingular = (count($selectedProducts) > 1) ? 'these' : 'this';
        $output = [];

        if (isset($products[0])) {
            $response = array(
                'status' => 'error',
                'message' => 'You have already selected '. $thisPluralOrSingular .' product'
            );
            return $response;
        }

        $now = $now = \Carbon\Carbon::now()->toDateTimeString();
        foreach ($selectedProducts as $product) {
            $output[] = array(
                'user_id' => $user_id,
                'product_id' => $product,
                'shares' => 0,
                'created_at' => $now,
                'updated_at' => $now
            );
        }

        //Create smmout for selected products
        SMMout::insert($output);

        $response = array(
            'status' => 'success',
            'message' => 'Products have been sent'
        );

        return $response;
    }
    // For admin access only
    public function smm_all()
    {
        $smmastereport1 = \DB::select("
            select MAX(sout.id) as id,
            us.id as buyer_id,
            sst.id as sst_id,
            us.first_name as first_name,
            us.last_name as last_name,
            count(sin.id='view ') as click,
            SUM(CASE WHEN sin.response = 'view' THEN 1 ELSE 0 END) as viewed,
            count(distinct sout.product_id) as share_item,
            count(sout.id) as share_time,
            SUM(CASE WHEN sin.response = 'buy' THEN 1 ELSE 0 END) as bought, 
            SUM(CASE WHEN sin.response = 'buy' THEN pay.receivable ELSE 0 END) as money,
            sout.created_at as last_share,
            sout.connections as friends
    from 
         users us,
         smmout sout,
         smmin sin,
         product prod,
         sales_staff sst,
         porder por,
         payment pay
         
    where

        sout.product_id = prod.id and
        sin.smmout_id=sout.id  and
        sout.user_id= us.id and 
        sst.user_id=us.id  and
        pay.id=por.payment_id


        "
        /**/
        
                )
        ;

        return $smmastereport1;
        return view('admin.master.smm.load_all_smm')->with('smmastereport',$smmastereport1);
    }
    public function smm_slct($value='')
    {
       
        // HardCode
        $os= DB::table('oauth_session')->get();
        //echo "OAUTH DUMP";
        //dump($os);
         $smminfo=array();
         $i=0;
        foreach ($os as $o) {
          try{
           $temp=array();

           $user= User::find($o->user_id);
           //echo "DUMP USER-v".$i;
           //dump($user);
           //echo "DUMP SalesStaff-v".$i;
           $sst= SalesStaff::where('user_id',$user->id)->first();
           //dump($sst);
           $smm= SMMout::where('smmout.user_id',$o->user_id)->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
           ->leftJoin('porder as por','sin.porder_id','=','por.id')
           ->leftJoin('payment as pay','por.payment_id','=','pay.id')
           ->leftJoin('social_media as sme','sin.smedia_id','=','sme.id')
           ->select(
            DB::raw("
                SUM(CASE WHEN sin.response = 'view'  THEN 1 ELSE 0 END) as viewed,
                SUM(CASE WHEN sin.response = 'buy' AND por.payment_id=pay.id AND sin.porder_id=por.id and sin.smmout_id=smmout.id THEN pay.receivable ELSE 0 END) as money,
                MAX(smmout.created_at) as last_share,
                count(sin.id) as click,
                sme.name as sme,
                MAX(smmout.connections) as friends,
                SUM(CASE WHEN sin.response = 'buy'  THEN 1 ELSE 0 END) as bought,
                count(distinct smmout.product_id) as share_item


                ")
            )->get();
           //echo "DUMP SMM v".$i;
           //dump($smm);
           $geo=Address::where('address.id',$user->default_address_id)
                        ->join('city as cit','cit.id','=','address.city_id')
                        ->join('country as cou','cit.country_code','=','cou.code')
                        ->join('state as sta','cit.state_code','=','sta.code')
                        ->leftJoin('area as ar','ar.id','=','address.area_id')
                        ->select(
                            DB::raw(

                            "
            ar.description as area,
            cou.name as country,
            sta.name as state,
            cit.name as city
                            "
                            ))->get();

           $temp['user_id']=$user->id;
           $temp['first_name']=$user->first_name;
           $temp['last_name']=$user->last_name;
           if (!is_null($sst)) {
               # code...
            $temp['status']=$sst->status;
            $temp['sst_id']=$sst->id;
           }
           else{
            $temp['status']='NA';
            $temp['sst_id']='NA';

           }
           // dump($geo);

           if (empty($smm)) {
               # code...
            $temp['trans']=array(array());
           }
           else{
            $temp['trans']=$smm[0];
           }
           if (empty($geo)) {
               # code...
           $temp['geo']=array(array());

           }else{
            if (!is_null($geo)) {
                # code...
                $temp['geo']=$geo[0];
            }
            else{
                $temp['geo']=array();
            }
           
           };
           $temp['share_time']=count(SMMout::where('user_id',$user->id)->get());
           // $temp['clicked']=count($smm[0]);


           
           
           //echo "FINAL DUMP ".$i;
           array_push($smminfo,$temp);
           $i= $i+1;
           //dump($smminfo);
       }catch(\Exception $e){
        // return $e;
       }
        }
        // return $smminfo;

        return view('admin.master.smm.selective_smm')->with('smmastereport',$smminfo);
    }
    public function smmastereport(Request $request)
    {
        /*This function controls the Admin Master*/ 
        $os= DB::table('oauth_session')->get();
         $smminfo=array();
         $i=0;
		 
        foreach ($os as $o) {
          try{
           $temp=array();

           $user= User::find($o->user_id);
           //echo "DUMP USER-v".$i;
           //dump($user);
           //echo "DUMP SalesStaff-v".$i;
           $sst= SalesStaff::where('user_id',$user->id)->first();
           //dump($sst);
           $smm= SMMout::where('smmout.user_id',$o->user_id)->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
           ->leftJoin('porder as por','sin.porder_id','=','por.id')
           ->leftJoin('payment as pay','por.payment_id','=','pay.id')
           ->leftJoin('social_media as sme','sin.smedia_id','=','sme.id')
           ->select(
            DB::raw("
                SUM(CASE WHEN sin.response = 'view'  THEN 1 ELSE 0 END) as viewed,
                SUM(CASE WHEN sin.response = 'buy' AND por.payment_id=pay.id AND sin.porder_id=por.id and sin.smmout_id=smmout.id THEN pay.receivable ELSE 0 END) as money,
                MAX(smmout.created_at) as last_share,
                count(sin.id) as click,
                sme.name as sme,
              
                SUM(CASE WHEN sin.response = 'buy'  THEN 1 ELSE 0 END) as bought,
                count(distinct smmout.product_id) as share_item


                ")
            )
           ->orderBy('smmout.created_at','DESC')
           ->get();
           //echo "DUMP SMM v".$i;
        //   dump($smm);
           $geo=Address::where('address.id',$user->default_address_id)
                        ->join('city as cit','cit.id','=','address.city_id')
                        ->join('country as cou','cit.country_code','=','cou.code')
                        ->join('state as sta','cit.state_code','=','sta.code')
                        ->leftJoin('area as ar','ar.id','=','address.area_id')
                        ->select(
                            DB::raw(

                          "
            ar.description as area,
            cou.name as country,
            sta.name as state,
            cit.name as city
                            "
                            ))->get();
        //echo "DUMP GEO v".$i;
        //dump($geo);
          $oss=DB::table('oauth_session')->where('user_id',$user->id)->first();
           $temp['user_id']=$user->id;
           $temp['first_name']=$user->first_name;
           $temp['last_name']=$user->last_name;
           $temp['connections']=$oss->connections;
           $temp['friends']=$oss->connections;
           $temp['username']=$oss->username;
           if (!is_null($sst)) {
               # code...
            $temp['status']=$sst->status;
            $temp['sst_id']=$sst->id;
           }
           else{
            $temp['status']='NA';
            $temp['sst_id']='NA';


           }
           // dump($geo);

           if (empty($smm)) {
               # code...
            $temp['trans']=array(array());
           }
           else{
            $temp['trans']=$smm[0];
           }
           if (empty($geo)) {
               # code...
           $temp['geo']=array(array());

           }else{
            if (!is_null($geo)) {
                # code...
                $temp['geo']=$geo[0];
            }
            else{
                $temp['geo']=array();
            }
           
           };
           $temp['share_time']=count(SMMout::where('user_id',$user->id)->get());
           // $temp['clicked']=count($smm[0]);


           
           
           //echo "FINAL DUMP ".$i;
           array_push($smminfo,$temp);
           $i= $i+1;
           //dump($smminfo);
       }catch(\Exception $e){
        // dump($user);
        // dump($e);
       }
        }
		// dd($smminfo);
		return view('admin.master.smm.newmastersmm')
        ->with('smmastereport',$smminfo);
        return view('smmastereport')->with('smmastereport',$smminfo);
        // ->with('smmastereport',$smmastereport1)
        // ->with('errors',$errors)
    }
	
    public function smmastereportapp($id, Request $request)
    {
        $os= DB::table('oauth_session')->where('user_id', $id)->get();
         $smminfo=array();
         $i=0;
		 
        foreach ($os as $o) {
          try{
           $temp=array();

           $user= User::find($o->user_id);
           //echo "DUMP USER-v".$i;
           //dump($user);
           //echo "DUMP SalesStaff-v".$i;
           $sst= SalesStaff::where('user_id',$user->id)->first();
           //dump($sst);
           $smm= SMMout::where('smmout.user_id',$o->user_id)->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
           ->leftJoin('porder as por','sin.porder_id','=','por.id')
           ->leftJoin('nsmmid','nsmmid.smm_id','=','smmout.id')
           ->leftJoin('payment as pay','por.payment_id','=','pay.id')
           ->leftJoin('social_media as sme','sin.smedia_id','=','sme.id')
           ->select(
            DB::raw("
                SUM(CASE WHEN sin.response = 'view'  THEN 1 ELSE 0 END) as viewed,
                SUM(CASE WHEN sin.response = 'buy' AND por.payment_id=pay.id AND sin.porder_id=por.id and sin.smmout_id=smmout.id THEN pay.receivable ELSE 0 END) as money,
                MAX(smmout.created_at) as last_share,
                nsmmid.nsmm_id as smm_id,
                count(sin.id) as click,
                sme.name as sme,
                MAX(smmout.connections) as friends,
                SUM(CASE WHEN sin.response = 'buy'  THEN 1 ELSE 0 END) as bought,
                count(distinct smmout.product_id) as share_item


                ")
            )->get();
           //echo "DUMP SMM v".$i;
           //dump($smm);
           $geo=Address::where('address.id',$user->default_address_id)
                        ->join('city as cit','cit.id','=','address.city_id')
                        ->join('country as cou','cit.country_code','=','cou.code')
                        ->join('state as sta','cit.state_code','=','sta.code')
                        ->leftJoin('area as ar','ar.id','=','address.area_id')
                        ->select(
                            DB::raw(

                            "
            ar.description as area,
            cou.name as country,
            sta.name as state,
            cit.name as city
                            "
                            ))->get();
        //echo "DUMP GEO v".$i;
        //dump($geo);
           $temp['user_id']=$user->id;
           $temp['first_name']=$user->first_name;
           $temp['last_name']=$user->last_name;
           if (!is_null($sst)) {
               # code...
            $temp['status']=$sst->status;
            $temp['sst_id']=$sst->id;
           }
           else{
            $temp['status']='NA';
            $temp['sst_id']='NA';

           }
           // dump($geo);

           if (empty($smm)) {
               # code...
            $temp['trans']=array(array());
           }
           else{
            $temp['trans']=$smm[0];
           }
           if (empty($geo)) {
               # code...
           $temp['geo']=array(array());

           }else{
            if (!is_null($geo)) {
                # code...
                $temp['geo']=$geo[0];
            }
            else{
                $temp['geo']=array();
            }
           
           };
           $temp['share_time']=count(SMMout::where('user_id',$user->id)->get());
           // $temp['clicked']=count($smm[0]);


           
           
           //echo "FINAL DUMP ".$i;
           array_push($smminfo,$temp);
           $i= $i+1;
           //dump($smminfo);
       }catch(\Exception $e){
        // return $e;
       }
        }
		
        return view('smmastereportapp')->with('smmastereport',$smminfo);
        // ->with('smmastereport',$smmastereport1)
        // ->with('errors',$errors)
    }	

    public function smmasteranalysis(Request $request){
        $smmasteranalysis = \DB::select("select sout.id as id,us.id as user_id, prod.id as product_id,prod.name as product_name,
count(sout.product_id) as share, SUM(CASE WHEN sin.response = 'view' or sin.response = 'buy' THEN 1 ELSE 0 END) as click,
SUM(CASE WHEN sin.response = 'buy' THEN pay.receivable ELSE 0 END) as bought, sout.created_at, adr.area_id as area, cit.name as city, cou.name as country, sta.name as state, mer.smm_min_duration as duration,SUM(CASE WHEN sin.response = 'view' THEN pay.receivable ELSE 0 END) as view
    from 
         users us,
         smmout sout,
         smmin sin,
         
         payment pay,
         product prod,
         address adr,
         city cit,
         country cou,
         state sta,
         merchantproduct merp,
         merchant mer
    where
        sout.id = sin.smmout_id and
        sout.user_id=us.id and
        sin.response in ('view','buy') and
        sout.product_id = prod.id and
        us.default_address_id = adr.id and
        adr.city_id = cit.id and
        cit.country_code = cou.code and
        cit.state_code = sta.code and
        sout.product_id = merp.product_id and
        mer.id = merp.merchant_id
    order by sout.created_at DESC
        "


        );
        // Removed
        // por.user_id = us.id and
        /* porder por,
                    sin.porder_id = por.id and
        por.payment_id = pay.id and
        
        */

        // New Query
        // $smmout= SMMout::all();
        // foreach ($smmout as $s) {
        //     SMMin::where('smmin.smminfo_id','=',$s->id)
        //     ->leftJoin('porder as por','smmin.porder_id','=','por.id')
        //     ->leftJoin('payment as pay','por.payment_id','=','pay.id')

        // }
        $global = Globals::where('id','1')->first();
        // return $smmasteranalysis;

        return view('admin.smmasteranalysis', ['smmasteranalysis' => $smmasteranalysis,'global'=>$global]);
    }



    public function update_product_smm(Request $anArray)
    {
        # code...
        // Get Key Based Array
        if (!$anArray->has('data')) {
            # code...
            return "No Data";
        }
        try {
            $temp=array();
            foreach ($anArray->data as $key => $value) {
                $p= Product::find($key);
                $p->smm_selected=intval($value);
                $p->save();
                array_push($temp, $key);
            }
            return $temp;
        } catch (\Exception $e) {
            return $e;
            return "failed";
        }
        //


    }
    public function smm_by_cat($cat_id)
    {
        $button_status=True;
        $merchant=False;
        $role="";
       if(Auth::check()){

            $user_id = Auth::user()->id;
            $role=DB::table('role_users')->where('user_id',$user_id)->pluck('role_id');
            if ($role==3) {
                # Merchant is Yes now.
                $role="mer";
                $merchant=True;
                // $button_status=False;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
            }
            if ($role==1){
                // Lazy Bypass. Bad
                $button_status=False;
            }
        }
        $id= $cat_id;
        $level = Product::select('product.subcat_level')
        ->where('product.subcat_id','=',$id)
        ->get();
        // dd($level);
        $cat = [];
        $cat =  SubCatLevel1::select('subcat_level_1.description')->find($id);
       
        $data = Product::
        join('oshopproduct','oshopproduct.product_id','=','product.id')
        ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
        ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
        ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
        ->where('product.subcat_id','=',$id)
        ->where('product.status','active')
        ->where('product.segment','b2c')
        ->where('product.oshop_selected',true)
        ->where('product.oshop_selected',1)
        ->where('product.smm_selected',true)
        ->where('merchant.status','active')
        ->where('oshop.status','active')
        ->groupBy('product.id')
		->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.photo_2' ,
				  'product.photo_3' ,
				  'product.photo_4' ,
				  'product.photo_5' ,
				  'product.adimage_1' ,
				  'product.adimage_2' ,
				  'product.adimage_3' ,
				  'product.adimage_4' ,
				  'product.adimage_5' ,
				  'product.description' ,
				  'product.free_delivery' ,
				  'product.free_delivery_with_purchase_qty' ,
				  'product.views' ,
				  'product.display_non_autolink' ,
				  'product.del_worldwide'  ,
				  'product.del_west_malaysia'  ,
				  'product.del_sabah_labuan'  ,
				  'product.del_sarawak'  ,
				  'product.cov_country_id' ,
				  'product.cov_state_id' ,
				  'product.cov_city_id' ,
				  'product.cov_area_id' ,
				  'product.b2b_del_worldwide' ,
				  'product.b2b_del_west_malaysia' ,
				  'product.b2b_del_sabah_labuan' ,
				  'product.b2b_del_sarawak' ,
				  'product.b2b_cov_country_id' ,
				  'product.b2b_cov_state_id' ,
				  'product.b2b_cov_city_id' ,
				  'product.b2b_cov_area_id' ,
				  'product.del_pricing'  ,
				  'product.del_width'  ,
				  'product.del_lenght'  ,
				  'product.del_height'  ,
				  'product.del_weight'  ,
				  'product.weight'  ,
				  'product.height'  ,
				  'product.width'  ,
				  'product.length'  ,
				  'product.del_option' ,
				  'product.retail_price' ,
				  'product.original_price' ,
				  'product.discounted_price',
				  'product.private_retail_price' ,
				  'product.private_discounted_price' ,
				  'product.stock' ,
				  'product.available' ,
				  'product.private_available' ,
				  'product.b2b_available' ,
				  'product.hyper_available' ,
				  'product.owarehouse_moq' ,
				  'product.owarehouse_moqpb' ,
				  'product.owarehouse_moqperpax' ,
				  'product.owarehouse_price' ,
				  'product.measure'  ,
				  'product.owarehouse_units' ,
				  'product.owarehouse_ave_unit_price' ,
				  'product.type'  ,
				  'product.owarehouse_duration' ,
				  'product.smm_selected'  ,
				  'product.oshop_selected'  ,
				  'product.mc_sales_staff_id' ,
				  'product.referral_sales_staff_id' ,
				  'product.mcp1_sales_staff_id' ,
				  'product.mcp2_sales_staff_id' ,
				  'product.psh_sales_staff_id' ,
				  'product.osmall_commission'  ,
				  'product.b2b_osmall_commission'  ,
				  'product.mc_sales_staff_commission'  ,
				  'product.mc_with_ref_sales_staff_commission'  ,
				  'product.referral_sales_staff_commission'  ,
				  'product.mcp1_sales_staff_commission'  ,
				  'product.mcp2_sales_staff_commission'  ,
				  'product.smm_sales_staff_commission'  ,
				  'product.psh_sales_staff_commission'  ,
				  'product.str_sales_staff_commission'  ,
				  'product.return_policy' ,
				  'product.return_address_id' ,
				  'product.status' ,
				  'product.active_date'  ,
				  'product.deleted_at'  ,
				  'product.created_at' ,
				  'product.updated_at')
        ->get();
        $total_results= count($data);
        $currency= Currency::where('active',1)->first();
        return view('SMM')->with('products',$data)
        ->with('count',$total_results)
        ->with('currency',$currency)
        ->with('button_status',$button_status)
        ->with('role',$role);
    }

    public static function getCommission($pid)
    {

        $ret=0;
        try {
            $g= DB::table('global')->first();
          $smmComm=$g->smm_commission;
          $smmMinComm=$g->smm_min_limit;
          $opsComm=$g->osmall_commission;
          
          $price=UtilityController::realPrice($pid);
        
          // Get Osmall Commision
          $oc=($price*$opsComm)/100;
          //Get SMM Comm
          $sc=($oc*$smmComm)/100;
         
          if ($sc >= $smmMinComm) {
              $ret=$sc;

          }
          } catch (\Exception $e) {
              $ret=0;
              dump($e);
          }
        return $ret;

    }
    public function getSMM($user_id)
    {
        $currency= DB::table('currency')->where('active', 1)->first()->code;
        $raw=SMMin::leftJoin('smmout as sout','smmin.smmout_id','=','sout.id')
        ->leftJoin('porder','smmin.porder_id','=','porder.id')
        ->leftJoin('orderproduct as op','op.porder_id','=','porder.id')
        ->where('sout.user_id',$user_id)
        
        ->select(DB::raw("
            sout.*,
            count(smmin.id='view ') as click,
                SUM(CASE WHEN smmin.response = 'view' THEN 1 ELSE 0 END) as viewed,
                count(sout.product_id) as share_item,
                count(sout.id) as share_time,
                SUM(CASE WHEN smmin.response = 'buy' THEN 1 ELSE 0 END) as bought,
                SUM(op.quantity * op.order_price ) as sold,
                sout.created_at as created_at
              

            "))
        ->groupBy('sout.id')
        ->orderBy('sout.created_at','DESC')
        ->get();
        $ret=[];
        $i=1;

        // Format it
        foreach ($raw as $r) {
            $purl=url('productconsumer',$r->product_id);
            $temp="
            <tr><td>".$i."</td><td>".IdController::nSMM($r->id)."</td><td><a href='".$purl."' target='_blank'>".IdController::nP($r->product_id)."</td><td><a class='clicked' uid=".$user_id." soutid=".$r->id.">".$r->click."</a></td><td>".$r->bought."</td><td>".$currency." ".number_format($r->sold/100,2)."</td><td>".UtilityController::s_date($r->created_at)."</td></tr>";

             array_push($ret, $temp);
             $i++;

        }
        return $ret;
    }
    public function getClicked($user_id,$smmout_id)
    {
        $g= DB::table('global')->first();
        $smmComm=$g->smm_commission;
        // $smmMinComm=$g->smm_min_commission_amt;
        $opsComm=$g->osmall_commission;

        $m=["status"=>"failure","long_message"=>"Failed to retrieve SMM information"];
        try {
            $sins=SMMin::leftJoin('porder','smmin.porder_id','=','porder.id')
          ->leftJoin('orderproduct as op','op.porder_id','=','porder.id')
          ->join('smmout','smmin.smmout_id','=','smmout.id')
          ->where('smmout.user_id','=',$user_id)
          ->where('smmout.id','=',$smmout_id)
          ->select(
              DB::raw("
                  smmin.smedia_id as smedia_id,
                  smmin.source_ip as source_ip,
                  smmin.created_at as date,
                  
                  porder.user_id as user_id,
                  (op.order_price*op.quantity) as amount

                  ")
              )
          ->get();
          // return $sins;
          $ret="";
          // Format IT
          $i=1;
          $source="";
          foreach ($sins as $v) {
              switch ($v->smedia_id) {
                case 1:
                  $source="Facebook";
                  break;
                
                default:
                  $source="NA";
                  break;
              }
              $comm=($opsComm/100)*$v->amount;
              $smmcomm=($smmComm/100)*$comm;
              $t="<tr><td>".$i."</td>".
              "<td>".UtilityController::s_date($v->date)."</td>".
              "<td>".IdController::nB($v->user_id)."</td>".
              "<td>".$v->source_ip."</td>".
              "<td>".$source."</td>".
              "</td><td>".number_format($comm/100,2)."</td>".
              "<td class='text-center'>".$smmComm."%</td>".
              "<td class='text-center'>".number_format($smmcomm/100,2)."</tr>";
              $ret.=$t;
              $i++;
          }

        } catch (\Exception $e) {
          return $m['shortn_message']=$e->getMessage();
          return response()->json($m);
        }
        return $ret;
    }
    /*
      @request ajax GET`
      @addedBy Zurez
      @route smm/trans/{smmout_id}
      @param smmout id
      @return smm transaction
      @requires Login/BuyerRole
    */ 
    public function getSMMInfo($smmout_id)
    {
      $m=["status"=>"failure","long_message"=>"Failed to retrieve SMM information"];
      try {
              $smm=SMMout::join('product','smmout.product_id','=','product.id')
                ->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
                ->leftJoin('porder as pr','pr.id','=','sin.porder_id')
                ->leftJoin('orderproduct as op','op.porder_id','=','pr.id')
                ->where('smmout.id',$smmout_id)

                ->select(
                        
                        'product.name as product_name',
                        'product.id as pid' ,
                        DB::raw('
                            SUM(op.order_price) as sales,
                            SUM(op.quantity) as q,
                            COUNT(sin.id) as view_clicks,
                            COUNT(smmout.id) as shares,
                             case when product.discounted_price>0 then product.discounted_price ELSE product.retail_price end as retail_price

                            '

                    
                            )
                    )
          
                
                ->first();
              if (!is_null($smm)) {
                  $m=[
                  "status"=>"success",
                  "long_message"=>"Record Found",
                  "pid"=>IdController::nP($smm->pid),
                  "product_name"=>$smm->product_name,
                  "quantity"=>$smm->q,
                  "sales"=>number_format($smm->sales/100,2),
                  "view_clicks"=>$smm->view_clicks,
                  "shares"=>$smm->shares,
                  "price"=>number_format($smm->retail_price/100,2)
                  ];
              }


      } catch (\Exception $e) {
        
      }
      return response()->json($m);
    }


    /*For SMM ARMY POSTING*/

    public function post_smm($user_id,$product,$custom_message,$smma_id)
    {
        $ret="success";
        $OWish=new OWish;
        $sst_status=DB::table('sales_staff')->where('user_id',$user_id)->pluck('status');
        if (empty($sst_status)) {
            return "missing_sst";
        }
        if ($sst_status !="active") {
            return "user_barred";
        }
       
        if ($product->smm_selected==False or $product->oshop_selected==False or $product->available ==0 or $product->status!="active") {
            return "product_ineligible";
        }
        // return $product;
        $pid = $product->parent_id;
        $product_id=$product->id;
        $pname = $product->name;
        // $base_url ="{{url('/')}}";
        $base_url=url();
        $img_url = $base_url."/images/product/".$pid."/".
            $product->photo_1;
        // Knowing the product we figure out who the merchant is
        $mprod = MerchantProduct::where('product_id', $product_id)->first();
        if (is_null($mprod)) {
            return "product_missing";
        }
        $merchant = Merchant::find($mprod->merchant_id);
        if (is_null($merchant)) {
            # code...
            return "merchant_missing";
        }
        // return "Merchant Id: ".$mprod->merchant_id;
        // return $merchant;
        $rp = $product->discounted_price/100;
        $op = $product->retail_price/100;

        if ($op > 0 && $op > $rp && $rp>0) {
            $pricing = $rp;
            // Discount case
           
            $discount = number_format((($op-$rp)/$op)*100, 0)."%";
             
            
        } else {
             $pricing = $op;
            $discount = null;
           
        }
        // return $pricing;
        // return $discount;
        // $access_token=Auth::user()->access_token;
        // Needs to be edited if multiple social account are there
        $os= DB::table('oauth_session')->where('user_id',$user_id)->first();
        
        if (is_null($os)) {
            # code...
            return -1
                ;
        }
        $access_token=$os->access_token;
        $fb_url= "https://graph.facebook.com/me/friends?access_token=".(string)$access_token;
        try {
            $json = json_decode(file_get_contents($fb_url), true);
        } catch (\Exception $e) {
            return "";
        }
        $totalFBfriends = intval($json['summary']['total_count']);
        DB::table('oauth_session')->where('id',$os->id)
        ->update(['connections'=>$totalFBfriends]);
        // return $totalFBfriends;
        $smmOut = SMMout::create(array(
            'user_id' => $user_id,
            'product_id' => $product_id,

        ));
        /*Add code for nsmmid*/ 
        UtilityController::smm_unique_id($smmOut->id); 
        $us= new UrlShortenerController;
        $shortened_url= $us->shorten($base_url."/cart/smmin/".$product_id. '/' .$smmOut->id,'smm',$smmOut->id);
        // return $shortened_url;
        // return $base_url.'/u/'.$shortened_url;
        //$description=strip_tags(substr($product->product_details,0,9000));
        $currency= Currency::where('active',1)->first()->code;
        // return "The description length is ".strlen($description);
        // return $discount;
        $icon=url()."/images/logo-white.png";
        $linkData = [
            'link' => $base_url.'/u/'.$shortened_url,
            'from' => "OPENSUPERMALL",
            'message' =>$custom_message,
            'icon' => $icon,
            'picture' => $img_url,
            'caption' => $merchant->oshop_name."@OpenSupermall",
            'name' => "** OpenSupermall ** | ".ucwords($pname),
      'description' => "Price:".$currency." ".$pricing.
        " | Discount:".$discount
        ];
        
        //Post selected product to facebook user's profile, from "app/OWish.php"
        

        
        $graphNode = $OWish->facebook($linkData,$user_id);
        try {
          SMMout::where('id', $smmOut->id)->update(array('connections'=>$totalFBfriends,'object_id' => $graphNode['graphNode']['id']));
        } catch (\Exception $e) {
          $message=$graphNode['message'];
          $ret="";
          switch ($message) {
            case 'Your token has expired':
              $ret="Facebook account expired.";
              break;
            
            default:
              # code...
              break;
          }
          // return $ret;
        }
        
        
        $smmc=new SMMCLog;
        $smmc->smma_log_id=$smma_id;
        $smmc->smma_channel_id=1;
        $smmc->smmout_id=$smmOut->id;
        $smmc->status="success";
        $smmc->channel_type="fb";
        if ($ret!="success") {
          $smmc->error_desc=$message;
          $smmc->status="failed";
        }
        $smmc->save();
        return $ret;

    }
  public function execute_army($r)
     {
        $message=$r->custom_message;
        $product_id=$r->product_id;
        $ret=array();
        $ret['status']="failure";
        $ret['mode']='army';
        $ret['count_success']=0;
        $ret['count_failed']=0;
        $errors=array();
        try {
          $pid=$r->product_id;
          /*Validation for product*/
          $product=Product::find($product_id);
          if (empty($product)) {
             return "Invalid Product";
          } 
          $comm=SMMController::getCommission($product->id);
     
          if ($comm==0) {
              return "ineligible_smm_commission";
          }

          $merchant_user_id=Auth::user()->id;
          $merchant_id=DB::table('merchant')->where('user_id',$merchant_user_id)->pluck('id');
          $company_id=DB::table('companyusers')->where('user_id',$merchant_user_id)->pluck('company_id');
          $role_id=DB::table('roles')->where('slug','sma')->pluck('id');
 
          /*Get All Staff for The Company with Role SMMArmy*/ 
        

          $army=DB::table('member')->
          leftJoin('users','users.id','=','member.user_id')->
          join('role_users','users.id','=','role_users.user_id')->
          join('company','member.company_id','=','company.id')->
          join('buyer','buyer.user_id','=','users.id')->
          where('company.owner_user_id',$merchant_user_id)->
          where('role_users.role_id',$role_id)->
          where('member.type','member')->
          where('buyer.status','active')->
          select(DB::raw("
            users.id,
            users.name,
            users.first_name as users_first_name,
            users.last_name as users_last_name
          "))->get();
        if (empty($army)) {
          return response()->json(["status"=>"failure","long_message"=>"You do not have any member in SMM Army"]);
        }
        /*Create a log*/
        $smma=new SMMALog;
        $smma->merchant_id=$merchant_id;
        $smma->product_id=$product_id;
        $smma->save();

          foreach ($army as $a) {
              $result=$this->post_smm($a->id,$product,$message,$smma->id);
              
                
                if ($result!="success") {

                  $errors[$a->name]=$result;
                  $ret['count_failed']+=1;
                }else{
                  $ret['count_success']+=1;
                }
              }
          $ret['total']=$ret['count_success']+$ret['count_failed'];
          $ret['status']="success";
          $ret['errors']=$errors;
        } catch (\Exception $e) {
          
          $ret['short_message']=$e->getMessage()."|".$e->getLine();
        }
        return response()->json($ret);

     } 
}
