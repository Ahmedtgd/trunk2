<?php namespace App\Classes;

use DB;
use GuzzleHttp;
use App\Http\Controllers\UtilityController as UC;
use App\Models\POrder;

define("WEBHOOK_LOGFILE", "/tmp/webhook.log");
class NinjaVan {
	public $attempts = 0;

	public function check_production() {
		$env = env('APP_ENV');

		switch($env) {
			case "production":
			case "prod":
			case "prd":
				$ret = TRUE;
				break;
			default:
				$ret = FALSE;
		}
		return $ret;
	}

	public function get_client_id($globals) {
		if ($this->check_production()) {
			$ret = $globals->nv_prd_client_id;
		} else {
			$ret = $globals->nv_client_id;
		}
		return trim($ret);
	}

	public function get_client_secret($globals) {
 		if ($this->check_production()) {
			$ret = $globals->nv_prd_client_secret;
		} else {
			$ret = $globals->nv_client_secret;
		}
		return trim($ret); 
	}

 	public function get_base_uri($globals) {
 		if ($this->check_production()) {
			$ret = $globals->nv_prd_base_uri;
		} else {
			$ret = $globals->nv_base_uri;
		}
		return trim($ret); 
	}
 
	public function curl_connection($url, $headers, $data, $custom){
		//dump($url);

		$ch = curl_init(trim($url));
		if(!is_null($data)){
			/* $data SHOULD BE already JSON encoded */
			// dump($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		if(!is_null($custom)){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $custom);
		}		

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_TIMEOUT, '30');	
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		
		$response = json_decode(curl_exec($ch));
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
		curl_close($ch); 
		$ret['response'] = $response;
		$ret['http_code'] = $http_code;
		return $ret;
	}

	/* Get an access token for API usage */
	public function check_access_token() {
		$access_token = null;
		$nvlog = DB::table('logistic')->where('id',3)->pluck('access_token');
		if(!is_null($nvlog)){
			$access_token =$nvlog;
		}
		return $access_token;
	}
	
	public function get_access_token() {
		$globals = DB::table('global')->first();
		$client_id = $this->get_client_id($globals);
		$client_secret = $this->get_client_secret($globals);
		$base_uri = $this->get_base_uri($globals);
		$grant_type = "client_credentials";
		$auth_uri = trim($globals->nv_auth_api);

		$data = json_encode(compact("client_id","client_secret","grant_type"));
		
		$headers = array();    
		$headers[0] = 'Content-type: application/json';  
		$url = trim($base_uri . $auth_uri);

		$token = $this->curl_connection($url, $headers, $data, NULL);

		$response = $token['response']; 
		

		$http_code = $token['http_code']; 
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
	//	$return['credentials'] = json_encode($data);
	//	$return['url'] = $base_uri . $auth_uri;
		$return['data'] = null;
		$return['http_code'] = $http_code;
		if(!is_null($response)){
			if(isset($response->access_token)){
				$return['status'] = 'success';
				$return['short_message'] = 'OK';
				$return['long_message'] = 'Access Token Successfully Obtained!';
				$return['data'] = $response;
				DB::table('logistic')->where('id',3)->
					update(['access_token'=>$response->access_token]);
			} else {
				$return['short_message'] = 'Access Token Error';
				$return['data'] = $response;
			}
		}

		return $return;
	}

	public function fake_create_order($nv_shipper_id, $orders, $type="NORMAL") {
		$return['status'] = 'success';
		$return['short_message'] = 'Order successfully';
		$return['http_code'] = '200';
		$return['long_message'] = 'HTTP: 200';

	    $b = [];
		foreach($orders as $order){   
			$a['id'] = 'e436b54670-5481-41d2-4gf6-07bd8334d430';
			$a['status'] = 'SUCCESS';
			$a['message'] = 'ORDER CREATED';
			$a['order_ref_no'] = $order->order_ref_no;
			$a['tracking_id'] =  time();
			array_push($b, (object)$a);
		}

		$return['data'] = $b;

		return $return;
	}
	
	/* Create a single or multiple shipper order */
	public function create_order_v3($orders, $type="NORMAL") {

		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;

			} else {
			
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		if($access_token != ''){
			$globals = DB::table('global')->first();
			$base_uri = $this->get_base_uri($globals);
			$order_uri = $globals->nv_order_api;
			$msorder_uri = $globals->nv_ms_order_api;
			$headers = array();    
			$headers[0] = 'Authorization: Bearer '.$access_token;    
			$headers[1] = 'Content-type: application/json';      
			$postorders = array();
			$json_orders=array();

			foreach($orders as $order){   
				$order_data['from_postcode'] = $order->from_zip_code;    
				$order_data['from_address1'] = $order->from_line1;    
				$order_data['from_address2'] =  $order->from_line2;      
			
				$order_data['from_city'] =  $order->from_city;     
				$order_data['from_state'] = $order->from_state;    
				$order_data['from_country'] = $order->from_country;    
				$order_data['from_email'] = $order->from_email;   
				$order_data['from_name'] = $order->from_name;    
				$order_data['from_contact'] = $order->from_contact;    
				$order_data['to_postcode'] = $order->to_zip_code;    
				$order_data['to_address1'] =  $order->to_line1;    
				$order_data['to_address2'] =  $order->to_line2;   
			 
				$order_data['to_city'] =  $order->to_city;    
				$order_data['to_state'] =  $order->to_state;   
				$order_data['to_country'] =  $order->to_country;   
				$order_data['to_email'] =  $order->to_email;    
				$order_data['to_name'] =  $order->to_name;    
				$order_data['to_contact'] =  $order->to_contact;     
				$order_data['delivery_date'] = $order->delivery_date;    
				$order_data['pickup_date'] = $order->pickup_date;   
				$order_data['pickup_weekend'] = false;
				$order_data['delivery_weekend'] = true;
				$order_data['staging'] = false;
				$order_data['pickup_timewindow_id'] = 1;
				$order_data['delivery_timewindow_id'] = 2;
				$order_data['max_delivery_days'] = 1;    
				// $order_data['cod_goods'] = $order->cod_goods;   
		
				/*
				$order_data['requested_tracking_id'] =
					substr('"'.time().'"', 0, 9);
				*/

				/* time() NEEDS TO BE REPLACED BY $nporder_id */
				$order_data['order_ref_no'] =  $order->order_ref_no;
				/*---------------------------------------------*/

				$order_data['type'] = $type; 	// Must be in CAPS!!   
				$order_data['parcel_size'] = $order->size;
				$order_data['parcel_volume'] = $order->volume;
				$order_data['parcel_weight'] = $order->weight;
				array_push($json_orders,$order_data);
				$ood=(object)$order_data;
				// UC::dynamic_save_loose($ood,"nv_order_create_req","nv_");
				DB::table('nv_order_create_req')->insert([


					]);
			}		

			if(is_null($nv_shipper_id)){
				$url = $base_uri . $order_uri;
			} else {
				$url = $base_uri . str_replace("{{\$shipper_id}}",
					$nv_shipper_id, $msorder_uri);
			}
			
			$json_orders=json_encode($json_orders);

			$get_orders = $this->curl_connection($url, $headers,
				$json_orders, null);

			$http_code = $get_orders['http_code'];
			$response = $get_orders['response'];
			$return['http_code'] = $http_code; 
			switch($http_code) {
				case 202:
					$return['status'] = 'success';
					$return['short_message'] = 'Order successfully';
					$return['long_message'] = 'HTTP: ' . $http_code;
					$return['data'] = $response; 
					$this->attempts = 0;
					break;

				## Order was created successfully and the Order object is
				## returned, hence 
				case 200:
					$return['status'] = 'success';
					$return['short_message'] = 'os';
					$return['long_message'] = 'HTTP: ' . $http_code;
					$return['data'] = $response; 
					$this->attempts = 0;
					break;

				default:
					if($http_code == 401 && $this->attempts == 0){
						$this->attempts++;
						

						$this->get_access_token();
						$return = $this->create_order_v3($nv_shipper_id,
							$orders,"NORMAL");
					


					} else {
						$this->attempts = 0;
						$return['short_message'] = 'Error: Order NOT created 2!';
						$return['long_message'] = 'HTTP: ' . $http_code;
						$return['data'] = $response;
					}		
			 } 			
		}
		return $return;
	}

	/* DANGER danger Danger
	   Confirm postcode length */ 
	public function address_validator($address)
	{
		$ret=null;

		if($address->country==NULL) return "Missing Country Details.";
		switch ($address->country) {
			case 'MY':
				if (strlen($address->postcode) != 5) {
					return "Incorrect Zip Code for Malaysia";
				}
				break;
			case 'SG':
				if (strlen($address->postcode) != 6) {
					return "Incorrect Zip Code for Singapore";
				}
				break;
			default:
				//return "Incorrect Zip Code";
		}
	}

	public function details_validator($value='')
	{
		/*
			Name must be between 3 and 255
		*/ 
	}

	/* NinjaVan Order API v4.0 */ 
	public function create_order($orders)
	{
		$ret=array();
		$access_token=null;

		$globals = DB::table('global')->first();
		$base_uri = $this->get_base_uri($globals);
		$order_uri = $globals->nv_order_api;
		$url = $base_uri.$order_uri;

		$json_orders = json_encode($orders);
		//dump($json_orders);

		/* Check for Token */
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;

			} else {
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

 		if (is_null($access_token)) {
 			$ret['httpCode'] = 000;
			$ret['body'] = 'Error: Missing Access Token!';
			$ret['data'] = NULL;
			return $ret;
 		}
 		
		$headers[0] = 'Authorization: Bearer '.$access_token;    
		$headers[1] = 'Content-type: application/json';        
		$get_orders = $this->curl_connection($url, $headers,
				$json_orders, null);

		//dump($get_orders);

		/* Remove http_code from array */
		// dd($get_orders);
		
		$http_code = $get_orders['http_code'];
		$response = $get_orders['response'];
		$ret['httpCode'] = $http_code; 
		$ret['data'] = $response;

		switch($http_code) {
			case 202:
				$body = json_decode($body);        
				// print_r($body); 

				## The Order ID returned.
				## This can be stored in db if needed.
				$parcel_id = $body[0]->id;        
				$parcel_size_id = $body[0]->parcel_size_id;        
				$parcel_volume = $body[0]->volume;        
				$parcel_weight = $body[0]->weight; 

				$header = array();        
				$header[0] = 'Authorization: Bearer '.nv1();    

				$ch = curl_init();        
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);        
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
				curl_setopt($ch, CURLOPT_TIMEOUT, '3');       
				$body = curl_exec($ch);        
				$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);       
				// print_r($body); 
				break;

			## Order was created successfully and the Order object is
			## returned, hence 
			case 200:
					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Order created.!';
					$ret['data'] =$response;
				
				break;

			default:
				$ret['httpCode'] = $http_code;
				$err = null; $msg = null;
				if (isset($ret['data']->error)) {
					$err = $ret['data']->error;
					if (isset($err->message)) {
						$msg = $err->message;
					}
				}
				$ret['long_message'] = $msg;
				$ret['body'] = 'Error: Order NOT created 2!';
				//$ret['data'] = NULL;
		 } 

		 return $ret;
	}


	/* Given a merchant create a sub shipper */
	public function create_subshipper($merchant) {
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				//dump('DB access token NULL or empty! ['.$access_token."]");
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;

			} else {
				//dump('Using access token from cache! ['.$access_token."]");
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		if($ret['status'] == 'success'){
			$globals = DB::table('global')->first();
			$base_uri = $this->get_base_uri($globals);
			$subshipper_uri = $globals->nv_subshipper_api;
			$headers = array();    
			$headers[0] = 'Authorization: Bearer '.$access_token;    
			$headers[1] = 'Content-type: application/json';         

			/*** Merchant should have user and Merchant Information ***/
			$sshipper = array();    
			$sshipper['name'] = $merchant->{'name'};    
			$sshipper['short_name'] = $merchant->company_name;    
			$sshipper['company_name'] = $merchant->company_name;    
			$sshipper['email'] = $merchant->email;    
			$sshipper['contact'] = $merchant->mobile_no;    
			$sshipper['prefix'] = $merchant->prefix;    
			$sshipper['liaison_name'] = "";    
			$sshipper['liaison_contact'] = "";
			$sshipper['liaison_email'] = "";
			$sshipper['liaison_address'] = "";    
			$sshipper['liaison_postcode'] = "";    
			$sshipper['billing_name'] = "";    
			$sshipper['billing_contact'] = "";    
			$sshipper['billing_address'] = "";    
			$sshipper['billing_postcode'] = "";    

			$settings['address_1'] = $merchant->line1;
			$settings['address_2'] = $merchant->line2;
			$settings['city'] = $merchant->city;
			//$settings['country'] = "Singapore";
			$settings['postcode'] =  $merchant->zip_code;
			$settings['name'] = $merchant->name;
			//$settings['contact'] = "60144443334";
			$settings['email'] = $merchant->email;
			$sshipper['returns_settings'] = $settings;

			$rservsettings['days'] = [1,2,3,5,6,7];
			$autorsettings['enabled'] = true;
			$autorsettings['ready_time'] = "09:00:00";
			$autorsettings['latest_time'] = "18:00:00";
			$autorsettings['order_create_cutoff_time'] = "00:05:00";

			$arsaddress['postcode'] = "432344";
			$arsaddress['address_1'] = $merchant->line1;
			$arsaddress['address_2'] = $merchant->line2;
			$arsaddress['city'] = $merchant->city;
			$arsaddress['country'] = $merchant->country;
			$arsaddress['name'] = $merchant->name;
			$arsaddress['contact'] = $merchant->mobile_no;
			$arsaddress['email'] = $merchant->email;
			$autorsettings['address'] = $arsaddress;
			$rservsettings['auto_reservation_settings'] = $autorsettings;

			$sshipper['reservation_settings'] = $rservsettings;
			$url = $base_uri . $subshipper_uri;
			$data = json_encode($sshipper);
			$create_sp = $this->curl_connection($url, $headers, $data, null);

			$http_code = $create_sp['http_code'];
			$response = $create_sp['response'];
			if($http_code == 401 && $this->attempts == 0){
				$this->attempts++;
				//dump("HTTP 401: attempts=".$this->attempts);

				$this->get_access_token();
				$return = $this->create_subshipper($merchant);
				//dump('Nested create_subshipper():');

			} else {
				$return['http_code'] = $http_code;
				if (!is_null($response->{'messages'}[0])) {
					$return['short_message'] = $response->{'messages'}[0];
					$return['long_message'] = 'Unable to create Subshipper';
					$return['data'] = $response;
				} elseif (!is_null($response->{'id'})) {
					$return['status'] = 'success';
					$return['short_message'] = 'OK';
					$return['long_message'] = 'Subshipper successfully created!';
					$return['data'] = $response;
				} else {
					//$ret = NULL;
				}
			}
		}

		return $return;
	}

	/* Order can be searched via 4 ID types */
	public function search_order($criteria, $type) {
		/* $type=1; $criteria -> order_ref_no
		 * $type=2; $criteria -> requested_tracking_id
		 * $type=3; $criteria -> tracking_id
		 * $type=4; $criteria -> order_id */
		switch($type) {
			case 1:
				$search_data = "order_ref_no=".$criteria;
				break;
			case 2:
				$search_data = "requested_tracking_id=".$criteria;
				break;
			case 3:
				$search_data = "tracking_id=".$criteria;
				break;
			default:
				$search_data = "order_id=".$criteria;
				break;
		}
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;
			} else {
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}
		
		if($ret['status'] == 'success'){
			$globals = DB::table('global')->first();
			$base_uri = $this->get_base_uri($globals);
			$search_uri = $globals->nv_search_api;
			$headers = array();    
			$headers[0] = 'Authorization: Bearer '. $access_token;    
			$headers[1] = 'Content-type: application/json'; 
			$search_string = $search_data;			
			$url = $base_uri . $search_uri ."?".$search_string;
			$search = $this->curl_connection($url, $headers, null,null);
			$http_code = $search['http_code'];
			$response = $search['response'];
			if($http_code == 401 && $this->attempts == 0){
				$this->attempts++;
				$this->get_access_token();
				$return = $this->search_order($criteria, $type);
			} else {
				$return['status'] = 'success';
				$return['short_message'] = 'OK';
				$return['long_message'] = 'Searching success!';
				$return['data'] = $response;
				$return['http_code'] = $http_code;
			}
		}			

		return $return;
	}

	/* Cancels an order using order_id */
	public function cancel_order_v3($nv_order_id) {
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;
			} else {
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}
		
		if($ret['status'] == 'success'){
			$globals = DB::table('global')->first();
			$base_uri = $this->get_base_uri($globals);
			$cancel_uri = $globals->nv_cancel_api;
			$headers = array();    
			$headers[0] = 'Authorization: Bearer '.$access_token;    
			$headers[1] = 'Content-type: application/json'; 		
			$url = $base_uri . $cancel_uri ."/".$nv_order_id;
			$search = $this->curl_connection($url, $headers, null,"DELETE");
			$http_code = $search['http_code'];
			$response = $search['response'];
			if($http_code == 401 && $this->attempts == 0){
				$this->attempts++;
				$this->get_access_token();
				$return = $this->cancel_order($nv_order_id);
			} else {
				$return['status'] = 'success';
				$return['short_message'] = 'OK';
				$return['long_message'] = 'Cancel success!';
				$return['data'] = $response;
				$return['http_code'] = $http_code;
			}
		}
		return $return;
	}
	public function get_headers()
	{
		$access_token=NULL;
		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;
			} else {
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			// dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}
		if (is_null($access_token)) {
			return NULL;
		}
		$headers = array();    
		$headers[0] = 'Authorization: Bearer '. $access_token;
		$headers[1] = 'Content-type: application/json';
		return $headers;

	}


	public function cancel_order($tracking_id,$country_code="sg")
	{
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		$global=DB::table('global')->first();
		$base_uri=$global->nv_prd_base_uri;
		$cancel_uri=$global->nv_cancel_api;
		$cancel_uri=str_replace("{{tracking_id}}",$tracking_id,$cancel_uri);

		// $url="https://api.ninjavan.co/".$country_code."/4.0/orders/".$tracking_id."/cancel";
		$url=$base_uri.$cancel_uri;
		$post_data['trackingNo']=$tracking_id;
		$post_data['countryCode']=$country_code;
		$post_data=json_encode($post_data);
		$headers=$this->get_headers();
		if (is_null($headers)) {
			return $return;
		}
		
		$action = $this->curl_connection($url, $headers,$post_data,null);
		$http_code = $action['http_code'];
		$response = $action['response'];
		if($http_code == 401 && $this->attempts == 0){
			$this->attempts++;
			$this->get_access_token();
			$return = $this->cancel_order($nv_order_id);
		} else {
			$return['status'] = 'success';
			$return['short_message'] = 'OK';
			$return['long_message'] = 'Cancel success!';
			$return['data'] = $response;
			$return['http_code'] = $http_code;
		}
		return $return;;
	}

	/*Track Id for NV API v4*/ 
	public function track_order($tracking_id,$country_code="sg")
	{
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;
		$url="https://api.ninjavan.co/".$country_code."/4.0/orders/".$tracking_id;
		$headers=$this->get_headers(); 
		$track=$this->curl_connection($url,$headers,null,null);
		$http_code = $track['http_code'];
		$response = $track['response'];
		if($http_code == 401 && $this->attempts == 0){
				$this->attempts++;
				$this->get_access_token();
				$return = $this->track_order($tracking_id);
			} else {		
				$this->attempts=0;
				$return['status'] = 'success';
				$return['short_message'] = 'OK';
				$return['long_message'] = 'Tracking order success!';
				$return['data'] = $response;
				$return['http_code'] = $http_code;
		}
		return $return;

	}

	/* Given an array of tracking_ids, returns the statuses of them */
	public function track_order_v3($array_of_tracking_ids) {
		$return['status'] = 'failure';
		$return['short_message'] = 'Null Error';
		$return['long_message'] = 'Unable to get Access Token';
		$return['data'] = null;
		$return['http_code'] = null;

		try {
			$access_token = $this->check_access_token();
			if(is_null($access_token) or empty($access_token)){
				$ret = $this->get_access_token();
				$access_token = $ret['data']->access_token;
			} else {
				$ret['status'] = 'success';
			}

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		if($ret['status'] == 'success'){
			$globals = DB::table('global')->first();
			$base_uri = $this->get_base_uri($globals);
			$track_uri = $globals->nv_track_api;
			$headers = array();    
			$headers[0] = 'Authorization: Bearer '. $access_token;
			$headers[1] = 'Content-type: application/json'; 		
			$url = $base_uri . $track_uri;
			$track = $this->curl_connection($url, $headers,
				json_encode($array_of_tracking_ids), null);

			$http_code = $track['http_code'];
			$response = $track['response'];

			if($http_code == 401 && $this->attempts == 0){
				$this->attempts++;
				$this->get_access_token();
				$return = $this->track_order($array_of_tracking_ids);
			} else {		
				$this->attempts=0;
				$return['status'] = 'success';
				$return['short_message'] = 'OK';
				$return['long_message'] = 'Tracking order success!';
				$return['data'] = $response;
				$return['http_code'] = $http_code;
			}
		}
		return $return;
	}

	/* Verification of NV WebHook messages */
	public function verify_webhook($data, $hmac_header){
		$globals = DB::table('global')->first();
		$client_secret = trim($globals->nv_client_secret);
		$calculated_hmac = base64_encode(
			hash_hmac('sha256', $data, $client_secret, true));

		return ($hmac_header == $calculated_hmac);
	}

	/* Log webhooks to a log file */
    public function log_webhook($verified, $data, $logfile){
		$fp = fopen($logfile, 'a');
		if ($verified) {     
			fwrite($fp, $data."XXX\n");

		} else {
			// HMAC SHA256 verification failed!
			fwrite($fp, "Webhook verification FAILED!\n");
			fwrite($fp, $data."\n");
		}

		fwrite($fp, "-------------------------------------------------\n");
		fclose($fp);
    }

 	/* Log webhooks to a log file */
    public function log($event, $data, $logfile){
		$fp = fopen($logfile, 'a');
		fwrite($fp, $event.":".$data."\n");
		fwrite($fp, "-------------------------------------------------\n");
		fclose($fp);
    }
 

	/* Process a subscribed NV webhook event:
	 * Respond with "200 OK" */
	public function webhook($event, $jsondata, $hmac=null) {
		$pstatus = $dtimestamp = $comments = null;
		$status='failed';
		$table = $column = $field = null;
		//$verified = NinjaVan::verify_webhook($jsondata, $hmac);
		$verified = true;
		NinjaVan::log($event, $jsondata, WEBHOOK_LOGFILE);

		$now = \Carbon\Carbon::now()->toDateTimeString();

		try {
			$data = json_decode($jsondata, true);
			if (isset($data['id']) && !empty($data['id'])) {
				$nv_order_id = trim($data['id']);

			} elseif (isset($data['order_id']) && !empty($data['order_id'])) {
				$nv_order_id = trim($data['order_id']);
			} 

			if (isset($data['tracking_id'])) {
				$nv_tracking_id = trim($data['tracking_id']);
			}

			if (isset($data['shipper_id'])) {
				$nv_shipper_id = trim($data['shipper_id']);
			}

			/* shipper_order_ref_no => $nporder_id */
			if (isset($data['shipper_order_ref_no'])) {
				$nporder_id = trim($data['shipper_order_ref_no']);
				$porder_id=DB::table('nporderid')->
					where('nporder_id',$nporder_id)->pluck('porder_id');
			}

			/* This is for pending_reschedule */
 			if (isset($data['timestamp'])) {
				$dtimestamp = trim($data['timestamp']);
			}

 			if (isset($data['comments'])) {
				$comments = trim($data['comments']);
			}
 

			switch($event) {
				case "staging":
					break;

				case "pending_pickup":
					$table  = "delivery";
					$where  = "porder_id";
					$column = "status";
					$value  = "pending";
					$type = DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						pluck('type');
					DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						update([$column => $value]);
					
					/* Updating porder.status to L-Processing and
					 * L-Processing1*/
 					$porder=POrder::find($porder_id);
					if (isset($porder)) {
						switch($type) {
							case "m2b":
								$pstatus="l-processing";
								break;
							case "b2m":
								$pstatus="l-processing1";
								break;
							default:
								$pstatus=$porder->status;
						}
						$porder->status=$pstatus;
						$porder->save(); 
					}
					break;

				case "van_enroute_to_pickup":
					break;
				case "enroute_to_sorting_hub":
					break;
				case "arrived_at_sorting_hub":
					break;
				case "on_vehicle_for_delivery":
					break;
				case "completed":
					break;

				case "pending_reschedule":
					/* You'd have to be in "l-collected" or "l-collected1"
					 * in order to be valid */
 					$porder=POrder::find($porder_id);
					if (empty($porder)) break;

					$status = $porder->status;
 					$table  = "delivery";
					$where  = "porder_id";
					$column = "status";
					$value  = null;
					$attempt = 0;

  					$del_rec = DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						first();

					$dtype   = $del_rec->type;
					$dstatus = $del_rec->status;
					$delivery_id = $del_rec->id;

					if ($status == "l-collected" ||
						$status == "l-collected1") {
						switch ($dstatus) {
							case "inprogress":
								// Delivery failure #1
								$value = "dfailed1";
								$attempt = 1;
								break;
							case "dfailed1":
								// Delivery failure #2
								$value = "dfailed2";
								$attempt = 2;
								break;
							case "dfailed2":
								// Delivery failure #3
								$value = "dfailed3";
								$attempt = 3;
								break;
							default:
								$value = null;
								$attempt = 0;
						}
					}

					/* Update delivery status */
					try {
						DB::table($table)->
							where($where,$porder_id)->
							where('consignment_number',$nv_tracking_id)->
							update([$column => $value]);
 					} catch (\Exception $e) {
						NinjaVan::log($event,
							$e->getFile().":".$e->getLine()."\n".
							$e->getMessage(),
							WEBHOOK_LOGFILE);
					}

					/* Store delivery failure data */
					if ($attempt > 0) {
						try {
							DB::table('dfailure')->insert([
								'delivery_id' => $delivery_id,
								'type' => $dtype,
								'attempt' => $attempt,
								'failure_timestamp' => $dtimestamp,
								'failure_comment' => $comments,
								'created_at' => $now,
								'updated_at' => $now
							]);
						} catch (\Exception $e) {
							NinjaVan::log($event,
								$e->getFile().":".$e->getLine()."\n".
								$e->getMessage(),
								WEBHOOK_LOGFILE);
						}
					}

 					NinjaVan::log($event, $table."-".$where."-".$porder_id.
						"-".$column."-".$value,
						WEBHOOK_LOGFILE);
  					NinjaVan::log($event, 'dfailure'."-".$delivery_id."-".
						$attempt."-".$dtimestamp."-".$comments,
						WEBHOOK_LOGFILE); 
					break;

				case "pickup_fail":
					$table  = "delivery";
					$where  = "porder_id";
					$column = "status";
					$value  = "pickup_failed";

					/* Update status to "pickup_failed" */
					DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						update([$column => $value]);
 					$type = DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						pluck('type');

					NinjaVan::log($event, $table."-".$where."-".$porder_id.
						"-".$column."-".$value,
						WEBHOOK_LOGFILE);

					/* Update porder table */ 
					$porder=POrder::find($porder_id);
 					if (isset($porder)) {
						switch($type) {
							case "m2b":
								$pstatus="l-collected";
								break;
							case "b2m":
								$pstatus="l-collected1";
								break;
							default:
								$pstatus=$porder->status;
						}
						$porder->status=$pstatus;
						$porder->save();  
					}
					break;

				case "cancelled":
					break;
				case "returned_to_sender":
					break;

				case "parcel_size":
	 				$table = "nv_order_create_resp";
					$where = "nv_tracking_id";
					$column = "nv_new_size";
					$value = $data['new_size'];
					DB::table($table)->
						where($where,$nv_tracking_id)->
						update([$column => $value]); 
					break;

 				case "parcel_weight":
					$table = "nv_order_create_resp";
					$where = "nv_tracking_id";
					$column = "nv_new_weight";
					$value = $data['new_weight'];
					DB::table($table)->
						where($where,$nv_tracking_id)->
						update([$column => $value]);
					break; 

				case "arrived_at_distribution_point":
					break;

				case "first_attempt_delivery_fail":
 					$table  = "delivery";
					$where  = "porder_id";
					$column = "status";
					$value  = "delivery_failed";

					/* Update status to "delivery_failed" */
					DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						update([$column => $value, 'attempt' => 1]);

					NinjaVan::log($event, $table."-".$where."-".$porder_id.
						"-".$column."-".$value."-attempt:1",
						WEBHOOK_LOGFILE);

					/* Update porder table: Should we update porder? */ 
					$porder=POrder::find($porder_id);
					/* This is delivery first attempt, so it's at l-collected,
					 * but unable to go to b-collected */
					$pstatus="l-collected";

					if (isset($porder)) {
						$porder->status=$pstatus;
						$porder->save();
					}
					break;

				case "successful_delivery":
					/* Store POD */
					$pod         = $data['pod'];
					$pod_type    = $pod['type'];
					$pod_name    = $pod['name'];
					$pod_idno    = $pod['identity_number'];
					$pod_contact = $pod['contact'];
					$pod_uri     = $pod['uri'];
					$pod_lisp    = $pod['left_in_safe_place'];
					DB::table('nv_pod')->insert([
						'nv_order_id'=>$nv_order_id,
						'nv_tracking_id'=>$nv_tracking_id,
						'nv_shipper_order_ref_no'=>$porder_id,
						'nvpod_type'=>$pod_type,
						'nvpod_name'=>$pod_name,
						'nvpod_identityno'=>$pod_idno,
						'nvpod_contact'=>$pod_contact,
						'nvpod_uri'=>$pod_uri,
						'nvpod_left_in_safe_place'=>$pod_lisp,
						'created_at'=>$now,
						'updated_at'=>$now
					]);
					/*
					Save the URI image
					Naming convention. $porder_id.$nv_tracking_id.png
					*/ 
					$image_name=$porder_id.$nv_tracking_id.".png";
					$image_path=public_path("images/pod/".$image_name);
					copy($pod_uri,$image_path);

					/* Update delivery */
 					$table   = "delivery";
					$where   = "porder_id";
					$column1 = "status";
					$value   = "delivered";
					$column2 = "pickup_name";
					$value2  = $pod_name;
					$column3 = "pickup_nric";
					$value3  = $pod_idno;
					$column4 = "pickup_contact";
					$value4  = $pod_contact;
					DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
						update([
							$column1 => $value,
							$column2 => $value2,
							$column3 => $value3,
							$column4 => $value4,
							'delivered_date'=>$now
						]);
   					/*
						Update porder status only when all parcels have
						been delivered ~~ NOT OBSOLETE
   					*/ 
					$del_rec=DB::table('delivery')->
						where('porder_id',$porder_id)->
						whereNull('delivered_date')->get();

					if (is_null($del_rec) or empty($del_rec)) {
						$porder=POrder::find($porder_id);
						if (isset($porder)) {
							switch ($porder->status) {
								case 'l-collected':
									$pstatus="b-collected";
									break;
								case 'l-collected1':
									$pstatus="m-collected";
									break;
								default:
									$pstatus=$porder->status;
							}
							$porder->status=$pstatus;
							$porder->save();
						}
					}
					break;

				case "successful_pickup":
					$table  = "delivery";
					$where  = "porder_id";
					$column = "status";
					$value  = "inprogress";
					DB::table($table)->
						where($where,$porder_id)->
						where('consignment_number',$nv_tracking_id)->
							update([$column => $value]);

					NinjaVan::log($event, $table."-".$where."-".$porder_id.
						"-".$column."-".$value,
						WEBHOOK_LOGFILE);

					/* Update porder table */ 
					$porder=POrder::find($porder_id);
					if (isset($porder)) {
						if ($porder->status == 'l-processing' ||
							$porder->status == 'l-collected') {
							$pstatus="l-collected";
						} else {
							$pstatus="l-collected1";
						}
						$porder->status=$pstatus;
						$porder->save();
					}
					break;

				case "cross_border_transit":
					break;
				case "customs_cleared":
					break;
				case "customs_held":
					break;
				default:
			}

			$type = null;
			if (isset($nv_shipper_id) && !empty($nv_shipper_id)) {
				$delivery=DB::table('delivery')->
					where('consignment_number',$nv_tracking_id)->first();
				$type=$delivery->type;
				switch ($type) {
					case 'b2m':
						/*nv_shipper_id is NOT nbuyer_id*/
						$user_id=DB::table('porder')->
							where('id',$delivery->id)->
							pluck('user_id'); 
						break;
					case 'm2b':
						/*nv_shipper_id is NOT nseller_id*/
						$merchant_id=UC::porderMerchantId($delivery->porder_id); 
						$user_id=DB::table('merchant')->
							where('id',$merchant_id)->
							pluck('user_id');
						break;
					default:
						$user_id=null;
				}
				if (!empty($user_id)) {
					DB::table('userninjavan')->
						where('user_id',$user_id)->
						update(["shipper_id"=>$nv_shipper_id]);
				}
			}
			$status="success";

		} catch(\Exception $e){
			NinjaVan::log("EXCEPTION ".":".$e->getFile().":".$e->getLine().
				"\n".$event, $e->getMessage(), WEBHOOK_LOGFILE);
		}

		return $status;
	}
}

?>
