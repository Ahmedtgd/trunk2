<?php
namespace App\Classes;
use Auth;
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
use App\Models\FPXBE;
use App\Models\FPXAC;
use App\Models\FPXAR;
use Schema;
use url;
use DB;

/**
* Wrapper class for FPX payment gateway.
*/

define('FPXCLASSLOG', '/tmp/fpxclass.log');

class CC
{
	public $model="01";
	public $fpx_version="6.0";
	public $currency="MYR";
	public $desc="OpenSupermall.com";
	public $merchant_id="";
	public $api_password="";
	public $connection_status_url="";
	public $order_id;
	public $transaction_id;
	protected $api_mode="REST";

	private $test_merchant_id = '10000023801';
	private $function = '3D online purchase';
	private $api_user_name = 'merchant.10000023801';
	private $api_code = '854294c074773779b720c3867f3341bb';
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->set_variables();
		// $test= $this->check_connection();
		// if ($test==false) {
		// 	throw new Exception("No connection", 404);
			
		// }

	}
	
	/**
	 * [set_variables description]
	 */
	public function set_variables()
	{
		$this->merchant_id=$this->test_merchant_id;
		$this->api_password="";
		$this->order_id = 'OD'.time();
		$this->transaction_id = time();
		if ($this->api_mode=="REST") {
			$this->connection_status_url="https://test-gateway.mastercard.com/api/rest/version/1/information";
		}
	}
	
	/**
	 * [log2file description]
	 * @param  [type] $data    [description]
	 * @param  [type] $logfile [description]
	 * @return [type]          [description]
	 */
	public static function log2file($data, $logfile=FPXCLASSLOG){
        $fp = fopen($logfile, 'a');
		fwrite($fp, $data."\n");
		fwrite($fp, "-----------------------------------------------\n");
		fclose($fp);
    }
 	
 	/**
 	 * [check_production being used to determine system environment for further 
 	 * action to be taken based on it ]
 	 * @return [type] [description]
 	 */
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

	/**
	 * [get_private_key function used to get private key of api to used to call
	 * in API. and it takes one parameter of globale object which has global 
	 * settings from DB's global setting DB.]
	 * @param  [object] $globals is a object of global settings Table.
	 * @return [string] complete path private key file where it is placed.
	 */
 	public function get_private_key($globals) {
 		if ($this->check_production()) {
			$ret = $globals->fpx_prd_exchange_id;
		} else {
			$ret = $globals->fpx_exchange_id;
		}
		return trim("certs/".$ret.".key"); 
	}
 
	/**
	 * [get_seller_id function return seller id from db of global settings.]
	 * @param  [object] $globals [object of global settings table.]
	 * @return [string]          [value from seller id field.]
	 */
	public function get_seller_id($globals) {
 		if ($this->check_production()) {
			$ret = $globals->fpx_prd_seller_id;
		} else {
			$ret = $globals->fpx_seller_id;
		}
		return trim($ret); 
	}

	/**
	 * [get_exchange_id returns exchange id from global settings. it takes one
	 * parameter of global settings type to get id from global settings table.]
	 * @param  [object] $globals [object of global settings table model]
	 * @return [string]          [returns cc exchange id if it is require]
	 */
	public function get_exchange_id($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_exchange_id;
		} else {
			$ret = $globals->fpx_exchange_id;
		}
		return trim($ret);  
	}

	/**
	 * [get_primary_url used to get primary url of api. it takes parameter of 
	 * global settings type and return primary url based of system environment
	 * like if production environment is developer then dev/test url will be
	 * returned other wise production environment will be return from this
	 * function]
	 * @param  [object] $globals [object of global settings table model]
	 * @return [string]          [returns API primary url.]
	 */
 	public function get_primary_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_url;
		} else {
			$ret = $globals->fpx_uat_url;
		}
		return trim($ret);  
	}

	/**
	 * [get_banklist_url function used to get bank list url from api. this func
	 * returns url of banklist based on system enviroment. like test of 
	 * production]
	 * @param  [object] $globals [object of global settings table model]
	 * @return [string]          [returns cc bank list url if it is require]
	 */
  	public function get_banklist_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_be_url;
		} else {
			$ret = $globals->fpx_uat_be_url;;
		}
		return trim($ret);  
	}
 	
	/**
	 * [get_auth_url function returns url from global settings table which is 
	 * required to authentication user over API layer. this function takes 
	 * global settins parameter as its parameter and return authentication url
	 * by fetching it through DB object]
	 * @param  [object] $globals [object of global settings table model]
	 * @return [string]          [returns cc auth url]
	 */
   	public function get_auth_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_ae_url;
		} else {
			$ret = $globals->fpx_uat_ae_url;
		}
		return trim($ret);  
	}

	/**
	 * [check_connection description]
	 * @return [type] [description]
	 */
	public function check_connection()
	{
		$ret=false;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $this->connection_status_url,
		    CURLOPT_SSL_VERIFYPEER => false
		));
		
		$response = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		$body=json_decode($response, true);
		var_dump($body);
		if ($body['status']=="OPERATING") {
			$ret=true;
		}
		return $ret;
	}
	/**
	 * [get_token function used to grab payment token to further use in payment process]
	 * @return [type] return token returned by master Card API.
	 */
	public function get_token($data) {
		$url = 'https://eu-gateway.mastercard.com/api/rest/version/44/merchant/10000023801/token';
		$curl = curl_init();
		$data ['sourceOfFunds'] = [
				'provided'=> [
					'card' => [
						'expiry' => [
									'month'=>$data['expiry_month'], 
									'year'=> $data['expiry_year']
								],
						'number' => $data['card_number'],
						'securityCode'=> $data['csv']
					]
				]
			];


		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_CUSTOMREQUEST=> "PUT",
		    CURLOPT_SSL_VERIFYPEER => false,
		    CURLOPT_POSTFIELDS => http_build_query($data)
		));
		$response = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		var_dump($response);
		exit;
	}

	/**
	 * [do_authorization description]
	 * @return [type] [description]
	 */
	public function do_payment ($data) {

//		$token = $this->get_token();
//		
		$data ['sourceOfFunds'] = [
				'provided'=> [
					'card' => [
						'expiry' => [
									'month'=> 05,
									'year'=> 2021
								],
						'number' => '5123450000000008',
						'securityCode'=> 100
					]
				]
			];
		$data ['order'] = $this->fake_data('order');
		echo $url = 'https://test-gateway.mastercard.com/api/rest/version/44/merchant/'.$this->merchant_id.'/order/'.$this->order_id.'/transaction/'.$this->transaction_id;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_CUSTOMREQUEST=> "PUT",
		    CURLOPT_SSL_VERIFYPEER => false,
		    CURLOPT_POSTFIELDS => http_build_query($data)
		));
		$response = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		var_dump($response);
	}
	/**
	 * [fake_data description]
	 * @return [type] [description]
	 */
	public function fake_data ($param = false) {
		if(!$param) {
			$card=array();
			$expiry=array();
			$expiry['month']="05";
			$expiry['year']="2021";

			$card['securityCode']="100";
			$card['number']="5123450000000008";
			$card['address']="10001 Alpha St";
			$card['expiry']=$expiry;

			return $card;	

		} else if($param == 'card') {
			$order = [];
			$order['amount'] = 1;
			$order['currency'] = 'MYR';
			return $order;
		}

		
	}
}
