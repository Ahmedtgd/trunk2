<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\CityLinkConnection;
use App\Classes\SecurityIDGenerator;
use App\Classes\NinjaVan;
use App\Models\Merchant;
use App\Models\Station;
use App\Models\RoleUser;
use App\Models\QR;
use App\Models\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use QrCode;
use URL;
use Image;
use GuzzleHttp;
use File;
use Carbon;

/* UAT */
/*
define("NINJAVAN_CLIENT_ID", '3e6a0d9471a74e1689bdaaa316dde41f');
define("NINJAVAN_CLIENT_SECRET", '1d18fbc3c0a4479d86cf735a00241a17');
*/

/* Production */
define("NINJAVAN_CLIENT_ID", 'a07c0e78aa8949149d43542527df5ecf');
define("NINJAVAN_CLIENT_SECRET", 'b6657c33e496496086d4388a6aec74ac');


define("WHLOGFILE", "/tmp/webhook.log");


class ScriptController extends Controller
{
	/* These are all TEST methods ONLY. Not MEANT for production */
	public function testgen()
    {
		$a = new CityLinkConnection;
		/********* t() ********/
		/*$DOC  = "http://delta.opensupermall.com/citylink/good.xml";
		$xml_file = file_get_contents($DOC);*/
		/********* t1() ********/
		/*$hawb_type  = 'H';
		$hawb_value = '060306600093627';*/
		/********* t2() ********/
		/*$hawb_type  = 'X';
		$hawb_value = '433078310';*/
		/********* t3() ********/
		//$hawb_value = "060307001284015";
		/********* t4() ********/
	/*	$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		$hawb_no		= "060306600093627";	*/
		/********* t5() ********/
		/*$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		//$hawb_no		= "060306600093627";
		$hawb_no		= "06039900996880";		*/
		/********* t6() ********/
		$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		//$hawb_no		= "060306600093627";
		$hawb_no		= "06039900996880";
		$dump = $a->t6($transaction_id, $company_code, $account_no, $meter_num, $hawb_no);
		dump($dump);
	}


  	public function jnv1()
    {
		$nvclass = new NinjaVan;
		$response = $nvclass->get_access_token();
		dump($response);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */

	/* v2.0 Authentication API */
	public function nv1()
    {
		//$url = 'https://api-sandbox.ninjavan.co/sg/2.0/oauth/access_token';
		$url = 'https://api.ninjavan.co/my/2.0/oauth/access_token';
		dump($url);

  		$headers = array();
		$headers[0] = 'Content-type: application/json';

		$client_id = NINJAVAN_CLIENT_ID;
		$client_secret = NINJAVAN_CLIENT_SECRET;
		$grant_type = "client_credentials";

		$data = compact("client_id", "client_secret", "grant_type");
		dump(json_encode($data));

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		dump($ch);

		$response = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		$at = $response->access_token;
		//$at = 'RACwTsuCOFCFCFvk4wYTiBQg8txGIZjjYeTt2T2Yfoobar';

		return (isset($at) ? $at : null);
	}

	/* v1.0 Sub-shipper API */
  	public function jnv2()
    {
		$nvclass = new NinjaVan;
		$sshipper = array();
		$sshipper['name'] = "ABC";
		$sshipper['company_name'] = "Company ABC Sdn. Bhd.";
		$sshipper['email'] = "waisun.intermedius@gmail.com";
		$sshipper['mobile_no'] = "60122936511";
		$sshipper['prefix'] = "Mr";
		$sshipper['liaison_name'] = "";
		$sshipper['liaison_contact'] = "";
		$sshipper['liaison_email'] = "";
		$sshipper['liaison_address'] = "";
		$sshipper['liaison_postcode'] = "";
		$sshipper['billing_name'] = "";
		$sshipper['billing_contact'] = "";
		$sshipper['billing_address'] = "";
		$sshipper['billing_postcode'] = "";

		$sshipper['line1'] = "30 Jalan Kilang Barat";
		$sshipper['line2'] = "Singapore";
		$sshipper['city'] = "Singapore";
		//$settings['country'] = "Singapore";
		$sshipper['zip_code'] = "159363";
		$sshipper['country'] = "Singapore";
		$subshipper = $nvclass->create_subshipper((object)$sshipper);
		dump($subshipper);
		return $subshipper;
	}

	/* v1.0 Sub-shipper API */
  	public function nv2()
    {
		$url = 'https://api-sandbox.ninjavan.co/sg/1.0/shippers/sub-shippers';
 		$headers = array();
		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';
		//$headers[1] = 'Content-type: application/x-www-form-urlencoded';

		dump($url);
		$sshipper = array();
		$sshipper['name'] = "ABC";
		$sshipper['short_name'] = "Company ABC";
		$sshipper['company_name'] = "Company ABC Sdn. Bhd.";
		$sshipper['email'] = "waisun.intermedius@gmail.com";
		$sshipper['contact'] = "60122936511";
		$sshipper['prefix'] = "Mr";
		$sshipper['liaison_name'] = "";
		$sshipper['liaison_contact'] = "";
		$sshipper['liaison_email'] = "";
		$sshipper['liaison_address'] = "";
		$sshipper['liaison_postcode'] = "";
		$sshipper['billing_name'] = "";
		$sshipper['billing_contact'] = "";
		$sshipper['billing_address'] = "";
		$sshipper['billing_postcode'] = "";

		$settings['address_1'] = "30 Jalan Kilang Barat";
		$settings['address_2'] = "Singapore";
		$settings['city'] = "Singapore";
		//$settings['country'] = "Singapore";
		$settings['postcode'] = "159363";
		$settings['name'] = "John Smith";
		//$settings['contact'] = "60144443334";
		$settings['email'] = "returns@ninjavan.co";
		$sshipper['returns_settings'] = $settings;

		$rservsettings['days'] = [1,2,3,5,6,7];
		$autorsettings['enabled'] = true;
		$autorsettings['ready_time'] = "09:00:00";
		$autorsettings['latest_time'] = "18:00:00";
		$autorsettings['order_create_cutoff_time'] = "00:05:00";

		$arsaddress['postcode'] = "432344";
 		$arsaddress['address_1'] = "30 Jalan Kilang Barat (PICKUP)";
		$arsaddress['address_2'] = "Store #01-01";
		$arsaddress['city'] = "Singapore";
		$arsaddress['country'] = "Singapore";
		$arsaddress['name'] = "ABC Warehouse IC";
		$arsaddress['contact'] = "60114345453";
		$arsaddress['email'] = "warehouse@abc.com";
		$autorsettings['address'] = $arsaddress;
		$rservsettings['auto_reservation_settings'] = $autorsettings;

		$sshipper['reservation_settings'] = $rservsettings;

		dump($headers);
		//dump($sshipper);

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		$postfields = json_encode($sshipper);
		dump($postfields);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch));
		dump($response);

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($http_code);

		if (!is_null($response->{'messages'}[0])) {
			$ret = $response->{'messages'}[0];
		} elseif (!is_null($response->{'id'})) {
			$ret = $response->{'id'};
		} else {
			$ret = NULL;
		}

