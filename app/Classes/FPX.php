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

class FPX
{
	public $model="01";
	public $fpx_version="6.0";
	public $currency="MYR";
	public $desc="OpenSupermall.com";

	/*
	public $seller_id="SE00007140";
	public $exchange_id="EX00006111";
	public $fpx_banklist_url="https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList";
	public $fpx_ae_url="https://uat.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp";
	public $fpx_url_test="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp";
	public $fpx_url_production="";
	//public $key="certs/EX00006111.key";
	*/

	public static function log2file($data, $logfile=FPXCLASSLOG){
        $fp = fopen($logfile, 'a');
		fwrite($fp, $data."\n");
		fwrite($fp, "-----------------------------------------------\n");
		fclose($fp);
    }
 
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


 	public function get_private_key($globals) {
 		if ($this->check_production()) {
			$ret = $globals->fpx_prd_exchange_id;
		} else {
			$ret = $globals->fpx_exchange_id;
		}
		return trim("certs/".$ret.".key"); 
	}
 

	public function get_seller_id($globals) {
 		if ($this->check_production()) {
			$ret = $globals->fpx_prd_seller_id;
		} else {
			$ret = $globals->fpx_seller_id;
		}
		return trim($ret); 
	}


	public function get_exchange_id($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_exchange_id;
		} else {
			$ret = $globals->fpx_exchange_id;
		}
		return trim($ret);  
	}


 	public function get_primary_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_url;
		} else {
			$ret = $globals->fpx_uat_url;
		}
		return trim($ret);  
	}


  	public function get_banklist_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_be_url;
		} else {
			$ret = $globals->fpx_uat_be_url;;
		}
		return trim($ret);  
	}
 

   	public function get_auth_url($globals) {
  		if ($this->check_production()) {
			$ret = $globals->fpx_prd_ae_url;
		} else {
			$ret = $globals->fpx_uat_ae_url;
		}
		return trim($ret);  
	}
 

	public function get_bank_by_id($bank_code) {
		$ret="Bank Name Missing";
		try {
			// $ret=$this->bank_kv[$bank_code];
			$ret=DB::table('bank')->where('code',$bank_code)->pluck('name');

		} catch (\Exception $e) {
			self::log2file($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		return $ret;
	}

	public function bank_kv()
	{
		$ret=array();
		$banks=DB::table('bank')->
			whereNull('deleted_at')->
			select('code','name')->
			orderBy('name')->get();

		foreach ($banks as $b) {
			$ret[$b->code]=$b->name;
		}
		return $ret;
	
	}

	public function get_status_by_code($code) {
		$ret="Code Missing";
		try {
			$row = DB::table('fpx_respcode')->
				where('respcode',$code)->first();
			if (!is_null($row)) {
				$ret = $row->description;
			}

		} catch (\Exception $e) {
			// dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		return "[$code] ".$ret;
	}


	public function get_ar_msg($r) {
		if (!Auth::check()) {
             return 0;

        } else {
            $user_id=Auth::user()->id;
            $user_email=Auth::user()->email;
            $user_name=Auth::user()->name;
        } 

		$globals = DB::table('global')->first();
		$fpx_id = $this->get_seller_id($globals);
		$exchange_id = $this->get_exchange_id($globals);

        $fpx_msgType="AR";
        $fpx_msgToken=$this->model;
        $fpx_sellerExId=$exchange_id;
        $fpx_sellerExOrderNo=(int)time();
        $fpx_sellerTxnTime=$this->get_txn_time();

        $fpx_sellerOrderNo=$r->reference_number;
        $fpx_sellerId=$fpx_id;
        $fpx_sellerBankCode="01";
        $fpx_txnCurrency=$this->currency;
        $fpx_txnAmount=$r->amount;
        $fpx_buyerBankId=$r->buyer_bankid;
        $fpx_buyerBankBranch="";
        $fpx_buyerName="";
        $fpx_buyerEmail=$user_email;
        $fpx_buyerId="";
        $fpx_buyerAccNo="";
        $fpx_makerName="";
        $fpx_buyerIban="";
        $fpx_productDesc=$this->desc;
        $fpx_version=$this->fpx_version;
        /**************************************/ 
        $data=compact("fpx_msgType","fpx_msgToken","fpx_sellerExId","fpx_sellerExOrderNo","fpx_sellerTxnTime","fpx_sellerOrderNo","fpx_sellerId","fpx_sellerBankCode","fpx_txnCurrency","fpx_txnAmount","fpx_buyerEmail","fpx_checkSum","fpx_buyerName","fpx_buyerBankId","fpx_buyerBankBranch","fpx_buyerAccNo","fpx_buyerId","fpx_makerName","fpx_buyerIban","fpx_productDesc","fpx_version");


		//$data=compact("fpx_buyerAccNo","fpx_buyerBankBranch","fpx_buyerBankId","fpx_buyerEmail","fpx_buyerIban","fpx_buyerId","fpx_buyerName","fpx_makerName","fpx_msgToken","fpx_msgType","fpx_productDesc","fpx_sellerBankCode","fpx_sellerExId","fpx_sellerExOrderNo","fpx_sellerId","fpx_sellerOrderNo","fpx_sellerTxnTime","fpx_txnAmount","fpx_txnCurrency","fpx_version");

        $checksum=$this->get_source_string($data);
		// dump($checksum);
      
        //$fpx_checkSum=$this->get_signed_checksum($checksum,$this->key);
        $fpx_checkSum=$this->get_signed_checksum($checksum,$this->get_private_key($globals));

		$data['fpx_checkSum']=$fpx_checkSum;
		$id=UtilityController::dynamic_save($data,'fpx_AR');
        // session_start();
        // $cart=unserialize($_SESSION['cart']);
        // session_write_close();
        // reset($cart);

		self::log2file("BEFORE session_id()=".session_id());

        $cart_session_id =session_id();

		self::log2file("AFTER cart_session_id=".$cart_session_id);
		

		DB::table('stuff')->
			insert(['note'=>'Cart Session ID|'.$cart_session_id]);
		DB::table('fpxref')->insert([
			'ref_no'=>$fpx_sellerOrderNo,
			'fpx_ar_id'=>$id,
			'user_id'=>Auth::user()->id,
			'cart_session_id'=>$cart_session_id,
			'tries'=>1,
			'created_at'=>date("Y-m-d H:i:s"),
			'updated_at'=>date("Y-m-d H:i:s")

			]);
		return $data;
	} 

	public function get_txn_time() {
		$ret="YYYYMMDDHHmmSS";
		$ret=date("Ymdhis");
		return $ret;   
	}

	public function get_source_string($data) {
		$raw="fpx_buyerAccNo|fpx_buyerBankBranch|fpx_buyerBankId|fpx_buyerEmail|fpx_buyerIban|fpx_buyerId|fpx_buyerName|fpx_makerName|fpx_msgToken|fpx_msgType|fpx_productDesc|fpx_sellerBankCode|fpx_sellerExId|fpx_sellerExOrderNo|fpx_sellerId|fpx_sellerOrderNo|fpx_sellerTxnTime|fpx_txnAmount|fpx_txnCurrency|fpx_version";
		$raw=explode("|",$raw);
		$cooked="";
		foreach ($raw as $r) {
			try {
				$cooked .= "|".$data[$r];
			} catch (\Exception $e) {
			// dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
			}
		}
		/* This is to get rid of the first '|' which is incorrect */
		$cooked = substr($cooked, 1);

	
		return $cooked;
	}

	public function get_signed_checksum($data,$key) {
		/* Reading key */
		$path= storage_path($key);
		$priv_key = file_get_contents($path);
		$pkeyid = openssl_get_privatekey($priv_key);
		openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
		$fpx_checkSum = strtoupper(bin2hex($binary_signature));
		return $fpx_checkSum;
	}

	function hextobin($hexstr) { 
		$n = strlen($hexstr); 
		$sbin="";   
		$i=0; 
		while($i<$n) {       
			$a =substr($hexstr,$i,2);           
			$c = pack("H*",$a); 
			if ($i==0){$sbin=$c;} 
			else {$sbin.=$c;} 
			$i+=2; 
		} 

		return $sbin; 
	}

	public function create_ae($ar_id)
	{
		$data=FPXAR::where('id',$ar_id)->first();

		$globals = DB::table('global')->first();
		$fpx_id = $this->get_seller_id($globals);
		$exchange_id = $this->get_exchange_id($globals);

		/*
        try {
            $exchange_id=$global->fpx_exchange_id;
            $fpx_id=$global->fpx_seller_id;

        } catch (\Exception $e) {
            $exchange_id=$this->exchange_id;
            $fpx_id=$this->seller_id;
        }
		*/

        $fpx_msgType="AE";
        $fpx_msgToken=$this->model;
        $fpx_sellerExId=$exchange_id;
        $fpx_sellerExOrderNo=(int)$data->fpx_sellerExOrderNo;
        $time=str_replace(":","",$data->fpx_sellerTxnTime);
        $time=str_replace("-","",$time);
        $time=str_replace(" ","",$time);
        $fpx_sellerTxnTime=$time;

        $fpx_sellerOrderNo=$data->fpx_sellerOrderNo;
        $fpx_sellerId=$fpx_id;
        $fpx_sellerBankCode="01";
        $fpx_txnCurrency=$this->currency;
        $fpx_txnAmount=$data->fpx_txnAmount;
        $fpx_buyerEmail=$data->fpx_buyerEmail;
    
        $fpx_buyerName=$data->fpx_buyerName;
        $fpx_buyerBankId=$data->fpx_buyerBankId;
 
        $fpx_buyerBankBranch=$data->fpx_buyerBankBranch;
        $fpx_buyerAccNo=$data->buyerAccNo;
        $fpx_buyerId=$data->fpx_buyerId;
        $fpx_makerName="";
        $fpx_buyerIban="";
        $fpx_productDesc=$this->desc;
        $fpx_version=$this->fpx_version;
        $data=compact(
			"fpx_msgType",
			"fpx_msgToken",
			"fpx_sellerExId",
			"fpx_sellerExOrderNo",
			"fpx_sellerTxnTime",
			"fpx_sellerOrderNo",
			"fpx_sellerId",
			"fpx_sellerBankCode",
			"fpx_txnCurrency",
			"fpx_txnAmount",
			"fpx_buyerEmail",
			"fpx_checkSum",
			"fpx_buyerName",
			"fpx_buyerBankId",
			"fpx_buyerBankBranch",
			"fpx_buyerAccNo",
			"fpx_buyerId",
			"fpx_makerName",
			"fpx_buyerIban",
			"fpx_productDesc",
			"fpx_version"
		);

		$checksum=$this->get_source_string($data);

        $fpx_checkSum=$this->get_signed_checksum($checksum,
			$this->get_private_key($globals));

		$data['fpx_checkSum']=$fpx_checkSum;
		return $data;
	}

	public function post_ae($ac_id)
	{
		$data=$this->create_ae($ac_id);
		//dump($data);

		$globals = DB::table('global')->first();
		//$url=$this->fpx_ae_url;
		$url=$this->get_auth_url($globals);

		$response="init";

		try {
			$source_string=null;
			foreach($data as $key=>$value) {
				$source_string .= $key.'='.$value.'&';
			}
			$source_string = rtrim($source_string,'&');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			// dump($url);
			// dump(count($data));

			curl_setopt($ch,CURLOPT_POST, count($data));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $source_string);

			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//execute post
			$response = curl_exec($ch);

			//close connection
			curl_close($ch);

		} catch (\Exception $e) {
			// dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		return $response;
	}

	public function create_be() {
		/* Send a request to FPX to get all the Bank lists and show
		   it to the buyer. If request fails, show the hardcoded list */ 

		$globals = DB::table('global')->first();
		$seller_id = $this->get_seller_id($globals);
		$exchange_id = $this->get_exchange_id($globals);

		$form=array();
		$fpx_msgType=urlencode("BE");
		$fpx_msgToken=urlencode("01");
		$fpx_sellerExId=urlencode($exchange_id);
		$fpx_version=urlencode($this->fpx_version);
		$data=compact("fpx_msgToken","fpx_msgType",
					  "fpx_sellerExId","fpx_version");
		$checksum=$this->get_source_string($data);
		//$data['fpx_checkSum']=$this->get_signed_checksum($checksum,$this->key);

		$data['fpx_checkSum']=$this->
			get_signed_checksum($checksum,$this->get_private_key($globals));

		return $data;
	}

	public function post_be($data)
	{
		$response="";
		$globals = DB::table('global')->first();
		//$url=$this->fpx_banklist_url;
		$url = $this->get_banklist_url($globals);

		try {
			$source_string="";
			foreach($data as $key=>$value) {
				$source_string .= $key.'='.$value.'&';
			}
			$source_string = rtrim($source_string, '&');
	   
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($data));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $source_string);

			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$response = curl_exec($ch);

			//close connection
			curl_close($ch);

		} catch (\Exception $e) {
			dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		return $response;
	}

	public function get_banks()
	{
		$response_value=array();
		$bank_list=array();
		$data=$this->create_be();
		$result=$this->post_be($data);
		
		try {
			$token = strtok($result, "&");

			while ($token !== false)
			{
				list($key1,$value1)=explode("=", $token);
				$value1=urldecode($value1);
				$response_value[$key1]=$value1;
		
				$token = strtok("&");
			}
			
			$fpx_msgToken=reset($response_value);
			$res=UtilityController::dynamic_save($response_value,'fpx_BE');
		
			//Response Checksum Calculation String
			$data=$response_value['fpx_bankList']."|".
				$response_value['fpx_msgToken']."|".
				$response_value['fpx_msgType']."|".
				$response_value['fpx_sellerExId'];

			// $val=verifySign_fpx($response_value['fpx_checkSum'], $data);
			$token = strtok($response_value['fpx_bankList'], ",");
			while ($token !== false)
			{
				list($key1,$value1)=explode("~", $token);
				$value1=urldecode($value1);
				$bank_list[$key1]=$value1;

				DB::table('bank')->
					where('code',$key1)->
					update(['status'=>$value1]);
				$token = strtok(",");
			}
		} catch (\Exception $e) {
			// dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
		}

		return $bank_list;
	}

	/************BELOW FUNCTIONS ARE COPIED AND UNTESTED*********************/
	/*
	function validateCertificate($path,$sign, $toSign)
	{
		global  $ErrorCode;

		$d_ate=date("Y");

		//validating Last Three Certificates 
		$fpxcert=array($path."fpxuat_current.cer",$path."fpxuat.cer");
		$certs=checkCertExpiry($fpxcert);

		// echo count($certs) ;
		$signdata = hextobin($sign);
		
		if(count($certs)==1) {
		   $pkeyid =openssl_pkey_get_public($certs[0]);
		   $ret = openssl_verify($toSign, $signdata, $pkeyid);	
			  if($ret!=1) {
			   $ErrorCode=" Your Data cannot be verified against the Signature. "." ErrorCode :[09]";
			   return "09";	  
			  }

		} elseif(count($certs)==2) {
		 
			$pkeyid =openssl_pkey_get_public($certs[0]);
			$ret = openssl_verify($toSign, $signdata, $pkeyid);	

			if($ret!=1) {
				$pkeyid =openssl_pkey_get_public($certs[1]);
				$ret = openssl_verify($toSign, $signdata, $pkeyid);	

				if($ret!=1) {
					$ErrorCode=" Your Data cannot be verified against the Signature. "." ErrorCode :[09]";
					return "09";
				}
			}
		}

		if($ret==1) {
			$ErrorCode=" Your signature has been verified successfully. "." ErrorCode :[00]";
			return "00";	  
		}
			 
		return $ErrorCode;
	}

	public function verifySign_fpx($sign,$toSign) 
	{
		$globals = DB::table('global')->first();
		// error_reporting(0);
		//$key=storage_path($this->key);
		$key=storage_path($this->get_private_key($globals));
		return validateCertificate($key,$sign, $toSign);
	}

	public function checkCertExpiry($path)
	{
		global  $ErrorCode;

		$stack = array();
		$t_ime= time();
		$curr_date=date("Ymd",$t_ime);

		for($x=0;$x<2;$x++) {
			error_reporting(0);
			$key_id = file_get_contents($path[$x]);

			if($key_id==null) {
				$cert_exists++;
				continue;
			}	 

			$certinfo = openssl_x509_parse($key_id);
			$s= $certinfo['validTo_time_t']; 
			$crtexpirydate=date("Ymd",$s-86400);

			if($crtexpirydate > $curr_date) {
				if ($x > 0) {
					if(certRollOver($path[$x], $path[$x-1])=="true") {
						array_push($stack,$key_id);
						return $stack;
					}
				}	

				array_push($stack,$key_id);
				return $stack;

			} else if ($crtexpirydate == $curr_date) {
				if ($x > 0 && (file_exists($path[$x-1])!=1)) {	   
					if(certRollOver($path[$x], $path[$x-1])=="true") {
						array_push($stack,$key_id);
						return $stack;
					}

				} else if(file_exists($path[$x+1])!=1) {
					array_push($stack,file_get_contents($path[$x]),$key_id);
					return $stack;
				}
				   
				array_push($stack,file_get_contents($path[$x+1]),$key_id);
				return $stack;
			}
		 }

		if ($cert_exists == 2)
			$ErrorCode="Invalid Certificates.  " . " ErrorCode : [06]";

		else if ($stack.Count == 0 && $cert_exists == 1)
			$ErrorCode="One Certificate Found and Expired "."ErrorCode : [07]";

		else if ($stack.Count == 0 && $cert_exists == 0)
			$ErrorCode="Both Certificates Expired " . "ErrorCode : [08]";  

		return $stack;
	}


	public function certRollOver($old_crt,$new_crt)
	{  
		if (file_exists($new_crt)==1) {
			//FPXOLD.cer to FPX_CURRENT.cer_<CURRENT TIMESTAMP> 
			rename($new_crt,$new_crt."_".date("YmdHis", time()));
		}

		if ((file_exists($new_crt)!=1) && (file_exists($old_crt)==1)) {
			//FPX.cer to FPX_CURRENT.cer 
			rename($old_crt,$new_crt);
		}

		return "true";
	}


	protected function generate_cert_key()
	{
		try {
			$dirPath=storage_path("key")."/";
			$gen_key_command="openssl genrsa -out ".$dirPath.$this->fpx_sellerExId.".key 2048";
			$gen_cer_command="openssl req -out ".$dirPath.$this->fpx_sellerExId.".csr -key ".$this->fpx_sellerExId.".key -new -sha256";
			exec($gen_key_command);
			exec($gen_cer_command);

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	*/
}
