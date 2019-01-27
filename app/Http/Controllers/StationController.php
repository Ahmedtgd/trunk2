<?php

namespace App\Http\Controllers;
use App\Classes\SecurityIDGenerator;
use App\Http\Requests;
use App\Models\Address;
use App\Models\Autolink;
use App\Models\Bunting;
use App\Models\Category;
use App\Models\Currency;
use App\Models\DeliveryOrder;
use App\Models\NdoID;
use App\Models\Receipt;
use App\Models\Station;
use App\Models\StationCategory;
use App\Models\OpenWish;
use App\Models\OrderProduct;
use App\Models\POrder;
use App\Models\Profile;
use App\Models\Signboard;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\Theme;
use App\Models\Wholesale;
use App\Models\Brand;
use App\Models\User;
use App\Models\SOrder;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Http\Controllers\EmailController;
use Cart;
use Log;
use App\Models\Product;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Merchant;
use App\Models\SalesStaff;
use App\Models\Globals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use DateTime;

//TODO
class StationController extends Controller {

    //---__construct Method---//
    public function __construct() {
        //TODO
        //  $this->middleware('auth', ['only', 'getDashboard']);
        $this->countryModel = new Country();
        $this->paymentModel = new Payment();
        $this->merchantModel = new Merchant();
        $this->salesStaffModel = new SalesStaff();
    }