		return $ret;
	}

	public function jnv3()
    {
		$nvclass = new NinjaVan;
		$order_data = array();
		$order_data['from_zip_code'] = "159363";
		$order_data['from_line1'] = "30 Jalan Cempaka 4";
		$order_data['from_line2'] = "Taman Len Seng";
		$order_data['from_locality'] = "";
		$order_data['from_city'] = "Kuala Lumpur";
		$order_data['from_state'] = "Wilayah Persekutuan";
		$order_data['from_country'] = "MY";
		$order_data['from_email'] = "leonard.nimoy@gmail.com";
		$order_data['from_name'] = "LEONARD NIMOY";
		$order_data['from_contact'] = "99001122";
		$order_data['to_zip_code'] = "318993";
		$order_data['to_line1'] = "4 Jalan Wawasan 4/10";
		$order_data['to_line2'] = "Pusat Bandar Puchong";
		$order_data['to_locality'] = "Puchong";
		$order_data['to_city'] = "Kuala Lumpur";
		$order_data['to_state'] = "Wilayah Persekutuan";
		$order_data['to_country'] = "MY";
		$order_data['to_email'] = "jameskirk@gmail.com";
		$order_data['to_name'] = "JAMES T KIRK";
		$order_data['to_contact'] = "99110022";
		$order_data['delivery_date'] = "2016-03-10";
		$order_data['pickup_date'] = "2016-03-09";
		$order_data['pickup_weekend'] = false;
		$order_data['delivery_weekend'] = true;
		$order_data['staging'] = false;
		$order_data['pickup_timewindow_id'] = 1;
		$order_data['delivery_timewindow_id'] = 2;
		$order_data['max_delivery_days'] = 1;
		$order_data['cod_goods'] = 35.50;
		$order_data['pickup_instuction'] = "Doorbell broken; call once you arrive.";
		$order_data['delivery_instuction'] = "Door is missing; just come in and party.";
		//$order_data['requested_tracking_id'] = substr('"'.time().'"', 0, 9);
		$order_data['order_ref_no'] =  11223344;
		$order_data['type'] = "NORMAL"; 	// Must be in CAPS!!
		$order_data['size'] = 1;
		$order_data['volume'] = 1122;
		$order_data['weight'] = 1.2;
		$orders = array();
		$orders[0] = (object) $order_data;
		dump($orders);
		//$corders = $nvclass->create_order("3684", $orders);
		$corders = $nvclass->create_order("135", $orders);
		dump($corders);
		return $corders;
	}

	public function get_test_data()
	{
		$nseller_id = "45679abcdef";
		$from_data['name'] = "45679abcdef";
		$rtn = time();
		$order_data=array();
		$from_address['address1'] = "4 Jalan Wawasan 4/10";
		$from_address['address2'] = "Pusat Bandar Puchong";
		$from_address['area']  = "Puchong";
		$from_address['city']  = "Kuala Lumpur";
		$from_address['state']  = "Wilayah Persekutuan";
		/*
		$from_address['country']  = "SG";
		$from_address['postcode'] = "159363";
		*/
		$from_address['country']  = "MY";
		$from_address['postcode'] = "47160";

		$to_address['address1'] = "30 Jalan Cempaka 4";
		$to_address['address2'] = "Taman Len Seng, Cheras";
		$to_address['area']  = "Cheras";
		$to_address['city']  = "Kuala Lumpur";
		$to_address['state']  = "Wilayah Persekutuan";
		/*
		$to_address['country']  = "SG";
		$to_address['postcode'] = "160123";
		*/
		$to_address['country']  = "MY";
		$to_address['postcode'] = "55000";

		$order_data = array();
		$order_data['service_type'] = "Marketplace";
		$order_data['service_level'] = "Standard";
		$order_data['requested_tracking_number'] = $rtn;
		$order_data['reference'] =
			array('shipper_order_ref_no'=>(string)time());

		$from_data['phone_number'] = "0122936511";
		$from_data['email'] = "waisun.chia@gmail.com";
		$from_data['address'] = $from_address;

		$to_data['name'] = "Tony Stark";
		$to_data['phone_number'] = "0117788431";
		$to_data['email'] = "tony@stark.com";
		$to_data['address'] = $to_address;

		$order_data['from'] = $from_data;
		$order_data['to']   = $to_data;

		$tslot['start_time'] = "09:00";
		$tslot['end_time']   = "22:00";
		$tslot['timezone']   = "Asia/Kuala_Lumpur";

		$parcel_job['is_pickup_required'] = false;
		$parcel_job['delivery_start_date']  = "2018-09-01";
		$parcel_job['delivery_timeslot']    = $tslot;

		$dim['weight'] = 1.0;
		$dim['size'] = "L";
		$parcel_job['delivery_instructions'] = "Handle with care!";
		$parcel_job['dimensions'] = $dim;

		$order_data['parcel_job'] = $parcel_job;
		/* seller_id = Merchant's nseller_id */
		$order_data['marketplace'] = array('seller_id'=>(string)$nseller_id);

		return $order_data;
	}


 	public function get_test_return_data()
	{
		$from_data['name'] = "45679abcdef";
		//$rtn = time();
		$rtn = substr(time(),0,9);
		$order_data=array();
		$from_address['address1'] = "4 Jalan Wawasan 4/10";
		$from_address['address2'] = "Pusat Bandar Puchong";
		$from_address['area']  = "Puchong";
		$from_address['city']  = "Kuala Lumpur";
		$from_address['state']  = "Wilayah Persekutuan";
		/*
		$from_address['country']  = "SG";
		$from_address['postcode'] = "159363";
		*/
		$from_address['country']  = "MY";
		$from_address['postcode'] = "47160";

		$to_address['address1'] = "30 Jalan Cempaka 4";
		$to_address['address2'] = "Taman Len Seng, Cheras";
		$to_address['area']  = "Cheras";
		$to_address['city']  = "Kuala Lumpur";
		$to_address['state']  = "Wilayah Persekutuan";
		/*
		$to_address['country']  = "SG";
		$to_address['postcode'] = "160123";
		*/
		$to_address['country']  = "MY";
		$to_address['postcode'] = "55000";

		$order_data = array();
		$order_data['service_type'] = "Return";
		$order_data['service_level'] = "Standard";
		$order_data['requested_tracking_number'] = $rtn;
		$order_data['reference'] =
			array('merchant_order_number'=>(string)time());

		$from_data['phone_number'] = "0122936511";
		$from_data['email'] = "waisun.chia@gmail.com";
		$from_data['address'] = $from_address;

		$to_data['name'] = "Tony Stark";
		$to_data['phone_number'] = "0117788431";
		$to_data['email'] = "tony@stark.com";
		$to_data['address'] = $to_address;

		$order_data['from'] = $from_data;
		$order_data['to']   = $to_data;

		$tslot['start_time'] = "09:00";
		$tslot['end_time']   = "22:00";
		$tslot['timezone']   = "Asia/Kuala_Lumpur";

		$parcel_job['is_pickup_required'] = true;
		$parcel_job['delivery_start_date']  = "2017-09-01";
		$parcel_job['delivery_timeslot']    = $tslot;
		$parcel_job['pickup_date']			= "2017-08-25";
		$parcel_job['pickup_timeslot']      = $tslot;
		$parcel_job['pickup_address']		= $to_data;
		$parcel_job['pickup_approximate_volume'] = "Half-Van Load";

		$dim['weight'] = 1.0;
		$dim['size'] = "L";
		$parcel_job['delivery_instructions'] = "Handle with care!";
		$parcel_job['pickup_instructions'] = "Knock Three Times and come in!";
		$parcel_job['dimensions'] = $dim;

		$order_data['parcel_job'] = $parcel_job;
		return $order_data;
	}

 	public function jnv4r()
	{
		$nv= new NinjaVan;
		$order=$this->get_test_return_data();
		dump($order);

		$result=$nv->create_order($order);
		dump($result);
		return $result;
	}



	public function jnv43()
	{
		$nv= new NinjaVan;
		$order=$this->get_test_data();
		dump($order);

		$result=$nv->create_order($order);
		dump($result);
		return $result;
	}

 	public function nv43()
    {
		/* /sg/4.0/orders */
		$url = 'https://api.ninjavan.co/my/4.0/orders';


		$headers = array();
		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';

		$order=$this->get_test_data();
		dump("ORDER: ".$url);
		dump($order);

		$postfields = json_encode($order);

		dump($postfields);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);
		$ret = array();


		## The Order was successfully received and is being processed.
		## Order ID is
		switch($http_code) {
			case 202:
				$body = json_decode($body);
				print_r($body);

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
				print_r($body);
				break;

			## Order was created successfully and the Order object is
			## returned, hence
			case 200:
				if (!empty($body)) {
					## The created Order's tracking ID and other details
					## can be stored in db if

					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Total Orders Created: '.count($body);
					$ret['data'] = $body;

					## Order was not created successfully.
					## Check the Order JSON that you sent f
				} else {
					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Error: Order NOT created!';
					$ret['data'] = NULL;
				}
				break;

			default:
				$ret['httpCode'] = $http_code;
				$ret['body'] = 'Error: Order NOT created 2!';
				$ret['data'] = NULL;
		 }




		 return $ret;

	}

	/* v3.0 Order API (Single-Shipper Fixed Format AWB) */
 	public function nv3()
    {
		/* Single-Shipper: /3.0/orders */
		/* Multi-Shipper: /3.0/shippers/:shipperid:/orders */
		//$shipper_id = ScriptController::nv2();
		//$url = 'https://api-sandbox.ninjavan.co/sg/3.0/shippers/'.$shipper_id.'/orders';
		$url = 'https://api-sandbox.ninjavan.co/sg/3.0/orders';

		$headers = array();
		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		//$headers[1] = 'Content-type: application/x-www-form-urlencoded';
		$headers[1] = 'Content-type: application/json';

		$order_data = array();
		$order_data['from_postcode'] = "159363";
		$order_data['from_address1'] = "30 Jalan Cempaka 4";
		$order_data['from_address2'] = "Taman Len Seng";
		$order_data['from_locality'] = "Cheras";
		$order_data['from_city'] = "Kuala Lumpur";
		$order_data['from_state'] = "Wilayah Persekutuan";
		$order_data['from_country'] = "MY";
		$order_data['from_email'] = "leonard.nimoy@gmail.com";
		$order_data['from_name'] = "LEONARD NIMOY";
		$order_data['from_contact'] = "99001122";
		$order_data['to_postcode'] = "318993";
		$order_data['to_address1'] = "4 Jalan Wawasan 4/10";
		$order_data['to_address2'] = "Pusat Bandar Puchong";
		$order_data['to_locality'] = "Puchong";
		$order_data['to_city'] = "Kuala Lumpur";
		$order_data['to_state'] = "Wilayah Persekutuan";
		$order_data['to_country'] = "MY";
		$order_data['to_email'] = "jameskirk@gmail.com";
		$order_data['to_name'] = "JAMES T KIRK";
		$order_data['to_contact'] = "99110022";
		$order_data['delivery_date'] = "2016-03-10";
		$order_data['pickup_date'] = "2016-03-09";
		$order_data['pickup_weekend'] = false;
		$order_data['delivery_weekend'] = true;
		$order_data['staging'] = false;
		$order_data['pickup_timewindow_id'] = 1;
		$order_data['delivery_timewindow_id'] = 2;
		$order_data['max_delivery_days'] = 1;
		$order_data['cod_goods'] = 35.50;
		$order_data['pickup_instuction'] = "Doorbell broken; call once you arrive.";
		$order_data['delivery_instuction'] = "Door is missing; just come in and party.";
		//$order_data['requested_tracking_id'] = substr('"'.time().'"', 0, 9);
		$order_data['order_ref_no'] =  (string)time();
		$order_data['type'] = "NORMAL"; 	// Must be in CAPS!!
		$order_data['parcel_size'] = 1;
		$order_data['parcel_volume'] = 1122;
		$order_data['parcel_weight'] = 1.2;


 		$jorder_data = '{
		"from_postcode":"159363",
		"from_address1":"30 Jalan Kilang Barat",
		"from_city":"SG",
		"from_country":"SG",
		"from_email":"jane.doe@gmail.com",
		"from_name":"Han Solo Exports",
		"from_contact":"91234567",
		"to_postcode":"318993",
		"to_address1":"998 Toa Payoh North",
		"to_city":"SG",
		"to_country":"SG",
		"to_email":"john.doe@gmail.com",
		"to_name":"James T Kirk",
		"to_contact":"98765432",
		"delivery_date":"2017-06-09",
		"pickup_date":"2017-06-08",
		"pickup_timewindow_id":1,
		"delivery_timewindow_id":2,
		"max_delivery_days":1,
		"type":"NORMAL",
		"parcel_size": 1,
		"parcel_volume": 4000,
		"parcel_weight": 1.2
		}';

		$djorder_data = json_decode($jorder_data);
		dump($djorder_data);

  		/* An array of JSON orders */
		$orders = array();
		$orders[0] = $djorder_data;
		/*
		$orders[1] = $order_data;
		$orders[2] = $order_data;
		$orders[3] = $order_data;
		$orders[4] = $order_data;
		*/

		dump("ORDER: ".$url);

		$postfields = json_encode($orders);
		dump($postfields);

		## Note that this is the production API endpoint
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);
		$ret = array();


		## The Order was successfully received and is being processed.
		## Order ID is
		switch($http_code) {
			case 202:
				$body = json_decode($body);
				print_r($body);

				## The Order ID returned.
				## This can be stored in db if needed.
				$parcel_id = $body[0]->id;
				$parcel_size_id = $body[0]->parcel_size_id;
				$parcel_volume = $body[0]->volume;
				$parcel_weight = $body[0]->weight;
				## Get Order by ID API
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
				print_r($body);
				break;

			## Order was created successfully and the Order object is returned, hence
			case 200:
				if (!empty($body)) {
					## The created Order's tracking ID and other details
					## can be stored in db if

					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Total Orders Created: '.count($body);
					$ret['data'] = $body;

					## Order was not created successfully.
					## Check the Order JSON that you sent f
				} else {
					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Error: Order NOT created!';
					$ret['data'] = NULL;
				}
				break;

			default:
				$ret['httpCode'] = $http_code;
				$ret['body'] = 'Error: Order NOT created 2!';
				$ret['data'] = NULL;
		 }

		 return $ret;
	}

 	/* v3.0 Order API (Multi-Shipper Fixed Format AWB) */
 	public function nv3ms()
    {
		/* Multi-Shipper: /3.0/shippers/:shipperid:/orders */
		//$shipper_id = ScriptController::nv2();
		//$shipper_id = "3684"; // TEST (only hardcoded in SANDBOX!!)
		$shipper_id = "135"; // TEST (only hardcoded in PRODUCTION!!)
		$url = 'https://api-sandbox.ninjavan.co/sg/3.0/shippers/'.
			$shipper_id.'/orders';

		$headers = array();
		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';

		dump($headers);

		$order_data = array();
		$order_data['from_postcode'] = "159363";
		$order_data['from_address1'] = "30 Jalan Cempaka 4";
		$order_data['from_address2'] = "Taman Len Seng";
		$order_data['from_locality'] = "Cheras";
		$order_data['from_city'] = "Kuala Lumpur";
		$order_data['from_state'] = "Wilayah Persekutuan";
		$order_data['from_country'] = "MY";
		$order_data['from_email'] = "leonard.nimoy@gmail.com";
		$order_data['from_name'] = "LEONARD NIMOY";
		$order_data['from_contact'] = "99001122";
		$order_data['to_postcode'] = "318993";
		$order_data['to_address1'] = "4 Jalan Wawasan 4/10";
		$order_data['to_address2'] = "Pusat Bandar Puchong";
		$order_data['to_locality'] = "Puchong";
		$order_data['to_city'] = "Kuala Lumpur";
		$order_data['to_state'] = "Wilayah Persekutuan";
		$order_data['to_country'] = "MY";
		$order_data['to_email'] = "jameskirk@gmail.com";
		$order_data['to_name'] = "JAMES T KIRK";
		$order_data['to_contact'] = "99110022";
		$order_data['delivery_date'] = "2016-03-10";
		$order_data['pickup_date'] = "2016-03-09";
		$order_data['pickup_weekend'] = false;
		$order_data['delivery_weekend'] = true;
		$order_data['staging'] = false;
		$order_data['pickup_timewindow_id'] = 1;
		$order_data['delivery_timewindow_id'] = 2;
		$order_data['max_delivery_days'] = 1;
		$order_data['cod_goods'] = 35.50;
		$order_data['pickup_instuction'] = "Doorbell broken; call once you arrive.";
		$order_data['delivery_instuction'] = "Door is missing; just come in and party.";
		//$order_data['requested_tracking_id'] = substr('"'.time().'"', 0, 9);
		$order_data['order_ref_no'] =  time();
		$order_data['type'] = "NORMAL"; 	// Must be in CAPS!!
		$order_data['parcel_size'] = 1;
		$order_data['parcel_volume'] = 1122;
		$order_data['parcel_weight'] = 1.2;


 		$jorder_data = '{
		"from_postcode":"159363",
		"from_address1":"30 Jalan Kilang Barat",
		"from_city":"SG",
		"from_country":"SG",
		"from_email":"jane.doe@gmail.com",
		"from_name":"Han Solo Exports",
		"from_contact":"91234567",
		"to_postcode":"318993",
		"to_address1":"998 Toa Payoh North",
		"to_city":"SG",
		"to_country":"SG",
		"to_email":"john.doe@gmail.com",
		"to_name":"James T Kirk",
		"to_contact":"98765432",
		"delivery_date":"2017-06-09",
		"pickup_date":"2017-06-08",
		"pickup_timewindow_id":1,
		"delivery_timewindow_id":2,
		"max_delivery_days":1,
		"type":"NORMAL",
		"parcel_size": 1,
		"parcel_volume": 4000,
		"parcel_weight": 1.2
		}';

		$djorder_data = json_decode($jorder_data);
		dump($djorder_data);

  		/* An array of JSON orders */
		$orders = array();
		$orders[0] = $djorder_data;
		/*
		$orders[1] = $order_data;
		$orders[2] = $order_data;
		$orders[3] = $order_data;
		$orders[4] = $order_data;
		*/

		dump("MULTI-SHIPPER ORDER: ".$url);

		$postfields = json_encode($orders);
		dump($postfields);

		## Note that this is the production API endpoint
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);

		$ret = array();

		## The Order was successfully received and is being processed.
		## Order ID is
		switch($http_code) {
			case 202:
				$body = json_decode($body);
				print_r($body);

				## The Order ID returned.
				## This can be stored in db if needed.
				$parcel_id = $body[0]->id;
				$parcel_size_id = $body[0]->parcel_size_id;
				$parcel_volume = $body[0]->volume;
				$parcel_weight = $body[0]->weight;
				## Get Order by ID API
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
				print_r($body);
				break;

			## Order was created successfully and the Order object is
			## returned, hence
			case 200:
				if (!empty($body)) {
					## The created Order's tracking ID and other details
					## can be stored in db if

					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Total Orders Created: '.count($body);
					$ret['data'] = $body;

					## Order was not created successfully.
					## Check the Order JSON that you sent f
				} else {
					$ret['httpCode'] = $http_code;
					$ret['body'] = 'Error: Order NOT created!';
					$ret['data'] = NULL;
				}
				break;

			default:
				$ret['httpCode'] = $http_code;
				$ret['body'] = 'Error: Order NOT created 2!';
				$ret['data'] = NULL;
		 }

		 return $ret;
	}

	public function jnv4()
    {
		$nvclass = new NinjaVan;
		$search_result = $nvclass->search_order("1fb921c2-64f7-474a-a808-ab22ed96411d",4);
		dump($search_result);
		//return $access_token;
	}

 	/* v3.0 Orders Collection API (Search by parameter) */
 	public function nv4($order_id=null)
    {
		$rawurl = 'https://api-sandbox.ninjavan.co/sg/3.0/orders';
		$tracking_id = "NVSGINTOS000000107";
		if (is_null($order_id)) {
			$order_id = "1fb921c2-64f7-474a-a808-ab22ed96411d";
		}

		// May get multiple orders for multiparcel consignment
		$order_ref_no = "1496917810";

		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';
		dump($headers);

		$search_data = "order_id=".$order_id;
		//$search_data = "tracking_id=".$tracking_id;
		//$search_data = "order_ref_no=".$order_ref_no;

		$search_string = $search_data;
		$url = $rawurl."?".$search_string;
		dump("SEARCH: ".$url);

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);
	}


	public function jnv5()
    {
		$nvclass = new NinjaVan;
		$search_result = $nvclass->cancel_order("e84de172-218f-411e-9979-2b1376ab8428");
		dump($search_result);
		//return $access_token;
	}

  	/* v2.0 Orders Cancellation API (delete by order_id) */
 	public function nv5()
    {
		$rawurl = 'https://api-sandbox.ninjavan.co/sg/2.0/orders';
		$order_id = "e84de172-218f-411e-9979-2b1376ab8428";

 		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';
		dump($headers);

		$url = $rawurl."/".$order_id;
		dump("DELETE: ".$url);

  		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);

		/* From NV Documentation: Order Cancellation API:
		   Note that a Cancel request has to be made within the day of Order
		   Creation (before 23:59:59 on aforementioned day). For instance, if an Order
		   was created at 2015-11-05 16:32:00, the Cancel request must be made before
		   2015-11-05 23:59:59. */

		/* We confirm that the Order has been indeed deleted:
		   It's a bit weird as we can keep running this function??!! And we can still
		   able to search the record even after being supposedly deleted! */

		/* Response from NV dev:
		   Cancelling the orders, will still allow it to be accessed from API.
		   This is expected. We don't actually "delete" the record. */

		ScriptController::nv4($order_id);
	}

	public function jnv6()
    {
		$nvclass = new NinjaVan;
		$tdata[0] = "NVSGINTOS000000131";
		$tdata[1] = "NVSGINTOS000000132";
		$tdata[2] = "NVSGINTOS000000133";
		$tdata[3] = "NVSGINTOS000000134";
		$tdata[4] = "NVSGINTOS000000135";
		$tdata[5] = "NVSGINTOS000000136";
		$tracking['trackingIds'] = $tdata;
		$search_result = $nvclass->track_order($tracking);
		dump($search_result);
	}

   	/* v2.0 Orders Tracking API (by tracking_id) */
 	public function nv6()
    {
		$url = 'https://api-sandbox.ninjavan.co/sg/2.0/track';

		$headers[0] = 'Authorization: Bearer '.ScriptController::nv1();
		$headers[1] = 'Content-type: application/json';

		dump("TRACKING: ".$url);

		$tdata[0] = "NVSGINTOS000000131";
		$tdata[1] = "NVSGINTOS000000132";
		$tdata[2] = "NVSGINTOS000000133";
		$tdata[3] = "NVSGINTOS000000134";
		$tdata[4] = "NVSGINTOS000000135";
		$tdata[5] = "NVSGINTOS000000136";

		$tracking['trackingIds'] = $tdata;
		dump($tracking);

 		## Note that this is the production API endpoint
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($tracking));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$body = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump($body);
		dump($http_code);
	}

	/* Verification of NV WebHook messages */
 	public function verify_webhook($data, $hmac_header){
		$calculated_hmac = base64_encode(
			// Need to calculate HMAC in raw mode!!!
			hash_hmac('sha256', $data, NINJAVAN_CLIENT_SECRET, true));
		return ($hmac_header == $calculated_hmac);
	}

 	public function log_webhook($verified, $data, $logfile){
		$chmac = null;
 		$fp = fopen($logfile, 'a');
		if ($verified) {
			fwrite($fp, "Webhook VERIFIED!\n");
			fwrite($fp, $data."\n");

		} else {
			// HMAC SHA256 verification failed!
			fwrite($fp, "Webhook verification FAILED!\n");
			fwrite($fp, $data."\n");
		}
		fwrite($fp, "-------------------------------------------------\n");
		fclose($fp);
	}

  	public function log($data, $logfile){
		$chmac = null;
 		$fp = fopen($logfile, 'a');
		fwrite($fp, $data."\n");
		fwrite($fp, "-------------------------------------------------\n");
		fclose($fp);
	}


 	/* v1.1 NV WebHooks API */
  	public function wh_pending_pickup() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');
		$nv = new NinjaVan;
		$nv->webhook("pending_pickup", $data, $hmac_header);
		$nv = null;
	}

   	public function wh_parcel_weight() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');
		$nv = new NinjaVan;
		$nv->webhook("parcel_weight", $data);
		$nv = null;
	}

	public function wh_parcel_size() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');
		$nv = new NinjaVan;
		$nv->webhook("parcel_size", $data, $hmac_header);
		$nv = null;
	}

	public function wh_successful_pickup() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');

		$nv = new NinjaVan;
		$nv->webhook("successful_pickup", $data, $hmac_header);
		$nv = null;
	}

 	public function wh_pending_reschedule() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');

		$nv = new NinjaVan;
		$nv->webhook("pending_reschedule", $data, $hmac_header);
		$nv = null;
	}


 	public function wh_pickup_fail() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');

		$nv = new NinjaVan;
		$nv->webhook("pickup_fail", $data, $hmac_header);
		$nv = null;
	}

  	public function wh_return_to_sender() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');

		$nv = new NinjaVan;
		$nv->webhook("return_to_sender", $data, $hmac_header);
		$nv = null;
	}


 	public function wh_successful_delivery() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');
		$nv = new NinjaVan;
		$nv->webhook("successful_delivery", $data, $hmac_header);
		$nv = null;
	}

  	public function wh_first_attempt_delivery_fail() {
		//$hmac_header = $_SERVER['HTTP_X_NINJAVAN_HMAC_SHA256'];
		$hmac_header = null;
		$data = file_get_contents('php://input');
		$nv = new NinjaVan;
		$nv->webhook("first_attempt_delivery_fail", $data, $hmac_header);
		$nv = null;
	}


	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t1()
    {
		$a = new CityLinkConnection;
		$dump = $a->t1();
		dump($dump);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t2()
    {
		$a = new CityLinkConnection;
		$dump = $a->t2();
		dump($dump);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t3()
    {
		$a = new CityLinkConnection;
		$dump = $a->t3();
		dump($dump);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t4()
    {
		$a = new CityLinkConnection;
		$dump = $a->t4();
		dump($dump);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t5()
    {
		$a = new CityLinkConnection;
		$dump = $a->t5();
		dump($dump);
	}

	/* These are all TEST methods ONLY. Not MEANT for production */
	public function t6()
    {
		$a = new CityLinkConnection;
		$dump = $a->t6();
		dump($dump);
	}

	public function testuuid()
    {
		$a = new SecurityIDGenerator;
		$newid = $a->generate(date('Y-m-d'));
		echo $newid;
	}

	public function scriptproductstatus()
    {
		$products = DB::table('product')->where('segment','b2c')->get();
		foreach($products as $product){
			if($product->status == 'active'){
				$aprsections = DB::table('aprsection')->where('type','product')->get();
				foreach($aprsections as $aprsection){
					$getstatus = DB::table('aprchecklist')->where('product_id',$product->id)->where('aprsection_id',$aprsection->id)->first();
					if(is_null($getstatus)){
						DB::table('aprchecklist')->insert(['status'=>'approved','product_id'=>$product->id,'merchant_id'=>0,
						'merchant_id'=>0,'aprsection_id'=>$aprsection->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
					}
				}
			}
		}
		echo "Script Completed";
	}

	public function b2bproductstatus()
    {
		$products = DB::table('product')->where('segment','b2c')->get();
		foreach($products as $product){
			DB::table('product')->where('parent_id',$product->id)->where('segment','b2b')->update(['status'=>$product->status]);
		}
		echo "Script Completed";
	}

	public function scriptdefaultwarehouse(){
		$merchants = DB::table('merchant')->get();
		foreach($merchants as $merchant){
			$warehouse = DB::table('fairlocation')->where('company_name',"Warehouse")->where('user_id',$merchant->user_id)->first();
			if(is_null($warehouse)){
				DB::table('fairlocation')->insert(['company_name'=>"Warehouse",'location'=>"Warehouse",'user_id'=>$merchant->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
		}
		echo "Script Completed";
	}

	public function scriptdefaulttokens(){
		$tokens = DB::table('product')->where('segment','token')->where('retail_price','>=',1000000)->get();
		$merchants = DB::table('merchant')->get();
		$stations = DB::table('station')->get();
		foreach($tokens as $token){
			DB::table('tokenuserproduct')->where('product_id',$token->id)->delete();
			foreach($merchants as $merchant){
				DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$merchant->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
			foreach($stations as $station){
				DB::table('tokenuserproduct')->insert(['product_id'=>$token->id,'user_id'=>$station->user_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
			}
		}
		echo "Script Completed";
	}

	public function scriptproductthumbs()
    {
		$products = DB::table('product')->
			where('segment','b2c')->orderBy('id','DESC')->get();

		//dd($products);
		foreach($products as $product){
			$folder = base_path() . '/public/images/product/' .
				$product->id;
			$folder_thumb = base_path() . '/public/images/product/' .
				$product->id . '/thumb';

			try {
				File::makeDirectory($folder, 0777, true, true);
			} catch (\Exception $e) {
				dump($e);
			}

			try {
				File::makeDirectory($folder_thumb, 0777, true, true);
			} catch (\Exception $e) {
				dump($e);
			}

			if(!is_null($product->photo_1) && $product->photo_1 != ""){
				$image_name = $product->photo_1;
				$image_thumb_name = "thumb_" . $product->photo_1;
				$image_aux_name = "aux_" . $product->photo_1;

				/*
				try{
					unlink(public_path('images/product/' .
						$product->id . '/thumb/'.$image_thumb_name));
				}catch (\Exception $e) {
					//dump($e);
				}
				*/

				$img_path = URL::to('/')."/images/product/".
					$product->id."/".$image_name;
				$tpath = public_path('images/product/' .
					$product->id . '/thumb/'.$image_thumb_name);

				try{
					if (@getimagesize($img_path)) {
						$auximg = Image::make($img_path)->
							save(public_path('images/product/' .
							$product->id . '/thumb/'.$image_aux_name));

						/*
						$width = $auximg->width();
						$height = $auximg->height();
						dump('W:'.$width.' H:'.$height);

						if($width >= $height){
							$twidth = 200;
							$t400width = 400;
							$theight = round(($height * 200)/$width);
							$t400height = round(($height * 400)/$width);
						} else {
							$theight = 200;
							$t400height = 400;
							$twidth = round(($width * 200)/$height);
							$t400width = round(($width * 400)/$height);
						}

 						Image::make(URL::to('/')."/images/product/".
							$product->id."/".$image_name)->
							fit($twidth, $theight)->
							save(public_path('images/product/' .
								$product->id . '/thumb/'.$image_thumb_name));
						*/

						Image::make(URL::to('/')."/images/product/".
							$product->id."/".$image_name)->
							resize(200, 200, function ($constraint) {
							    $constraint->aspectRatio();
							})->save($tpath);

						unlink(public_path('images/product/' .
							$product->id . '/thumb/'.$image_aux_name));

						Product::where('id', $product->id)->
							update(['thumb_photo' => $image_thumb_name]);

						Product::where('parent_id', $product->id)->
							update(['thumb_photo' => $image_thumb_name]);

						dump("DONE!! Product ".$product->id);

					} else {
						dump("Product ".$product->id.
							": ".$img_path.": Image file not found)");
					}
				}catch(\Exception $e){
					dump("Product ".$product->id.": Error with Image");
					dump($e);
				}
			} else {
				dump("Product ".$product->id.": Error No Image Defined in DB");
			}
		}
		echo "Script Completed";
	}

	public function scriptproductthumbs2()
    {
		$products = DB::table('product')->where('segment','b2c')->get();
		//dd($products);

		/*
 		$products = DB::table('product')->
			where('segment','b2c')->
			where('id',2151)->
			orderBy('id','DESC')->limit(20)->get();
		*/

		foreach($products as $product){
			$folder = base_path() . '/public/images/product/' .
				$product->id;
			$folder_thumb = base_path() . '/public/images/product/' .
				$product->id . '/thumb';

			try {
				File::makeDirectory($folder, 0777, true, true);
			} catch (\Exception $e) {
			}

			try {
				File::makeDirectory($folder_thumb, 0777, true, true);
			} catch (\Exception $e) {
			}

			if(!is_null($product->photo_1) && $product->photo_1 != ""){
				$image_name = $product->photo_1;
				$image_thumb_name = "thumb400_" . $product->photo_1;
				$image_aux_name = "aux_" . $product->photo_1;
				try{
					unlink(public_path('images/product/'.$product->id.
						'/thumb/'.$image_thumb_name));
				}catch (\Exception $e) {
				}

				try{
					if (@getimagesize(URL::to('/')."/images/product/".
						$product->id."/".$image_name)) {
						$auximg = Image::make(URL::to('/')."/images/product/".
							$product->id."/".$image_name)->
							save(public_path('images/product/'.$product->id.
							'/thumb/'.$image_aux_name));

						$width = $auximg->width();
						$height = $auximg->height();
						if($width >= $height){
							$twidth = 200;
							$t400width = 400;
							$theight = round(($height * 200)/$width);
							$t400height = round(($height * 400)/$width);
						} else {
							$theight = 200;
							$t400height = 400;
							$twidth = round(($width * 200)/$height);
							$t400width = round(($width * 400)/$height);
						}

						Image::make(URL::to('/')."/images/product/".
							$product->id."/".$image_name)->
							resize(400, 400, function($constraint) {
								$constraint->aspectRatio();
							})->
							save(public_path('images/product/'.$product->id.
							'/thumb/'.$image_thumb_name));

						unlink(public_path('images/product/'.$product->id.
							'/thumb/'.$image_aux_name));

						Product::where('id', $product->id)->
							update(['thumb_photo2' => $image_thumb_name]);

						Product::where('parent_id', $product->id)->
							update(['thumb_photo2' => $image_thumb_name]);

					} else {
						dump("Product ".$product->id.": Error with Image");
					}
				}catch(\Exception $e){
					dump("Product ".$product->id.": Error with Image");
				}
			} else {
				dump("Product ".$product->id.": Error No Image Defined");
			}
		}
		echo "Script Completed";
	}

	public function scriptoshopqr(){
		$oshops = DB::table('oshop')->get();
		foreach($oshops as $oshop){
			$qrexits = DB::table('oshopqr')->where('oshop_id',$oshop->id)->delete();
			UtilityController::createQr($oshop->id,'oshop', URL::to('/') . '/o/' . $oshop->url);
		}
		echo "Script Completed";
	}

	public function scriptproductqr(){
		$products = DB::table('product')->where('segment','b2c')->get();
		foreach($products as $product){
			$qrexits = DB::table('productqr')->where('product_id',$product->id)->delete();
			UtilityController::createQr($product->id,'product', URL::to('/') . '/productconsumer/' . $product->id);
		}
		$products = DB::table('product')->where('segment','b2b')->get();
		foreach($products as $product){
			$qrexits = DB::table('productqr')->where('product_id',$product->id)->delete();
			UtilityController::createQr($product->id,'product', URL::to('/') . '/productconsumer/' . $product->parent_id);
		}
		echo "Script Completed";
	}

	public function scripthybrid()
    {
		$merchants = DB::table('merchant')->get();
		foreach($merchants as $merchant){
			$stationse = DB::table('station')->where('user_id',$merchant->user_id)->first();
			if(is_null($stationse)){
				$userid = $merchant->user_id;
				$merchant = DB::table('merchant')->where('user_id',$userid)->first();

				$user_as_station = new Station();
				$user_as_station_model = $user_as_station->store_frommerchant($merchant, $userid);
				DB::table('station')->where('id',$user_as_station_model->id)->update(['stationtype_id'=>1]);
				$mdocuments = DB::table('merchantdocument')->where('merchant_id',$merchant->id)->get();
				foreach($mdocuments as $mdocument){
					DB::table('stationdocument')->insert(['station_id'=>$user_as_station_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}

				$mbrands = DB::table('merchantbrand')->where('merchant_id',$merchant->id)->get();
				foreach($mbrands as $mbrand){
					DB::table('stationbrand')->insert(['station_id'=>$user_as_station_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}
				//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
				//for storing web sites in "stationwebsite" table
				//first create station and get id
				//then create websites and get website model array like director
				//then attach station with each website id
				$mwebsites = DB::table('merchantwebsite')->where('merchant_id',$merchant->id)->get();
				foreach($mwebsites as $mwebsite){
					DB::table('stationwebsite')->insert(['station_id'=>$user_as_station_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}

				$mdirectors = DB::table('merchantdirector')->where('merchant_id',$merchant->id)->get();
				foreach($mdirectors as $mdirector){
					DB::table('stationdirector')->insert(['station_id'=>$user_as_station_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}
				$rr = DB::table('role_users')->where('user_id',$userid)->where('role_id',11)->first();
				if(is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $userid;
					$role->role_id = 11;
					$role->save();
				}
			}
		}

		$stations = DB::table('station')->get();
		foreach($stations as $station){
			$merchantse = DB::table('merchant')->where('user_id',$station->user_id)->first();
			if(is_null($merchantse)){
				$userid = $station->user_id;
				$station = DB::table('station')->where('user_id',$userid)->first();

				$user_as_merchant = new Merchant();
				$user_as_merchant_model = $user_as_merchant->store_fromstation($station, $userid);

				$mdocuments = DB::table('stationdocument')->where('station_id',$station->id)->get();
				foreach($mdocuments as $mdocument){
					DB::table('merchantdocument')->insert(['merchant_id'=>$user_as_merchant_model->id,'document_id'=>$mdocument->document_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}

				$mbrands = DB::table('stationbrand')->where('station_id',$station->id)->get();
				foreach($mbrands as $mbrand){
					DB::table('merchantbrand')->insert(['merchant_id'=>$user_as_merchant_model->id,'brand_id'=>$mbrand->brand_id,'subcat_id'=>$mbrand->subcat_id,'subcat_level'=>$mbrand->subcat_level,'relationship'=>$mbrand->relationship,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}
				//http://laravel.com/docs/5.1/eloquent-relationships#inserting-many-to-many-relationships
				//for storing web sites in "stationwebsite" table
				//first create station and get id
				//then create websites and get website model array like director
				//then attach station with each website id

				$mwebsites = DB::table('stationwebsite')->where('station_id',$station->id)->get();
				foreach($mwebsites as $mwebsite){
					DB::table('merchantwebsite')->insert(['merchant_id'=>$user_as_merchant_model->id,'website_id'=>$mwebsite->website_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}

				$mdirectors = DB::table('stationdirector')->where('station_id',$station->id)->get();
				foreach($mdirectors as $mdirector){
					DB::table('merchantdirector')->insert(['merchant_id'=>$user_as_merchant_model->id,'director_id'=>$mdirector->director_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
				}

				$rr = DB::table('role_users')->where('user_id',$userid)->where('role_id',3)->first();
				if(is_null($rr)){
					$role = new RoleUser;
					$role->user_id = $userid;
					$role->role_id = 3;
					$role->save();
				}
			}
		}
		echo "Script Completed";
	}

	public function scriptqr()
    {
		$merchants = DB::table('merchant')->get();
		foreach($merchants as $merchant){
			$qrexits = DB::table('merchantqr')->where('merchant_id',$merchant->id)->first();
			if(is_null($qrexits)){
				UtilityController::createQr($merchant->id,'merchant',IdController::nSeller($merchant->user_id));
			}
		}
		dump("Merchant Done");
		$stations = DB::table('station')->get();
		foreach($stations as $station){
			$qrexits = DB::table('stationqr')->where('station_id',$station->id)->first();
			if(is_null($qrexits)){
				UtilityController::createQr($station->id,'station',IdController::nSeller($station->user_id));
			}
		}
		dump("Station Done");
		$buyers = DB::table('buyer')->join('users','buyer.user_id','=','users.id')->select('buyer.*','users.first_name','users.last_name')->get();
		foreach($buyers as $buyer){
			$qrexits = DB::table('buyerqr')->where('buyer_id',$buyer->id)->first();
			if(is_null($qrexits)){
				UtilityController::createQr($buyer->id,'buyer',IdController::nB($buyer->user_id));
			}
		}
		dump("Buyer Done");
		$products = DB::table('product')->get();
		foreach($products as $product){
			$qrexits = DB::table('productqr')->where('product_id',$product->id)->first();
			if(is_null($qrexits)){
				UtilityController::createQr($product->id,'product',IdController::nP($product->id));
			}
		}
		dump("Product Done");
		$oshops = DB::table('oshop')->get();
		foreach($oshops as $oshop){
			$qrexits = DB::table('oshopqr')->where('oshop_id',$oshop->id)->first();
			if(is_null($qrexits)){
				UtilityController::createQr($oshop->id,'oshop',IdController::nOshop($oshop->id));
			}
		}
		dump("Oshop Done");
		$receipts = DB::table('receipt')->get();
		foreach($receipts as $receipt){
			$qrexits = DB::table('receiptqr')->where('receipt_id',$receipt->id)->first();
			if(is_null($qrexits)){
				$merchant = DB::table('merchantproduct')->join('orderproduct','merchantproduct.product_id','=','orderproduct.product_id')
				->join('porder','orderproduct.porder_id','=','porder.id')->where('porder.id',$receipt->porder_id)->first();
				if(!is_null($merchant)){
					UtilityController::createQr($receipt->id,'receipt',IdController::nO($receipt->porder_id));
				} else {
					UtilityController::createQr($receipt->id,'receipt',IdController::nO($receipt->porder_id));
				}
			}
		}
		dump("Receipt Done");
		$invoices = DB::table('invoice')->get();
		foreach($invoices as $invoice){
			$qrexits = DB::table('invoiceqr')->where('invoice_id',$invoice->id)->first();
			if(is_null($qrexits)){
				$merchant = DB::table('merchanttproduct')->join('ordertproduct','merchanttproduct.tproduct_id','=','ordertproduct.tproduct_id')
				->join('porder','ordertproduct.porder_id','=','porder.id')->where('porder.id',$invoice->porder_id)->first();
				if(!is_null($merchant)){
					UtilityController::createQr($invoice->id,'invoice',IdController::nO($invoice->porder_id));
				} else {
					UtilityController::createQr($invoice->id,'invoice',IdController::nO($invoice->porder_id));
				}
			}
		}
		dump("Invoice Done");
		$deliveryorders = DB::table('deliveryorder')->get();
		foreach($deliveryorders as $deliveryorder){
			$qrexits = DB::table('deliveryorderqr')->where('deliveryorder_id',$deliveryorder->id)->first();
			if(is_null($qrexits)){
				$deliveryorder2 = DB::table('deliveryorder')->join('receipt','deliveryorder.receipt_id','=','receipt.id')->where('deliveryorder.id',$deliveryorder->id)
				->select('receipt.*')->first();
				if(!is_null($deliveryorder2)){
			//		$delivery = DB::table('delivery')->where('porder_id',$deliveryorder2->porder_id)->first();
			//		if(!is_null($delivery)){
					UtilityController::createQr($deliveryorder->id,'deliveryorder',IdController::nO($deliveryorder2->porder_id));
					dump("DOID: " . $deliveryorder->id . " - content: " . IdController::nO($deliveryorder2->porder_id));
			//		} else {
					//	UtilityController::createQr($deliveryorder->id,'deliveryorder',IdController::nDO($deliveryorder->id));
		//			}

		//		} else {
				//	UtilityController::createQr($deliveryorder->id,'deliveryorder',IdController::nDO($deliveryorder->id));
				}
			}
		}
		dump("DeliveryOrder Done");
		$deliveryinvoices = DB::table('deliveryinvoice')->get();
		foreach($deliveryinvoices as $deliveryinvoice){
			$qrexits = DB::table('deliveryinvoiceqr')->where('deliveryinvoice_id',$deliveryinvoice->id)->first();
			if(is_null($qrexits)){
				$deliveryinvoice2 = DB::table('deliveryinvoice')->join('invoice','deliveryinvoice.invoice_id','=','invoice.id')->where('deliveryinvoice.id',$deliveryinvoice->id)
				->select('invoice.*')->first();
				if(!is_null($deliveryinvoice2)){
				//	$delivery = DB::table('delivery')->where('porder_id',$deliveryinvoice2->porder_id)->first();
				//	if(!is_null($delivery)){
						UtilityController::createQr($deliveryinvoice2->id,'deliveryinvoice',IdController::nO($deliveryinvoice2->porder_id));
				//	} else {
					//	UtilityController::createQr($deliveryinvoice->id,'deliveryinvoice',IdController::nI($deliveryinvoice->invoice_id));
				//	}

				//} else {
				//	UtilityController::createQr($deliveryinvoice->id,'deliveryinvoice',IdController::nI($deliveryinvoice->invoice_id));
					dump("DIID: " . $deliveryinvoice->id . " - content: " . IdController::nO($deliveryinvoice2->porder_id));
				}

			}
		}
		dump("DeliveryInvoice Done");
		$qrexits = DB::table('landingqr')->first();
		if(is_null($qrexits)){
			$qr_store_path=public_path()."/images/qr/landing/";
			if (!file_exists($qr_store_path)) {
				mkdir($qr_store_path, 0775, true);
			}
			$qr_info="http://opensupermall.com";
			$qr_image_name='BY-'.str_random(10);
			QrCode::format('png')->
				encoding('UTF-8')->
				size(400)->
				generate($qr_info,$qr_store_path.$qr_image_name.".png");

			$qr= new QR;
			$qr->type='qr';
			$qr->image_path=$qr_image_name;
			$qr->save();

			DB::table('landingqr')->insert(['qr_management_id'=>$qr->id,
				'created_at'=>date('Y-m-d H:i:s') ,
				'updated_at'=>date('Y-m-d H:i:s')]);
			dump("Landing Done");
		}

		echo "Script Completed";
	}

	public function scriptmerchantproduct()
    {
		try{
			$id = 2;
			$filter = 'subcatlevel';
			$filter_id = 4038;
			$category = DB::table('category')->where('floor',$id)->first();
			if(!is_null($category)){
				$id = $category->id;
				$object = DB::table('product')->where("product.deleted_at", null)
				->where('product.category_id',$id)->where('product.oshop_selected', '=', true)
				->where('product.segment', '=', 'b2c')->where('product.retail_price', '>', '0')
				->where('product.status','active')->where('product.available','>',0)
					->join("category", function ($join) { $join->on("category.id", "=", "product.category_id"); })
					->select(array("product.*",DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.description WHEN product.subcat_level = 2 THEN subcat_level_2.description WHEN product.subcat_level = 3 THEN subcat_level_3.description END AS subcat_description'),
					DB::raw('CASE WHEN product.subcat_level = 1 THEN subcat_level_1.name WHEN product.subcat_level = 2 THEN subcat_level_2.name WHEN product.subcat_level = 3 THEN subcat_level_3.name END AS subcat_name'),
							"category.description as category_description"));
				if($filter == 'brand'){
					$filterobject = $object->where('product.brand_id','=',$filter_id)
					->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
				}
				if($filter == 'subcategory'){

				}
				if($filter == 'subcatlevel'){
					/*$filterobjectfirst = $object;
					$filterobjectfirst = $filterobjectfirst->where('product.subcat_level',2)->where('product.subcat_id',$filter_id)
					->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });*/
					$filterobject = $object->where('product.subcat_level',3)->where('subcat_level_3.subcat_level_2_id',$filter_id)
					->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
					//->union($filterobjectfirst);
				}
				if($filter == 'subcatlevel3'){
					$filterobject = $object->where('product.subcat_level',3)->where('product.subcat_id',$filter_id)
					->leftjoin("subcat_level_1", function ($join) { $join->on("subcat_level_1.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_2", function ($join) { $join->on("subcat_level_2.id", "=", "product.subcat_id"); })
					->leftjoin("subcat_level_3", function ($join) { $join->on("subcat_level_3.id", "=", "product.subcat_id"); });
				}
				$finalobject = $filterobject->get();
				$result = array();
				foreach ($finalobject as $value) {
					$result[$value['subcat_name']][] = $value;
				}
				//dd("HOLA");
				dump($result);
			} else {
				$result = array();
				dump($result);
			}
		} catch(Exception $e){
			dump($e);
		}
	}

    public function scriptfloor()
    {
		$categories = DB::table('category')->
			select('category.*')->whereRaw("EXISTS (
			SELECT
				product.id FROM product, merchantproduct, merchant
			WHERE
				product.category_id = category.id AND
				product.id = merchantproduct.product_id AND
				product.oshop_selected = true AND
				merchant.id = merchantproduct.merchant_id AND
				product.available > 0 AND
				product.status = 'active' AND
				merchant.status = 'active'
			)")->orderBy('category.floor','ASC')->get();

		$floor = 1;
		foreach($categories as $category){
			DB::table('category')->
				where('id',$category->id)->
				update(['floor'=>$floor,'enable'=>true, 'color'=>$category->original_color]);

			$floor++;
		}

		$notcategories = DB::table('category')->select('category.*')->whereRaw("NOT EXISTS
				(SELECT product.id FROM product, merchantproduct, merchant WHERE product.category_id = category.id AND product.id = merchantproduct.product_id AND product.oshop_selected = true AND merchant.id = merchantproduct.merchant_id AND product.available > 0 AND product.status = 'active' AND merchant.status = 'active')")
				->orderBy('category.floor','ASC')->get();

		foreach($notcategories as $category){
			DB::table('category')->where('id',$category->id)->update(['floor'=>$floor,'enable'=>false, 'color'=>'#AAAAAA']);
			$floor++;
		}

		echo "Script Completed";
	}

	public function scriptoshopurl()
    {
		$oshops = DB::table('oshop')->where('single',false)->get();
		foreach($oshops as $oshop){
			$oname = $oshop->oshop_name;
			$name = $oshop->oshop_name;
			$name = str_replace(' ', '-', $name);
			$name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
			$exists = DB::table('oshop')->where('url',$name)->first();
		//	dump($name);
			if(is_null($oshop->url)){
				if(is_null($exists)){
					DB::table('oshop')->where('id',$oshop->id)->update(['url'=>$name,'original_url'=>$oname]);
				} else {
					$ra = rand(100,999);
					DB::table('oshop')->where('id',$oshop->id)->update(['url'=>$name . $ra,'original_url'=>$oname . $ra]);
				}
			}
		}
		$oshops = DB::table('oshop')->where('single',true)->get();
		foreach($oshops as $oshop){
			DB::table('oshop')->where('id',$oshop->id)->update(['url'=>$oshop->id,'original_url'=>$oshop->id]);
		}
		echo "Script Completed";
	}

	public function scriptoshopsingle()
    {

		DB::table('oshop')->where('single',true)->update(['oshop_name'=>'Single']);
		$merchants = DB::table('merchant')->
			join('users','users.id','=','merchant.user_id')->
			join('address','address.id','=','merchant.address_id')->
			select('merchant.*', 'address.id as addressid',
				'users.first_name', 'users.last_name',
				'users.mobile_no')->get();
		foreach($merchants as $merchant){
			$havesingle = DB::table('merchantoshop')->join('oshop','merchantoshop.oshop_id','=','oshop.id')->where('merchantoshop.merchant_id',$merchant->id)->where('oshop.single',true)->count();
			if($havesingle < 1){
				$oshop = DB::table('oshop')->
						insertGetId([
							'oshop_name'=>"Single",
							'brand_id'=>0,
							'address_id'=>$merchant->addressid,
							'shop_size'=>'0',
							'contact_first_name'=>$merchant->first_name,
							'contact_last_name'=>$merchant->last_name,
							'contact_mobile_no'=>$merchant->mobile_no,
							'status'=>'active',
							'single'=>true,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);

						DB::table('merchantoshop')->insert([
							'merchant_id'=>$merchant->id,
							'oshop_id'=>$oshop,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')]);
			}
		}
		echo "Script Completed";
	}

	public function scriptoshop()
    {
		//DB::table('oshop')->delete();
		$merchants = DB::table('merchant')->
			join('users','users.id','=','merchant.user_id')->
			join('address','address.id','=','merchant.address_id')->
			select('merchant.*', 'address.id as addressid',
				'users.first_name', 'users.last_name',
				'users.mobile_no')->get();

		foreach($merchants as $merchant){
			$haveoshop = DB::table('merchantoshop')->where('merchantoshop.merchant_id',$merchant->id)->where('oshop.single',false)->count();
			if($haveoshop < 1){
				$oshop = DB::table('oshop')->
				insertGetId([
					'oshop_name'=>$merchant->oshop_name,
					'brand_id'=>0,
					'address_id'=>$merchant->addressid,
					'shop_size'=>'0',
					'contact_first_name'=>$merchant->first_name,
					'contact_last_name'=>$merchant->last_name,
					'contact_mobile_no'=>$merchant->mobile_no,
					'status'=>'active',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);

				DB::table('merchantoshop')->insert([
					'merchant_id'=>$merchant->id,
					'oshop_id'=>$oshop,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')]);

				$products = DB::table('merchantproduct')->
					where('merchant_id',$merchant->id)->get();

				foreach($products as $product){
					$oshopp = DB::table('oshopproduct')->
						where('product_id',$product->product_id)->first();

					if(is_null($oshopp)){
						DB::table('oshopproduct')->insert([
							'oshop_id'=>$oshop,
							'product_id'=>$product->product_id,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s') ]);

					} else {
					/*	DB::table('oshopproduct')->
							where('id',$oshopp->id)->
							update(['oshop_id'=>$oshop]);*/
					}
				}
			}
		}

		echo "Script Completed";
	}

    public function scriptbranch()
    {
		DB::table('nbranchid')->delete();
		DB::table('nbranchoshopid')->delete();
		DB::table('nbranchoutletid')->delete();
		$oshop = DB::table('oshop')->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchantoshop.merchant_id','=','merchant.id')->join('address','address.id','=','merchant.address_id')->select('oshop.id as oid', 'address.city_id as cityid')->get();

		foreach($oshop as $osho){
			$newid = "";
			$nid = DB::table('nbranchid')->join('nbranchoshopid','nbranchid.id','=','nbranchoshopid.nbranchid_id')->where('nbranchoshopid.oshop_id',$osho->oid)->count();
			if($nid == 0){
				$newid = UtilityController::branchuniqueid($osho->cityid, "06");
				if($newid != ""){
			//		dump("user: " . $merchant->user_id . " - " . $newid);
					$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$newid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

					DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$osho->oid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		$oshop = DB::table('sproperty')->join('address','address.id','=','sproperty.address_id')->select('sproperty.id as oid', 'address.city_id as cityid')->get();

		foreach($oshop as $osho){
			$newid = "";
			$nid = DB::table('nbranchid')->join('nbranchoutletid','nbranchid.id','=','nbranchoutletid.nbranchid_id')->where('nbranchoutletid.outlet_id',$osho->oid)->count();
			if($nid == 0){
				$newid = UtilityController::branchuniqueid($osho->cityid, "07");
				if($newid != ""){
			//		dump("user: " . $merchant->user_id . " - " . $newid);
					$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$newid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

					DB::table('nbranchoutletid')->insertGetId(['nbranchid_id'=>$nbid, 'outlet_id'=>$osho->oid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

	//	dd("OK");
		echo "Script Completed";
    }

	public function scriptreceipt_no()
    {
		$receipts = DB::table('receipt')->get();
		foreach($receipts as $receipt){
			$porder_id = $receipt->porder_id;
			$merchant_receipt = DB::table('merchantproduct')->join('orderproduct','orderproduct.product_id','=','merchantproduct.product_id')->join('porder','orderproduct.porder_id','=','porder.id')->whereRaw('porder.id NOT IN (SELECT sorder.porder_id FROM sorder WHERE sorder.porder_id = porder.id)')->where('porder.id',$porder_id)->pluck('merchant_id');
			//dump($merchant_receipt);
			if(!is_null($merchant_receipt)){
				$merchant = DB::table('merchant')->where('id',$merchant_receipt)->first();
				if(!is_null($merchant)){
					$receipt_no = $merchant->receipt_no;
					if(!is_null($receipt_no)){
						$receipt_no++;
					} else {
						$receipt_no = 1;
					}
					DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
					DB::table('merchant')->where('id',$merchant_receipt)->update(['receipt_no'=>$receipt_no]);
				}
			} else {
				$station_receipt = DB::table('merchantproduct')->join('orderproduct','orderproduct.product_id','=','merchantproduct.product_id')->join('porder','orderproduct.porder_id','=','porder.id')->join('sorder','sorder.porder_id','=','porder.id')->where('porder.id',$porder_id)->pluck('station_id');
				//dump($station_receipt);
				if(!is_null($station_receipt)){
					$station = DB::table('station')->where('id',$station_receipt)->first();
					if(!is_null($station)){
						$receipt_no = $station->receipt_no;
						if(!is_null($receipt_no)){
							$receipt_no++;
						} else {
							$receipt_no = 1;
						}
						DB::table('receipt')->where('id',$receipt->id)->update(['receipt_no'=>$receipt_no]);
						DB::table('station')->where('id',$station_receipt)->update(['receipt_no'=>$receipt_no]);
					}
				}
			}
		}
		echo "Script Completed";
	}

	public function scriptcompany()
    {
		$merchants = DB::table('merchant')->get();
		foreach($merchants as $merchant){
			$companyexists = DB::table('company')->
				where('owner_user_id',$merchant->user_id)->first();

			if(is_null($companyexists)){
				$cname = trim($merchant->company_name);
				$cdesc = trim($merchant->description);
				dump("merchant:".$cname);

				$farray = explode(" ",$cname);
				$num = count($farray);
			//	dump($farray);
			//	dump($num);

				if($num == 1){
					$sysname = strtolower(substr($farray[0],0,3));
				} else if($num == 2){
					$sysname =strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1));
				} else if($num >= 3) {
					$sysname = strtolower(substr($farray[0],0,1) .
						substr($farray[1],0,1) . substr($farray[2],0,1));
				} else {
					$sysname = "n/a";
				}


				DB::table('company')->insert(['sysname'=>$sysname,
					'owner_user_id'=>$merchant->user_id,
					'dispname'=>$cname,
					'company_name'=>$cname,
					'description'=>$cdesc,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')]);
			}
		}

		$stations = DB::table('station')->get();
		foreach($stations as $merchant){
			$companyexists = DB::table('company')->
				where('owner_user_id',$merchant->user_id)->first();

			if(is_null($companyexists)){
				$cname = trim($merchant->company_name);
				$cdesc = trim($merchant->description);
				dump("station:".$cname);

				$farray = explode(" ",$cname);
				$num = count($farray);
			//	dump($farray);
				//dump($num);

				if($num == 1){
					$sysname = substr($farray[0],0,3);
				} else if($num == 2){
					$sysname = substr($farray[0],0,1) .
						substr($farray[1],0,1);
				} else if($num >= 3) {
					$sysname = substr($farray[0],0,1) .
						substr($farray[1],0,1) . substr($farray[2],0,1);
				} else {
					$sysname = "n/a";
				}

				DB::table('company')->insert(['sysname'=>$sysname,
					'owner_user_id'=>$merchant->user_id,
					'dispname'=>$cname,
					'company_name'=>$cname,
					'description'=>$cdesc,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')]);
			}
		}
		echo "Script Completed";
	}

    public function scriptseller()
    {
		DB::table('nsellerid')->delete();
		$merchants = DB::table('merchant')->join('address','address.id','=','merchant.address_id')->select('merchant.id as mid', 'merchant.user_id as user_id', 'address.city_id as cityid')->get();

		foreach($merchants as $merchant){
			$newid = "";
			$nid = DB::table('nsellerid')->where('user_id',$merchant->user_id)->count();
			if($nid == 0){
				$newid = UtilityController::selleruniqueid($merchant->cityid, "00");
				if($newid != ""){
			//		dump("user: " . $merchant->user_id . " - " . $newid);
					DB::table('nsellerid')->insert(['nseller_id'=>$newid, 'user_id'=>$merchant->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
		//dd("OK");
		$stations = DB::table('station')->where('stationtype_id','1')->join('address','address.id','=','station.address_id')->select('station.id as mid', 'station.user_id as user_id', 'address.city_id as cityid','station.stationtype_id as type')->get();

		foreach($stations as $station){
			$newid = "";
			$nid = DB::table('nsellerid')->where('user_id',$station->user_id)->count();
			if($nid == 0){
				$newid = UtilityController::selleruniqueid(
					$station->cityid, "01");
				if($newid != ""){
				//	dump("user: " . $station->user_id . " - " . $newid);
					DB::table('nsellerid')->insert(['nseller_id'=>$newid, 'user_id' => $station->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
		DB::table('nsproviderid')->delete();
		DB::table('nsproviderlogisticid')->delete();
		$stations = DB::table('station')->where('stationtype_id','!=','1')->join('logistic','logistic.station_id','=','station_id')->join('address','address.id','=','station.address_id')->select('station.id as mid', 'logistic.id as lid', 'station.user_id as user_id', 'address.city_id as cityid','station.stationtype_id as type')->get();

		foreach($stations as $station){
			$newid = "";
			$nid = DB::table('nsproviderid')->join('nsproviderlogisticid','nsproviderid.id','=','nsproviderlogisticid.nsproviderid_id')->where('nsproviderlogisticid.logistic_id',$station->lid)->count();
			if($nid == 0){
				$newid = UtilityController::sprovideruniqueid(
					$station->cityid, "00");
				if($newid != ""){
				//	dump("user: " . $station->user_id . " - " . $newid);
					$nlid = DB::table('nsproviderid')->insertGetId(['nsprovider_id'=>$newid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

					DB::table('nsproviderlogisticid')->insertGetId(['nsproviderid_id'=>$nlid, 'logistic_id'=>$station->lid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}
	//	dd("OK");
		echo "Script Completed";
    }

    public function scriptmerchant()
    {
		DB::table('nmerchantid')->delete();
		$merchants = DB::table('merchant')->join('address','address.id','=','merchant.address_id')->select('merchant.id as mid', 'merchant.user_id as user_id', 'address.city_id as cityid')->get();

		foreach($merchants as $merchant){
			$nid = DB::table('nmerchantid')->where('merchant_id',$merchant->mid)->count();
			if($nid == 0){
				$newid = UtilityController::merchantuniqueid($merchant->cityid);
				if($newid != ""){
					DB::table('nmerchantid')->insert(['nmerchant_id'=>$newid, 'merchant_id'=>$merchant->mid, 'user_id' => $merchant->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptoshopid()
    {
	//	DB::table('nbranchoshopid')->delete();
		$oshops = DB::table('oshop')->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->join('merchant','merchant.id','=','merchantoshop.merchant_id')
		->join('address','address.id','=','merchant.address_id')->select('oshop.id as id', 'address.city_id as cityid')->get();

		foreach($oshops as $oshop){
			$nid = DB::table('nbranchoshopid')->where('oshop_id',$oshop->id)->count();
			if($nid == 0){
			//	$uniqueid = (new UtilityController)->branchuniqueid($request->get('city_id'),'06');
				$newid = UtilityController::branchuniqueid($oshop->cityid,'06');
				if($newid != ""){
					$nbid = DB::table('nbranchid')->insertGetId(['nbranch_id'=>$newid, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

						DB::table('nbranchoshopid')->insertGetId(['nbranchid_id'=>$nbid, 'oshop_id'=>$oshop->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptstation()
    {
		DB::table('nstationid')->delete();
		$stations = DB::table('station')->join('address','address.id','=','station.address_id')->select('station.id as mid', 'station.user_id as user_id', 'address.city_id as cityid','station.stationtype_id as type')->get();

		foreach($stations as $station){
			$nid = DB::table('nstationid')->where('station_id',$station->mid)->count();
			if($nid == 0){
				$newid = UtilityController::stationuniqueid(
					$station->cityid, $station->type);
				if($newid != ""){
					DB::table('nstationid')->insert(['nstation_id'=>$newid, 'station_id'=>$station->mid, 'user_id' => $station->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptbuyer()
    {
		DB::table('nbuyerid')->delete();
		$buyers = DB::table('buyer')->join('users','users.id','=','buyer.user_id')->join('address','address.id','=','users.default_address_id')->select('buyer.id as bid', 'buyer.user_id as user_id', 'address.city_id as cityid')->get();

		foreach($buyers as $buyer){
			//dump($buyer);

			$nid = DB::table('nbuyerid')->where('buyer_id',$buyer->bid)->count();
			if($nid == 0){
				$newid = UtilityController::buyeruniqueid($buyer->cityid);
				if($newid != ""){
					DB::table('nbuyerid')->insert(['nbuyer_id'=>$newid, 'buyer_id'=>$buyer->bid, 'user_id' => $buyer->user_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptporder()
    {
		$orders = DB::table('porder')->get();
		DB::table('nporderid')->delete();
		foreach($orders as $order){
			$nid = DB::table('nporderid')->where('porder_id',$order->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($order->id, '1', '1', $order->created_at, 'nporderid', 'nporder_id');
				if($newid != ""){
					DB::table('nporderid')->insert(['nporder_id'=>$newid, 'porder_id'=>$order->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptdo()
    {
		$orders = DB::table('deliveryorder')->get();
		DB::table('ndeliveryorderid')->delete();
		foreach($orders as $order){
			$nid = DB::table('ndeliveryorderid')->
				where('deliveryorder_id',$order->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($order->id, '3',
					'1', $order->created_at, 'ndeliveryorderid',
					'ndeliveryorder_id');

				if($newid != ""){
					DB::table('ndeliveryorderid')->
						insert(['ndeliveryorder_id'=>$newid,
						'deliveryorder_id'=>$order->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptdelivery()
    {
		$deliveries = DB::table('delivery')->get();
		DB::table('ndeliveryid')->delete();
		foreach($deliveries as $delivery){
			$nid = DB::table('ndeliveryid')->where('delivery_id',$delivery->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($delivery->id, '11', '1', $delivery->created_at, 'ndeliveryid', 'ndelivery_id');
				if($newid != ""){
					DB::table('ndeliveryid')->insert(['ndelivery_id'=>$newid, 'delivery_id'=>$delivery->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptdiscount()
    {
		$discounts = DB::table('discount')->get();
		DB::table('ndiscountid')->delete();
		foreach($discounts as $discount){
			$nid = DB::table('ndiscountid')->where('discount_id',$discount->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($discount->id, '4', '1', $discount->created_at, 'ndiscountid', 'ndiscount_id');

				if($newid != ""){
					DB::table('ndiscountid')->insert(['ndiscount_id'=>$newid, 'discount_id'=>$discount->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			//	dd($newid);
			}
		}

		echo "Script Completed";
    }

    public function scriptocredit()
    {
		$ocredits = DB::table('ocredit')->get();
		DB::table('nocreditid')->delete();
		foreach($ocredits as $ocredit){
			$nid = DB::table('nocreditid')->where('ocredit_id',$ocredit->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($ocredit->id, '5', '1', $ocredit->created_at, 'nocreditid', 'nocredit_id');
				if($newid != ""){
					DB::table('nocreditid')->insert(['nocredit_id'=>$newid, 'ocredit_id'=>$ocredit->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scripthyper()
    {
		$hypers = DB::table('owarehouse')->get();
		DB::table('nhyperid')->delete();
		foreach($hypers as $hyper){
			$nid = DB::table('nhyperid')->where('hyper_id',$hyper->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($hyper->id, '6', '1', $hyper->created_at, 'nhyperid', 'nhyper_id');
				if($newid != ""){
					DB::table('nhyperid')->insert(['nhyper_id'=>$newid, 'hyper_id'=>$hyper->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }


    public function scriptopenwish()
    {
		$openwishs = DB::table('openwish')->get();
		DB::table('nopenwishid')->delete();
		foreach($openwishs as $openwish){
			$nid = DB::table('nopenwishid')->where('openwish_id',$openwish->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($openwish->id, '7', '1', $openwish->created_at, 'nopenwishid', 'nopenwish_id');
				if($newid != ""){
					DB::table('nopenwishid')->insert(['nopenwish_id'=>$newid, 'openwish_id'=>$openwish->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptsmm()
    {
		$smms = DB::table('smmout')->get();
		DB::table('nsmmid')->delete();
		foreach($smms as $smm){
			$nid = DB::table('nsmmid')->where('smm_id',$smm->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($smm->id, '8', '1', $smm->created_at, 'nsmmid', 'nsmm_id');
				if($newid != ""){
					DB::table('nsmmid')->insert(['nsmm_id'=>$newid, 'smm_id'=>$smm->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptcre()
    {
		$cres = DB::table('cre')->get();
		DB::table('ncreid')->delete();
		foreach($cres as $cre){
			$nid = DB::table('ncreid')->where('ncre_id',$cre->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($cre->id, '9', '1', $cre->created_at, 'ncreid', 'ncre_id');
				if($newid != ""){
					DB::table('ncreid')->insert(['ncre_id'=>$newid, 'cre_id'=>$cre->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptautolink()
    {
		$autolinks = DB::table('autolink')->get();
		DB::table('nautolinkid')->delete();
		foreach($autolinks as $autolink){
			$ism = DB::table('merchant')->where('user_id',$autolink->initiator)->count();
			$iss = DB::table('station')->where('user_id',$autolink->initiator)->count();
			$type = "1";
			if($iss > 0){
				$type = "2";
			}
			if($ism > 0){
				$type = "4";
			}
			$nid = DB::table('nautolinkid')->where('autolink_id',$autolink->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($autolink->id, '2',$type, $autolink->created_at, 'nautolinkid', 'nautolink_id');
				if($newid != ""){
					DB::table('nautolinkid')->insert(['nautolink_id'=>$newid, 'autolink_id'=>$autolink->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

    public function scriptvoucher()
    {
		$vouchers = DB::table('voucher')->get();
		DB::table('nvoucherid')->delete();
		foreach($vouchers as $voucher){
			$nid = DB::table('nvoucherid')->where('voucher_id',$voucher->id)->count();
			if($nid == 0){
				$newid = UtilityController::generaluniqueid($voucher->id, '10','01', $voucher->created_at, 'nvoucherid', 'nvoucher_id');
				if($newid != ""){
					DB::table('nvoucherid')->insert(['nvoucher_id'=>$newid, 'voucher_id'=>$voucher->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
				}
			}
		}

		echo "Script Completed";
    }

	public function scriptcountry()
    {
		$fh = fopen('ncountryid_bulk.txt','r');
		DB::table('ncountryid')->delete();
		while ($line = fgets($fh)) {
		  // <... Do your work with the line ...>
		 // echo($line . "<br>");
			$mappingarr = explode("\t", $line,3);
			$mappingarr[1] = str_replace("\n","",$mappingarr[1]);
			DB::table('ncountryid')->insert(['country_id'=>$mappingarr[0],'ncountry_id'=>$mappingarr[1],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
		}
		fclose($fh);
		echo "Script Completed";
	}

	public function scriptproductdetails()
    {
		$products = DB::table('product')->
			orderBy('id', 'ASC')->
			select('id','productdetail_id')->get();

		foreach($products as $product){
			if($product->productdetail_id == 0 ||
				is_null($product->productdetail_id)){

				$singleproduct = DB::table('product')->
					where('id',$product->id)->first();

				$details = $singleproduct->product_details;
				if (!is_null($details)) {
					$pdetail = DB::table('productdetail')->
						insertGetId([
							'data'=>$details,
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')
						]);

					DB::table('product')->
						where('id',$product->id)->
						update(['productdetail_id'=>$pdetail]);
				}
			}
		}
		echo "Script Completed";
	}

    public function scriptproduct()
    {
		DB::table('nproductid')->delete();

 		$query = "select * from product order by id";
        $dbh=DB::connection('mysql')->getPdo();
		$sth=$dbh->prepare($query);
        $sth->execute();

		//foreach($products as $product){
		$j = $k = 0;
		while ($product = $sth->fetchObject()) {
			$nid = DB::table('nproductid')->where('product_id',$product->id)->count();

			echo ++$k.". ".$product->id.": nid=".$nid."\n";

			if($nid == 0){

				$merchant = DB::table('merchant')->
					join('merchantproduct','merchant.id','=',
						'merchantproduct.merchant_id')->
					where('merchantproduct.product_id',$product->parent_id)->
					first();

				$merchant_id = 0;
				$merchant_uniqueid = "";
				if(!is_null($merchant)){
					$user_id = $merchant->user_id;
					$merchant_id = $merchant->merchant_id;
					$merchantu = DB::table('nsellerid')->
						where('user_id',$user_id)->first();

					if(!is_null($merchantu)){
						$merchant_uniqueid = $merchantu->nseller_id;
						$colors = DB::table('color')->
							join('productcolor','color.id','=',
								'productcolor.color_id')->
							where('productcolor.product_id',
								$product->parent_id)->
							select('color.*')->get();

						if(!is_null($colors) && count($colors) > 0){
							foreach($colors as $color){
								$newid = UtilityController::productuniqueid(
									$merchant_id,$merchant_uniqueid,
									$product->segment, $color->id,$product->id);

								echo $j++.". ProductID: ".
									$product->id." - NewID: ".
									$newid . "<br>\n";

								if($newid != ""){
									DB::table('nproductid')->
									insert(['nproduct_id'=>$newid,
										'product_id'=>$product->id,
										'created_at' => date('Y-m-d H:i:s'),
										'updated_at' => date('Y-m-d H:i:s')]);
								}
							}
						} else {
							$newid = UtilityController::productuniqueid(
								$merchant_id,$merchant_uniqueid,
								$product->segment, 0,$product->id);

							echo $j++.". ProductID: ".$product->id." - NewID: ".
								$newid . "<br>\n";

							if($newid != ""){
								DB::table('nproductid')->
									insert(['nproduct_id'=>$newid,
									'product_id'=>$product->id,
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')]);
							}
						}
					}

				} else {
					$merchant_uniqueid = "000000000000";
				}
			} else {
				echo "nproduct_id EXISTS: ProductID: ".
					$product->id." - NID: ".$nid."<br>";
			}

		}
		echo "Script Completed";
    }

	/* NinjaVan Search via Order API v4.0 */
    public function jnv44()
    {
    	$tracking_id="INTOS732";
    	$nv=new NinjaVan;
    	$ret = $nv->track_order($tracking_id);
    	dump($ret);
		return $ret;
    }

	/* NinjaVan Cancellation via Order API v4.0 */
    public function jnv45()
    {
    	$tracking_id="INTOS732";
    	$nv=new NinjaVan;
    	$ret = $nv->cancel_order($tracking_id);
    	dump($ret);
		return $ret;
    }


	public function foofoo()
	{
 		//$url = 'https://api-sandbox.ninjavan.co/sg/2.0/oauth/access_token';
		$url = 'https://api.ninjavan.co/my/2.0/oauth/access_token';
		dump($url);

  		$headers = array();
		$headers[0] = 'Content-type: application/json';

		$client_id = NINJAVAN_CLIENT_ID;
		$client_secret = NINJAVAN_CLIENT_SECRET;
		$grant_type = "client_credentials";

		$data = compact("client_id", "client_secret", "grant_type");
		dump(json_encode($data));

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		dump($ch);

		$response = json_decode(curl_exec($ch));
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		$at = $response->access_token;
		//$at = 'RACwTsuCOFCFCFvk4wYTiBQg8txGIZjjYeTt2T2Yfoobar';

		return (isset($at) ? $at : null);
	}


    /* Mastercard */
	/* These are all TEST methods ONLY. Not MEANT for production */

	/* Mastercard v4.5: Create a Session */
 	public function mc1()
    {
    	$mid="10000023801";
    	$username="merchant.".$mid;
    	$password="854294c074773779b720c3867f3341bb";
		$url = "https://test-gateway.mastercard.com/api/rest/version/45/merchant/$mid/session";
		$raw=$username.":".$password;
		dump("URL=".$url);
		dump("UserId:Password=".$raw);

 		/* correlationId MUST be of string */
		$cid = time();
 		$correlationId="$cid";
        $data = compact("correlationId");

		dump($data);
		$jdata = json_encode($data);
		dump($jdata);

  		$headers = array();
		$headers[0] = 'Content-Type: Application/json;charset=UTF-8';
		$headers[1]=  'Authorization: Basic '.base64_encode($raw);
		dump($headers);

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		return json_encode($response);
	}


	/* Mastercard v4.5: Create Checkout Session */
	public function mc2()
    {
    	$mid="10000023801";
    	$username="merchant.".$mid;
    	$password="854294c074773779b720c3867f3341bb";
		$url = "https://test-gateway.mastercard.com/api/rest/version/45/merchant/$mid/session";
		$raw=$username.":".$password;
		dump("URL=".$url);
		dump("UserId:Password=".$raw);

		/*
		${"sourceOfFunds.provided.card.expiry.month"}=5;
		${"sourceOfFunds.provided.card.expiry.year"}=21;
		${"sourceOfFunds.provided.card.securityCode"}=100;
		${"order.id"}=1566;
		${"transaction.id"}=1566;
		${"order.amount"}=29.00;
		${"order.currency"}='MYR';
		$apiOperation='PAY';
		${"sourceOfFunds.type"}='CARD';
		${"sourceOfFunds.provided.card.number"}='5111111111111118';
		$merchant=$mid;
		$apiPassword=$password;
		$apiUsername=$username;
		*/

		/*
		$data = compact(
			"sourceOfFunds.provided.card.expiry.month",
			"sourceOfFunds.provided.card.expiry.year",
			"sourceOfFunds.provided.card.securityCode",
			"order.id",
			"transaction.id",
			"order.amount",
			"order.currency",
			"apiOperation",
			"sourceOfFunds.type",
			"sourceOfFunds.provided.card.number",
			"merchant",
			"apiPassword",
			"apiUsername"
		);
		 */

 		$apiOperation='CREATE_CHECKOUT_SESSION';
        $order=[
            "id"=>"1234",
            "currency"=>DB::table('currency')->where('active', 1)->first()->code
        ];
        $data = compact("apiOperation", "order");

		dump($data);
		$jdata = json_encode($data);
		dump($jdata);


		/*
		$data = "sourceOfFunds.provided.card.expiry.month=5&sourceOfFunds.provided.card.expiry.year=21&sourceOfFunds.provided.card.securityCode=100&order.id=1566&transaction.id=1566&order.amount=29.00&order.currency=MYR&apiOperation=PAY&sourceOfFunds.type=CARD&sourceOfFunds.provided.card.number=5111111111111118&merchant=".$mid."&apiPassword=".$apipassword."&apiUsername=".$apiusername;
		 */

  		$headers = array();
		$headers[0] = 'Content-Type: Application/json;charset=UTF-8';
		$headers[1]=  'Authorization: Basic '.base64_encode($raw);
		dump($headers);

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		//curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

		$response = json_decode(curl_exec($ch));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		return json_encode($response);
	}

 	/* Mastercard v4.5: Check Gateway */
 	public function mc3()
    {
		$url = "https://test-gateway.mastercard.com/api/rest/version/45/information";

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		return json_encode($response);
	}

 	/* Mastercard v4.5: Payment Option Inquiry */
 	public function mc4()
    {
    	$mid="10000023801";
		$url = "https://test-gateway.mastercard.com/api/rest/version/45/merchant/$mid/paymentOptionsInquiry";
    	$username="merchant.".$mid;
    	$password="854294c074773779b720c3867f3341bb";

 		$raw=$username.":".$password;
		dump("URL=".$url);
		dump("UserId:Password=".$raw);

   		$headers = array();
		$headers[0] = 'Content-Type: Application/json;charset=UTF-8';
		$headers[1]=  'Authorization: Basic '.base64_encode($raw);
		dump($headers);

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		return json_encode($response);
	}

 	/* Mastercard v4.5: Create Token with System Id */
  	public function mc5()
    {
    	$mid="10000023801";
    	$username="merchant.".$mid;
    	$password="854294c074773779b720c3867f3341bb";
		$url = "https://test-gateway.mastercard.com/api/rest/version/45/merchant/$mid/token";
		$raw=$username.":".$password;
		dump($url);

		${"sourceOfFunds.type"}='CARD';
		${'sourceOfFunds.provided.card.expiry.month'}='5';
		${'sourceOfFunds.provided.card.expiry.year'}='21';
		${'sourceOfFunds.provided.card.securityCode'}='100';
		${'sourceOfFunds.provided.card.number'}='5111111111111118';

		$data = compact(
			"sourceOfFunds.type",
			'sourceOfFunds.provided.card.expiry.month',
			'sourceOfFunds.provided.card.expiry.year',
			'sourceOfFunds.provided.card.securityCode',
			'sourceOfFunds.provided.card.number'
		);

		dump($data);

		$jdata = json_encode($data);

		$jdata = '{"sourceOfFunds.type":"CARD","sourceOfFunds.provided.card.expiry.month":"5","sourceOfFunds.provided.card.expiry.year":"21","sourceOfFunds.provided.card.securityCode":"100","sourceOfFunds.provided.card.number":"5111111111111118"}';


		dump($jdata);

  		$headers = array();
		$headers[0] = 'Content-Length: '.strlen($jdata);
		$headers[1] = 'Content-Type: Application/json;charset=UTF-8';
		$headers[2]=  'Authorization: Basic '.base64_encode($raw);
		dump($headers);

 		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = json_decode(curl_exec($ch));

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		dump('http_code='.$http_code);
		dump($response);

		return json_encode($response);
	}


	public function module_access()
	{
		$merchants=DB::table('merchant')
		->whereNull('deleted_at')
		->get();
		$modules=DB::table('sysmodule')->get();
		foreach ($merchants as $merchant) {
			# code...
			$this->sysmodule_access_merchant($merchant->id,$modules);

		}
		return "ok";
	}

	public function sysmodule_access_merchant($merchant_id,$modules)
	{
		# code...
		foreach ($modules as $m) {
			# code...
			DB::table('moduleaccess')
			->insert([
				"sysmodule_id"=>$m->id,
				"merchant_id"=>$merchant_id,
				"status"=>"active",
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now()
			]);
		}

	}
}
