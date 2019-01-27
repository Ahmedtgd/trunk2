<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IdController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\POrder;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\OrderProduct;
use App\Models\Logistic;
use App\Models\LogisticSlab as LS;
use App\Models\NvShip;
use App\Classes\NinjaVan as NV;
use App\Models\PackageDimension;
use Exception;
use DateTime;
use DateInterval;
use DB;
use QrCode;
use DNS1D;
use PDF;

// use Requests;
// use App\Models\

class NinjaVanController extends Controller
{
    public $bl = "|"; //Barcode Limiter
    public $cN = "";
    public $btype = "C128";
    public $sysname = "nv";
    public $logistic_id;

    public function __construct () {
        $log=new LogisticsController;
        $this->logistic_id=$log->select_logistic_id($this->sysname);
    }

	public function shipReqObject($order_id)
    {
		return [
			"from_postcode"=>"159363", 
			"from_address1"=>"30 Jalan Kilang Barat", 
			"from_address2"=>"Ninja Van HQ", 
			"from_locality"=>"Bukit Merah", 
			"from_city"=>"SG", 
			"from_country"=>"SG", 
			"from_email"=>"jane.doe@gmail.com", 
			"from_name"=>"Han Solo Exports", 
			"from_contact"=>"91234567", 
			"to_postcode"=>"318993", 
			"to_address1"=>"998 Toa Payoh North", 
			"to_address2"=>"#01-10",
			"to_locality"=>"Toa Payoh", 
			"to_city"=>"SG", 
			"to_country"=>"SG", 
			"to_email"=>"john.doe@gmail.com", 
			"to_name"=>"James T Kirk", 
			"to_contact"=>"98765432", 
			"delivery_date"=>"2014-12-02", 
			"pickup_date"=>"2014-12-01", 
			"pickup_weekend"=>true, 
			"delivery_weekend"=>true, 
			"staging"=>false, 
			"pickup_timewindow_id"=>1, 
			"delivery_timewindow_id"=>2, 
			"max_delivery_days"=>1, 
			"cod_goods"=>35.50, 
			"pickup_instruction"=>"Warehouse alarm bell does not work, please ca ",
			"delivery_instruction"=>"My doorbell is broken.Please knock the door ",
			"requested_tracking_id"=>"24167", 
			"order_ref_no"=>"8374", 
			"type"=>"NORMAL", 
			"parcel_size"=> 1, 
			"parcel_volume"=> 4000, 
			"parcel_weight"=> 1.2
		];
	}
	
    public function informLogistic($order_id,$type,$object)
    {
		/* In this function you should check if shipper exists. If not Create
		shipper. Then with the shipper ID you should call
		NinvaVan->create_order() function. It will return the success/fail
		status. */

		return response()->json([
			'status' => 'success',
			'short_message' => 'Dummy',
			'long_message' => 'This is a dummy message'
		]);
    }

    public function labelQR($consignmentNumber,$order_id)
    {
        $consignmentNumber=$consignmentNumber->consignment_number;
        $filename = $consignmentNumber."_qr.png";
        $bl = "|";
        $filepath = public_path('ninjavan/' .$order_id."/" . $filename);
        $qrInfo = $consignmentNumber;

        QrCode::format('png')->
			encoding('UTF-8')->
			size(400)->
			generate($qrInfo, $filepath);
    }

    public function labelBC($consignmentNumber,$order_id)
    {
        $consignmentNumber=$consignmentNumber->consignment_number;
        $height = 1; //cm
        $filename = $consignmentNumber."_bc.png";
        $filepath = public_path('ninjavan/' . $order_id . "/" . $filename);
        $base64 = DNS1D::getBarcodePNG($consignmentNumber, $this->btype);
        $img = base64_decode($base64);
        file_put_contents($filepath, $img);
    }

    public function bootStrap($consignmentNumber, $order_id)
    {
        $cn=$consignmentNumber->consignment_number;
        $pathName = public_path("ninjavan/".$order_id);
        try {
            // Create folder
            try{
                mkdir($pathName, 0775, true);
            }catch(\Exception $e){}  
            
            // Generate QR
            $this->labelQR($consignmentNumber,$order_id);
            // Generate Barcode
            $this->labelBC($consignmentNumber,$order_id);

        } catch (\Exception $e) {
            ////dump($e);
        }
        return $pathName;

    }

