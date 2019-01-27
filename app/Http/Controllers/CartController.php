<?php
//
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Http\Controllers\EmailController;
use App\Models\OpenWishPledge;
use App\Models\Owarehouse_pledge;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Category;
use App\OWish;
use App\Models\PRef;
use App\Models\Cart as DBCart;
use App\Jobs\OpenwishPledgeJob;
use Cart;
use Log;
use App\Classes\SecurityIDGenerator;
use App\Classes\Delivery;

use App\Classes\StationIntelligence;
use App\Models\Product;
use App\Models\PGP;
use App\Models\PaymentRequest;
use App\Models\PaymentResponse;
use App\Models\GlobalT;
use App\Models\POrder;
use App\Models\SOrder;
use App\Models\OrderProduct;
use App\Models\Ocredit;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Address;
use App\Models\Receipt;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderProduct;
use App\Models\User;
use App\Models\Payment;
use App\Models\OpenWish;
use App\Models\SalesStaff;
// use App\Models\OpenWishPledge;
use Input;
use Redirect;
use Auth;
use Session;
use URL;
use Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Globals;
use Mailgun\Mailgun;
//use App\Classes\PiwikTracker;

/*
Bugs
Delivery Total should come from cart
attach product delivery to button
*/ 


/* Define Global URL for Matomo/Piwik Server */
//PiwikTracker::$URL = 'https://zeta.opensupermall.com/piwik.php';


define('IDSITE', 1);