    /**
     * Get the o shops list
     * @return $this
     */
    public function purchases($uid = null)
    {
        if (!Auth::check() or (!Auth::user()->hasRole('sto') and !Auth::user()->hasRole('adm'))) {
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','You do not have permission to access the page.');
        }
        if(!is_null($uid) and Auth::user()->hasRole('adm')){
            $user_id=$uid;
        } else {
            $user_id=Auth::user()->id;
        }
        $selluser = User::find($user_id);
        $porders = DB::table('porder')->where('user_id', $user_id)->where('mode','cash')->orderBy('created_at','DESC')->get();
        //	dd($user_id);
        $b= new BuyerController;
        $product_orders= $b->products($porders,true);
        // dd($product_orders);
        $orders= array();
        foreach ($product_orders as $po) {
            # code...
            $ex=DB::table('porder')->where('id',$po['oid'])->first();
            $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
            //   $po['total']=$total;
            $po['status']=$ex->status;
            $po['o_receipt']=$ex->created_at;
            $po['segment']=UtilityController::getPorderSegment($ex->id);
            $date = $ex->created_at;
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($date)));
            $diff = $date1->diff($date2);
            $hours = $diff->h;
            $days = $diff->days;
            $totaldiff = ($diff->days * 24) + $diff->h + ($diff->i / 60) + ($diff->s / 3600);
            $totaldiff=UtilityController::cancelTime($date);
            $po['hours']=$hours;
            $po['days']=$days;
            $po['totaldiff']=$totaldiff;
            $po['delivery_timestamp']=DB::table('delivery')->where('porder_id',$ex->id)->where('type','m2b')->orderBy('updated_at','DESC')->pluck('delivered_date');
            array_push($orders, $po);
        }
        // dd($orders);
        return view('station.dashboard.buyer-order',compact('orders','selluser'));

    }
    public function salesreport($uid = null)
    {

        if (!Auth::check()) {
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','You need to login to access the page.');
        }

        if($uid == null){
            $user_id = Auth::user()->id;
        } else {
            $user_id = $uid;
        }
        $selluser = User::find($user_id);
        $station_id= DB::table('station')->where('user_id',$user_id)->pluck('id');
        $since = DB::table('station')->where('user_id',$user_id)->orderBY('created_at','ASC')->pluck('created_at');
        if(is_null($since)){
            $since = date("d-M-Y",strtotime('-2 year',  date("Y-m-d")));
        } else {
            $since = date("d-M-Y", strtotime($since));
        }
        $data['countries'] = $this->countryModel->where('code','MYS')->lists('name','id')->all();
        $data['merchants'] = $this->merchantModel->getAllMerchants();
        $data['brands'] = Brand::join('product','product.brand_id','=','brand.id')
            ->join('sproduct','sproduct.product_id','=','product.id')
            ->join('stationsproduct','stationsproduct.sproduct_id','=','sproduct.id')
            ->where('stationsproduct.station_id',$station_id)
            ->lists('brand.name','brand.id')->all();
        $data['categories'] = Category::join('product','product.category_id','=','category.id')
            ->join('sproduct','sproduct.product_id','=','product.id')
            ->join('stationsproduct','stationsproduct.sproduct_id','=','sproduct.id')
            ->where('stationsproduct.station_id',$station_id)
            ->lists('category.description','category.id')->all();
        return view('station.salesreport')
            ->with('station_id',$station_id)
            ->with('selluser',$selluser)
            ->with('since',$since)
            ->with('data',$data);
    }

    public function index() {
        $merchants = Merchant::orderBy('oshop_name', 'ASC')->get();
        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A', 'B', 'C', 'D');
        $letters['EH'] = array('E', 'F', 'G', 'H');
        $letters['IL'] = array('I', 'J', 'K', 'L');
        $letters['MP'] = array('M', 'N', 'O', 'P');
        $letters['QT'] = array('Q', 'R', 'S', 'T');
        $letters['UX'] = array('U', 'V', 'W', 'X');
        $letters['YZ'] = array('Y', 'Z');


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
    public function postAddInvoicePo(Request $request) {

        $poid= $request['poid'];
        $merchantid = $request['merchantid'];
        $merchant = DB::table('merchant')->where('id',$merchantid)->first();
        $invoice_no = 0;
        $facility = DB::table('facility')->where('name','term')->first();
        if(!is_null($facility)){
            $tokens = DB::table('userstoken')->where('user_id',$merchant->user_id)->first();
            if(is_null($tokens)){
                $user = DB::table('users')->where('id',$merchant->user_id)->first();
                $e= new EmailController;
                $e->termtokenError($user->email, $merchant->user_id);
            } else {
                $tokes_needed = $facility->token_admin_fee;
                $tokens_available = $tokens->qty;
                if($tokens_available < $tokes_needed){
                    //
                    $user = DB::table('users')->
                    where('id',$merchant->user_id)->first();
                    $e= new EmailController;
                    $e->termtokenError($user->email, $merchant->user_id);
                    return "Token available is less than token needed.";
                } else {
                    $ntokens = $tokens_available - $tokes_needed;
                    DB::table('userstoken')->
                    where('id',$tokens->id)->update(['qty'=>$ntokens]);

                }
            }
        }

        $merchant_email = "";
        if(!is_null($merchant)){
            $invoice_no = $merchant->invoice_no;
            if(!is_null($invoice_no)){
                $invoice_no++;
            } else {
                $invoice_no = 1;
            }
            //	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
            DB::table('merchant')->where('id',$merchantid)->update(['invoice_no'=>$invoice_no]);
            $merchant_user = DB::table('users')->where('id',$merchant->user_id)->first();
            $merchant_email = $merchant_user->email;
        }
        $a = new SecurityIDGenerator;
        $do_password = $a->generate(date('Y-m-d'));
        $isinvoice = DB::table('invoice')->where('porder_id',$poid)->first();

		$ret = null;
        if(is_null($isinvoice)){
            $porder = DB::table('porder')->where('id',$poid)->first();

            $station = DB::table('station')->where('user_id',$porder->user_id)->first();

            $stationterm = DB::table('stationterm')->where('creditor_user_id',$merchant->user_id)
                ->where('station_id',$station->id)->first();

            $invoice = DB::table('invoice')->insertGetId(['porder_id'=>$poid,
                'duration'=>$stationterm->term_duration,
                'invoice_no'=>$invoice_no,
                'do_password'=>$do_password,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]);

            DB::table('invoicetokenlog')->insert(['user_id'=>$merchant->user_id,
                'quantity'=>$tokes_needed,
                'invoice_id'=>$invoice,
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')]);

            UtilityController::createQr($invoice,'invoice',IdController::nO($poid));

            $deliveryinvoice = DB::table('deliveryinvoice')->insertGetId(['invoice_id'=>$invoice,
                'status'=>"pending",
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')]);

            UtilityController::createQr($deliveryinvoice,'deliveryinvoice',IdController::nO($poid));

            $prodarray = DB::table('ordertproduct')->where('porder_id',$poid)->get();


            foreach($prodarray as $prod){

                $tproduct = DB::table('tproduct')->where('id', $prod->tproduct_id)->first();

                if(is_null($tproduct->product_id) || $tproduct->product_id == 0){

                    $nwh = $tproduct->available - $prod->quantity;

                    DB::table('tproduct')->where('id',$tproduct->id)->update(['available'=>$nwh]);

                } else {
                    $product = DB::table('product')->where('id',$tproduct->product_id)->first();

                    if(!is_null($product)){

                        $nwh = $product->warehouse_available - $prod->quantity;

                        if($nwh < 0){

                            $nwh = 0;

                        }
                        DB::table('product')->where('id',$product->id)->update(['warehouse_available'=>$nwh]);

                    } else {
                        $nwh = $tproduct->available - $prod->quantity;
                        DB::table('tproduct')->where('id',$tproduct->id)->update(['available'=>$nwh]);
                    }
                }
                $deliveryinvoice2 = DB::table('deliveryinvoicetproduct')->insertGetId(['di_id'=>$deliveryinvoice, 'tproduct_id'=>$prod->tproduct_id, 'status'=>"pending"
                    , 'quantity' => $prod->quantity, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
            }




            $receipt = Receipt::create([
                'porder_id'=> $poid,
                'receipt_no'=> Receipt::max('receipt_no') +1
            ]);

            $new_do =   DeliveryOrder::create([
                'receipt_id'=> $receipt->id,
                'status'=>'pending',
                'source'=>'jaguar',
                'merchant_id' => Merchant::where('user_id','=',Auth::user()->id)->pluck('id')

            ]);

            NdoID::create([
                'ndeliveryorder_id'=>  UtilityController::generaluniqueid( $new_do->id, '3', '1',  $new_do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id'),
                'deliveryorder_id'=> $new_do->id
            ]);


            $e= new EmailController;
            $e->sendInv(Auth::user()->email,$poid);
            $e->sendDI($merchant_email,$poid);

			$ret = "OK";
		
        } else {
			$ret = "ERR";
        }
		Log::debug('***** postAddInvoicePo(): '.$ret);
        return $ret;
    }

    public function postDeleteInvoicePo(Request $request) {
        $poid= $request['poid'];
        DB::table('ordertproduct')->where('porder_id',$poid)->delete();
        DB::table('porder')->where('id',$poid)->delete();
        return "OK";
    }

    public function postAddInvoice(Request $request) {
        $merarray = $request['json'];
        $user_id=Auth::user()->id;
        $isexceed = false;
        $iserror = false;
        foreach($merarray as $merchantid => $prodarray){
            $invoice_no = 0;
            $merchant = DB::table('merchant')->where('id',$merchantid)->first();
            /*if(!is_null($merchant)){
                $invoice_no = $merchant->invoice_no;
                if(!is_null($invoice_no)){
                    $invoice_no++;
                } else {
                    $invoice_no = 1;
                }
            //	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
                DB::table('merchant')->where('id',$merchantid)->update(['invoice_no'=>$invoice_no]);
            }*/
            $purorders = DB::table('porder')->where('mode','term')->leftJoin('invoice','invoice.porder_id','=','porder.id')
                ->join('ordertproduct','ordertproduct.porder_id','=','porder.id')
                ->join('merchanttproduct','ordertproduct.tproduct_id','=','merchanttproduct.tproduct_id')
                ->where('merchanttproduct.merchant_id',$merchantid)
                ->where('user_id',$user_id)->whereNull('invoice.id')->select('porder.*')->first();
            if(is_null($purorders)){
                $invoice = DB::table('porder')->insertGetId(['user_id'=>$user_id, 'address_id'=>0, 'payment_id'=>0, 'status'=>"pending"
                    , 'created_at'=>date('Y-m-d H:i:s'), 'source'=> 'b2b', 'mode'=>'term', 'delivery_mode'=>'own', 'updated_at'=>date('Y-m-d H:i:s')]);
                $newinvid = UtilityController::generaluniqueid($invoice,'1','3', date('Y-m-d H:i:s'), 'nporderid', 'nporder_id');
                DB::table('nporderid')->insert(['nporder_id'=>$newinvid, 'porder_id'=>$invoice, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            } else {
                $invoice = $purorders->id;
            }
            $total_new = 0;
            $total_owned = 0;
            $mer_exceed = false;
            foreach($prodarray as $prodtid => $value){
                $total_new += $value['price'];
            }
            $station = DB::table('station')->where('user_id',$user_id)->first();
            if(!is_null($station)){
                $stationterm = DB::table('stationterm')->where('creditor_user_id',$merchant->user_id)->where('station_id',$station->id)->first();
                $current_pos = DB::table('porder')->where('mode','term')->join('invoice','invoice.porder_id','=','porder.id')
                    ->join('ordertproduct','ordertproduct.porder_id','=','porder.id')
                    ->join('merchanttproduct','ordertproduct.tproduct_id','=','merchanttproduct.tproduct_id')
                    ->where('invoice.status','!=','paid')
                    ->where('merchanttproduct.merchant_id',$merchant->id)
                    ->where('user_id',Auth::user()->id)->select('porder.*','invoice.id as invoice_id')->distinct()->get();
                //dd($current_pos);
                foreach($current_pos as $current_po){
                    $tproducts_pos = DB::table('ordertproduct')->join('tproduct','tproduct.id','=','ordertproduct.tproduct_id')
                        ->where('porder_id',$current_po->id)->get();
                    foreach($tproducts_pos as $tproducts_po){
                        $total_owned += ($tproducts_po->order_price/100)*$tproducts_po->quantity;
                    }
                    $payments_pos = DB::table('invoicepayment')->where('invoice_id',$current_po->invoice_id)->get();
                    foreach($payments_pos as $payments_po){
                        $total_owned -= $payments_po->amount/100;
                    }
                }
                $balance = ($stationterm->credit_limit/100) - $total_owned;
                /*dump($stationterm->credit_limit/100);
                dump($balance - ($total_new/100));
                dump($total_owned);
                dd($balance);*/
                if(($balance - ($total_new/100)) < 0){
                    $isexceed = true;
                } else {
                    foreach($prodarray as $prodtid => $value){
                        $ordertp = DB::table('ordertproduct')->where('porder_id',$invoice)->where('tproduct_id',$value['id'])->first();
                        if(is_null($ordertp)){
                            $invoice2 = DB::table('ordertproduct')->insertGetId(['porder_id'=>$invoice, 'tproduct_id'=>$value['id'], 'order_price' => $value['price']/$value['qty']
                                ,'status'=>"pending", 'order_delivery_price' => 0, 'quantity' => $value['qty'],'shipping_cost' => 0
                                , 'created_at'=>date('Y-m-d H:i:s'), 'source'=> 'b2b', 'updated_at'=>date('Y-m-d H:i:s')]);
                        } else {
                            $orderqty = $ordertp->quantity + $value['qty'];
                            DB::table('ordertproduct')->where('id',$ordertp->id)->update(['quantity'=>$orderqty]);
                        }
                    }
                }
            } else {
                $iserror = true;
            }
        }
        if($iserror){
            return Response::json(['response'=>'ERROR']);
        } else {
            if($isexceed){
                return Response::json(['response'=>'WARN']);
            } else {
                $purorders = DB::table('porder')->join('ordertproduct','ordertproduct.porder_id','=','porder.id')
                    ->join('merchanttproduct','ordertproduct.tproduct_id','=','merchanttproduct.tproduct_id')->where('mode','term')->leftJoin('invoice','invoice.porder_id','=','porder.id')->select('porder.*')->distinct()
                    ->where('user_id',Auth::user()->id)->whereNull('invoice.id')->get();
                return Response::json(['response'=>'OK','purorders'=>count($purorders)]);
            }
        }


    }

    public function oShopOne(Request $request, $id) {
//        $merchant = Merchant::relatedProducts($id);
        //Lazy loading
        $merchant = Merchant::with('products', 'categories')->find($id);

        //dd($merchant->categories->first()->subCatLevel1->first()->description);
        //Check if this merchant exist
        if (!$merchant) {
            $request->session()->flash('message', 'Merchant cant be found');
            return redirect()->back();
        }

        //Get the profile settings referring to album for a given merchant
        $profile = Merchant::withProfile($id);

        return view('detail')
            ->with('merchant', $merchant)
            ->with('profile', $profile)
            ->with('type', 'oshop');
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function aboutUs(Request $request, $id) {
        $merchant = Merchant::find($id);

        $profile = Merchant::withProfile($id);

        if (!$merchant) {
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        //dd($merchant->teams);

        return view('shops.oshopaboutus')->with('merchant', $merchant)->with('profile', $profile);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function show() {

        return view('station.station-administration');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getStationData() {
        $stationsData = Station::all();
        // return view('shops.oshopcertificate')->with('merchant', $merchant);
    }

    /**
     * AJAX Requests
     */
    public function getAreasByCountry() {
        $country = Input::get('country');
        $areas = DB::table('city')->where('country_code', $country)->orderBy('created_at','DESC')->get();
        return Response::json($areas);
    }

    /**
     * AJAX Requests
     */
    public function getMapData() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->select(DB::raw("address.longitude, address.latitude, address.line1, address.line2, address.line3, address.line4, 
				'0' as type, city.name as cityname, station.station_name as station_name" ));
        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
        }
        return Response::json($preparedStatement);
    }


    /**
     * AJAX Requests
     */
    public function getMapDataMerchant() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->orderBy('address.created_at','DESC')
            ->select(DB::raw("address.longitude, address.latitude, address.line1, address.line2, address.line3, address.line4, 
				'1' as type, city.name as cityname, merchant.company_name as station_name" ));
        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
        }
        return Response::json($preparedStatement);
    }

    public function getMapDataBoth() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->orderBy('address.created_at','DESC')
            ->select(DB::raw("address.longitude, address.latitude, address.line1, address.line2, address.line3, address.line4, 
				'1' as type, city.name as cityname, merchant.company_name as station_name" ));
        /*     ->select([
'address.longitude',
'address.latitude',
'address.line1',
'address.line2',
'address.line3',
'address.line4',
'1 as type',
'city.name as cityname',
'merchant.company_name as station_name'
])*/
        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
        }

        $preparedStatements = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->orderBy('address.created_at','DESC')
            ->select(DB::raw("address.longitude, address.latitude, address.line1, address.line2, address.line3, address.line4, 
				'0' as type, city.name as cityname, station.station_name as station_name" ));
        if ($searchBy == 'country') {
            $preparedStatements = $preparedStatements->where('country.code', '=', $searchKey)->get();
        }
        if ($searchBy == 'city') {
            $preparedStatements = $preparedStatements->where('city.id', '=', $searchKey)->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            $preparedStatements = $preparedStatements->where('address.latitude', '=', $cordinates[0]);
            $preparedStatements = $preparedStatements->where('address.longitude', '=', $cordinates[1])->get();
        }

        if ($searchBy == 'state') {
            $preparedStatements = $preparedStatements->where('city.state_code', '=', $searchKey)->get();
        }

        if ($searchBy == 'all') {
            $preparedStatements = $preparedStatements->get();
        }

        $defarray = array_merge($preparedStatement->toArray(), $preparedStatements->toArray());

        return Response::json($defarray);
    }
    /**
     * AJAX Requests
     */
    public function getStationsDataForTable() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->orderBy('address.created_at','DESC')
            ->select([
                'station.station_name',
                'station.id',
                'address.longitude',
                'address.latitude',
                'station.created_at',
                'country.name',
                'city.name AS cityName',
                'address.area_id'
            ]);

        $YTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('station.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-01-01")');

        $MTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('station.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-",month(curdate()),"-1")');

        $SalesSinceAmountStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw(
                'station.id,
                SUM(payment.receivable) AS total
                    '
            );

        $inventoryItemStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('product', 'product.cov_city_id', '=', 'city.id')
            ->join('sproduct', 'product.id', '=', 'sproduct.product_id')
            ->selectRaw(
                'station.id,
                SUM(sproduct.available) AS total
                    '
            );

        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            //dd($cordinates);
            //exit;
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
            $YTDStatement = $YTDStatement->where('address.latitude', '=', $cordinates[0]);
            $YTDStatement = $YTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('address.latitude', '=', $cordinates[0]);
            $MTDStatement = $MTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.latitude', '=', $cordinates[0]);
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('address.latitude', '=', $cordinates[0]);
            $inventoryItemStatement = $inventoryItemStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
            $YTDStatement = $YTDStatement->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->groupBy('station.id')->get();
        }

        $json = array();
        $index = 1;
        $ytd = array();
        $mtd = array();
        $sales = array();
        $item = array();
        foreach ($YTDStatement AS $row) {
            $ytd[$row['id']] = $row['total'];
        }
        foreach ($MTDStatement AS $row) {
            $mtd[$row['id']] = $row['total'];
        }
        foreach ($SalesSinceAmountStatement AS $row) {
            $sales[$row['id']] = $row['total'];
        }
        foreach ($inventoryItemStatement AS $row) {
            $item[$row['id']] = $row['total'];
        }
        foreach ($preparedStatement as $row) {

//            $date1 = new DateTime($row['created_at']);
//            $date2 = new DateTime(date("Y-m-d"));
//            $interval = date_diff($date1, $date2);
//            $num_months = $interval->m + ($interval->y * 12);
            /**
             * MAKE ARRAY NON ASSOCIATIVE
             * Arranging the data order
             * */
            if (isset($ytd[$row['id']])) {
                $ytdAmount = $ytd[$row['id']];
            } else {
                $ytdAmount = 0;
            }

            if (isset($mtd[$row['id']])) {
                $mtdAmount = $mtd[$row['id']];
            } else {
                $mtdAmount = 0;
            }
            if (isset($sales[$row['id']])) {
                $salesAmount = $sales[$row['id']];
            } else {
                $salesAmount = 0;
            }
            if (isset($item[$row['id']])) {
                $itemCount = $item[$row['id']];
            } else {
                $itemCount = 0;
            }
            $date1 = new DateTime($row['created_at']);
            $date2 = new DateTime(date("d-m-Y"));
            $interval = date_diff($date1, $date2);
            $num_months = $interval->m + ($interval->y * 12);
            if ($num_months != 0) {
                $monthlyAverage = $salesAmount / $num_months;
            } else {
                $monthlyAverage = '';
            }
            $date = strtotime($row['created_at']);
            $myFormatForView = date("m/d/y", $date);

            $json[] = array(
                $index++,
                $row['station_name'],
                "<a href='http://" . $_SERVER['SERVER_NAME'] ."/admin/popup/station/".$row['id']."' target='_blank'>[" . str_pad($row['id'],10,'0',STR_PAD_LEFT) . "]</a>",
                $myFormatForView,
                $ytdAmount,
                $mtdAmount,
                $monthlyAverage,
                $itemCount,
                null,
                null,
                0,
                "item " . $index,
                0,
                0,
                "Distributor",
                "Ac",
                "Pas",
                $row['name'],
                $row['state_name'],
                $row['cityName'],
                $row['area'],
                '',
                ''
            );
        }
        /*         * * MAKE RESPONSE HAVE 'data' ENTRY *** */
        $response = array();
        $response['data'] = $json;


        return Response::json($response);
    }

    public function getMerchantsDataForTable() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->select([
                'merchant.company_name',
                'merchant.id',
                'address.longitude',
                'address.latitude',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
                'city.name as cityname',
                'merchant.created_at',
                'country.name',
                'state.name AS state_name',
                'city.name AS cityName',
                'address.area_id'
            ]);

        $YTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('merchant.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-01-01")');

        $MTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('merchant.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-",month(curdate()),"-1")');

        $SalesSinceAmountStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw(
                'merchant.id,
                SUM(payment.receivable) AS total
                    '
            );

        $inventoryItemStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('product', 'product.cov_city_id', '=', 'city.id')
            ->join('merchantproduct', 'product.id', '=', 'merchantproduct.product_id')
            ->selectRaw(
                'merchant.id,
                COUNT(product.available) AS total
                    '
            );

        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            //dd($cordinates);
            //exit;
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
            $YTDStatement = $YTDStatement->where('address.latitude', '=', $cordinates[0]);
            $YTDStatement = $YTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('address.latitude', '=', $cordinates[0]);
            $MTDStatement = $MTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.latitude', '=', $cordinates[0]);
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('address.latitude', '=', $cordinates[0]);
            $inventoryItemStatement = $inventoryItemStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
            $YTDStatement = $YTDStatement->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->groupBy('merchant.id')->get();
        }

        $json = array();
        $index = 1;
        $ytd = array();
        $mtd = array();
        $sales = array();
        $item = array();
        foreach ($YTDStatement AS $row) {
            $ytd[$row['id']] = $row['total'];
        }
        foreach ($MTDStatement AS $row) {
            $mtd[$row['id']] = $row['total'];
        }
        foreach ($SalesSinceAmountStatement AS $row) {
            $sales[$row['id']] = $row['total'];
        }
        foreach ($inventoryItemStatement AS $row) {
            $item[$row['id']] = $row['total'];
        }
        foreach ($preparedStatement as $row) {

//            $date1 = new DateTime($row['created_at']);
//            $date2 = new DateTime(date("Y-m-d"));
//            $interval = date_diff($date1, $date2);
//            $num_months = $interval->m + ($interval->y * 12);
            /**
             * MAKE ARRAY NON ASSOCIATIVE
             * Arranging the data order
             * */
            if (isset($ytd[$row['id']])) {
                $ytdAmount = $ytd[$row['id']];
            } else {
                $ytdAmount = 0;
            }

            if (isset($mtd[$row['id']])) {
                $mtdAmount = $mtd[$row['id']];
            } else {
                $mtdAmount = 0;
            }
            if (isset($sales[$row['id']])) {
                $salesAmount = $sales[$row['id']];
            } else {
                $salesAmount = 0;
            }
            if (isset($item[$row['id']])) {
                $itemCount = $item[$row['id']];
            } else {
                $itemCount = 0;
            }
            $date1 = new DateTime($row['created_at']);
            $date2 = new DateTime(date("d-m-Y"));
            $interval = date_diff($date1, $date2);
            $num_months = $interval->m + ($interval->y * 12);
            if ($num_months != 0) {
                $monthlyAverage = $salesAmount / $num_months;
            } else {
                $monthlyAverage = '';
            }
            $date = strtotime($row['created_at']);
            $myFormatForView = date("m/d/y", $date);
            $json[] = array(
                $index++,
                $row['company_name'],
                "<a href='http://" . $_SERVER['SERVER_NAME'] ."/admin/popup/merchant/".$row['id']."' target='_blank'>[" . str_pad($row['id'],10,'0',STR_PAD_LEFT) . "]</a>",
                $myFormatForView,
                $ytdAmount,
                $mtdAmount,
                $monthlyAverage,
                $itemCount,
                null,
                null,
                0,
                "item " . $index,
                0,
                0,
                "Distributor",
                "Ac",
                "Pas",
                $row['name'],
                $row['state_name'],
                $row['cityName'],
                $row['area'],
                '',
                ''
            );
        }
        /*** MAKE RESPONSE HAVE 'data' ENTRY ***/
        $response = array();
        $response['data'] = $json;


        return Response::json($response);
    }

    public function getBothDataForTable() {
        $searchBy = Input::get('searchBy');
        $searchKey = Input::get('searchKey');
        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->select([
                'merchant.company_name',
                'merchant.id',
                'address.longitude',
                'address.latitude',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
                'city.name as cityname',
                'merchant.created_at',
                'country.name',
                'state.name AS state_name',
                'city.name AS cityName',
                'address.area_id'
            ]);

        $YTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('merchant.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-01-01")');

        $MTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('merchant.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-",month(curdate()),"-1")');

        $SalesSinceAmountStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw(
                'merchant.id,
                SUM(payment.receivable) AS total
                    '
            );

        $inventoryItemStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('merchant', 'merchant.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('product', 'product.cov_city_id', '=', 'city.id')
            ->join('sproduct', 'product.id', '=', 'sproduct.product_id')
            ->join('stationsproduct', 'sproduct.id', '=', 'stationsproduct.sproduct_id')
            ->selectRaw(
                'merchant.id,
                COUNT(*) AS total
                    '
            );

        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('country.code', '=', $searchKey)->groupBy('merchant.id')->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.id', '=', $searchKey)->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            //dd($cordinates);
            //exit;
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
            $YTDStatement = $YTDStatement->where('address.latitude', '=', $cordinates[0]);
            $YTDStatement = $YTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('address.latitude', '=', $cordinates[0]);
            $MTDStatement = $MTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.latitude', '=', $cordinates[0]);
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('address.latitude', '=', $cordinates[0]);
            $inventoryItemStatement = $inventoryItemStatement->where('address.longitude', '=', $cordinates[1])->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.state_code', '=', $searchKey)->groupBy('merchant.id')->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
            $YTDStatement = $YTDStatement->groupBy('merchant.id')->get();
            $MTDStatement = $MTDStatement->groupBy('merchant.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->groupBy('merchant.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->groupBy('merchant.id')->get();
        }

        $json = array();
        $index = 1;
        $ytd = array();
        $mtd = array();
        $sales = array();
        $item = array();
        foreach ($YTDStatement AS $row) {
            $ytd[$row['id']] = $row['total'];
        }
        foreach ($MTDStatement AS $row) {
            $mtd[$row['id']] = $row['total'];
        }
        foreach ($SalesSinceAmountStatement AS $row) {
            $sales[$row['id']] = $row['total'];
        }
        foreach ($inventoryItemStatement AS $row) {
            $item[$row['id']] = $row['total'];
        }
        foreach ($preparedStatement as $row) {

//            $date1 = new DateTime($row['created_at']);
//            $date2 = new DateTime(date("Y-m-d"));
//            $interval = date_diff($date1, $date2);
//            $num_months = $interval->m + ($interval->y * 12);
            /**
             * MAKE ARRAY NON ASSOCIATIVE
             * Arranging the data order
             * */
            if (isset($ytd[$row['id']])) {
                $ytdAmount = $ytd[$row['id']];
            } else {
                $ytdAmount = 0;
            }

            if (isset($mtd[$row['id']])) {
                $mtdAmount = $mtd[$row['id']];
            } else {
                $mtdAmount = 0;
            }
            if (isset($sales[$row['id']])) {
                $salesAmount = $sales[$row['id']];
            } else {
                $salesAmount = 0;
            }
            if (isset($item[$row['id']])) {
                $itemCount = $item[$row['id']];
            } else {
                $itemCount = 0;
            }
            $date1 = new DateTime($row['created_at']);
            $date2 = new DateTime(date("d-m-Y"));
            $interval = date_diff($date1, $date2);
            $num_months = $interval->m + ($interval->y * 12);
            if ($num_months != 0) {
                $monthlyAverage = $salesAmount / $num_months;
            } else {
                $monthlyAverage = '';
            }
            $date = strtotime($row['created_at']);
            $myFormatForView = date("m/d/y", $date);
            $json[] = array(
                $index++,
                $row['company_name'],
                "<a href='http://" . $_SERVER['SERVER_NAME'] ."/admin/popup/merchant/".$row['id']."' target='_blank'>[" . str_pad($row['id'],10,'0',STR_PAD_LEFT) . "]</a>",
                $myFormatForView,
                $ytdAmount,
                $mtdAmount,
                $monthlyAverage,
                $itemCount,
                null,
                null,
                0,
                "item " . $index,
                0,
                0,
                "Distributor",
                "Ac",
                "Pas",
                $row['name'],
                $row['state_name'],
                $row['cityName'],
                $row['area'],
                '',
                ''
            );
        }

        /********************* STATIONS *****************/

        $preparedStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->select([
                'station.station_name',
                'station.id',
                'address.longitude',
                'address.latitude',
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
                'city.name as cityname',
                'station.created_at',
                'country.name',
                'state.name AS state_name',
                'city.name AS cityName',
                'address.area_id'
            ]);

        $YTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('station.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-01-01")');

        $MTDStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw('station.id,
                    SUM(payment.receivable) AS total
                    ')
            ->where('porder.created_at', '>=', 'concat(year(curdate()),"-",month(curdate()),"-1")');

        $SalesSinceAmountStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('porder', 'address.id', '=', 'porder.address_id')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('users', 'porder.user_id', '=', 'users.id')
            ->join('payment', 'payment.id', '=', 'porder.payment_id')
            ->selectRaw(
                'station.id,
                SUM(payment.receivable) AS total
                    '
            );

        $inventoryItemStatement = Address::join('city', 'city.id', '=', 'address.city_id')
            ->join('country', 'city.country_code', '=', 'country.code')
            ->join('station', 'station.address_id', '=', 'address.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->join('product', 'product.cov_city_id', '=', 'city.id')
            ->join('sproduct', 'product.id', '=', 'sproduct.product_id')
            ->selectRaw(
                'station.id,
                COUNT(*) AS total
                    '
            );

        if ($searchBy == 'country') {
            $preparedStatement = $preparedStatement->where('country.code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('country.code', '=', $searchKey)->groupBy('station.id')->get();
        }
        if ($searchBy == 'city') {
            $preparedStatement = $preparedStatement->where('city.id', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.id', '=', $searchKey)->groupBy('station.id')->get();
        }

        if ($searchBy == 'coordinate') {
            // separating latitude longitude
            $cordinates = explode(",", $searchKey);
            //dd($cordinates);
            //exit;
            $preparedStatement = $preparedStatement->where('address.latitude', '=', $cordinates[0]);
            $preparedStatement = $preparedStatement->where('address.longitude', '=', $cordinates[1])->get();
            $YTDStatement = $YTDStatement->where('address.latitude', '=', $cordinates[0]);
            $YTDStatement = $YTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('address.latitude', '=', $cordinates[0]);
            $MTDStatement = $MTDStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.latitude', '=', $cordinates[0]);
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('address.latitude', '=', $cordinates[0]);
            $inventoryItemStatement = $inventoryItemStatement->where('address.longitude', '=', $cordinates[1])->groupBy('station.id')->get();
        }

        if ($searchBy == 'state') {
            $preparedStatement = $preparedStatement->where('city.state_code', '=', $searchKey)->get();
            $YTDStatement = $YTDStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->where('city.state_code', '=', $searchKey)->groupBy('station.id')->get();
        }

        if ($searchBy == 'all') {
            $preparedStatement = $preparedStatement->get();
            $YTDStatement = $YTDStatement->groupBy('station.id')->get();
            $MTDStatement = $MTDStatement->groupBy('station.id')->get();
            $SalesSinceAmountStatement = $SalesSinceAmountStatement->groupBy('station.id')->get();
            $inventoryItemStatement = $inventoryItemStatement->groupBy('station.id')->get();
        }

        /*  $json = array();
          $index = 1;
          $ytd = array();
          $mtd = array();
          $sales = array();
          $item = array();*/
        foreach ($YTDStatement AS $row) {
            $ytd[$row['id']] = $row['total'];
        }
        foreach ($MTDStatement AS $row) {
            $mtd[$row['id']] = $row['total'];
        }
        foreach ($SalesSinceAmountStatement AS $row) {
            $sales[$row['id']] = $row['total'];
        }
        foreach ($inventoryItemStatement AS $row) {
            $item[$row['id']] = $row['total'];
        }
        foreach ($preparedStatement as $row) {

//            $date1 = new DateTime($row['created_at']);
//            $date2 = new DateTime(date("Y-m-d"));
//            $interval = date_diff($date1, $date2);
//            $num_months = $interval->m + ($interval->y * 12);
            /**
             * MAKE ARRAY NON ASSOCIATIVE
             * Arranging the data order
             * */
            if (isset($ytd[$row['id']])) {
                $ytdAmount = $ytd[$row['id']];
            } else {
                $ytdAmount = 0;
            }

            if (isset($mtd[$row['id']])) {
                $mtdAmount = $mtd[$row['id']];
            } else {
                $mtdAmount = 0;
            }
            if (isset($sales[$row['id']])) {
                $salesAmount = $sales[$row['id']];
            } else {
                $salesAmount = 0;
            }
            if (isset($item[$row['id']])) {
                $itemCount = $item[$row['id']];
            } else {
                $itemCount = 0;
            }
            $date1 = new DateTime($row['created_at']);
            $date2 = new DateTime(date("d-m-Y"));
            $interval = date_diff($date1, $date2);
            $num_months = $interval->m + ($interval->y * 12);
            if ($num_months != 0) {
                $monthlyAverage = $salesAmount / $num_months;
            } else {
                $monthlyAverage = '';
            }
            $date = strtotime($row['created_at']);
            $myFormatForView = date("m/d/y", $date);
            $json[] = array(
                $index++,
                $row['station_name'],
                "<a href='http://" . $_SERVER['SERVER_NAME'] ."/admin/popup/station/".$row['id']."' target='_blank'>[" . str_pad($row['id'],10,'0',STR_PAD_LEFT) . "]</a>",
                $myFormatForView,
                $ytdAmount,
                $mtdAmount,
                $monthlyAverage,
                $itemCount,
                null,
                null,
                0,
                "item " . $index,
                0,
                0,
                "Distributor",
                "Ac",
                "Pas",
                $row['name'],
                $row['state_name'],
                $row['cityName'],
                $row['area'],
                '',
                ''
            );
        }

        /*         * * MAKE RESPONSE HAVE 'data' ENTRY *** */
        $response = array();
        $response['data'] = $json;


        return Response::json($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function certificate(Request $request, $id) {
        $merchant = Merchant::with('certificates')->find($id);

        //Check if Merchant exist
        if (!$merchant) {
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        return view('shops.oshopcertificate')->with('merchant', $merchant);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard() {
        if (!Auth::check()) {
            # code...
            // return redirect('/')->with('redirect_to_login',1);
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access the page')
                ->with('redirect_to_login',1);

        }

        $orders = null;
        $user_id= Auth::user()->id;
        $station_id= DB::table('station')->where('user_id',$user_id)->pluck('id');
        $b= new BuyerController();
        $autolinks= $b->get_autolink($user_id);
        $o= new OpenWishController();
        $station = Station::where('user_id' , $user_id)->first();
        $openwish = $o->get_openwish($station->user_id);
        $currency =   $currency = Currency::where('active', 1)->first();

        $porders = DB::table('porder')->where('user_id', $user_id)->orderBy('porder.created_at','DESC')->get();
        $porders2= DB::table('porder')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('orderproduct', 'porder.id', '=', 'orderproduct.porder_id')
            ->join('sproduct', 'sproduct.product_id', '=', 'orderproduct.product_id')
            ->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')
            ->join('station', 'stationsproduct.station_id', '=', 'station.id')
            ->select('porder.*')
            ->orderBy('porder.created_at','DESC')
            ->where('sorder.station_id', $station_id)
            ->get();

        $station_payment_details=DB::table("station as s")
            ->select("s.mc_sales_staff_commission as commission","po.id as order_id","p.receivable as receivable",DB::raw('sum(p.receivable) as logistics'))
            ->join("sorder as sodr","sodr.station_id","=","s.id")
            ->join("porder as po","po.id","=","sodr.porder_id")
            ->join("payment as p","p.id","=","po.payment_id")
            ->join("stationsproduct as stp","sodr.station_id","=","stp.station_id")
            ->join("sproduct as spro","stp.sproduct_id","=","spro.id")
            ->join("orderproduct as op","op.product_id","=","spro.product_id")
            ->where("s.id",$station_id)
            ->get();
        // This piece of code takes station as a buyer and therefore should be same as it
        $bporders = DB::table('porder')->where('user_id', $user_id)->orderBy('created_at','DESC')->get();

        $bproduct_orders= $b->products($bporders,true);
        // dd($product_orders);
        $borders= array();
        foreach ($bproduct_orders as $po) {
            # code...
            $ex=DB::table('porder')->where('id',$po['oid'])->first();
            //$total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
            $po['status']=$ex->status;
            $po['o_receipt']=$ex->receipt_tstamp;
            $date = $ex->created_at;
            $date1 = new DateTime(date('Y-m-d H:i:s'));
            $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($date)));
            $diff = $date1->diff($date2);
            $hours = $diff->h;
            $days = $diff->days;
            $totaldiff = ($diff->days * 24) + $diff->h + ($diff->i / 60) + ($diff->s / 3600);
            $po['hours']=$hours;
            $po['days']=$days;
            $po['totaldiff']=$totaldiff;
            array_push($borders, $po);
        }
        //dd($bproduct_orders);
        // The above code will populate the SD:Buying-Order tab. Any question?No good.
        $product_orders= $b->products($porders2,true);
        $product_orders2= $b->products($porders2,true);
        $orders= array();
        $ordersb= array();
        $station_details=Station::where('user_id',Auth::user()->id)->first();
        foreach ($product_orders as $po) {
            # code...
            $ex=DB::table('porder')->where('id',$po['oid'])->first();
            if(isset($ex)){
                $rcv_date = $ex->created_at;
                $po['user_id'] =   $ex->user_id;

                //return $station_details;
                $po['station_name'] = $station_details->company_name;
                if($rcv_date != null and $rcv_date != ''){
                    $date = Carbon::parse($rcv_date);
                    $day = $date->format('d');
                    $month = $date->format('m');
                    $year = $date->format('Y');
                    $day_after_seven_days = $day + 7;

                    if ($day_after_seven_days <= 15){
                        $due_date = Carbon::parse($year.'-'.$month.'-15')->format('dMy h:m');
                    }else{
                        $due_date = Carbon::parse($year.'-'.$month.'-30')->format('dMy h:m');
                    }
                }else{
                    $due_date= '';
                }
                $po['due_date'] =   $due_date;
                $po['rcv_date'] =   Carbon::parse($rcv_date)->format('dMy h:m');
            }
//            $po['description']= $ex->description;
            $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
            $po['total']=$total;
            $po['status']=$ex->status;
            array_push($orders, $po);
        }
        $oid = 0;
        foreach ($product_orders2 as $po2) {
            # code...
            $ex=DB::table('porder')->where('id',$po2['oid'])->first();
            if(isset($ex)){
                $rcv_date = $ex->created_at;
                if($rcv_date != null and $rcv_date != ''){
                    $date = Carbon::parse($rcv_date);
                    $day = $date->format('d');
                    $month = $date->format('m');
                    $year = $date->format('Y');
                    $day_after_seven_days = $day + 7;

                    if ($day_after_seven_days <= 15){
                        $due_date = Carbon::parse($year.'-'.$month.'-15')->format('dMy h:m');
                    }else{
                        $due_date = Carbon::parse($year.'-'.$month.'-30')->format('dMy h:m');
                    }
                }else{
                    $due_date= '';
                }
                $po2['due_date'] =   $due_date;
                $po2['rcv_date'] =   Carbon::parse($rcv_date)->format('dMy h:m');
            }
//            $po['description']= $ex->description;
            $total= DB::table('payment')->where('id',$ex->payment_id)->pluck('receivable');
            $po2['total']=$total;
            $po2['status']=$ex->status;
            if($oid != $po2['oid']){
                $oid = $po2['oid'];
                array_push($ordersb, $po2);
            } else {
            }
        }
        /*print_r ($orders);
        exit;*/
        $bank_commision=DB::table('global')->pluck('payment_gateway_commission');
        $shipping = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->orderBy('porder.created_at','DESC')
            ->where('porder.user_id',$user_id)
            ->get();

        $shippingsales = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('sproduct','sproduct.id','=','orderproduct.product_id')
            ->leftJoin('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')
            ->leftJoin('station','station.id','=','stationsproduct.station_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->orderBy('porder.created_at','DESC')
            ->where('station.user_id',$user_id)
            ->get();

        $data['countries'] = $this->countryModel->lists('name','id')->all();
        $data['merchants'] = $this->merchantModel->getAllMerchants();
        $data['merchantConsultants'] = $this->salesStaffModel->getAllMerchantConsultants();
        // Hyper
        try {
            $hypers = Product::leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                {
                    $join->on('o.id', '=', 'op.owarehouse_id')
                        ->where('op.status','=','executed');
                })
                ->where('op.user_id',$user_id)
                ->select(DB::raw('product.*,product.parent_id as product_id,o.id as owarehouse_id,o.collection_price,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))

                ->groupBy('product.id')
                ->get();
        } catch (\Exception $e) {
            return $e;
            $hypers=array();  //Fallback ! Just in case something happens
        }

        $product_likes = DB::select(DB::raw("SELECT product.*, DATE_FORMAT(usersproduct.created_at,'%d%b%y') as since, usersproduct.created_at FROM product, usersproduct WHERE product.id = usersproduct.product_id AND usersproduct.user_id = " . $user_id. " ORDER BY usersproduct.created_at DESC"));
        //return $orders;
        return view('station.dashboard')
            ->with('product_likes',$product_likes)
            ->with('orders',$orders)
            ->with('ordersb',$ordersb)
            ->with('shipping',$shipping)
            ->with('shippingsales',$shippingsales)
            ->with('bank',$bank_commision)
            ->with('autolinks' , $autolinks)
            ->with('openwish' , $openwish)
            ->with('currency' , $currency)
            ->with('currency_code' , $currency->code)
            ->with('data' , $data)
            ->with('station_id', $station_id)
            ->with('borders',$borders)
            ->with('ow_product',$hypers);
        /*   return view('station.dashboard', compact(
                           'orders',
   //            'voucher_orders',
   //            'openWishes',
                'autolinks'
   //            'all',
   //            'all_pro',
   //            'currency'
           ));*/

        /* }catch (\Exception $e){
          return back();
          } */
    }
    public function get_porder_payment($porders,$payment)
    {
        // dd($porders);
        $products = array();

        foreach ($porders as $order) {
            try {
                $odata = DB::table('orderproduct')->where('porder_id', $order->porder_id)->first();
                $pdata = DB::table('product')->where('id', $odata->product_id)->first();//product detail

                // return $pdata->name;

                //
                if ($pdata->subcat_level == '0') {
                    $cat2 = DB::table('category')->where('id', $pdata->category_id)->pluck('name');
                } else {
                    try {
                        $table = 'subcat_level_' . $link->subcat_level;
                        $totaldata = DB::table($table)->where('id', $link->subcat_id)->first();
                        $catdata = DB::table('category')->where('id', $totaldata->category_id)->first();
                        $cat2 = $catdata->name;
                        $subcat2 = $totaldata->description;
                    } catch (\Exception $e) {
                        $cat2 = "Not Found";
                        $subcat2 = "Not Found";
                    }
                }
                $commission= Product::where('id',$pdata->id)->pluck('osmall_commission');
                if (is_null($commission)) {
                    # code...
                    $m= new MerchantDashboardController;
                    $user_id= Auth::user()->id;
                    $commission= $m->get_merchant_commission($user_id);
                }
                $temp = array();
                $temp['pname'] = $pdata->name; //
                $temp['oid'] = $order->porder_id;//Order ID
                $temp['quantity'] = $odata->quantity;
                $temp['orig_price'] = $pdata->retail_price;
                $temp['retail_price'] = $pdata->discounted_price;
                $temp['o_rcv'] = $order->delivery_tstamp;
                $temp['o_exec'] = $order->created_at;
                $temp['uid'] = $order->user_id;
                $temp['source'] = $cat2;
                $temp['sku'] = $pdata->id; //product id
                $temp['comm']=$commission;
                $temp['desc']=$order->description;
                if ($payment==true) {

                    $pay = DB::table('payment')->where('id',$order->payment_id)->first();
                }
                $temp['payment']=$pay;
                array_push($products, $temp);
            } catch (\Exception $e) {
                // echo "<script> console.log('Exception:Product not found' ); </script>";
            }
        }
        return $products;
    }

    public function userCustomThems() {
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
                if (count($Bunting) == 0 && count($Signboard) == 0) {
                    $theme_data = null;
                }
            } else {
                $theme_data = null;
                $theme = null;
            }
        } else {
            $theme_data = null;
            $theme = null;
        }

        return Response::json(array('theme' => $theme, 'theme_data' => $theme_data));
    }

    public function postCalcSale(Request $request) {
        $date1 = Carbon::parse($request['date1']);
        $date2 = Carbon::parse($request['date2']);

        $user = Auth::user();

        // $user->type may be null!!!!
        $merchant = $user->merchant;

        $products = $merchant->first()->products()->get()->lists('id', 'id');

        $orderproduct = OrderProduct::whereIn('product_id', $products)->groupBy('porder_id')->lists('porder_id', 'porder_id');

        $orderSince = POrder::whereIn('id', $orderproduct)->where('created_at', '>=', $date1)->where('created_at', '<=', $date2)->with(['payment'])->get();

        $paymentSince = 0;
        foreach ($orderSince as $order) {
            $paymentSince += $order->payment->receivable;
        }

        $orders = POrder::whereIn('id', $orderproduct)->whereYear('created_at', '>=', $date1)->where('created_at', '<=', $date2)->with(['payment'])->get();

        $payment = 0;
        foreach ($orders as $order) {
            $payment += $order->payment->receivable;
        }

        return response()->json([
            'payment' => $payment,
            'paymentSince' => $paymentSince
        ]);
    }

    public function getOrderViewListTerm($uid = null) {


        if (!Auth::check()) {
            # code...;
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access the page')
                ->with('redirect_to_login',1);
            return redirect('/')->with('redirect_to_login',1);
        }
        if(is_null($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }
        $selluser = User::find($user_id);
        $termfacility = DB::table('facility')->where('name','term')->pluck('id');
        $facilitysubs = DB::table('facility')->where('name','term')->pluck('token_subscription_fee');
        $facilityadmin = DB::table('facility')->where('name','term')->pluck('token_admin_fee');
        if(is_null($facilitysubs)){
            $facilitysubs = 10000;
        }
        if(is_null($facilityadmin )){
            $facilityadmin = 2;
        }
        //	dd($termfacility);
        $station_id= DB::table('station')->where('user_id',$user_id)->pluck('id');

        $orders = DB::table('product')
            ->join('category','product.category_id','=','category.id')
            ->join('product as parent','product.parent_id','=','parent.id')
            ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
            ->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
            ->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
            ->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
            ->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
            ->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')
            ->leftJoin('userstoken', 'userstoken.user_id', '=', 'merchant.user_id')
            ->leftJoin('sellerfacility', function($join2) use ($termfacility)
            {
                $join2->on('sellerfacility.user_id', '=', 'merchant.user_id')->where('sellerfacility.facility_id', '=',$termfacility);
            })
            ->leftJoin('tproduct', 'tproduct.product_id', '=', 'product.id')
            ->leftJoin('stationterm', function($join) use ($station_id)
            {
                $join->on('stationterm.creditor_user_id', '=', 'merchant.user_id')->where('stationterm.station_id', '=',$station_id);
            })
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            //	->where('product.oshop_selected', '=', 1)
            ->where('stationsproduct.station_id', '=', $station_id)
            ->where('product.segment', '=', 'b2b')
            ->where('parent.status', '=', 'active')
            ->select([
                'product.id AS product_id',
                'product.parent_id AS parent_id',
                'product.name',
                'product.subcat_id',
                'product.available',
                'product.retail_price',
                'product.photo_1',
                'sellerfacility.id as sellerfacilityid',
                'userstoken.qty as tokenqty',
                'tproduct.id AS tid',
                'product.discounted_price',
                'merchant_id',
                'merchant.user_id as muid',
                'stationterm.credit_limit',
                'stationterm.term_duration',
                'autolink.responder'
            ])
            ->distinct()
            ->get();
//		dd($orders);
        $orderst = DB::table('tproduct')
            //     ->join('twholesale', 'tproduct.id', '=', 'twholesale.tproduct_id')
            ->join('merchanttproduct', 'tproduct.id', '=', 'merchanttproduct.tproduct_id')
            ->join('merchant', 'merchant.id', '=', 'merchanttproduct.merchant_id')
            ->join('autolink', 'merchanttproduct.merchant_id', '=', 'autolink.responder')
            ->leftJoin('userstoken', 'userstoken.user_id', '=', 'merchant.user_id')
            ->leftJoin('sellerfacility', function($join2) use ($termfacility)
            {
                $join2->on('sellerfacility.user_id', '=', 'merchant.user_id')->where('sellerfacility.facility_id', '=',$termfacility);
            })
            ->leftJoin('stationterm', function($join) use ($station_id)
            {
                $join->on('stationterm.creditor_user_id', '=', 'merchant.user_id')->where('stationterm.station_id', '=',$station_id);
            })
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            ->where('tproduct.status', '=', 'active')
            ->where('tproduct.available', '>', 0)
//            ->where('sorder.id', '=', 1)
            ->select([
                'tproduct.id AS product_id',
                'tproduct.name',
                'tproduct.photo_1',
                'tproduct.parent_id',
                'tproduct.available',
                'sellerfacility.id as sellerfacilityid',
                'userstoken.qty as tokenqty',
                'merchant_id',
                'stationterm.credit_limit',
                'stationterm.term_duration',
                'autolink.responder'
            ])
            ->distinct()
            ->get();
        //dd($orderst);
        $product_ids= DB::table('product')
            ->join('category','product.category_id','=','category.id')
            ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
            ->join('merchantproduct', 'product.parent_id', '=',
                'merchantproduct.product_id')
            ->join('autolink', 'merchantproduct.merchant_id', '=',
                'autolink.responder')
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            //	->where('product.oshop_selected', '=', 1)
            ->where('product.available', '>', 0)
            ->whereRaw('NOT EXISTS (
				SELECT sproduct.id
				FROM sproduct, stationsproduct
				WHERE sproduct.id = stationsproduct.sproduct_id
				AND stationsproduct.station_id = ' . $station_id . '
				AND sproduct.product_id = product.parent_id)')
            ->where('product.segment', '=', 'b2b')
            ->lists('product.parent_id');

        $products= DB::table('product')->whereIn('id',$product_ids)->
        select([
            'product.id AS product_id',
            'product.name',
            'product.subcat_id',
            'product.available',
            'product.retail_price',
            'product.discounted_price'
        ])->distinct()->count();
        //	dd($orders);
        return view('station.order-view-list-term', compact('orderst','orders', 'selluser','products','termfacility ','facilitysubs','facilityadmin'));
    }

    public function getOrderViewList($uid = null) {
        if (!Auth::check()) {
            # code...;
            return view('common.generic')
                ->with('message_type','error')
                ->with('message','Please login to access the page')
                ->with('redirect_to_login',1);
            return redirect('/')->with('redirect_to_login',1);
        }
        if(is_null($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }
        $selluser = User::find($user_id);
        $termfacility = DB::table('facility')->where('name','term')->pluck('id');
        $facilitysubs = DB::table('facility')->where('name','term')->pluck('token_subscription_fee');
        $facilityadmin = DB::table('facility')->where('name','term')->pluck('token_admin_fee');
        if(is_null($facilitysubs)){
            $facilitysubs = 10000;
        }
        if(is_null($facilityadmin )){
            $facilityadmin = 2;
        }
        //	dd($termfacility);
        $station_id= DB::table('station')->where('user_id',$user_id)->pluck('id');

        $orders = DB::table('product')
            ->join('category','product.category_id','=','category.id')
            ->join('product as parent','product.parent_id','=','parent.id')
            ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
            ->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
            ->join('merchant', 'merchant.id', '=', 'merchantproduct.merchant_id')
            ->join('autolink', 'merchantproduct.merchant_id', '=', 'autolink.responder')
            ->join('sproduct', 'merchantproduct.product_id', '=', 'sproduct.product_id')
            ->join('stationsproduct', 'stationsproduct.sproduct_id', '=', 'sproduct.id')
            ->leftJoin('userstoken', 'userstoken.user_id', '=', 'merchant.user_id')
            ->leftJoin('sellerfacility', function($join2) use ($termfacility)
            {
                $join2->on('sellerfacility.user_id', '=', 'merchant.user_id')->where('sellerfacility.facility_id', '=',$termfacility);
            })
            ->leftJoin('tproduct', 'tproduct.product_id', '=', 'product.id')
            ->leftJoin('stationterm', function($join) use ($station_id)
            {
                $join->on('stationterm.creditor_user_id', '=', 'merchant.user_id')->where('stationterm.station_id', '=',$station_id);
            })
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            //	->where('product.oshop_selected', '=', 1)
            ->where('stationsproduct.station_id', '=', $station_id)
            ->where('product.segment', '=', 'b2b')
            ->where('product.available', '>', 0)
            ->where('parent.status', '=', 'active')
            ->whereRaw('NOT EXISTS (
					SELECT product.id
					FROM productblacklist
					WHERE product.parent_id = productblacklist.product_id AND productblacklist.user_id = ' . $user_id . '
					)
				')
            ->select([
                'product.id AS product_id',
                'product.parent_id AS parent_id',
                'product.name',
                'product.subcat_id',
                'product.available',
                'product.retail_price',
                'product.photo_1',
                'sellerfacility.id as sellerfacilityid',
                'userstoken.qty as tokenqty',
                'tproduct.id AS tid',
                'product.discounted_price',
                'merchant_id',
                'merchant.user_id as muid',
                'stationterm.credit_limit',
                'stationterm.term_duration',
                'autolink.responder'
            ])
            ->distinct()
            ->get();
//		dd($orders);
        $orderst = DB::table('tproduct')
            //     ->join('twholesale', 'tproduct.id', '=', 'twholesale.tproduct_id')
            ->join('merchanttproduct', 'tproduct.id', '=', 'merchanttproduct.tproduct_id')
            ->join('merchant', 'merchant.id', '=', 'merchanttproduct.merchant_id')
            ->join('autolink', 'merchanttproduct.merchant_id', '=', 'autolink.responder')
            ->leftJoin('userstoken', 'userstoken.user_id', '=', 'merchant.user_id')
            ->leftJoin('sellerfacility', function($join2) use ($termfacility)
            {
                $join2->on('sellerfacility.user_id', '=', 'merchant.user_id')->where('sellerfacility.facility_id', '=',$termfacility);
            })
            ->leftJoin('stationterm', function($join) use ($station_id)
            {
                $join->on('stationterm.creditor_user_id', '=', 'merchant.user_id')->where('stationterm.station_id', '=',$station_id);
            })
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            ->where('tproduct.status', '=', 'active')
//            ->where('sorder.id', '=', 1)
            ->select([
                'tproduct.id AS product_id',
                'tproduct.name',
                'tproduct.available',
                'sellerfacility.id as sellerfacilityid',
                'userstoken.qty as tokenqty',
                'merchant_id',
                'stationterm.credit_limit',
                'stationterm.term_duration',
                'autolink.responder'
            ])
            ->distinct()
            ->get();
        //dd($orders);
        $product_ids= DB::table('product')
            ->join('category','product.category_id','=','category.id')
            ->join('wholesale', 'product.id', '=', 'wholesale.product_id')
            ->join('merchantproduct', 'product.parent_id', '=',
                'merchantproduct.product_id')
            ->join('autolink', 'merchantproduct.merchant_id', '=',
                'autolink.responder')
            ->where('autolink.initiator', '=', $user_id)
            ->where('autolink.status', '=', 'linked')
            //	->where('product.oshop_selected', '=', 1)
            ->where('product.available', '>', 0)
            ->whereRaw('NOT EXISTS (
				SELECT sproduct.id
				FROM sproduct, stationsproduct
				WHERE sproduct.id = stationsproduct.sproduct_id
				AND stationsproduct.station_id = ' . $station_id . '
				AND sproduct.product_id = product.parent_id)')
            ->whereRaw('NOT EXISTS (
					SELECT product.id
					FROM productblacklist
					WHERE product.parent_id = productblacklist.product_id AND productblacklist.user_id = ' . $user_id . '
					)
				')
            ->where('product.segment', '=', 'b2b')
            ->lists('product.parent_id');

        $products= DB::table('product')->whereIn('id',$product_ids)->
        select([
            'product.id AS product_id',
            'product.name',
            'product.subcat_id',
            'product.available',
            'product.retail_price',
            'product.discounted_price'
        ])->distinct()->count();
        //	dd($orders);
        return view('station.order-view-list', compact('orderst','orders', 'selluser','products','termfacility ','facilitysubs','facilityadmin'));
    }

    public function getSorderData() {
        $orders = DB::table('porder')
            ->join('sorder', 'porder.id', '=', 'sorder.porder_id')
            ->join('orderproduct', 'orderproduct.porder_id', '=', 'porder.id')
            ->join('product', 'product.id', '=', 'orderproduct.product_id')
            ->leftJoin('productdetail', 'product.productdetail_id', '=', 'productdetail.id')
//            ->join('category','product.category_id','=','category.id')
//            ->join('wholesale','product.id','=','wholesale.product_id')
            ->join('brand', 'product.brand_id', '=', 'brand.id')
//            ->join('subcat_level_'.$subcatlevel ,'product.subcat_id','=','subcat_level_'.$subcatlevel.'.id')
//            ->where('sorder.id', '=', 1)
            ->select([
                'porder.id',
                'product.id AS product_id',
                'product.name',
//                'category.name AS categoryname' ,
                'brand.name AS brandname',
                'product.subcat_id',
                'productdetail.data as product_details',
                'product.available',
                'product.retail_price',
                'product.discounted_price',
//                'wholesale.price AS wholesaleprice',
//                'wholesale.unit',
//
                'orderproduct.quantity',
                'orderproduct.shipping_cost',
            ]);

        return Datatables::of($orders)
            ->addColumn('action', function ($order) {
                return '<a href="#edit-' . $order->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getOrderViewIcon() {
//        $subcategories1 = SubCatLevel1::all();
//        $subcategories2 = SubCatLevel2::all();
//        $subcategories3 = SubCatLevel3::all();
//        $subcategories1= SubCatLevel1::all();
        $porderIds = POrder::where('user_id', '=', Auth::user()->id)->lists('id', 'id');
        $orderProducts = OrderProduct::whereIn('porder_id', $porderIds)->lists('product_id', 'product_id');
        $productList = Product::whereIn('id', $orderProducts)->lists('category_id', 'subcat_id')->toArray();
        $categoryList = array_values($productList);
        $subCategoryList = array_keys($productList);
        $categories = Category::whereIn('id', $categoryList)->with(array(
                'subCatLevel1' => function($query) use($subCategoryList) {

                    return $query->whereIn('id', $subCategoryList)->with('product');
                },
                'subCatLevel2' => function($query1) use($subCategoryList) {
                    return $query1->whereIn('id', $subCategoryList)->with('product');
                }
            )
        )->get();

        /**
         * Get detail of the recommanded items
         */
        $recommandedItems = DB::table('sproduct')
            ->join('stationsproduct', function($join) {
                $join->on('stationsproduct.sproduct_id', '=', 'sproduct.id');
            })
            ->join('product', 'sproduct.product_id', '=', 'product.id')
            ->join('orderproduct', 'orderproduct.product_id', '=', 'sproduct.product_id')
            ->join('station', 'stationsproduct.station_id', '=', 'station.id')
            ->join('sorder', 'sorder.porder_id', '=', 'orderproduct.porder_id')
            ->select([
                'product.id',
                'product.name',
                'product.photo_1',
            ])
            ->take(6)
            ->groupBy('sproduct.id')->get();
//                ->orderBy('sum(orderproduct.quantity)');
//        $orders = DB::table('porder')
//            ->join('sorder','porder.id','=','sorder.porder_id')
//            ->join('orderproduct','orderproduct.porder_id','=','porder.id')
//            ->join('product','product.id','=','orderproduct.product_id')
//            ->join('category','product.category_id','=','category.id')
//            ->join('wholesale','product.id','=','wholesale.product_id')
//            ->join('brand','product.brand_id','=','brand.id')
////            ->join('subcat_level_'.$subcatlevel ,'product.subcat_id','=','subcat_level_'.$subcatlevel.'.id')
//
////            ->where('sorder.id', '=', 1)
//
//            ->select([
//                'porder.id',
//                'product.id AS product_id',
//                'product.name',
//                'category.name AS categoryname' ,
//                'brand.name AS brandname',
//                'product.subcat_id',
//                'product.product_details',
//
//                'product.available',
//                'product.retail_price',
//                'product.original_price',
//                'wholesale.price AS wholesaleprice',
//                'wholesale.unit',
////
////                'orderproduct.quantity',
////                'orderproduct.shipping_cost',
//            ])->get();

        return view('station.order-view-icon', compact('subcategories1', 'subcategories2', 'subcategories3', 'categories', 'recommandedItems'));
    }

    function getProductIcon($id){


        $porderIds = POrder::where('user_id', '=', Auth::user()->id)->lists('id', 'id');
        $orderProducts = OrderProduct::whereIn('porder_id', $porderIds)->where('product_id', $id)->lists('porder_id');

        $infoProduct = DB::select(DB::raw(
            'SELECT  sto.order_qty, who.price, prde.special_price, pro.name, pro.id, pro.photo_1
                FROM product pro, sorder sto, wholesale who, productdealer prde
                where sto.id ='. $orderProducts[0] .'
                and who.product_id = '.$id.'
                and prde.product_id = '.$id.'
                and pro.id = '.$id.'
                and sto.order_qty BETWEEN who.funit and who.unit'
        ));

        return json_encode($infoProduct);
    }

    function getProductDetail($productId = 0) {
        $fileds = array(
            'id', 'name', 'brand_id', 'category_id',
            'subcat_id', 'photo_1', 'retail_price'
        );
        $productDetail = Product::where('id', $productId)
            ->select($fileds)
            ->with(array(
                'wholesale',
                'productdealer' => function($query) {
                    return $query->where('dealer_id', Auth::user()->id);
                }
            ))
            ->first();
        $wholeSaleJson = array();
        foreach ($productDetail->wholesale->toArray() as $productDealer) {
            $wholeSaleJson[$productDealer['unit']] = $productDealer['price'];
        }
        $wholeSaleJson = json_encode($wholeSaleJson);
        $specialPriceJson = array();
        foreach ($productDetail->productdealer->toArray() as $productDealer) {
            $specialPriceJson[$productDealer['special_unit']] = $productDealer['special_price'];
        }
        $specialPriceJson = json_encode($specialPriceJson);
        return view('station.get_product_detail', compact('productDetail', 'wholeSaleJson', 'specialPriceJson'));
    }

    public function updateOrderProductQuantity($id) {
        $quantity = Input::get('quantity_' . $id);
        $order = OrderProduct::find($id);
        $order->quantity = $quantity;
//        dd($order);
        $order->update();
        Session::flash('global', 'Successfully Updated');

        return Redirect::back();
    }

    public function getOpenChannel($uid = null) {
        /* $initiators = Autolink::where('initiator_type', 'merchant')
                 ->get();*/
        if(is_null($uid)){
            $user_id = Auth::id();
        } else {
            $user_id = $uid;
        }
        $selluser = User::find($user_id);
        $station_id = DB::table('station')->where('user_id',$user_id)->first();
        if(is_null($station_id )){
            return "Not Logged In";
        } else {
            $station_id = DB::table('station')->where('user_id',$user_id)->first()->id;
            $count = 0;
            $suppliers = array();
            $suppliers = DB::select(DB::raw("select auto.responder as merchantid, address.line1, address.line2, auto.linked_since as linked_since, mer.company_name as name, mer.user_id as supplier_user_id, SUM(IF(porder.created_at >= '1970-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as since_sum, SUM(IF(porder.created_at >= '" . date('Y') . "-01-01' AND sorder.id IS NOT NULL, orderproduct.order_price * orderproduct.quantity, 0)) as YTD, SUM(IF(porder.created_at >= '" . date('Y-m') . "-01' AND sorder.id IS NOT NULL,orderproduct.order_price * orderproduct.quantity,0)) as MTD, city.name as cityname, state.name as statename, country.name as countryname, area.name as areaname
					from autolink auto inner join merchant mer on auto.responder = mer.id 
					left join merchantproduct on merchantproduct.merchant_id = mer.id
					left join orderproduct ON merchantproduct.product_id = orderproduct.product_id
					left join porder ON orderproduct.porder_id = porder.id
					left join sorder ON sorder.porder_id = porder.id
					left join address ON mer.address_id = address.id
					left join city ON address.city_id = city.id
					left join state ON city.state_code = state.code
					left join country ON state.country_code = country.code
					left join area ON address.area_id = area.id
					WHERE auto.initiator = $user_id
					AND auto.visibility = 1
					group by merchantid 
					order by auto.created_at DESC"));

            $currency = Currency::where('active', 1)->first();


            return view('station.open-channel', compact('suppliers'))->with('currencyCode',$currency->code)->with('station_id',$station_id)->with('selluser',$selluser);
        }
    }

    public function getStationOpenChannel() {
        $stations = Station::all();

        $currency = Currency::where('active', 1)->first();

        return view('station.open-station-channel', compact('stations'))->with('currencyCode',$currency->code);
    }

    /*     * **********By Amjad******************* */

    public function getInventoryData() {

        $user_id= Auth::user()->id;
        $station_id= DB::table('station')->where('user_id',$user_id)->pluck('id');
        $inventoryResults = DB::select(DB::raw(
            'SELECT DISTINCT(product.id) as id, product.name as name, merchantproduct.merchant_id as merchant_id, sproduct.available as available, sproduct.stock as stock, b2b.available as b2b_available
				FROM product
				JOIN merchantproduct ON merchantproduct.product_id = product.id
				JOIN sproduct ON sproduct.product_id = product.id
				JOIN stationsproduct ON stationsproduct.sproduct_id = sproduct.id
				LEFT JOIN product as b2b ON product.id = b2b.parent_id AND b2b.segment = \'b2b\'
				WHERE stationsproduct.station_id = ' . $station_id
        ));
        $currency = Currency::where('active', 1)->first();
        //dd($inventoryResults);
        return view('station.inventory-report', compact('inventoryResults'))->with('currencyCode', $currency->code);
    }

    public function postOrderQty() {
        $OrderQty = Input::get('OrderQty');
        $stationId = Input::get('stationId');
        $result = DB::table('sorder')
            ->where('id', $stationId)
            ->update(['order_qty' => $OrderQty]);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //Station Add To Cart
    public function postAddtocart() {
        foreach (Input::get('orderQuantity') as $key => $value) {
            $product = Product::find($_POST['Productid'][$key]);
            $quantity = $_POST['orderQuantity'][$key];
            $page = Input::get('page');
            if ($quantity > 0) {
                if ($page == 'owarehouse') {
                    Session::put('page', 'b2b');
                    $price = Input::get('price');
                    Cart::insert(array(
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'image' => $product->photo_1
                    ));
                } else {
                    Cart::insert(array(
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->retail_price,
                        'quantity' => $quantity,
                        'image' => $product->photo_1
                    ));
                }
            }
        }

        $data[0] = Cart::totalItems();
        $data[1] = $product->name;
        $data[2] = $product->id;
        return redirect()->route('cart');
    }
    public function owAddtocart(Request $request) {
        $found = false;
        $product = Product::find($request->product_id)->first();
        foreach (Cart::contents() as $item) {
            if($item->id == $request->product_id){
                $item->price = $request->amount + $item->price;
                $item->quantity += 1;
                $found = true;
            }
        }
        if(!$found){
            Cart::insert(
                array(
                    'id' => $request->product_id,
                    'quantity' => '1',
                    'name' => $product->name,
                    'price' => $request->amount,
                    'image' => $product->photo_1
                )
            );
        }
        $total_items = Cart::totalItems();
        $product_name = $product->name;
        return compact('total_items' , 'product_name');
    }
    public function ochannel_station_statement($id){

        $station_statement = \DB::select("select pro.id as id, pro.name as name, SUM(CASE WHEN sta.id = ? THEN pay.receivable ELSE 0 END) as A, SUM(CASE WHEN sta.id = ? THEN orp.quantity ELSE 0 END) as B, pay.created_at as date, SUM(CASE WHEN por.user_id = ? THEN pay.receivable ELSE 0 END) as X, SUM(CASE WHEN por.user_id = ? THEN orp.quantity ELSE 0 END) as Y
                                from
                                product pro,
                                orderproduct orp,
                                station sta,
                                stationsproduct stp,
                                sproduct spr,
                                porder por,
                                payment pay
                                where
                                sta.id=stp.station_id and
                                stp.sproduct_id = spr.id and
                                spr.product_id = pro.id and
                                pro.id = orp.product_id and
                                orp.porder_id = por.id and
                                por.payment_id = pay.id and
                                sta.id = ?
                                GROUP BY pro.id",array($id,$id,$id,$id,$id));

        return json_encode($station_statement);
    }

    public function ochannel_merchant_statement($id){

        $merchant_statement = \DB::select("select pro.id as id, pro.name as name, SUM(CASE WHEN mer.id = ? THEN pay.receivable ELSE 0 END) as A, SUM(CASE WHEN mer.id = ? THEN orp.quantity ELSE 0 END) as B, pay.created_at as date, SUM(CASE WHEN por.user_id = ? THEN pay.receivable ELSE 0 END) as X, SUM(CASE WHEN por.user_id = ? THEN orp.quantity ELSE 0 END) as Y
                                from
                                product pro,
                                orderproduct orp,
                                merchant mer,
                                merchantproduct mep,
                                porder por,
                                payment pay
                                where
                                mer.id=mep.merchant_id and
                                mep.product_id = pro.id and
                                pro.id = orp.product_id and
                                orp.porder_id = por.id and
                                por.payment_id = pay.id and
                                mer.id = ?
                                GROUP BY pro.id",array($id,$id,$id,$id,$id));

        return json_encode($merchant_statement);
    }
    public function station_details($user_id)
    {
        $payment=[];
        $merchant=Station::where('user_id',$user_id)->first();
        if ($merchant) {
            if ($merchant->mc_sales_staff_id>0) {
                $merchant=DB::table("station as m")
                    ->select("m.mc_sales_staff_commission as commission","po.id as order_id","p.receivable as receivable",DB::raw('sum(pro.del_pricing) as logistics'))
                    ->join("porder as po","po.user_id","=","m.user_id")
                    ->join("merchantsales_staff as msstf","msstf.id","=","m.mc_sales_staff_id")
                    ->join("payment as p","p.id","=","po.payment_id")
                    ->join("merchantproduct as mp","m.id","=","mp.merchant_id")
                    ->join("OrderProduct as op","op.product_id","=","mp.product_id")
                    ->join("product as pro","pro.id","=","op.product_id")
                    ->where("m.id",$user_id)
                    ->get();//loop here if need
                //return $merchant;
                //$globals=Globals::first();
            }
            $globals= Globals::first();
            return $merchant;
            return view('merchant_payment_details', ['merchant'=> $merchant,"globals"=>$globals]);
        }else{
            return "Unauthorized Access";
        }
    }

    public function logistics_station()
    {
        return view('station/logistics_station');
    }

    public function station_selection_admin()
    {

        $states = DB::table('state')->where('country_code','MYS')->get();
        $merchants = DB::table('merchant')->get();
        $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked ";
        $sqlfrom = " FROM address, sproperty, stationtype, station ";
        $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
							 LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109 ";
        $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
        $sqlwhere = " WHERE station.id = sproperty.station_id AND sproperty.address_id = address.id AND station.stationtype_id = stationtype.id ";
        $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, isautolinked DESC, last_selection ASC, station.created_at ";

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));
        //dd($stations);
        return view('admin.analysis.station_selection', ['states'=>$states,'stations'=>$stations,'merchants'=>$merchants]);
    }

    public function station_selection_get_merchant(Request $request, $id)
    {

        if($request->area_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id AND stationarea.area_id = " . $request->area_id . "
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN autolink ON  autolink.initiator = station.user_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND s2.area_id = " . $request->area_id ." AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE address.area_id = $request->area_id AND autolink.responder = $id AND autolink.status = 'linked' ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";
        } else if($request->city_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN autolink ON  autolink.initiator = station.user_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE city.id = $request->city_id AND autolink.responder = $id AND autolink.status = 'linked'  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        } else if($request->state_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			LEFT JOIN state ON city.state_code = state.code
			JOIN autolink ON  autolink.initiator = station.user_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE state.id = $request->state_id AND autolink.responder = $id AND autolink.status = 'linked'  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, isautolinked DESC, last_selection ASC, station.created_at ";
        } else {
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid  ";
            $sqlfrom = " FROM address, sproperty, stationtype, station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN autolink ON  autolink.initiator = station.user_id
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE station.id = sproperty.station_id AND sproperty.address_id = address.id AND station.stationtype_id = stationtype.id AND autolink.responder = $id AND autolink.status = 'linked'  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, station.created_at ";
        }

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));

        return json_encode($stations);
    }

    public function station_selection_get_product(Request $request, $id)
    {

        if($request->area_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id AND stationarea.area_id = " . $request->area_id . "
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN stationsproduct ON  station.id = stationsproduct.station_id
			JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND s2.area_id = " . $request->area_id ." AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE address.area_id = $request->area_id AND sproduct.product_id = $id ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC,station.osmall_commission DESC, last_selection ASC, station.created_at ";
        } else if($request->city_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN stationsproduct ON  station.id = stationsproduct.station_id
			JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE city.id = $request->city_id AND sproduct.product_id = $id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        } else if($request->state_id != ""){
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
            $sqlfrom = " FROM station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			LEFT JOIN state ON city.state_code = state.code
			JOIN stationsproduct ON  station.id = stationsproduct.station_id
			JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE state.id = $request->state_id AND sproduct.product_id = $id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, isautolinked DESC, last_selection ASC, station.created_at ";
        } else {
            $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid  ";
            $sqlfrom = " FROM address, sproperty, stationtype, station ";
            $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN stationsproduct ON  station.id = stationsproduct.station_id
			JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			";
            $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
            $sqlwhere = " WHERE station.id = sproperty.station_id AND sproperty.address_id = address.id AND station.stationtype_id = stationtype.id AND sproduct.product_id = $id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";
        }

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));

        return json_encode($stations);
    }

    public function station_selection_get_city(Request $request, $id)
    {

        $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
        $sqlfrom = " FROM station ";
        $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
        $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
        $sqlwhere = " WHERE city.id = $id ";
        $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        if($request->product_id != ""){
            $sqlleftJoin .= " JOIN stationsproduct ON  station.id = stationsproduct.station_id
				JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id ";
            $sqlwhere .= " AND sproduct.product_id = $request->product_id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        } else if($request->merchant_id != ""){
            $sqlleftJoin .= " JOIN autolink ON  autolink.initiator = station.user_id ";
            $sqlwhere .= " AND autolink.responder = $request->merchant_id AND autolink.status = 'linked' ";
        }

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));

        return json_encode($stations);
    }

    public function station_selection_get_state(Request $request, $id)
    {

        $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
        $sqlfrom = " FROM station ";
        $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id 
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			LEFT JOIN state ON city.state_code = state.code
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
        $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
        $sqlwhere = " WHERE state.id = $id ";
        $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        if($request->product_id != ""){
            $sqlleftJoin .= " JOIN stationsproduct ON  station.id = stationsproduct.station_id
				JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id ";
            $sqlwhere .= " AND sproduct.product_id = $request->product_id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";
        } else if($request->merchant_id != ""){
            $sqlleftJoin .= " JOIN autolink ON  autolink.initiator = station.user_id ";
            $sqlwhere .= " AND autolink.responder = $request->merchant_id AND autolink.status = 'linked' ";
        }

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));

        return json_encode($stations);
    }

    public function station_selection_get($id)
    {

        $sqlselect = "SELECT DISTINCT station.*, s2.created_at as last_selection, osmall_merchant.id as isautolinked, nsellerid.nseller_id as nid ";
        $sqlfrom = " FROM station ";
        $sqlleftJoin = " LEFT JOIN stationarea ON station.id = stationarea.station_id AND stationarea.area_id = " . $id . "
			LEFT JOIN autolink as osmall_merchant ON station.user_id = osmall_merchant.initiator AND osmall_merchant.responder = 109
			JOIN sproperty ON station.id = sproperty.station_id
			JOIN address ON sproperty.address_id = address.id 
			JOIN nsellerid ON nsellerid.user_id = station.user_id
			LEFT JOIN city ON address.city_id = city.id
			JOIN stationtype ON  station.stationtype_id = stationtype.id ";
        $sqlleftouterJoin = " LEFT OUTER JOIN stationarea s2 ON station.id = s2.station_id AND s2.area_id = " . $id ." AND (stationarea.created_at = s2.created_at OR stationarea.created_at < s2.created_at AND stationarea.id < s2.id) ";
        $sqlwhere = " WHERE address.area_id = $id ";
        $sqlorder = " ORDER BY last_selection IS NULL DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";

        if($request->product_id != ""){
            $sqlleftJoin .= " JOIN stationsproduct ON  station.id = stationsproduct.station_id
				JOIN sproduct ON  sproduct.id = stationsproduct.sproduct_id ";
            $sqlwhere .= " AND sproduct.product_id = $request->product_id  ";
            $sqlorder = " ORDER BY last_selection IS NULL DESC, stationsproduct.fair_commission DESC, station.osmall_commission DESC, last_selection ASC, station.created_at ";
        } else if($request->merchant_id != ""){
            $sqlleftJoin .= " JOIN autolink ON  autolink.initiator = station.user_id ";
            $sqlwhere .= " AND autolink.responder = $request->merchant_id AND autolink.status = 'linked' ";
        }

        $sqltotal = $sqlselect . $sqlfrom . $sqlleftJoin . $sqlleftouterJoin . $sqlwhere . $sqlorder;

        $stations = DB::select(DB::raw($sqltotal));


        return json_encode($stations);
    }
}