    public function labelData($order_id, $type = "m2b")
    {
        $porder = POrder::find($order_id);
        $buyer_user_id = $porder->user_id;
        // Get Buyer's Data
        $user = User::find($buyer_user_id);

        $pid = OrderProduct::where('porder_id', $order_id)->pluck('product_id');
        $mp = MerchantProduct::where('product_id', $pid)->first();
        if (is_null($mp)) {
            $product = Product::find($pid);

            if (is_null($product)) {

                $product = Product::where('parent_id', $pid)->first();
            }
            $mp = MerchantProduct::where('product_id', $product->parent_id)->first();
        }
        $merchant = Merchant::find($mp->merchant_id)

        ;
        $parcels=DB::table('nv_order_create_resp')
        ->join('delivery','delivery.consignment_number','=','nv_order_create_resp.nv_tracking_id')
        ->leftJoin('nv_order_create_req as nocq','nocq.nv_order_ref_no','=','nv_order_create_resp.nv_order_ref_no')
        ->where('delivery.porder_id',$order_id)
        // ->where('nv_order_create_resp.nv_order_ref_no',$order_id)
        ->where('delivery.type',$type)
        ->groupBy('nv_order_create_resp.nv_tracking_id')
        ->whereNull('delivery.deleted_at')
        ->whereNull('nv_order_create_resp.deleted_at') 
        ->select("nv_order_create_resp.nv_tracking_id","nocq.nv_delivery_date")
        ->get();

        $mAdd = DB::table('address')->where('address.id', $merchant->address_id)
			->join('city', 'address.city_id', '=', 'city.id')
			->join('state', 'city.state_code', '=', 'state.code')
			->select(DB::raw("
			address.*,
			city.name as city,
			state.name as state
			"))
			->first();

        $bAdd = DB::table('address')->where('address.id',
			$user->default_address_id)
			->join('city', 'address.city_id', '=', 'city.id')
			->join('state', 'city.state_code', '=', 'state.code')
			->select(DB::raw("
			address.*,
			city.name as city,
			state.name as state
			"))
			->first();

        /*Parcels*/
        if ($type=="b2m") {
            $c1=$mAdd;
            $c2=$bAdd;
            $bAdd=$c1;
            $mAdd=$c2;
        }
     
        $forder_id=IdController::nO($order_id);
        $ret=compact("user","merchant","parcels","mAdd","bAdd","forder_id","order_id","type");
        return $ret;

        // Get Merchant's Data
    }

    public function labelPDF($order_id,$type="m2b")
    {
        /*Consignment Number is useless , as we are switching too multi parcel*/ 

        $fileName = "labels/label-" ."-o-" . $order_id . ".pdf";
        $filePath = $fileName;
        $data = $this->labelData($order_id,$type);
    
      
        try {
            unlink(storage_path($filePath));
        } catch (\Exception $e) {
                // ////dump($e);
        }
        
        // return view('ninjavan.label',['data' => $data]);
        $pdf = PDF::loadView('ninjavan.label', ['data' => $data])
            ->setPaper('a4')
            ->setOption('zoom', 0.70)
            ->save(storage_path($filePath));
        return $filePath;
    }

    public static function cleanUP($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new Exception("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            // if (is_dir($file)) {
            //     self::deleteDir($file);
            // } else {
            unlink($file);
            // }
        }
        rmdir($dirPath);
    }

    public function downloadLabel($order_id, $type)
    {
        $f1 = "";
        $this->ctype = $type;
        try {
            $consignmentNumber = DB::table('delivery')->
				where('porder_id', $order_id)->
				where('type',$type)->
				select('consignment_number')->get();
     
            foreach ($consignmentNumber as $k) {
                $f1 = $this->bootStrap($k, $order_id);
            }
            
            $f2 = $this->labelPDF($order_id, $type);
        
            $this->cleanUP($f1);

            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->
				download(storage_path($f2), "label.pdf", $headers)->
				deleteFileAfterSend(true);

        } catch (\Exception $e) {
            //  Paul on 13 April 2017 at 10 10 pm
            //////dump($e);
            //  Ends Here
            try {
                $this->cleanUP($f1);
            } catch (\Exception $e) {
            }

			return view('common.generic')->
				with('message_type', 'error')->
				with('message',
					'Something went wrong. Please contact OpenSupport');
        }
    }

	public function order_formatter_v3($porder,$buyer,$merchant,$to_address,
		$from_address,$pickup_date,$delivery_date,$type="m2b")
    {

        $order=(object)array();
              try {
            /*Fix Name*/
            switch ($type) {
                case 'm2b':
                    $to_name=$buyer->name;
                    $from_name=$merchant->company_name;
                    $to_contact=$buyer->mobile_no;
                    $from_contact=$merchant->contact_person;
                    break;
                case 'b2m':
                    /*Very stupid input naming*/ 
                    $to_name=$buyer->company_name;
                    $from_name=$merchant->name;
                    $to_contact=$buyer->contact_person;
                    $from_contact=$merchant->mobile_no;
                    break;
                default:
                    # code...
                    break;
            }

            $order->from_zip_code=(string)$from_address->postcode;
            $order->from_line1=$from_address->line1;
            $order->from_line2=$from_address->line2;
            $order->from_city=$from_address->city;
            $order->from_state=$from_address->state;
            $order->from_country="MY";
            $order->from_email=$merchant->email;
            $order->from_name=$from_name;
            $order->from_contact=$from_contact;
        
            /*To Address*/ 
            $order->to_zip_code=(string)$to_address->postcode;
            $order->to_line1=$to_address->line1;
            $order->to_line2=$to_address->line2;
            $order->to_city=$to_address->city;
            $order->to_state=$to_address->state;
            $order->to_country="MY";
            $order->to_email=$buyer->email;
            $order->to_name=$to_name;
            $order->to_contact=$to_contact;

            /*Test*/ 
            $order->order_ref_no=(string)IdController::nO($porder->id);
            $order->size=1;
            $order->weight=1.2;
            $order->volume=2000;
            $order->delivery_date=$delivery_date;
            $order->pickup_date=$pickup_date;
            // $order->cod_goods=35.50;

        } catch (\Exception $e) {
            ////dump($e);
        }
    
        return $order;
    }
    public function order_formatter($porder,$buyer,$merchant,$to_address,
        $from_address,$pickup_date,$delivery_date,$nsellerid,$attach_rtn,$type="m2b")
    {

		/*
		//dump($merchant->mobile_no);
		//dump($buyer->mobile_no);
		*/

        // $order=(object)array();
        $rtn=null;
       
		try {
			switch ($type) {
                case 'm2b':
                    $to_name=$buyer->name;
                    $from_name=$merchant->company_name;
                    $to_contact=$buyer->mobile_no;
                    $from_contact=$merchant->mobile_no;
                    $to_email=$buyer->email;
                    $from_email=$merchant->email;
                    $service_type="Marketplace";
                    $is_pickup_required=false;
                    $rtn=time();
                    break;
                case 'b2m':
                    $to_name=$buyer->company_name;
                    $from_name=$merchant->first_name." ". $merchant->last_name;
                    if (is_null($from_name)) {
                        $from_name="Buyer";
                    }
                    $to_contact=$merchant->mobile_no;
                    $from_contact=$buyer->mobile_no;
                    $to_email=$merchant->email;
                    $from_email=$buyer->email;
                    $service_type="Return";
                    $is_pickup_required=true;
                    $rtn =substr(time(),0,9);
                    $attach_rtn=True;
                    break;
                default:
                    # code...
            }
            $pickup_instruction="";
            $delivery_instruction="";
            $save_in_db=[
            'nv_from_postcode' =>$from_address->postcode ,
            'nv_from_address1' =>$from_address->line1 ,
            'nv_from_address2' => $from_address->line2,
            'nv_from_city' => $from_address->city,
            'nv_from_state' =>$from_address->state,
            'nv_from_country' =>$from_address->country ,
            'nv_from_email' => $from_email,
            'nv_from_name' =>$from_name,
            'nv_from_contact' =>$from_contact,
            'nv_to_postcode' => $to_address->postcode,
            'nv_to_address1' => $to_address->line1,
            'nv_to_address2' => $to_address->line2,
          
            'nv_to_city' => $to_address->city,
            'nv_to_state' => $to_address->state,
            'nv_to_country' =>$to_address->country,
            'nv_to_email' =>$to_email,
            'nv_to_name' => $to_name,
            'nv_to_contact' => $to_contact,
            'nv_delivery_date' =>$delivery_date,
            'nv_pickup_date' =>$pickup_date,
            'nv_pickup_instruction' =>$pickup_instruction ,
            'nv_delivery_instruction' => $delivery_instruction,
            'nv_requested_tracking_id' =>$rtn ,
            'nv_order_ref_no' => IdController::nO($porder->id),
            'nv_type' =>$service_type,
            'nv_parcel_size' =>'L' ,
            
            'nv_parcel_volume' => '1',
            'nv_parcel_weight' =>'1.0'
            
            ];
            DB::table('nv_order_create_req')->insert($save_in_db);
            $from_address1=array();
            $from_address1['address1'] =$from_address->line1;    
            $from_address1['address2'] =$from_address->line2;   
            $from_address1['city']  = $from_address->city;
            $from_address1['state'] =$from_address->state ;
            $from_address1['country']  =$from_address->country;
            // $from_address1['country']  ="SG";
            $from_address1['postcode'] =(string)$from_address->postcode;
         
            $to_address1=array();
            $to_address1['address1'] =$to_address->line1;    
            $to_address1['address2'] =$to_address->line2;    
            $to_address1['city']  = $to_address->city;
            $to_address1['state']  =$to_address->state;
            $to_address1['country']  = $to_address->country;
             // $to_address1['country']  = "SG";
            $to_address1['postcode'] =(string)$to_address->postcode;

            $from_data['name'] ="[OpenSupermall] ".$from_name;
            $from_data['phone_number'] = $from_contact;
            $from_data['email'] =$from_email;
            $from_data['address'] = $from_address1;

            $to_data['name'] =$to_name;
            // $to_data['name'] =$to_name;
            $to_data['phone_number'] =$to_contact;
            $to_data['email'] =$to_email;
            $to_data['address'] = $to_address1;

            $tslot=array();
            $tslot['start_time'] = "09:00";
            $tslot['end_time']   = "22:00";
            $tslot['timezone']   = "Asia/Kuala_Lumpur";           
            $parcel_job=array();
            $parcel_job['is_pickup_required'] =$is_pickup_required;
            $parcel_job['delivery_instructions'] = "Handle with care!";
            $parcel_job['delivery_start_date']   = $delivery_date;
            $parcel_job['delivery_timeslot']     = $tslot;
            $parcel_job["pickup_address"]= [
				"name"=>$from_name,
				"phone_number"=>$from_contact,
				"email"=>$from_email,
				"address"=> [
					"address1"=>$from_address->line1,
					"address2"=> $from_address->line2,
					"country"=> $from_address->country,
					"postcode"=>(string)$from_address->postcode
                ]
            ];
            $parcel_job['pickup_timeslot']=$tslot;
            $parcel_job["pickup_date"]=$pickup_date;
            $parcel_job["pickup_instruction"]= "Please be careful, the package is fragile";
            $parcel_job["pickup_approximate_volume"]= "Half-Van Load";
            $parcel_job["allow_weekend_delivery"]= false;

            $dim['weight'] = 1.0;

           
            $dim['size'] = "L";
            $parcel_job['dimensions'] = $dim;
            /*Test*/ 
            // $order->order_ref_no=(string)IdController::nO($porder->id);
            // $order->size=1;{#1688}
            // $order->weight=1.2;
            // $order->volume=2000;
            // $order->delivery_date=$delivery_date;
            // $order->pickup_date=$pickup_date;
            /**/
            $order_data['service_type'] =$service_type;
            $order_data['service_level'] = "Standard";
            $order_data['reference']=array('merchant_order_number'=>(string)IdController::nO($porder->id));
            if($is_pickup_required==False){
                $order_data['marketplace'] = [
					'seller_id' => (string)$nsellerid,
					'seller_company_name' => $merchant->company_name
				];
            }
            $order_data['from'] = $from_data;
            $order_data['to']   = $to_data; 
            $order_data['parcel_job'] = $parcel_job;
            if ($attach_rtn) {
                $order_data["requested_tracking_number"]=$rtn;
            }
        } catch (\Exception $e) {
            //dump($e);
        }
    
        return $order_data;
    }

    public function identify_error()
    {
        return True;
    }


    /* v4 of the API */
	public function callLogistic(Request $r)
    {
        $pstatus = null;
        $status = "pending";
        $order_id = $r->oid;
        $porder = POrder::find($order_id);
        if (empty($porder)) {
            return response()->json([
                    'status' => 'failure',
                    'short_message' => "Bad Porder Id",
                    'long_message' => 'Order does not exist. Please contact OpenSupport.'
                ]);  
        }
        $backup_status=$porder->status;

        try {
            /* Validation Block */
            $buyer_user_id = $porder->user_id;
            if (!in_array($porder->status,[
				"m-processing1","request-goods"])) {
				return response()->json([
					'status' => 'failure',
					'short_message' => "Bad Porder Status",
					'long_message' => 'Logistic has already been called. Please contact OpenSupport.'
				]);   
            }

            $merchant_id=UtilityController::porderMerchantId($porder->id);
            $un_id=DB::table('merchant')->
				where('id',$merchant_id)->
				pluck('user_id');

            $type = "m2b";
            $nvtype="NORMAL";
            $status="m-processing2";
            $pstatus = "m-processing1";
            if ($r->has('type')) {
                $type = $r->type;
                switch($r->type)  {
                case "m2b":
                    $status = "m-processing2";
                    $pstatus = "m-processing1";
                    break;
                case "b2m":
                    $nvtype="RETURN";
                    $pstatus = "request-goods";
                    $status = "call-logistic1";
                    $un_id=$buyer_user_id;
                    break;
                default:
                }
            }
                
            // return $type;
            // Validation

            $isotime = $r->ts;
          
            $packageArray = $r->pd;
            $packageCount = $r->count;
            $datetime = new DateTime($isotime);
            $pickup_date = $datetime->format("Y-m-d");

            $delivery_date=$datetime->add(
                new DateInterval('P1D'))->format("Y-m-d");
           
            // $dt = explode(" ", $fdate);
            // $pref_date = $dt[0];
            // $t = explode(":", $dt[1]);
            // $hr = $t[0];
            // $min = $t[1];

            $user = User::find($buyer_user_id);
            $nbuyerid=DB::table('nbuyerid')->
				where('user_id',$buyer_user_id)->
				pluck('nbuyer_id');

            $pid = OrderProduct::where('porder_id', $order_id)->
				pluck('product_id');

            $mp = MerchantProduct::where('product_id', $pid)->first();
            if (is_null($mp)) {
                $product = Product::find($pid);

                if (is_null($product)) {

                    $product = Product::where('parent_id', $pid)->first();
                }
                // ////dump($product);
                $mp = MerchantProduct::where('product_id', $product->id)->first();
                if (is_null($mp)) {
                    $mp = MerchantProduct::where('product_id', $product->
						parent_id)->first();
                }
            }

            // $mer=Merchant::find($mp->merchant_id);
            $mer = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                ->where('merchant.id', '=', $mp->merchant_id)
                ->join('nsellerid','nsellerid.user_id','=','merchant.user_id')
                ->select(DB::raw("
                        merchant.*,
                        users.email,
                        nsellerid.nseller_id as nsellerid
                        "))
                ->first();
            $nsellerid=$mer->nsellerid;
            $rtn=True;
          
			$mnv=DB::table('userninjavan')->
				where('user_id',$un_id)->
				where('has_shipper_id',1)->first();

            /* Important */ 
            if (empty($mnv)) {
                $rtn=False;
            }

            /* DANGER danger Danger
				THE COUNTRY CODE HAS BEEN HARDCODED TO 'SG',
				REPLACE IT WITH state.country_code
            */ 

			$mAdd = DB::table('address')->
				where('address.id', $mer->address_id)->
				join('city', 'address.city_id', '=', 'city.id')->
				join('state', 'city.state_code', '=', 'state.code')->
				select(DB::raw("
					address.*,
					city.name as city,
					state.name as state,
					LEFT(state.country_code,2) as country
                "))->first();

			$bAdd = DB::table('address')->
				where('address.id', $user->default_address_id)->
				join('city', 'address.city_id', '=', 'city.id')->
				join('state', 'city.state_code', '=', 'state.code')->
				select(DB::raw("
					address.*,
					city.name as city,
					state.name as state,
					LEFT(state.country_code,2) as country
                "))->first();

            /*Create an order with NinjaVan*/ 
            $nv_class=new NV;
            $b_val=$nv_class->address_validator($bAdd);
            $m_val=$nv_class->address_validator($mAdd);
            /*
            if (!is_null($b_val)) {
                return response()->json([
                    "short_message"=>"Validation failure",
                    "status"=>"failure",
                    "long_message"=>$b_val
                    ]);
            }

            if (!is_null($m_val)) {
                return response()->json([
                    "short_message"=>"Validation failure",
                    "status"=>"failure",
                    "long_message"=>$m_val
                    ]);
                
            }
            */
            if (!is_null($b_val) or !is_null($m_val)) {
                return response()->json([
                    "short_message"=>"Validation failure",
                    "status"=>"failure",
                    "long_message"=>$m_val."\n".$b_val
                    ]);
            }
            switch ($type) {
                case 'm2b':
                    $order=$this->order_formatter(
                        $porder,$user,$mer,$bAdd,$mAdd,
                        $pickup_date,$delivery_date,$nsellerid,$rtn,$type);
                    break;

                case 'b2m':
                    $order=$this->order_formatter(
                        $porder,$mer,$user,$mAdd,$bAdd,
                        $pickup_date,$delivery_date,$nbuyerid,$rtn,$type);
                    break;

                default:
            }

            // $nv_orders=array();

			if ($rtn==False) {
				DB::table('userninjavan')->
					insert([
                        'user_id'=>$un_id,
                        'has_shipper_id'=>1,
                        'type'=>$type
					]);
            }
           
            $error=0;
            $packageCount=(int)$packageCount;
      
            for ($i=0; $i <$packageCount ; $i++) { 
                $cn=$nv_class->create_order($order);
                // dump($cn);
                $details=$cn['data'];
                switch ($cn['httpCode']) {
                    case '200':
                        
                        $this->post_create_order_processing($details,$porder,$type);  
                        break;
                        
                    case '401':
                       
                        // dump($data);
                        // dump($data->code);
                        // dump(gettype($data));
                        // $data=json_decode($cn['data'], true); 
                        switch ($details->code) {
                            case '2011':
                                /*Expired Token.*/
                                if ($details->description=="UNAUTHORIZED_ACCESS_TOKEN") {
                                    $nv_class->get_access_token(); 
                                    $cn=$nv_class->create_order($order);
                                    $details=$cn['data'];
                                    // dump($details);
                                    $this->post_create_order_processing($details,$porder,$type); 
                                }
                                
                                
                                break;
                            
                            default:
                               
                                $cn=$nv_class->create_order($order);
                                $details=$cn['data'];
                                $this->post_create_order_processing($details,$porder,$type);
                                DB::table('userninjavan')->
                                insert([
                                    'user_id'=>$un_id,
                                    'has_shipper_id'=>1,
                                    'type'=>$type
                                ]);
                                break;

                        }
                        break;

                    default:
                       throw new Exception("Error Processing Request", 1);
                       
                        break;
                }
                // if ($cn['httpCode'] =="200") {
                    
                // } elseif ($cn['httpCode']=="400") {
                //     $error=1;

                // }elseif ($cn['httpCode']=="401") {
                    
                // }
                /* else {
					if ($error>0) {
						return response()->json([
						'status' => 'failure',
						'short_message' => 'HTTP Error:'.$cn['httpCode'],
						'long_message' => 'Something went wrong. Please contact OpenSupport.']);
					}

					$error_is_rtn=$this->identify_error();
					if ($cn['httpCode']=="401" and $error_is_rtn==True) {
						$cn=$nv_class->create_order($order);
                        if ($cn['httpCode'] =="200") {
                            $details=$cn['data'];
                            $this->post_create_order_processing($details,$porder,$type);  
                        } else {
                            $error=1;
                        }

						DB::table('userninjavan')->
							insert([
								'user_id'=>$un_id,
								'has_shipper_id'=>1,
                                'type'=>$type
							]);
					}
				}*/
			}

            $porder->status = $status;

            // Update OrderProduct
			$ops = OrderProduct::where('porder_id', $porder->id)->
				where('status', $pstatus)->
				update(['status'=>$status]);
           
            $porder->save();
            return response()->json([
                'status' => 'success',
                'short_message' => 'P&O updated',
                'long_message' => 'The logistic has been informed. Please ready the package for pickup']);

        } catch (\Exception $e) {
            
            Porder::where('id',$porder->id)->update(['status'=>$backup_status]);

            return response()->json([
                'status' => 'failure',
                'short_message' => $e->getMessage()."\nFILE:".
					$e->getFile().":".$e->getLine(),
                'long_message' => 'Something went wrong. Please contact OpenSupport.']);

            
        }
    }

    public function post_create_order_processing($details,$porder,$type)
    {
		$ret = 0;
        $tracking_id=$details->tracking_number;
		try {
			$nvship=new NvShip;
			$nvship->nv_tracking_id=$tracking_id;
			$nvship->nv_status="success";
			$nvship->nv_message="";
			$nvship->nv_order_ref_no=$details->reference->merchant_order_number;
			$nvship->save();
        } catch (\Exception $e) {
			dump($e->getMessage().
                "\nFILE:".$e->getFile().":".$e->getLine().
                "\nUSER:".$user_id);
			return ($e->getMessage().
                "\nFILE:".$e->getFile().":".$e->getLine().
                "\nUSER:".$user_id);
		}

        /* Add record in delivery */
		try {
			$del=new Delivery;
			$del->porder_id=$porder->id;
			$del->logistic_id=$this->logistic_id;
			$del->status="active";
			$del->consignment_number=$tracking_id;
			$del->type=$type;
			$del->save();
		} catch (\Exception $e) {
			dump($e->getMessage().
                "\nFILE:".$e->getFile().":".$e->getLine().
                "\nUSER:".$user_id);
			return ($e->getMessage().
                "\nFILE:".$e->getFile().":".$e->getLine().
                "\nUSER:".$user_id);
		}
    }

	// THE CODE BELOW CALLS THE LOGISTIC
    public function callLogistic_v3(Request $r)
    {
		$pstatus = null;
		$status = "pending";
        try {
            $order_id = $r->oid;

            /*Validation Block*/
            $porder = POrder::find($order_id);
            if (!in_array($porder->status,["m-processing1","request-goods"])) {
             return response()->json([
			 	'status' => 'failure',
				'short_message' => "Bad Porder Status",
				'long_message' => 'Logistic has already been called. Please contact OpenSupport.']);   
            }

            $type = "m2b";
            $nvtype="NORMAL";
            $status="m-processing2";
            $pstatus = "m-processing1";
            if ($r->has('type')) {
				$type = $r->type;
                switch($r->type)  {
				case "m2b":
					$status = "m-processing2";
					$pstatus = "m-processing1";
					break;
				case "b2m":
					$nvtype="RETURN";
					$pstatus = "request-goods";
					$status = "call-logistic1";
					break;
				default:
					break;
				}
			}
				
            // return $type;
            // Validation

            $isotime = $r->ts;
          
            $packageArray = $r->pd;
            $packageCount = $r->count;
			//dd($packageCount);
            $datetime = new DateTime($isotime);
            $pickup_date = $datetime->format("Y-m-d");

            $delivery_date=$datetime->add(
				new DateInterval('P1D'))->format("Y-m-d");
           
            // $dt = explode(" ", $fdate);
            // $pref_date = $dt[0];
            // $t = explode(":", $dt[1]);
            // $hr = $t[0];
            // $min = $t[1];

            $buyer_user_id = $porder->user_id;
            $user = User::find($buyer_user_id);

            $pid = OrderProduct::where('porder_id', $order_id)->pluck('product_id');
            $mp = MerchantProduct::where('product_id', $pid)->first();
            if (is_null($mp)) {
                $product = Product::find($pid);

                if (is_null($product)) {

                    $product = Product::where('parent_id', $pid)->first();
                }
                // ////dump($product);
                $mp = MerchantProduct::where('product_id', $product->id)->first();
                if (is_null($mp)) {
                    $mp = MerchantProduct::where('product_id', $product->parent_id)->first();
                }
            }
            // $mer=Merchant::find($mp->merchant_id);
            $mer = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                ->where('merchant.id', '=', $mp->merchant_id)
                ->select(DB::raw("
                        merchant.*,
                        users.email
                        "))
                ->first();
            $mAdd = DB::table('address')->where('address.id', $mer->address_id)
                ->join('city', 'address.city_id', '=', 'city.id')
                ->join('state', 'city.state_code', '=', 'state.code')
                ->select(DB::raw("
                address.*,
                city.name as city,
                state.name as state
                "))
                ->first();
            $bAdd = DB::table('address')->where('address.id', $user->default_address_id)
                ->join('city', 'address.city_id', '=', 'city.id')
                ->join('state', 'city.state_code', '=', 'state.code')
                ->select(DB::raw("
                address.*,
                city.name as city,
                state.name as state
                "))
                ->first();

            /*Create an order with NinjaVan*/ 
            $nv_class=new NV;

            switch ($type) {
                case 'm2b':
                    $order=$this->order_formatter(
						$porder,$user,$mer,$bAdd,$mAdd,
						$pickup_date,$delivery_date,$type);
                    break;
                case 'b2m':
                    $order=$this->order_formatter(
						$porder,$mer,$user,$mAdd,$bAdd,
						$pickup_date,$delivery_date,$type);
                    break;
                default:
                    # code...
                    break;
            }

            $nv_orders=array();
            for ($i=0; $i <$packageCount ; $i++) { 
                array_push($nv_orders,$order);
            }
			//////dump($nv_orders);
			//////dump('nv_subshipper_id='.$mer->nv_subshipper_id);

			/* Decide on subshipper_id based on APP_ENV */
			switch(env('APP_ENV')) {
				case "production":
				case "prod":
				case "prd":
					$shipper_id = $mer->nv_subshipper_id;
					break;

				default:
					$shipper_id = "3684";
			}

			$cn=$nv_class->create_order($shipper_id, $nv_orders, $nvtype);

            $data=$cn['data'];

			//////dump($data);
			//////dump($packageCount);

            for ($i=0; $i <$packageCount ; $i++) { 
				if(isset($cn['data'][$i])){
					$details=$cn['data'][$i];

					$tracking_id=$details->tracking_id;
				   
					$nvship=new NvShip;
					$nvship->nv_tracking_id=$tracking_id;
					$nvship->nv_order_id=$details->id;
					$nvship->nv_status=$details->status;
					$nvship->nv_message=$details->message;
					$nvship->nv_order_ref_no=$details->order_ref_no;
					$nvship->save();

					/*Add record in delivery */
					$del=new Delivery;
					$del->porder_id=$porder->id;
					$del->logistic_id=$this->logistic_id;
					$del->status="active";
					$del->consignment_number=$tracking_id;
					$del->type=$type;

					$del->save();
				}
            }
            
            if ($cn['http_code'] =="200") {
                /*  Paul on 09 May 2017 at 1 15 am
                    DR Error means Duplicate Request  */
                if($porder->status === $status)
                    return response()->json([
						'status' => 'failure',
						'short_message' => 'DR Error',
						'long_message' => 'You have already called the Logistic.']);
                /*  Ends Here  */

				// Update status
				$porder->status = $status;

                // Update OrderProduct
                $ops = OrderProduct::where('porder_id', $porder->id)
                    ->where('status', $pstatus)
                    ->get();

                foreach ($ops as $op) {
                    $o = OrderProduct::find($op->id);

                    //  Paul on 09 May 2017
                    if($o->status === $status)
                        return response()->json([
							'status' => 'failure',
							'short_message' => 'DR Error',
							'long_message' => 'You have already called the Logistic.']);

                    $o->status = $status;
                    $o->save();
                }
                // $porder->call_logistic_count=1;
                $porder->save();
                return response()->json([
					'status' => 'success',
					'short_message' => 'P&O updated',
					'long_message' => 'The logistic has been informed. Please ready the package for pickup']);
            }
            return response()->json([
				'status' => 'failure',
				'short_message' => 'HTTP Error:'.$cn['http_code'],
				'long_message' => 'Something went wrong. Please contact OpenSupport.']);
        } catch (\Exception $e) {
            //  Paul on 13 April 2017 at 10 10 pm
                // ////dump($e);
            //  Ends Here
            return response()->json([
				'status' => 'failure',
				'short_message' => $e->getMessage(),
				'long_message' => 'Something went wrong. Please contact OpenSupport.']);
        }

    }


    /* Tracking */
    public static function track($consignmentNumber)
    {
        $ret = "Could not be tracked";
        try {
            $c = new CL;
            $ret = $c->trackDetail($consignmentNumber);
        } catch (\Exception $e) {

        }
        return $ret;

    }

    /* Webhook Successful Delivery */ 
    public function handle_sdelivery()
    {
        // $hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
        $data = file_get_contents('php://input');

        $nv = new NV;
        return $nv->webhook("successful_delivery", $data);
    }
}