class CartController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $buffer=999999999;
    public function index() {
        $viewfile="cartview";
        $is_mobile=false;
        $is_mobile=UtilityController::is_mobile();
        if($is_mobile)$viewfile="mobile.cartview";
        

        $showMessage=0;
        $cartMessage="The following product(s) have been removed from cart <br>";
       
        $cartProducts = Cart::contents();
        $deliveryWaiverProduct=array();
        $deliveryWaiverMerchant=array();
        foreach ($cartProducts as $key => $cartProduct) {
            if ($cartProduct->mode =="rfee") {
                $mid=$cartProduct->merchant_id;
                $merchant=Merchant::find($mid);
                $cartProducts[$key]->mid =$mid;
                $cartProducts[$key]->oshop =$merchant->oshop;
                $cartProducts[$key]->company =$merchant->company;
            } elseif ($cartProduct->mode =="adjustment"){
			} elseif ($cartProduct->mode == "token" or $cartProduct->page =="token") {
                $mid=$cartProduct->merchant_id;
                $merchant=Merchant::find($mid);
                $cartProducts[$key]->mid =$mid;
           //     $cartProducts[$key]->oshop =$merchant->oshop;
                $cartProducts[$key]->company =$merchant->company;
            } else {
                $id = $cartProduct->id;
                $p= Product::find($id);
                $cartProduct->available=$p->available;
                $dS=UtilityController::deliveryStatus($id);
                if ($dS['type'] == "merchant" and !array_key_exists($cartProduct->merchant_id,$deliveryWaiverMerchant) ) {
                    $deliveryWaiverMerchant[$cartProduct->mid]=$dS['amount'];
                }elseif ($dS['type'] == "product") {
                    $deliveryWaiverProduct[$cartProduct->parent_id]=$dS['amount'];
                }
                $del=new Delivery;
                $cartProduct->delivery_price=$del->get_delivery_price($cartProduct->id,$cartProduct->quantity)/100;
                $cartProduct->actual_delivery_price=$del->get_delivery_price($cartProduct->id,$cartProduct->quantity,False)/100;
                if ($p->available==0) {
                    $cartMessage.=$p->name.", because it is out of stock!<br>";
                    $cartProduct->remove();
                    $showMessage=1;
                } elseif ($p->oshop_selected==false) {
                    $cartMessage.=$p->name.", because it is no longer available for sale!<br>";
                    $cartProduct->remove();  
                    $showMessage=1; 
                } else {
                    $merchant = DB::select(DB::raw("SELECT m.id AS mid, m.oshop_name AS oshop, m.company_name AS company FROM users u , merchantproduct mp, merchant m WHERE mp.product_id = $id AND mp.merchant_id = m.id AND mp.deleted_at IS NULL AND m.user_id = u.id GROUP BY m.id"));
                    if(isset($merchant[0])){
                        $cartProducts[$key]->mid = $merchant[0]->mid;
                        $cartProducts[$key]->oshop = $merchant[0]->oshop;
                        $cartProducts[$key]->company = $merchant[0]->company;               
                    } else {
						$merchant_id=UtilityController::productMerchantId($id);
						$cartProducts[$key]->mid =$merchant_id;
						$merchant= Merchant::find($merchant_id);
						// $cartProducts[$key]->mid = 0;
						$cartProducts[$key]->oshop =$merchant->oshop;
						$cartProducts[$key]->company =$merchant->company;               
                    }
					$cartProducts[$key]->category =
						Category::where('id',$p->category_id)->pluck('description');
				}
			}
        }
        $oc_balance=0;
        
        $merchants = array();
        foreach ($cartProducts as $key => $cp) {
            if (!in_array($cp->mid, $merchants)){
                $merchants[$key] = $cp->mid;
            }
        }

        $products = array();
        foreach ($merchants as $m) {
            foreach ($cartProducts as $key => $cartP) {
                if ($cartP->mid == $m) {
                    $products[$m][$key] = $cartP;
                }
            }
        }
        
        $global = GlobalT::get(['ipay88_merchant_key',
            'ipay88_merchant_code'])->toArray();

        $merchantKey = $global[0]['ipay88_merchant_key'];
        $merchantCode = $global[0]['ipay88_merchant_code'];


        $arr = $this->getTotal();
		//dd($arr);
        $prodTotal = $arr[0]/100;
        $deliveryTotal = $arr[1]/100;

        $gstTotal=$arr[2]/100;
        // $total2 = number_format($prodTotal+$deliveryTotal, 2);
        $total2=$arr[0]/100+$arr[1];
    
        // return $total2;
        /********************* Demo/Test account ************************/
        $merchantKey = "t31B7FOsUf";
        $merchantCode = "M00568";
        $total = "1.00";
        /********************* Demo/Test account ************************/

        //$total = number_format($prodTotal+$deliveryTotal, 2);

        $currency = DB::table('currency')->where('active', 1)->first()->code;
        $countries = null;
        $user_country = null;
        $globalvar = Globals::where('id','1')->first();
        $globalvar = $globalvar->station_min_order;     
         $refNo = time(); 
        if (Auth::check()) {
            $address = Address::find(Auth::user()->shipping_address_id);
            if (is_null($address)) {
                try {
                     $address = Address::find(Auth::user()->
                        shipping_address_id);

                } catch (\Exception $e) {
                    $address=array();
                }
            }

            $oc_balance=UtilityController::ocredit()['ocredit'];
            if(isset($address)){
                $user_country = DB::table("country")
                ->join('city', 'city.country_code', '=', 'country.code')
                ->join('address', 'address.city_id', '=', 'city.id')
                ->select('country.name as country')
                ->where('address.id', $address->id)
                ->first();
                if(!is_null($user_country)){
                    $countries = Country::where('name', '!=',
                    $user_country->country)->get()->sortBy('name');
                } else {
                    $user_country = $countries = null;
                }
                
            }
            else{
                $user_country = $countries = null;
            }

            /* Generate iPay88 Security Signature */
           // Using epoch as a refNo!

            /* Need to scrub $total of decimal place, and thousands separator */
            $total1 = str_replace('.','',$total);
            $total_scrubbed = str_replace(',','',$total1);

            $src = $merchantKey.$merchantCode.$refNo.$total_scrubbed.$currency;
            $signature = $this->iPay88_signature($src);

		  //	dd(Cart::contents());
          
            // dd($viewfile);
            return view($viewfile,compact('deliveryWaiverMerchant','deliveryWaiverProduct'))->with(array(
                        'merchantsAndProducts' => $products,
                        'merchantCode' => $merchantCode,
                        'merchantKey' => $merchantKey,
                        'signature' => $signature,
                        'refNo' => $refNo,
                        'globalvar' => $globalvar,
                        'total' => $total,
                        'prodTotal' => $prodTotal,
                        'deliveryTotal' => $deliveryTotal,
                        'address' => $address,
                        'currency' => $currency,
                       // 'products' => $products,
                        'gst'=>$gstTotal,
                        'countries' => $countries,
                        'address' => $address,
                        'user_country' => $user_country,
                        'grandtotal'=>$total2,
                        'ocb'=>$oc_balance,
                        'showMessage'=>$showMessage,
                        'cartMessage'=>$cartMessage
            ));

        } else {

            /* This is for anonymous buyer */
            $address = Address::find(1);
            $country = Country::all();

            $countries_collection = new \Illuminate\Support\Collection($country);
            $countries = $countries_collection->sortBy('name');
            
            return view($viewfile)->with(array(
				'merchantsAndProducts' => $products,
				'merchantCode' => $merchantCode,
				'merchantKey' => $merchantKey,
				'globalvar' => $globalvar,
				'total' => $total,
				'currency' => $currency,
				 'refNo' => $refNo,
			  //  'products' => $products,
				'address' => $address,
				'countries' => $countries,
				'grandtotal'=>$total2,
				'ocb'=>$oc_balance,
				'gst'=>$gstTotal,
				'showMessage'=>$showMessage,
				'cartMessage'=>$cartMessage
            ));
        }

       // return view('cartview')->with('merchantsAndProducts', $products);
    }

    public function cartItemChanges()
    {
        $ret="";
        $cc= Cart::contents();
        foreach ($cc as $c) {
            
        }
    }

    public function cartmerchant($id) {
        Cart::destroy();
        $mid = $id;
        $product = Product::where('name', 'Merchant Annual Subscription Fee')->first();
        $quantity = 1;
        $name = $product->name;
        $image = '';
        $price = $product->retail_price;      

        Cart::insert(array(
            'id' => $product->id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => '',
            'page'=> ''
        ));
        
        $cartProducts = Cart::contents();
        foreach ($cartProducts as $key => $cartProduct) {
            $id = $cartProduct->id;
            $merchant = DB::select(DB::raw("SELECT m.id AS mid, m.oshop_name AS oshop, m.company_name AS company FROM users u , merchantproduct mp, merchant m WHERE mp.product_id = $id AND mp.merchant_id = m.id AND m.user_id = u.id AND mp.deleted_at IS NULL GROUP BY m.id"));
            $cartProducts[$key]->mid = $merchant[0]->mid;
            $cartProducts[$key]->oshop = $merchant[0]->oshop;
            $cartProducts[$key]->company = $merchant[0]->company;
        }

        $merchants = array();
        foreach ($cartProducts as $key => $cp) {
            if (!in_array($cp->mid, $merchants)){
                $merchants[$key] = $cp->mid;
            }
        }

        $products = array();
        foreach ($merchants as $m) {
            foreach ($cartProducts as $key => $cartP) {
                if ($cartP->mid == $m) {
                    $products[$m][$key] = $cartP;
                }
            }
        }

        // dd($products);

        return view('cartview')->
            with('merchantsAndProducts', $products)->
            with('merchant_id', $mid);
    }   
    
    public function cartstation($id) {
        Cart::destroy();
        $sid = $id;
        $product = Product::where('name', 'Station Annual Subscription Fee')->first();
        $quantity = 1;
        $name = $product->name;
        $image = '';
        $price = $product->retail_price;      

        Cart::insert(array(
            'id' => $product->id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'available'=>$product->available,
            'image' => '',
            'page'=> ''
        ));
        
        $cartProducts = Cart::contents();
        foreach ($cartProducts as $key => $cartProduct) {
            $id = $cartProduct->id;
            $merchant = DB::select(DB::raw("SELECT m.id AS mid, m.oshop_name AS oshop, m.company_name AS company FROM users u , merchantproduct mp, merchant m WHERE mp.product_id = $id AND mp.merchant_id = m.id AND m.user_id = u.id GROUP BY m.id"));
            $cartProducts[$key]->mid = $merchant[0]->mid;
            $cartProducts[$key]->oshop = $merchant[0]->oshop;
            $cartProducts[$key]->company = $merchant[0]->company;
        }

        $merchants = array();
        foreach ($cartProducts as $key => $cp) {
            if (!in_array($cp->mid, $merchants)){
                $merchants[$key] = $cp->mid;
            }
        }

        $products = array();
        foreach ($merchants as $m) {
            foreach ($cartProducts as $key => $cartP) {
                if ($cartP->mid == $m) {
                    $products[$m][$key] = $cartP;
                }
            }
        }

        $global = DB::table('global')->first();
        $isstation = 0;
        if($global->station_annual_subscription_fee > 0 ){
            $isstation = 1;
        }

        return view('cartview')->
            with('merchantsAndProducts', $products)->
            with('merchant_id', $sid)->
            with('isstation', $isstation);
    }       

    public function postMultipleAddTocart() {
        $insertData = Input::get('product');
        foreach ($insertData as $pId => $selectedProduct) {
            Cart::insert(array(
                'id' => $selectedProduct['id'],
                'name' => $selectedProduct['name'],
                'price' => $selectedProduct['special_price'],
                'quantity' => $selectedProduct['qty'],
                'image' => $selectedProduct['image']
            ));
        }
        return redirect('cart');
    }

    public function postAddtocart() {
        if (Request::ajax()) {
            $product = Product::where('id', Input::get('id'))->first();
            // Price not by Input Get Price
			$product_parent = Product::where('id', $product->parent_id)->first();
            if ($product->discounted_price>0 and $product->retail_price>$product->discounted_price) {
                $price=$product->discounted_price;

            } else {
                $price=$product->retail_price;
            }
            // $price = Input::get('price');
            $quantity = Input::get('quantity');
        

            $pr= new PriceController;
   

            $name = $product->name;
            $image = $product->photo_1;
            
            // Check for gst
            $gst_rate=Globals::first()->gst_rate;
            $mp=DB::table('merchantproduct')->where('product_id',$product_parent->id)->whereNull('deleted_at')->first();



            $gst= new PriceController;
            $gstprice= $gst->init($product->id,'gst',Input::get('delivery_price'));
            $del=new Delivery;
            
            $page = Input::get('page');
		
            if ($page == 'owarehouse') {
                Session::put('page', 'owarehouse');
                $price = Input::get('price');
                $hyper_id=Input::get('owarehouse_id');
				$delivery_price = Input::get('delivery_price');
                // If type != "b2c" and merchantproduct has NO record and product.parent_id = merchantproduct.merchant_id, then product.parent_id is the merchant_id
                // $product= Product::find($product->id);
                // $mpExists=DB::table('merchantproduct')->where('product_id',$product->id)
                // if ($product->type!="b2c") {
                
                // }
                Cart::insert(array(
                    'id' => $product->id,
                    'parent_id' => Input::get('parent_id'),
                    'hyper_id'=>$hyper_id,
                    'name' => $name,
                    'price' => $price*100,
                    'quantity' => $quantity,
                    'image' => $image,
                    'gst'=>$gstprice,
                    'delivery_price'=>$delivery_price,
                    'available'=>$product->available,
                    'actual_delivery_price'=>$delivery_price,
                    'mode'=>'hyper',
                    'page'=>'owarehouse'
                ));
            } elseif ($page == 'productconsumerdisc') {
                foreach (Cart::contents() as $i){
                if ($i->id==$product->id) {
                        $i->remove();
                    }
                }
				$price = Input::get('price');
                $delivery_price=$del->get_delivery_price($product->id,$quantity)/100;
                $actual_delivery_price=$del->get_delivery_price($product->id,$quantity,False)/100;
                Cart::insert(array(
                    'id' => $product->id,
                    'parent_id' => $product->id,
                    'name' => $name,
                    'price' => $price,
                    'available'=>$product->available,
                    'delivery_price' => $delivery_price,
                    'actual_delivery_price'=>$delivery_price,
                    'quantity' => $quantity,
                    'image' => $image,
                    'gst'=>$gstprice,
					'mode'=>'disc',
                    'page'=>'productconsumerdisc'
                ));
            } 


            else {
				if($page == 'b2b'){
					$price = Input::get('price');
				}
				$delivery_price=$del->get_delivery_price($product->id,$quantity)/100;
                $actual_delivery_price=$del->get_delivery_price($product->id,$quantity,False)/100;
                Cart::insert(array(
                    'id' => $product->id,
                    'parent_id' => $product->parent_id,
                    'name' => $name,
                    'price' => $price,
                    'available'=>$product->available,
                    'delivery_price' => $delivery_price,
                    'actual_delivery_price'=>$delivery_price,
                    'quantity' => $quantity,
                    'image' => $image,
                    'gst'=>$gstprice,
                    'page'=>$page,
                    'mode'=>'b2c'
                ));
            }
            $currency=Currency::where('active',1)->pluck('code');
            $data[0] = Cart::totalItems();
            $data[1] = $product->name." ".$currency;
            $data[2] = $product->id;
            $this->deliveryMerchantValidation();
            return $data;
        }
    }

    public function getRemoveitem($identifier) {
        $item = Cart::item($identifier);        
        try{
            if($item->page == 'owarehouse'){
                $owarehouse = DB::table('owarehouse')->where('product_id',$item->id)->first();
                if(!is_null($owarehouse)){
                    if (Auth::check()) {
                        $pledge = DB::table('owarehousepledge')->where('owarehouse_id',$owarehouse->id)->where('user_id',Auth::user()->id)->delete();
                        if(!is_null($pledge)){
                            //DB::table('owarehousepledge')->
                        }
                    }
                }
            }   
            $item->remove();
        } catch (\Exception $e) {               
        }   

        
       //dd($item->id);
        return Redirect::to('cart');
    }

    public function getPayment() {
        Session::put('requestReferrer', URL::previous());
        $products = Cart::contents();

        $global = GlobalT::get(['ipay88_merchant_key', 'ipay88_merchant_code'])->toArray();

        $merchantKey = $global[0]['ipay88_merchant_key'];
        $merchantCode = $global[0]['ipay88_merchant_code'];

        // $getTotal = Cart::total();   // $this->getTotal() will provide with total+delivery
        $getTotal = Input::get('amount');
        $currency = DB::table('currency')->where('active', 1)->first()->code;
        $countries = null;
        $user_country = null;
        $globalvar = Globals::where('id','1')->first();
        $globalvar = $globalvar->station_min_order;

        if (Auth::check()) {
            $address = Address::find(Auth::user()->shipping_address_id);

            if(isset($address)){
                $user_country = DB::table("country")
                ->join('city', 'city.country_code', '=', 'country.code')
                ->join('address', 'address.city_id', '=', 'city.id')
                ->select('country.name as country')
                ->where('address.id', $address->id)
                ->first();

                $countries = Country::where('name', '!=',
                    $user_country->country)->get()->sortBy('name');
            } else {
                $user_country = $countries = null;
            }

            return view('payment')->with(array(
				'merchantCode' => $merchantCode,
				'merchantKey' => $merchantKey,
				'globalvar' => $globalvar,
				'total' => $getTotal,
				'$address' => $address,
				'currency' => $currency,
				'products' => $products,
				'countries' => $countries,
				'address' => $address,
				'user_country' => $user_country,
            ));
        } else {
            $address = Address::find(1);
            $country = Country::all();

            $countries_collection = new \Illuminate\Support\Collection($country);
            $countries = $countries_collection->sortBy('name');
            return view('payment')->with(array(
				'merchantCode' => $merchantCode,
				'merchantKey' => $merchantKey,
				'globalvar' => $globalvar,
				'total' => $getTotal,
				'currency' => $currency,
				'products' => $products,
				'address' => $address,
				'countries' => $countries,
            ));
        }
    }

    public function deliveryMerchantValidation()
    {   
        /*Works with delivery waiver*/ 
        $merchantTotal=array();
        $adjustments=array();
        $ret=array();
        // $buffer=99999999999
        foreach (Cart::contents() as $k => $v) {
            $v->mid=UtilityController::productMerchantId($v->id);
            $mid=$v->mid;
            // $merchantTotal[$mid]['identifiers']=[];
            // $merchantTotal[$mid]['total']=0;
            // $merchantTotal[$mid]['delivery']=0;
            if ($v->mode == "adjustment") {
                $id=$this->buffer.$v->mid;
                $adjustments[$id]=$v->identifier;
                
            } else {
                $temp=array();
                $product=Product::find($v->id);
                $plimit=$product->free_delivery_with_purchase_amt;
                $cost=$v->price * $v->quantity;
                if ($plimit <= $cost and !is_null($plimit) and $plimit !=0) {
                    
                    $v->delivery_price=0;
                    try {
                        $merchantTotal[$mid]['total']+=($v->price*$v->quantity);
                        $merchantTotal[$mid]['delivery']+=($v->delivery_price*100);
                    } catch (\Exception $e) {

                        $merchantTotal[$mid]['total']=($v->price*$v->quantity);
                        $merchantTotal[$mid]['delivery']=($v->delivery_price*100);
                    }
                    try {
                        array_push($merchantTotal[$mid]['identifiers'],$v->identifier);
                    } catch (\Exception $e) {
                        $merchantTotal[$mid]['identifiers']=[];
                        array_push($merchantTotal[$mid]['identifiers'],$v->identifier);
                    }
                    
                } else {
                    $v->delivery_price=$v->actual_delivery_price;
                }
            }
        }
      
        foreach ($merchantTotal as $mid => $Array) {
            $merchant=Merchant::find($mid);
            $limit=$merchant->delivery_waiver_min_amt;
       
            $id=$this->buffer.$v->mid;
            $adj=0;
            if ($limit <= $Array['total']) {
                // Make Delivery zero
                foreach (Cart::contents() as $item) {
                    if (in_array($item->identifier,$Array['identifiers'])) {
                        $item->delivery_price=0;
                        $adj+=$item->actual_delivery_price;
                        
                    }
                $ret[$v->mid]=$adj;
                    
                }
            }else{
                //Make delivery back

                foreach (Cart::contents() as $item) {
                    if (in_array($item->identifier,$Array['identifiers'])) {
                        $item->delivery_price=$item->actual_delivery_price;
                    }
                }
                unset($ret[$v->mid]);
            }
        }
    
        return $ret;
    }
    public function cartSum() {

        $item_id = Input::get('id');
        $item_quantity = Input::get('quantity');
        /*
            Validation
        */
        foreach (Cart::contents() as $item) {
            $item->available=Product::find($item->id)->available;

        }
        $product=Product::find($item_id);
        $available=0;
        if (!is_null($product)) {
            $available=$product->available;
        }
        if ($item_quantity<=$available) {
            # code...
            try {
                $scheck=Session::get('checkout');
                if ($scheck!=1) {
                    $cart_products = Cart::contents();

                    foreach ($cart_products as $cart_product) {
                $id = $cart_product->id;
                if ($id == $item_id) {
                    $cart_product->quantity = $item_quantity;
                    $del=new Delivery;
                    $cart_product->delivery_price=$del->get_delivery_price($id,$item_quantity);
                    $cart_product->actual_delivery_price=$del->get_delivery_price($id,$item_quantity,Fale);
                }
                    }
                }else{
                // Session::put('checkout',1);
                 }
            } catch (\Exception $e) {
            
            }
        }



        $adjustments=$this->deliveryMerchantValidation();
        $arr = $this->getTotal(); // $this->getTotal() will provide total+delivery
        // return $arr[1];
		$prodTotal = $arr[0]/100;
        $deliveryTotal = $arr[1]/100;

        $gstTotal=$arr[2]/100;
        // Keep Track for merchant waiver

        $total2=$arr[0]/100+$arr[1];
       
        
        $ret['status']=$this->cartItemsMerchantInfo();
        $ret['adjustments']=$adjustments;
        $ret['delivery']=$this->deliverys();
        $ret['notify']=$this->notify();	
        $ret["total"]=$total2;
        return $ret;
        // return $cart_total/100;
    }

    public function notify()
    {
        $ret=array();
        foreach (Cart::contents() as $item) {
            $product=Product::find($item->id);
            /*
                Need to add mode validation for $item ~Zurez
            */ 
            if (1==1 and !is_null($product)) {
                if ($product->available < $item->quantity) {
                    $ret[IdController::nP($item->id)]=$product->available;
                }

            }
        }
        return $ret;
    }

    public function deliverys()
    {
        $ret=array();
        foreach (Cart::contents() as $item) {
            // dump($item->id);
            // dump($item->mid);
            // dump($ret);
            $del=new Delivery;
              try {
                $delivery_price=$del->get_delivery_price(
                        $item->id,$item->quantity);
                $delivery_price=number_format(
                    $delivery_price/100,2);
                 $temp=[IdController::nP($item->id),$delivery_price];
                  array_push($ret[$item->mid],$temp);
              } catch (\Exception $e) {
                // dump($e);
                  $ret[$item->mid]=array();
                  array_push($ret[$item->mid],$temp);
                  
              }
                
        }
        // dump($ret);
        return $ret;
    }

    public function totalItems()
    {
        # code...
        return Cart::totalItems();
    }

    public function getRequestResponse() {
        $payment_requests = PaymentRequest::all();
        $payment_responses = PaymentResponse::all();
        return view('payment_request_response')->with(array(
                    'payment_requests' => $payment_requests,
                    'payment_responses' => $payment_responses
        ));
	}

    public static function complete_successful_transaction($user_id,
        $ref_no,$amount,$transaction_id)
    {
        /*
        Validation Block
            Use ctrans table to validate against.
            Validate Cart Identifier.
            Validate Amount [Missing on purpose]
            Validate (Optional) Buyer

            Do the transaction Block
            Assuming all the above validations have passed.
        */ 

		/* Initialize PiwikTracking API */
		/*$pt = new PiwikTracker($idSite = IDSITE);
		$pt->setNewVisitorId();
		Log::debug("PiwikTracker:".json_encode($pt));
*/
		Log::debug("CartController::complete_successful_transaction|".
            $user_id."|".$ref_no."|".$transaction_id);

        try {
             // $identifiers=DB::table('ctrans')->where('ref_no',$ref_no)->lists('cart_id');
            $user=User::find($user_id);
            $address = Address::find($user->default_address_id); 
            $address_id=$address->id;
            $identifiers=DB::table('ctrans')->
                where('ref_no',$ref_no)->lists('cart_id');

			Log::debug('identifiers='.json_encode($identifiers));

            $comm_prcnt=DB::table('global')->first()->osmall_commission;
            $comm_amnt= ($comm_prcnt*$amount)/100;
            $py= new Payment;
            $py->receivable=$amount*100; //Cents not MYR
            $py->osmall_commission=$comm_amnt;
            $py->status="paid";
            $py->note=$transaction_id;
            $py->save();

			Log::debug('payment='.json_encode($py));

            $m_p_record=array();
            $items=DBCart::whereIn('identifier',$identifiers)->
                groupBy('identifier')->where('status','active')->get();

			Log::debug('ITEM:'.json_encode($items));

			$c = 0;
            foreach ($items as $item){
				$c += 1;

				Log::debug($c.". mode=".$item->mode);
				Log::debug("item->identifier=".$item->identifier);
				Log::debug("identifiers=".json_encode($identifiers));
			
                if(in_array($item->identifier, $identifiers)) {

					Log::debug("INSIDE in_array()");

                    if ($item->mode=="owish") {
                        $email = $user->email;
                        $openwish_id=$item->openwish_id;
                        $data = array(
                            'openwish_id'    => $openwish_id,
                            'smedia_id'      => 1, //i am not sure whats fb
                            'smedia_account' => $email,
                            'source_ip'      => '0.0.0.0',
                            'pledged_amt'    => $item->pledged_amt*100,
                        );
                        $this->dispatch( new OpenwishPledgeJob($data) );
                        $pledge_ocredit=new Ocredit;
                        $sidg= new SecurityIDGenerator;
                        $security_id= $sidg->generate(Carbon::now()->toDateString());
                        $pledge_ocredit->security_id=$security_id;
                        $pledge_ocredit->value=($item->pledged_amt*100)+($item->actual_delivery_price*100);
                        $pledge_ocredit->mode="debit";
                        $pledge_ocredit->openwish_id=$openwish_id;
                        $pledge_ocredit->save(); 
                        $item->remove();
                   
                    } else if ($item->mode == "rfee"){
                        CREController::processCREOrder($item->product_id);

                    } else if ($item->mode=="hyper" or
                               $item->page=="owarehouse") {
                        $owarehouse_id= $item->hyper_id;
                        $owarehousepledge = new Owarehouse_pledge();
                        $owarehousepledge->owarehouse_id =$owarehouse_id;
                        $owarehousepledge->user_id=$user_id;
                        $owarehousepledge->status='executed';
                        $owarehousepledge->pledged_qty =$item->quantity;

                        if(!$owarehousepledge->save()){
                            $data['status'] = 'error';
                        } else {
                            $data['status'] = 'success';
                            $producthyper = DB::table('product')->
                                where('segment','hyper')->
                                where('parent_id',$item->parent_id)->
                                first();

                            if(!is_null($producthyper)){
                                $available = $producthyper->available -
                                    $item->quantity;

                                DB::table('product')->
                                    where('segment','hyper')->
                                    where('parent_id',$item->parent_id)->
                                    update(['available'=>$available]);
                            }
                        }

                        if (array_key_exists($item->merchant_id,
                            $m_p_record)) {
                            array_push($m_p_record[$item->merchant_id],
                                $item->identifier);

                        } else {
                            $m_p_record[$item->merchant_id]=array();
                            array_push($m_p_record[$item->merchant_id],
                                $item->identifier);
                        }

                    } else if ($item->mode == "owishbn"){
                        $cartItem=$item;
                        $this->processOwishBN($cartItem,$py->id,$ref_no);
                        $email =$user->email;
                        $openwish_id=$item->openwish_id;
                        $data = array(
                            'openwish_id'    => $openwish_id,
                            'smedia_id'      => 1, //i am not sure whats fb
                            'smedia_account' => $email,
                            'source_ip'      => '0.0.0.0',
                            'pledged_amt'    => $item->price,
                        );
                        $this->dispatch( new OpenwishPledgeJob($data) );
                        $pledge_ocredit=new Ocredit;
                        $sidg= new SecurityIDGenerator;
                        $security_id= $sidg->generate(Carbon::now()->toDateString());
                        $pledge_ocredit->security_id=$security_id;
                        $pledge_ocredit->value=($item->price)+($item->actual_delivery_price*100);
                        $pledge_ocredit->mode="debit";
                        $pledge_ocredit->openwish_id=$openwish_id;
                        $pledge_ocredit->save(); 
                        $item->remove();
                        
                    } else if ($item->mode=="token") {
						$checktoken = DB::table('userstoken')->
							where('user_id',$user_id)->first();

						if(is_null($checktoken)){
							DB::table('userstoken')->insert([
								'user_id'=>$user_id,
								'qty'=>($item->quantity*($item->tokenquantity/100)),
								'created_at'=> date('Y-m-d H:i:s'),
								'updated_at'=> date('Y-m-d H:i:s')]);
							
						} else {
							$nquantity = $checktoken->qty + ($item->quantity *
								($item->tokenquantity/100));
							DB::table('userstoken')->
								update([
									'qty'=>$nquantity,
									'updated_at'=> date('Y-m-d H:i:s')]);
						}

						DB::table('boughttokenlog')->insert([
							'user_id'=>$user_id,
							'quantity'=>($item->quantity * ($item->tokenquantity/100)),
							'created_at'=> date('Y-m-d H:i:s'),
							'updated_at'=> date('Y-m-d H:i:s')]);

						if (array_key_exists($item->mid,$m_p_record)) {
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

	    				if (!array_key_exists($item->mid,$m_p_record)) {
	    					$m_p_record[$item->mid]=array();
	    					array_push($m_p_record[$item->mid],$item->identifier);
	    				}

					} else {
						Log::debug('INSIDE else()');

                        if (array_key_exists($item->merchant_id,$m_p_record)) {
                            array_push($m_p_record[$item->merchant_id],
                                $item->identifier);

                        } else {
                            $m_p_record[$item->merchant_id]=array();
                            array_push($m_p_record[$item->merchant_id],
                                $item->identifier);
						}

						/*
                        if (!array_key_exists($item->merchant_id,$m_p_record)) {
                            $m_p_record[$item->merchant_id]=array();
                            array_push($m_p_record[$item->merchant_id],
                                $item->identifier);
                        }
						*/

						Log::debug('m_p_record='.json_encode($m_p_record));
                    } 
                } //if block  
            } //foreach 

			Log::debug('AFTER foreach LOOP');

            $pr_po_record=array();
            $global=DB::table('global')->first();

			Log::debug('m_p_record='.json_encode($m_p_record));

			/* Order Loop, one per Merchant */
            foreach ($m_p_record as $k => $v) {
                // Create one porder for each
                $p= new POrder;
                $p->user_id=$user_id;
                $p->courier_id=0; //should be something else
                $p->address_id=$address_id; //should be something else
                $p->payment_id=$py->id; //0 for ocredit| No More
                $p->order_administration_fee=$global->order_administration_fee;
                $p->status="pending";
                // PorderPaymentGateway
                //dd($p);
                $p->osmall_comm_percent=$global->osmall_commission;
                $p->smm_comm_percent=$global->smm_commission;
                $p->ow_comm_percent=$global->ow_commission;
                $p->log_comm_percent=$global->logistic_commission;

				Log::debug('porder='.json_encode($p));
                
                // ToDO add mode
                // Mail to merchant
                try {
                    $merchant_user_id=DB::table('merchant')->
                        where('id',$k)->first()->user_id;

                    $merchant_email=User::find($merchant_user_id)->email;
                   
                } catch (\Exception $e) {
                    $merchant_email="";
                }

                $p->save();
                $pgp= new PGP;
                $pgp->payment_gateway_id=2; //for fpx
                $pgp->porder_id=$p->id;
                $pgp->save();
                $station_picked = 0;

				Log::debug('BEFORE Station Intelligence');
                
                try{
                    $sint= new StationIntelligence;
                    if($pick_station == 0){
                        $station_picked =
                            $sint->get_station($address, $m_p_record[$k]);
                    } else {
                        $station_picked = $pick_station;
                    }

                    if($station_picked > 0){
                        $so= new SOrder;
                        $so->station_id=$station_picked;
                        $so->porder_id=$p->id; 
                        $so->save();
                        $stationarea = DB::table('station')->
                            where('station.id',$station_picked)->
                            join('address','station.station_address_id',
                                '=','address.id')->
                            select('address.area_id')->first();

                        if(!is_null($stationarea)){
                            if(!is_null($stationarea->area_id)){
                                DB::table('stationarea')->
                                    insert(['station_id'=>$station_picked,
                                    'area_id' => $stationarea->area_id,
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s')]);
                            }
                        }
                    }                      

                } catch (\Exception $e) {
                    //dd($e->getMessage());
                }

                $newpoid = UtilityController::generaluniqueid($p->id,
                    '1','1', $p->created_at, 'nporderid', 'nporder_id');

                DB::table('nporderid')->insert(['nporder_id'=>$newpoid,
                    'porder_id'=>$p->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')]);

                $a = new SecurityIDGenerator;
                $do_password = $a->generate(date('Y-m-d'));     
                $receipt_no = 0;
                if($station_picked > 0){
                    $station = DB::table('station')->
                        where('id',$station_picked)->first();

                    if(!is_null($station)){
                        $receipt_no = $station->receipt_no;
                        if(!is_null($receipt_no)){
                            $receipt_no++;
                        } else {
                            $receipt_no = 1;
                        }

                        //DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
                        DB::table('station')->
                            where('id',$station_picked)->
                            update(['receipt_no'=>$receipt_no]);
                    }                           

                } else {
                    $merchant = DB::table('merchant')->
                        where('id',$k)->first();

                    if(!is_null($merchant)){
                        $receipt_no = $merchant->receipt_no;
                        if(!is_null($receipt_no)){
                            $receipt_no++;
                        } else {
                            $receipt_no = 1;
                        }
                    //  DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
                        DB::table('merchant')->
                            where('id',$k)->
                            update(['receipt_no'=>$receipt_no]);
                    }
                }                   

				Log::debug('BEFORE Creating Receipt');

                $rc= new Receipt;
                $rc->porder_id=$p->id;
                $rc->receipt_no=$receipt_no;
                $rc->do_password=$do_password;
                $rc->save();

                UtilityController::createQr($rc->id,'receipt',
                    IdController::nO($p->id));

                // $r=DB::table('receipt')->insert([
                //      'porder_id'=>$p->id
                //      ]);

				Log::debug('BEFORE Creating Delivery Order');

                $do= new DeliveryOrder;
                $do->receipt_id=$rc->id;
                $do->status="pending";
                $do->save();
                $newdoid = UtilityController::generaluniqueid($do->id,'3',
                    '1', $do->created_at, 'ndeliveryorderid',
                    'ndeliveryorder_id');

                DB::table('ndeliveryorderid')->
                    insert(['ndeliveryorder_id'=>$newdoid,
                    'deliveryorder_id'=>$do->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')]);                  

                UtilityController::createQr($do->id,'deliveryorder',
                    IdController::nO($p->id));

                // Add to porderefno
                $r= new PRef;
                $r->ref_no=$ref_no;
                $r->porder_id=$p->id;
                $r->payment_mode='fpx';
                $r->save();


				Log::debug('BEFORE Commission Processing');

                $merchant_user_id=DB::table('merchant')->where('id',$k)->first()->user_id;
                $merchant_email=User::find($merchant_user_id)->email;

                $porder_value=0;
                $imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
                $imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $k)->where('status','linked')->count();
                $global=DB::table('global')->first();
                $merchant_commissions = DB::table('merchant')->where('id',$k)->first();
                $commission_type="std";
                $b2b_commission_type="std";
                
                if(is_null($merchant_commissions)){
                    $commission_type=$global->commission_type;
                    $b2b_commission_type=$global->b2b_commission_type;
                } else {
                    if($merchant_commissions->commission_type != "std" && $merchant_commissions->commission_type != "var" ){
                        $commission_type=$global->commission_type;
                    } else {
                        $commission_type=$merchant_commissions->commission_type;
                    }
                    
                    if($merchant_commissions->b2b_commission_type != "std" && $merchant_commissions->b2b_commission_type != "var" ){
                        $b2b_commission_type=$global->b2b_commission_type;
                    } else {
                        $b2b_commission_type=$merchant_commissions->b2b_commission_type;
                    }                       
                }
                $source_po = "";
                $source_po_global = "";
				$totalOPprice = 0;
				$totalDelprice = 0;
				$totalGST = 0;
				$totalODP = 0;
				$totalDisc = 0;

				/* Per Order Item Loop */
                foreach ($m_p_record[$k] as $l) {
                    // $l is identifier here
                    $cartItem=DBCart::where('identifier',$l)->where('status','active')->whereNull('deleted_at')->first();
                    $commission = 10;
                    $ptype ='b2c';
                    $product = DB::table('product')->where('id',$cartItem->product_id)->first();
                    if(!is_null($product)){
                        $ptype = $product->segment; 
                    }
                    if($ptype == 'b2b'){
                        if($b2b_commission_type ==  'std'){
                            if(is_null($merchant_commissions)){
                                $commission=$global->b2b_osmall_commission;
                            } else {
                                if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
                                    $commission=$global->b2b_osmall_commission;
                                } else {
                                    $commission=$merchant_commissions->b2b_osmall_commission;
                                }
                            }
                        } else {
                            if(is_null($product)){
                                $commission=$global->b2b_osmall_commission;
                            } else {
                                if($product->b2b_osmall_commission == null || $product->b2b_osmall_commission == 0 || $product->b2b_osmall_commission == ""){
                                    if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
                                        $commission=$global->b2b_osmall_commission;
                                    } else {
                                        $commission=$merchant_commissions->b2b_osmall_commission;
                                    }
                                } else {
                                    $commission=$product->b2b_osmall_commission;
                                }
                            }                               
                        }
                    } else {
                        if($commission_type ==  'std'){
                            if(is_null($merchant_commissions)){
                                $commission=$global->osmall_commission;
                            } else {
                                if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->osmall_commission == ""){
                                    $commission=$global->osmall_commission;
                                } else {
                                    $commission=$merchant_commissions->osmall_commission;
                                }
                            }
                        } else {
                            if(is_null($product)){
                                $commission=$global->osmall_commission;
                            } else {
                                if($product->osmall_commission == null || $product->osmall_commission == 0 || $product->osmall_commission == ""){
                                    if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
                                        $commission=$global->osmall_commission;
                                    } else {
                                        $commission=$merchant_commissions->osmall_commission;
                                    }
                                } else {
                                    $commission=$product->osmall_commission;
                                }
                            }                               
                        }                           
                    }
                    $source_now = "";
                    if($ptype == 'b2c'){
                        $source_now = 'b2c';
                    } else if($ptype == 'b2b'){
                        $source_now = 'b2b';
                    } else if($ptype == 'hyper'){
                        $source_now = 'hyper';
                    } else {
                        $source_now = 'b2c';
                    }
                    if($cartItem->mode == 'token'){
                        $source_now = 'token';
                    }
                    if($source_po == ""){
                        $source_po = $source_now;
                        $source_po_global = $source_now;
                    } else {
                        if($source_po == $source_now){
                            $source_po_global = $source_now;
                        } else {
                            $source_po_global = "mixed";
                        }
                    }                       
                    $porder_value+=$cartItem->price;
                    $osmall_commission_per=UtilityController::getCommission($cartItem->product_id);
                    $totalPrice=$cartItem->price+$cartItem->delivery_price * 100;
                    $osmall_commission=($osmall_commission_per*$totalPrice)/100;
                    $ssfcomm=0;

					if ($cartItem->mode=="smm") {
						$smmin=$cartItem->smmin_id;
						$s=SMMin::find($smmin);
						$sout=$s->smmout_id;
						$s->response="buy";
						$s->porder_id=$p->id;
						$s->quantity=$cartItem->quantity;
						$s->save();
				
						$ssfcomm=SMMController::getCommission($cartItem->id);
						$smmout=SMMout::find($sout);
						$smm_author=$smmout->user_id;
						$ssfc=SalesStaff::where('user_id',$smm_author)->where('type','smm')->first();
						// check if salesStaff exists
						if (is_null($ssfc)) {
							# code...
							$ssf= new SalesStaff;
							$ssf->type="smm";
							$ssf->commission=$ssfcomm;
							$ssf->user_id=Auth::user()->id;
							$ssf->save();
						} else {
							$ssf= SalesStaff::find($ssfc->id);
						
							$ssf->commission=$ssf->commission+$ssfcomm;
							
							$ssf->save();
							/*Add Opencredit to the SMM Author */
							$smm_ocredit=new Ocredit;
							$sidg= new SecurityIDGenerator;
							$security_id= $sidg->generate(Carbon::now()->toDateString());
							$smm_ocredit->security_id=$security_id;
							$smm_ocredit->value=$ssfcomm;
							$smm_ocredit->mode="credit";
							$smm_ocredit->smmout_id=$sout;
							$smm_ocredit->save(); 
						}
					}

                    $o= new OrderProduct;
                    $o->porder_id=$p->id;
                    $o->product_id=$cartItem->product_id;
                    $o->quantity=$cartItem->quantity;
                    $o->order_price=$cartItem->price;
                    $o->source=$source_now;


					/* Total Order Revenue */
					$price = $cartItem->price/100;
					$dprice = $cartItem->delivery_price/100;
                    $totalOPprice = $totalOPprice +
						($price*$cartItem->quantity)+ $dprice;

					/* Total Delivery Price */
					$totalDelprice = $totalDelprice + $dprice;

					/* Total GST amount */
					$gst = $global->gst_rate/100;
					$totalGST = $totalGST + ($price-($price/(1+$gst)));
					Log::debug('gst     ='.$gst);
					Log::debug('price   ='.$price);
					Log::debug('totalGST='.$totalGST);

					/* Total Order Delivery Price */
					$totalODP = $totalODP + $dprice;

					/* Total Discount Received (%) */
					$retailp = $product->retail_price/100;
					$totalDisc = $totalDisc +
						((($retailp - $price)*100)/$retailp);
					Log::debug('retailp   ='.$retailp);
					Log::debug('price     ='.$price);
					Log::debug('totalDisc ='.$totalDisc);

                    $pgfee=($global->payment_gateway_commission*$totalOPprice)/100;

                    $shippingCost=$cartItem->delivery_price *
						(1- ($global->logistic_commission/100));

                    $o->osmall_comm_amount=$osmall_commission;
                    //$o->paid_commission_rate=$commission;
                    $o->order_delivery_price=$cartItem->delivery_price * 100;
                    $o->payment_gateway_fee=$pgfee;
                    // $o->shipping_cost=$shippingCost;
                    $o->actual_delivery_price=$cartItem->actual_delivery_price * 100;
                    $o->save();

					Log::debug("OrderProduct Loop:".json_encode($o));
					Log::debug("cartItem:".json_encode($cartItem));

					/* Grab category */
					$catdesc = DB::table("product")->
						join("category","category.id","=",
							"product.category_id")->
						where("product.id","=",$cartItem->product_id)->
						pluck('category.description');

					Log::debug("catdesc=".$catdesc);

					/* Tracking Order items via Piwik/Matomo API */
					/*$pt->setURL('https://opensupermall.com/productconsumer/'.
						$cartItem->product_id);
					$pt->addEcommerceItem(
						$cartItem->product_id,
						$cartItem->product_name,
						$catdesc,
						floatval($cartItem->price/100),
						intval($cartItem->quantity));
					$pt->doTrackPageView('Retail Product Ordered');
					Log::debug("pt=".json_encode($pt));
					*/

                    if ($cartItem->mode=="smm") {
                        $smmin=$cartItem->smmin_id;
                        $s=SMMin::find($smmin);
                        $sout=$s->smmout_id;
                        $s->response="buy";
                        $s->porder_id=$p->id;
                        $s->quantity=$cartItem->quantity;
                        $s->save();
                
                        $ssfcomm=SMMController::getCommission($cartItem->
							product_id);
                        $ssfc=SalesStaff::where('user_id',$user_id)->
							where('type','smm')->first();

                        // check if salesStaff exists
                        if (is_null($ssfc)) {
							$ssf= new SalesStaff;
							$ssf->type="smm";
							$ssf->commission=$ssfcomm;
							$ssf->user_id=$user_id;
							$ssf->save();

                        } else {
							$ssf= SalesStaff::find($ssfc->id);
						
							$ssf->commission=$ssf->commission+$ssfcomm;
							
							$ssf->save();
							$smm_ocredit=new Ocredit;
							$sidg= new SecurityIDGenerator;
							$security_id= $sidg->
								generate(Carbon::now()->toDateString());
							$smm_ocredit->security_id=$security_id;
							$smm_ocredit->value=$ssfcomm;
							$smm_ocredit->mode="credit";
							$smm_ocredit->smmout_id=$sout;
							$smm_ocredit->save(); 
                        }
                    }

					Log::debug('BEFORE OpenCredit Processing');

                    $pr=Product::find($cartItem->product_id);
                    $oc=new Ocredit;
                    $dlp=DB::table('deliveryordersproduct')->insert([
                        'do_id'=>$do->id,
                        'product_id'=>$cartItem->product_id,
                        'status'=>'pending',
                        'quantity'=>$cartItem->quantity,
					]);

                } // Item Loop per Order

                //dd($source_po_global);
                
                $p->source=$source_po_global;
                $p->save();

				Log::debug('BEFORE email processing');
                
                $e= new EmailController;
                $e->sendRC($user->email,$p->id);
                
				Log::debug("POrder Loop: porder_id=".$p->id.":".
					json_encode($p));


				Log::debug("totalOPprice =".$totalOPprice);
				Log::debug("totalDelprice=".$totalDelprice);
				Log::debug("totalGST     =".$totalGST);
				Log::debug("totalODP     =".$totalODP);
				Log::debug("totalDisc    =".$totalDisc);

				/* Tracking the eCommerce Order via Piwik/Matomo's API */
				/*$pt->setURL('https://opensupermall.com/cart');
				$pt->doTrackEcommerceOrder(
					$p->id,
					$totalOPprice,
					$totalOPprice-$totalDelprice,
					$totalGST,
					$totalODP,
					$totalDisc);
				$pt->doTrackPageView('Order Cart');
				*/

            } // Order Loop

			Log::debug('Cart Identifier:'.json_encode($identifiers));

			/* WARNING: UNCOMMENT THIS FOR PRODUCTION */
            DBCart::whereIn('identifier',$identifiers)->
                update(['status'=>'destroyed']);
            return 1;

        } catch (\Exception $e) {
			Log::error($e->getFile().":".$e->getLine().",".$e->getMessage());
          
            try {
                Payment::destroy($payment->id);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            try {
                DeliveryOrder::destroy($do->id);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

			return $e->getMessage().
				"\nFILE:".$e->getFile().":".$e->getLine().
				"\nUSER:".$user_id;
        }
    }

    public function storeResponse() {
        // Role based redirection
        $roles= DB::table('role_users')->where('user_id',Auth::user()->id)->get();
        foreach ($roles as $r) {
            switch($r->role_id) {
                case 3:
                    $redirect_to_url=url('merchant/dashboard#orders');
                    break;
                case 11:
                    $redirect_to_url=url('station/dashboard#buying-orders');
                    break;
                default:
                     $redirect_to_url=url('buyer/dashboard#orders');
            }
        }

        $paymentResponse = new PaymentResponse;

        $paymentResponse->payment_id = $_REQUEST["PaymentId"];
        $paymentResponse->merchant_code = $_REQUEST["MerchantCode"];
        $paymentResponse->ref_no = $_REQUEST["RefNo"];
        $paymentResponse->amount = $_REQUEST["Amount"];
        $paymentResponse->currency = $_REQUEST["Currency"];
        $paymentResponse->remark = $_REQUEST["Remark"];
        $paymentResponse->trans_id = $_REQUEST["TransId"];
        $paymentResponse->signature = $_REQUEST["Signature"];
        $paymentResponse->auth_code = $_REQUEST["AuthCode"];
        $paymentResponse->err_desc = $_REQUEST["ErrDesc"];

        $paymentResponse->save();
        $ref_no= $_REQUEST["RefNo"];
            //dump($_REQUEST);
            $user_id=Auth::user()->id;
			$address = Address::find(Auth::user()->shipping_address_id);
        if ($_REQUEST['Status']=="1") {
            #Payment Successful.
            $identifiers=DB::table('ctrans')->where('ref_no',$ref_no)->lists('cart_id');

            $comm_prcnt=DB::table('global')->first()->osmall_commission;
            $amount=$_REQUEST["Amount"];
            $comm_amnt= ($comm_prcnt*$amount)/100; //Not multiplying by 100 as this amount is supposed to be in cents
            // Create new payment
            $py= new Payment;
            $py->receivable=$amount*100; //Cents not MYR
            $py->osmall_commission=$comm_amnt;
            $py->status="paid";
            $py->note=$_REQUEST['TransId'];
            $py->save();
            $address_id=DB::table('ctrans')->where('ref_no',$ref_no)->first()->address_id; //In future we can have different address for different products
			$pick_station = 0;
			if(isset($_REQUEST["StationPicked"])){
				$pick_station = $_REQUEST["StationPicked"];
			}
            foreach (Cart::contents() as $item) {
                    $m_p_record=array();
                    if (in_array($item->identifier,$identifiers)) {
                        if ($item->page=="openwish" or $item->mode=="owish") {
                            $email = Auth::user()->email;
                            $openwish_id=$item->openwish_id;
                            $data = array(
                                'openwish_id'    => $openwish_id,
                                'smedia_id'      => 1, //i am not sure whats fb
                                'smedia_account' => $email,
                                'source_ip'      => '0.0.0.0',
                                'pledged_amt'    => $item->pledged_amt*100,
                            );
                            $this->dispatch( new OpenwishPledgeJob($data) );
                            $item->remove();
                        // Write Email Block
                        }
                        else if ($item->mode=="hyper") {
                            $owarehouse_id= $item->hyper_id;
                            $owarehousepledge = new Owarehouse_pledge();
                            $owarehousepledge->owarehouse_id =$owarehouse_id;
                            $owarehousepledge->user_id=$user_id;
                            $owarehousepledge->status='executed';
                            $owarehousepledge->pledged_qty =$item->quantity;
                            if(!$owarehousepledge->save()){
                                $data['status'] = 'error';
                            }
                            else{
                                $data['status'] = 'success';
                                $producthyper = DB::table('product')->where('segment','hyper')->where('parent_id',$item->parent_id)->first();
                                if(!is_null($producthyper)){
                                    $available = $producthyper->available - $item->quantity;
                                    DB::table('product')->where('segment','hyper')->where('parent_id',$item->parent_id)->update(['available'=>$available]);
                                }
                            }
                            if (array_key_exists($item->mid,$m_p_record)) {
                                array_push($m_p_record[$item->mid],$item->identifier);
                            } else {
                            //if (!array_key_exists($item->mid,$m_p_record)) {
                                $m_p_record[$item->mid]=array();
                                array_push($m_p_record[$item->mid],$item->identifier);
                            }
                            //$item->remove();
                            // Email Block
                        }
                        else{
                            if (array_key_exists($item->mid,$m_p_record)) {
                                array_push($m_p_record[$item->mid],$item->identifier);
                            }
                            if (!array_key_exists($item->mid,$m_p_record)) 
                                $m_p_record[$item->mid]=array();
                                array_push($m_p_record[$item->mid],$item->identifier);
                            }
                        }
                        $pr_po_record=array();
                        foreach ($m_p_record as $k => $v) {
                            // Create one porder for each
                            $p= new POrder;
                            $p->user_id=$user_id;
                            $p->courier_id=0; //should be something else
                            $p->address_id=$address_id; //should be something else
                            $p->payment_id=$py->id; //0 for ocredit
                            $p->status="pending";
                            // ToDO add mode
                            $p->osmall_comm_percent=$global->osmall_commission;
                            $p->smm_comm_percent=$global->smm_commission;
                            $p->ow_comm_percent=$global->ow_commission;
                            $p->log_comm_percent=$global->logistic_commission;
                            $p->save();
        					$station_picked = 0;
					
        					try{
        						$sint= new StationIntelligence;
        						if($pick_station == 0){
        							$station_picked = $sint->get_station($address, $m_p_record[$k]);
        						} else {
        							$station_picked = $pick_station;
        						}
        						if($station_picked > 0){
        							$so= new SOrder;
        							$so->station_id=$station_picked;
        							$so->porder_id=$p->id; 
        							$so->save();
        							$stationarea = DB::table('station')->where('station.id',$station_picked)->join('address','station.station_address_id','=','address.id')->select('address.area_id')->first();
        							if(!is_null($stationarea)){
        								if(!is_null($stationarea->area_id)){
        									DB::table('stationarea')->insert(['station_id'=>$station_picked, 'area_id' => $stationarea->area_id, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        								}
        							}
    							
        						 }						
        					} catch (\Exception $e) {
    						
    					}
    					if($station_picked > 0){
    						$so= new SOrder;
    						$so->station_id=$station_picked;
    						$so->porder_id=$p->id; 
    						$so->save();
    						$stationarea = DB::table('station')->where('station.id',$station_picked)->join('address','station.station_address_id','=','address.id')->select('address.area_id')->first();
    						if(!is_null($stationarea)){
    							if(!is_null($stationarea->area_id)){
    								DB::table('stationarea')->insert(['station_id'=>$station_picked, 'area_id' => $stationarea->area_id, 'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
    							}
    						}						
    					}
                    // Add to porderefno    /**/
                        $newpoid = UtilityController::generaluniqueid($p->id,'1','1', $p->created_at, 'nporderid', 'nporder_id');
    					DB::table('nporderid')->insert(['nporder_id'=>$newpoid, 'porder_id'=>$p->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
    					$a = new SecurityIDGenerator;
    					$do_password = $a->generate(date('Y-m-d'));
    					$receipt_no = 0;
    					if($station_picked > 0){
    						$station = DB::table('station')->where('id',$station_picked)->first();
    						if(!is_null($station)){
    							$receipt_no = $station->receipt_no;
    							if(!is_null($receipt_no)){
    								$receipt_no++;
    							} else {
    								$receipt_no = 1;
    							}
    							//DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
    							DB::table('station')->where('id',$station_picked)->update(['receipt_no'=>$receipt_no]);
    						}							
    					} else {
    						$merchant = DB::table('merchant')->where('id',$k)->first();
    						if(!is_null($merchant)){
    							$receipt_no = $merchant->receipt_no;
    							if(!is_null($receipt_no)){
    								$receipt_no++;
    							} else {
    								$receipt_no = 1;
    							}
    						//	DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
    							DB::table('merchant')->where('id',$k)->update(['receipt_no'=>$receipt_no]);
    						}
    					}					
                        $rc= new Receipt;
                        $rc->porder_id=$p->id;
                        $rc->receipt_no=$receipt_no;
                        $rc->do_password=$do_password;
                        $rc->save();
    					UtilityController::createQr($rc->id, 'receipt',IdController::nO($p->id));
                        $do= new DeliveryOrder;
                        $do->receipt_id=$rc->id;
                        $do->status="pending";
                        $do->save();
					
                        $newdoid = UtilityController::generaluniqueid($do->id,'3','1', $do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id');
    					DB::table('ndeliveryorderid')->insert(['ndeliveryorder_id'=>$newdoid, 'deliveryorder_id'=>$do->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                        UtilityController::createQr($do->id,'deliveryorder', IdController::nO($p->id));
    					$r= new PRef;
                        $r->ref_no=$ref_no;
                        $r->porder_id=$p->id;
                        $r->payment_mode='ipay88';
                        $r->save();
    					$merchant_user_id=DB::table('merchant')->where('id',$k)->first()->user_id;
    					$merchant_email=User::find($merchant_user_id)->email;
    					$imstation = DB::table('station')->where('user_id', $user_id)->where('status', 'active')->count();
    					$imautolink = DB::table('autolink')->where('initiator', $user_id)->where('responder', $k)->where('status','linked')->count();
    					$global=DB::table('global')->first();
    					$merchant_commissions = DB::table('merchant')->where('id',$k)->first();
    					$commission_type="std";
    					$b2b_commission_type="std";
					
    					if(is_null($merchant_commissions)){
    						$commission_type=$global->commission_type;
    						$b2b_commission_type=$global->b2b_commission_type;
    					} else {
    						if($merchant_commissions->commission_type != "std" && $merchant_commissions->commission_type != "var" ){
    							$commission_type=$global->commission_type;
    						} else {
    							$commission_type=$merchant_commissions->commission_type;
    						}
    						
    						if($merchant_commissions->b2b_commission_type != "std" && $merchant_commissions->b2b_commission_type != "var" ){
    							$b2b_commission_type=$global->b2b_commission_type;
    						} else {
    							$b2b_commission_type=$merchant_commissions->b2b_commission_type;
    						}						
    					}	
    					$source_po = "";
    					$source_po_global = "";
                        // Add Each Porder to 
                        foreach ($m_p_record[$k] as $l) {
                            // $l is identifier here

                            $cartItem=Cart::item($l);
                            if ($cartItem->mode=="smm") {
                                $smmin=$cartItem->smmin_id;

                                $s=SMMin::find($smmin);
                                $sout=$s->smmout_id;
                                $s->response="buy";
                                $s->porder_id=$p->id;
                                $s->quantity=$cartItem->quantity;
                                $s->save();
                                // Total Sales for that smmout
                                $smmsaleCount=count(SMMin::where('smmout_id',$sout)->where('response','buy')->get());
                                $ssfcommpc=$global->smm_sales_staff_commission;
                                $osmall_commission=$global->osmall_commission;
                                $ssfcomm=($ssfcommpc*$cartItem->price*$osmall_commission)/($count*100*100);  //In cents
                                $ssfc=SalesStaff::where('user_id',Auth::user()->id)->where('type','smm')->first();
                                // check if salesStaff exists
                                if (is_null($ssfc)) {
                                    # code...
                                $ssf= new SalesStaff;
                                $ssf->type="smm";
                                $ssf->commission=$ssfcomm;
                                $ssf->user_id=Auth::user()->id;
                                $ssf->save();
                                }else{
                                $ssf= SalesStaff::find($ssfc->id);
                            
                                $ssf->commission=$ssf->commission+$ssfcomm;
                                
                                $ssf->save();
                                }

                            }
    						$commission = 10;
    						$ptype ='b2c';
    						$product = DB::table('product')->where('id',$cartItem->product_id)->first();
    						if(!is_null($product)){
    							$ptype = $product->segment;	
    						}
    						if($ptype == 'b2b'){
    							if($b2b_commission_type ==  'std'){
    								if(is_null($merchant_commissions)){
    									$commission=$global->b2b_osmall_commission;
    								} else {
    									if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
    										$commission=$global->b2b_osmall_commission;
    									} else {
    										$commission=$merchant_commissions->b2b_osmall_commission;
    									}
    								}
    							} else {
    								if(is_null($product)){
    									$commission=$global->b2b_osmall_commission;
    								} else {
    									if($product->b2b_osmall_commission == null || $product->b2b_osmall_commission == 0 || $product->b2b_osmall_commission == ""){
    										if($merchant_commissions->b2b_osmall_commission == null || $merchant_commissions->b2b_osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
    											$commission=$global->b2b_osmall_commission;
    										} else {
    											$commission=$merchant_commissions->b2b_osmall_commission;
    										}
    									} else {
    										$commission=$product->b2b_osmall_commission;
    									}
    								}								
    							}
    						} else {
    							if($commission_type ==  'std'){
    								if(is_null($merchant_commissions)){
    									$commission=$global->osmall_commission;
    								} else {
    									if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->osmall_commission == ""){
    										$commission=$global->osmall_commission;
    									} else {
    										$commission=$merchant_commissions->osmall_commission;
    									}
    								}
    							} else {
    								if(is_null($product)){
    									$commission=$global->osmall_commission;
    								} else {
    									if($product->osmall_commission == null || $product->osmall_commission == 0 || $product->osmall_commission == ""){
    										if($merchant_commissions->osmall_commission == null || $merchant_commissions->osmall_commission == 0 || $merchant_commissions->b2b_osmall_commission == ""){
    											$commission=$global->osmall_commission;
    										} else {
    											$commission=$merchant_commissions->osmall_commission;
    										}
    									} else {
    										$commission=$product->osmall_commission;
    									}
    								}								
    							}							
    						}	
    						$source_now = "";
    						if($ptype == 'b2c'){
    							$source_now = 'b2c';
    						} else if($ptype == 'b2b'){
    							$source_now = 'b2b';
    						} else if($ptype == 'hyper'){
    							$source_now = 'hyper';
    						} else {
    							$source_now = 'b2c';
    						}
    						if($source_po == ""){
    							$source_po = $source_now;
    						} else {
    							if($soucer_po == $source_now){
    								$source_po_global = $source_now;
    							} else {
    								$source_po_global = "mixed";
    							}
    						}
                            $o= new OrderProduct;
                            $o->porder_id=$p->id;
                            $o->product_id=$cartItem->product_id;
                            $o->quantity=$cartItem->quantity;
                            $o->order_price=$cartItem->price;
    						//$o->paid_commission_rate=$commission;
                            $o->order_delivery_price=$cartItem->delivery_price * 100;
                            $o->status="pending";
                            $o->source=$source_now;
                            $o->save();
    					
                            if(!is_null($cartItem->ocredit)){
                                if($cartItem->ocredit > 0){
                                    $cre_new = DB::table('cre')->insertGetId(['user_id'=>Auth::user()->id,'type'=>'return','porder_id'=>$p->id,'product_id'=>$cartItem->product_id, 'status' => 'success','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                            
                                    $ocre_new = DB::table('ocredit')->insertGetId(['cre_id'=>$cre_new,'mode'=>'debit','openwish_id'=>$cartItem->ow_id,'product_id'=>$cartItem->product_id,'porder_id'=>$p->id,'value'=>$cartItem->ocredit,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                                }
                            }
                        }
                    //$p=Product::find($item->id);
                        $p->source=$source_po_global;
                        $p->save();
                    // $dop=new DeliveryOrderProduct;
                    //     $dop->do_id=$do->id;
                    //     $dop->product_id=$cartItem->product_id;
                    //     $dop->status="pending";
                    //     $dop->quantity=$cartItem->quantity;
                    //     $dop->remark="No Remark";
                    //     $dop->save();
                        DB::table('deliveryordersproduct')->insert([
                            'do_id'=>$do->id,
                            'product_id'=>$cartItem->product_id,
                            'status'=>'pending',
                            'quantity'=>$cartItem->quantity,

                            ]);
							
    					try{
                            $e= new EmailController;
                            //$e->sendRC(Auth::user()->email,$p->id);
                           // $e->sendDO($merchant_email,$p->id);
    						if($station_picked > 0){
    							$station = DB::table('station')->where('id',$station_picked)->first();
    							if(!is_null($station)){
    								$user_station = DB::table('users')->where('id',$station->user_id)->first();
    								if(!is_null($user_station)){
    								//	$e->sendDO($user_station->email,$p->id);
    								}
    								
    							}
    						} else {
    						//	$e->sendDO($merchant_email,$p->id);
    						}
    											 
    					//	$e->sendRC(Auth::user()->email,$p->id);						
    					} catch (\Exception $e){
    						
    					}
					 
                        $item->remove();
            }
                sleep(1);
                
                return redirect($redirect_to_url);
                return response()->json(['status'=>'success','short_message'=>0,'long_message'=>'Transaction Successfull','redirect'=>$redirect_to_url]);
            }

            // 
           
        }

        return Session::get('requestReferrer');
        return redirect(json_encode(Session::get('requestReferrer')));
    }
	

	
	public function get_station($address, $contents){
		$limit = 5;
		$days = 90;
		$station_picked = 0;
		$date = date('Y-m-j H:i:s');
		$newdate = strtotime ( '-' . $days .' day' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-j H:i:s' , $newdate );
		$stations = null;
		// return $address->area_id;
		if(!is_null($address)){
			if(!is_null($address->area_id)){
				$sqlselect = "SELECT DISTINCT (station.id) as id,(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance ";
				$sqlfrom = " FROM station, address, sproperty ";
				$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.area_id = " . $address->area_id . ") OR (station.station_address_id  = address.id AND address.area_id = " . $address->area_id . ")";
				$sqlorder = " ORDER BY distance LIMIT " . $limit; 
				$k=0;
				foreach ($contents as $l) {
					$item=Cart::item($l);
					$k++;
					$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
					$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " AND sproduct" . $k . ".stock > 0 ";
				}

				$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

				$stations = DB::select(DB::raw($sqltotal));
			}
			$arrstations = array();
			$arrsums = array();
			if(!is_null($stations)){
				$k=0;
				$sum = 10000;
				
				foreach ($stations as $st) {
					$station = null;
					$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
					foreach ($stationsum as $sum) {
						$station = $sum->id;
					}
					if(!is_null($station)){
						$arrstations[$k] = $st->id;
						$arrsums[$k] = $sum;
						$k++;
					} else {
						$station_picked = $st->id;
						break;
					}
					$sum--;
				}
				if($station_picked == 0){
					$least_ammount = 1000000000;
					$least_id = 0;
					for($i=0;$i<$limit;$i++){
						if($arrsums[$i]<$least_ammount){
							$least_ammount = $arrsums[$i];
							$least_id = $arrstations[$i];
						}
					}
					$station_picked = $least_id;
				}
			} else {
				if(!is_null($address->city_id)){
					$sqlselect = "SELECT DISTINCT (station.id),(((acos(sin((address.latitude*pi()/180)) * 
					sin((" . $address->latitude . "*pi()/180))+cos((address.latitude*pi()/180)) * 
					cos((" . $address->latitude . "*pi()/180)) * cos(((address.longitude - " . $address->longitude . ")* 
					pi()/180))))*180/pi())*60*1.1515
				) as distance ";
					$sqlfrom = " FROM station, address, sproperty ";
					$sqlwhere = " WHERE (station.id = sproperty.station_id AND sproperty.address_id = address.id AND address.city_id = " . $address->city_id . ") OR (station.station_address_id  = address.id AND address.city_id = " . $address->city_id . ")";
					$sqlorder = " ORDER BY distance";
					$k=0;
					foreach ($contents as $item) {
						$k++;
						$sqlfrom = $sqlfrom . " , stationsproduct as st" . $k . ", sproduct as sproduct" . $k . " ";
						$sqlwhere = $sqlwhere . " AND st" . $k . ".station_id = station.id AND sproduct" . $k . ".id = st" . $k . ".sproduct_id AND sproduct" . $k . ".product_id = " . $item->id . " AND sproduct" . $k . ".available >= " . $item->quantity . " ";
					}

					$sqltotal = $sqlselect . $sqlfrom . $sqlwhere . $sqlorder;

					$stations = DB::select(DB::raw($sqltotal));
				}
				$arrstations = array();
				$arrsums = array();
				if(!is_null($stations)){
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$station = null;
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
						foreach ($stationsum as $sum) {
							$station = $sum->id;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							$arrsums[$k] = $sum;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1000000000;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if($arrsums[$i]<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
					$k=0;
					$sum = 10000;
					foreach ($stations as $st) {
						$stationsum = DB::select(DB::raw("SELECT * FROM stationarea WHERE station_id = " . $st->id . " AND created_at > '" . $newdate . "'"));
						foreach ($stationsum as $sum) {
							$station = $sum->id;
						}
						if(!is_null($station)){
							$arrstations[$k] = $st->id;
							$arrsums[$k] = $sum;
							$k++;
						} else {
							$station_picked = $st->id;
							break;
						}
						$sum--;
					}
					if($station_picked == 0){
						$least_ammount = 1000000000;
						$least_id = 0;
						for($i=0;$i<$limit;$i++){
							if($arrsums[$i]<$least_ammount){
								$least_ammount = $arrsums[$i];
								$least_id = $arrstations[$i];
							}
						}
						$station_picked = $least_id;
					}
				}
			}
		}

		return $station_picked;
	}	

    public function saveAddress() {
        $address = new Address;
        $user = User::findOrFail(Auth::user()->id);
        $data = Input::all();

        $address->city_id = $data['city'];
        $address->postcode = $data['postcode'];
        $address->address = $data['address'];

        $address->save();
        $user->mobile_no = $data['mobile'];
        $user->billing_address_id = $address->id;
        $user->shipping_address_id = $address->id;
        $user->save();

        return 'success';
    }

    public function saveUser() {
        $data = Input::all();

        if ($data['password'] == $data['conf_pass']) {
            $address = new Address;

            $messages = [
                'email.required' => 'We need to know your e-mail address!',
                'email.unique' => 'Email already exist ',
            ];
            //Need email validation here
            $validation = Validator::make($data, [
                        'email' => 'required|email|unique:user',
                        'password' => 'required',
                        'first_name' => 'required'
                            ], $messages);

            if ($validation->fails()) {
                return 'Validation Failed';
            } else {

                $user = new User();

                $address->city_id = $data['city'];
                $address->postcode = $data['postcode'];
                $address->address = $data['address'];
                $address->save();

                $user->first_name = $data['first_name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->mobile_no = $data['mobile'];
                $user->billing_address_id = $address->id;
                $user->shipping_address_id = $address->id;
                $user->save();

                return 'success';
            }
        } else {
            return 'fail';
        }
    }

    public function getState() {
        $country_code = Input::get('country_code');
        $state = State::where('country_code', '=', $country_code)->lists('name', 'code')->toArray();
        $states_collection = new \Illuminate\Support\Collection($state);
        $states = $states_collection->sort();

        return $states;
    }

    public function getCity() {
        $state_code = Input::get('state_code');
        $city = City::where('state_code', '=', $state_code)->lists('name', 'id')->toArray();
        $cities_collection = new \Illuminate\Support\Collection($city);
        $cities = $cities_collection->sort();

        return $cities;
    }

    private function sharePost($data = array()) {
        $base_url = "http://beta.opensupermall.com";
        $img_url = $base_url . "/images/product/" . $data['product_id'] . "/" .
                $data['product_photo'];

        $rp = number_format($data['product_retail_price'] / 100, 2);
        $op = number_format($data['product_original_price'] / 100, 2);
        if ($op > 0 && $op > $rp) {
            $pricing = $op;
            $discount = number_format((($op - $rp) / $op) * 100, 2);
        } else {
            $pricing = "Super HOT product!";
            $discount = null;
        }

        $pledge = OpenWishPledge::withPledgeAmt($data['openwish_id']);
        $balance = $data['product_original_price'] - $pledge;

        $owish = new OWish();

        $linkData = [
            'link' => $base_url . "/productconsumer/" . $data['product_id'] . '/' . $data['openwish_id'],
            'from' => "FOO BAR BAZ",
            'message' => "I help him..Please HELP him too!",
            'icon' => "http://beta.opensupermall.com/images/logo-white.png",
            'picture' => $img_url,
            'caption' => $data['oshop_name'] . "@OpenSupermall",
            'name' => "** OpenSupermall ** | " . $data['product_name'],
            'description' => "Price:".$currency." ".$pricing."|Discount:".
			$discount ."%|Accumulated:".$currency." ".$pledge.
			"|Balance:".$currency." ".$balance,
        ];

        //Post selected product to facebook user's profile, from "app/OWish.php"
        $owish->facebook($linkData);
    }

    public function iPay88_signature($source)
    {
        return base64_encode(hex2bin(sha1($source)));
    }

    public function hex2bin($hexSource)
    {
        for ($i = 0; $i < strlen($hexSource); $i = $i + 2) {
            $bin .= chr(hexdec(substr($hexSource, $i, 2)));
        }
        return $bin;
    }
    /*
        $ret=[
        mid=>{
            "total":"",
            "rawTotal":"",
            "delivery":"",
            "specialMessage":"",
            "products":[
                pid=>rawTotal
            ]
        }
        
        ];

    */ 
    public function cartItemsMerchantInfo()
    {
        $ret=array();
        foreach (Cart::contents() as $item) {
              $del=new Delivery;
                $mid=UtilityController::productMerchantId($item->id);
                 $delivery= $del->get_delivery_price($item->id,$item->quantity);
                 // dump($delivery);
                if (array_key_exists($mid,$ret)){
                    
                    $ret[$mid]['rawTotal']+=($item->price*$item->quantity)/100;
                    $ret[$mid]['delivery'] +=$delivery/100;
                    $ret[$mid]['products'][$item->id]=($item->price*$item->quantity)/100;
                    $ret[$mid]['total']+=(($item->price*$item->quantity)+$delivery)/100;
                }else{
                    $ret[$mid]['total'] = (($item->price*$item->quantity)+$delivery)/100;
                    $ret[$mid]['rawTotal'] = ($item->price*$item->quantity)/100;
                    $ret[$mid]['delivery'] =$delivery/100;
                    $ret[$mid]['products'][$item->id]=($item->price*$item->quantity)/100;
              
                }
            
        }
        return $ret;
    }

    public function getTotal()
    {
        /* Note that this does not include delivery price, only product */
        $prodTotal = Cart::total();
        $deliveryTotal = 0;
        $gstTotal=0;
        $total=0;
        
        /* Next, we need to total up all the delivery prices */
        foreach (Cart::Contents() as  $cartProduct) {
            $total=0;
            
            if ($cartProduct->mode != "adjustment") {
				if ($cartProduct->mode == "token") {
					$deliveryTotal = 0;
					$gstTotal = 0;
					for ($i=0; $i <$cartProduct->quantity ; $i++) { 
						$total+=$cartProduct->price;
					}
				} else {
					$p = new PriceController;
                    $del=new Delivery;
					$deliveryTotal += ($del->get_delivery_price($cartProduct->id,$cartProduct->quantity))/100;
                    // dump($deliveryTotal);
					for ($i=0; $i <$cartProduct->quantity ; $i++) { 
						# code...
						
						$total+=$cartProduct->price;
					}
					$credit = 0;
					if(!is_null($cartProduct->ocredit)){
						$credit = $cartProduct->ocredit;
						$total -= $credit;
						if($total < 0){
							$credit = $total * -1;
							$total = 0;
							$cartProduct->ocredit = $credit;
						}       
					}
					if($cartProduct->mode != "rfee" and $cartProduct->mode != "adjustment"){
					$gstTotal+=$p->init($cartProduct->id,'gst');
					}
				}
            }
        }

        return [$prodTotal, $deliveryTotal,$gstTotal,$total];
    }

    // Add Delivery To Cart

    // public function delivery($del)
    // {
    //     # code...
    // }
    
    public function getMerchantDelivery($merchant_id)
    {
        $ret=["status"=>"failure","delivery"=>0];

        try {
            foreach (Cart::contents() as $item) {
                if ($item->mid == $merchant_id) {
                    $ret["delivery"]+=$item->delivery_price;
                }
            }
            $ret["status"]="success";
        } catch (\Exception $e) {
            $ret["short_message"]=$e->getMessage();
        }

        return response()->json($ret);

    }
}
