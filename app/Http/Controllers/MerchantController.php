<?php

namespace App\Http\Controllers;

use App\Models\Autolink;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\MerchantCategory;
use App\Models\OpenWish;
use App\Models\OrderProduct;
use App\Models\POrder;
use App\Models\Product;
use App\Models\Station;
use App\Models\Album;
use App\Models\Signboard;
use App\Models\Bunting;
use App\Models\Theme;
use App\Models\Profile;
use App\Models\VBanner;
use App\Models\User;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class MerchantController extends Controller
{
    //---__construct Method---//
    public function __construct(){
        $this->middleware('auth',['only','getDashboard']);
    }

    /**
     * Get the o shops list
     * @return $this
     */
	 
	public function getOpenChannel($uid = null){
		if(is_null($uid)){
			$user_id = Auth::id();
		} else {
			$user_id = $uid;
		}
		$selluser = User::find($user_id);
		$merchant_id = DB::table('merchant')->where('user_id',$user_id)->first();
		$stations=  Station::join('autolink', 'autolink.initiator', '=', 'station.user_id')->
				leftJoin('address','station.address_id','=','address.id')->
				leftJoin('city','city.id','=','address.city_id')->
				leftJoin('state','city.state_code','=','state.code')->
				leftJoin('country','country.code','=','state.country_code')->
				leftJoin('sorder','sorder.station_id','=','station.id')->
				leftJoin('porder','sorder.porder_id','=','porder.id')->
				leftJoin('orderproduct','orderproduct.porder_id','=','porder.id')->
				leftJoin('area','area.id','=','address.area_id')
                ->selectRaw('station.id, station.company_name as station_name, station.user_id, address.line1, address.line2, station.address_id, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname, autolink.responder as merchantid, SUM( IF(porder.created_at >= \'1970-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= \'' . date('Y') . '-01-01\' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= \'' . date('Y-m') . '-01\' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD
                    ')
                ->where('autolink.responder', '=', $merchant_id->id)->where('autolink.status', '=', 'linked')->where('autolink.visibility', '=', 1)->groupBy('station.id')->get();

					//$openstation = DB::table('station')->where('id',$stations)->get();	
                //dd($stations);
					$currency = Currency::where('active', 1)->first();

                   return view('merchant.openchannel_all')
                ->with('stations',$stations)
                ->with('selluser',$selluser)
                ->with('currency',$currency);		
	}
	
    public function index()
    {
        $merchants = Merchant::orderBy('oshop_name', 'ASC')->get();
        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A','B','C','D');
        $letters['EH'] = array('E','F','G','H');
        $letters['IL'] = array('I','J','K','L');
        $letters['MP'] = array('M','N','O','P');
        $letters['QT'] = array('Q','R','S','T');
        $letters['UX'] = array('U','V','W','X');
        $letters['YZ'] = array('Y','Z');



        return view('shops.oshoplist')
            ->with('merchants', $merchants)
            ->with('firstLetter', $firstLetter)
            ->with('firstRun', $firstRun)
            ->with('letters', $letters);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function oShopOne(Request $request, $id)
    {
//        $merchant = Merchant::relatedProducts($id);

        //Lazy loading
        $merchant = Merchant::with('products', 'categories')->find($id);

        //dd($merchant->categories->first()->subCatLevel1->first()->description);

        //Check if this merchant exist
        if(!$merchant){
            $request->session()->flash('message', 'Merchant cant be found');
            return redirect()->back();
        }

        //Get the profile settings referring to album for a given merchant
        $profile = Merchant::withProfile($id);

        return view('detail')
            ->with('merchant', $merchant)
            ->with('profile', $profile)
            ->with('type','oshop');
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
	 
	public function sellerinfo()
    {
		if(!Auth::check()){
			return view('error');
		} else {
			return view('seller');
		}
	} 
	 
    public function aboutUs(Request $request, $id)
    {
        $merchant = Merchant::find($id);

        $profile = Merchant::withProfile($id);

        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        //dd($merchant->teams);

        return view('shops.oshopaboutus')->with('merchant', $merchant)->with('profile', $profile);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function certificate(Request $request, $id)
    {
        $merchant = Merchant::with('certificates')->find($id);

        //Check if Merchant exist
        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        return view('shops.oshopcertificate')->with('merchant', $merchant);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(){

//        Auth::loginUsingId(1);
//        return Carbon::now();
//        return ;
        try{
            $user = Auth::user();

            // $user->type may be null!!!!
            $merchant = $user->merchant;
			//dd($merchant->first()->products());
			dd($merchant);
//            $products = $merchant->first()->sections()->products()->product()->whereType('product')->get()->lists('id','id');
            $products = $merchant->first()->products()->whereType('product')->get()->lists('id','id');

//            $vouchers =$merchant->first()->sections()->products()->product()->whereType('voucher')->get()->lists('id','id');
            $vouchers = $merchant->first()->products()->whereType('voucher')->get()->lists('id','id');

            $orderproduct = OrderProduct::whereIn('product_id',$products)->groupBy('porder_id')->lists('porder_id','porder_id');

            $ordervouchers = OrderProduct::whereIn('product_id',$vouchers)->groupBy('porder_id')->lists('porder_id','porder_id');

            $orders = POrder::whereIn('id',$orderproduct)->with(['products','products.category','courier','payment','user'])->get();
            $voucher_orders = POrder::whereIn('id',$ordervouchers)->with(['products','products.category','courier','payment','user'])->get();

            $openWishes = OpenWish::whereIn('product_id',$products)->with(['user','product','pledges'])->get();


            //$all_pro   = $merchant->first()->sections()->products()->product()-with(['wholesale'])->get();
            $all_pro = $merchant->first()->products()->with(['wholesale'])->get();

            $all_p = $all_pro->lists('id','id');

            $op_all = OrderProduct::whereIn('product_id',$all_p)->groupBy('porder_id')->lists('porder_id','porder_id');

            $all = POrder::whereIn('id',$op_all)->with(['products','products.category','courier','payment','user'])->get();
    //        return $orders;
            //auto link start
            $autoLinks = null;

            $currency = Currency::where('active', 1)->first();

//            dd($autoLinks);
//

            return view('merchant.dashboard',compact('orders','voucher_orders','openWishes','autoLinks','all','all_pro','currency'));

        }catch (\Exception $e){
            return back();
        }
    }

    public static  function merchantStations($merchat_id)
    {

        // Get all autolink
      
        $raw_query="select al.id, al.initiator, st.id as 'station_id', al.sproperty_id as 'sproperty_id',d.id as 'dealer_id', st.station_name, st.company_name,al.responder,al.status as 'AL.stat',st.status as 'ST.stat' from autolink al, station st, dealer d where al.responder=".$merchat_id." and st.user_id=d.user_id and al.initiator=d.user_id and al.initiator=st.user_id order by al.created_at desc, station_id";

        DB::raw($raw_query)->get();
       
    }

    public function userCustomThems()
    {
        //get album id
        $albumId = Session::get('album_id');
        if ($albumId) {
            $profile_id = Profile::where('album_id', $albumId)->first();
            if (count($profile_id) > 0) {
                $theme = Theme::where('id', $profile_id->theme_id)->first();
                $Signboard = Signboard::where('id', $profile_id->signboard_id)->first();
                $Bunting = Bunting::where('id', $profile_id->bunting_id)->first();

                if (count($Bunting) > 0) {
                    $theme_data['BuntingId'] = $Bunting->id;
                    $theme_data['Bunting'] = $Bunting->image;
                }
                if (count($Signboard) > 0) {
                    $theme_data['SignboardId'] = $Signboard->id;
                    $theme_data['Signboard'] = $Signboard->image;
                }
                if (count($Bunting) == 0 && count($Signboard) == 0){
                    $theme_data = null;
                }
            }
            else
            {
                $theme_data = null;
                $theme = null;
            }
        }
        else
        {
            $theme_data = null;
            $theme = null;
        }

        return Response::json(array('theme'=>$theme,'theme_data'=>$theme_data));
    }


    public function postCalcSale(Request $request){
        $date1 = Carbon::parse($request['date1']);
        $date2 = Carbon::parse($request['date2']);

        $user = Auth::user();

        // $user->type may be null!!!!
        $merchant = $user->merchant;

        $products = $merchant->first()->products()->get()->lists('id','id');

        $orderproduct = OrderProduct::whereIn('product_id',$products)->groupBy('porder_id')->lists('porder_id','porder_id');

        $orderSince = POrder::whereIn('id',$orderproduct)->where('created_at','>=',$date1)->where('created_at','<=',$date2)->with(['payment'])->get();

        $paymentSince = 0;
        foreach ($orderSince as $order) {
            $paymentSince += $order->payment->receivable;
        }

        $orders = POrder::whereIn('id',$orderproduct)->whereYear('created_at','>=',$date1)->where('created_at','<=',$date2)->with(['payment'])->get();

        $payment = 0;
        foreach ($orders as $order) {
            $payment += $order->payment->receivable;
        }

        return response()->json([
            'payment' => $payment,
            'paymentSince' => $paymentSince
        ]);
    }
}
