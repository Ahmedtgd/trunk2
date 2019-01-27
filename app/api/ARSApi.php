<?php

namespace App\api;

class ARSApi {

	// sending a top-up fields
	private $dealID;
	private $transTYPE;
	private $transID;
	private $targetMSISDN;
	private $telcoCODE;
	private $tpDENOM;
	private $transDATE;
	private $transTIME;
	private $TopUpRequestFields = [];
	private $TopUpResponseFields = [];

	// base api url
	private $base_url;

	// verification code
	private $veriCODE;
	
	//sending a top-up 
	private $tpRESULT;
	private $failREASON;

	// singletone implementation
	private function __construct(){

	}

	// get instance
	public static function getInstance(){
		static $inst = null;
		if($inst === null){
			$inst = new ARSApi();
		}
		return $inst;
	}

	//set base url 
	public function setBaseURL($url){
		$this->base_url = $url;
	}

	// get base url
	public function getBaseUrl(){
		return $this->base_url;
	}


	// set veriCode
	public function setVeriCode($tid, $tM, $tpD, $tD, $tt){
		$vc = ((int)(substr($tM, -4, 4)) * (int)($tpD)) + (int)(substr($tid, -5, 5)) + (int)(substr($tD, -5, 5)) + (int)(substr($tt, -4, 4));
		$this->veriCODE = $vc;
	}

	//get vericode
	public function getVeriCode(){
		return $this->veriCODE;
	}


	// execute post request
	private function execRequest($base_url, $fields){


		$fields_string = "";
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$new = rtrim($fields_string, '&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $base_url->jc_ars_url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $new);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}

	// set top up request fields
	public function setTopUpRequestFields($f1, $f2, $f3, $f4, $f5, $f6, $f7, $f8, $f9){
		$this->TopUpRequestFields["dealID"] = $f1;
		$this->TopUpRequestFields["transTYPE"] = $f2;
		$this->TopUpRequestFields["transID"] = $f3;
		$this->TopUpRequestFields["targetMSISDN"] = $f4;
		$this->TopUpRequestFields["telcoCODE"] = $f5;
		$this->TopUpRequestFields["tpDENOM"] = $f6;
		$this->TopUpRequestFields["transDATE"] = $f7;
		$this->TopUpRequestFields["transTIME"] = $f8;
		$this->TopUpRequestFields["veriCODE"]  = $f9;
	}

	// set top up response fields
	public function setTopUpResponseFields($f1, $f2, $f3, $f4, $f5, $f6, $f7){
		$this->TopUpResponseFields["transTYPE"] = $f1;
		$this->TopUpResponseFields["transID"] = $f2;
		$this->TopUpResponseFields["targetMSISDN"] = $f3;
		$this->TopUpResponseFields["transDATE"] = $f4;
		$this->TopUpResponseFields["transTIME"] = $f5;
		$this->TopUpResponseFields["tpRESULT"]  = $f6;
		$this->TopUpResponseFields["failREASON"]  = $f7;
	}

	// get top up request fields
	public function getTopUpRequestFields(){
		//dd($this->TopUpRequestFields);
		if(count($this->TopUpRequestFields) != 9) {
			throw new Exception("Fields must be nine (9)");
			return;
		}else{
			return $this->TopUpRequestFields;
		}
	}

	// get top up response fields
	public function getTopUpResponseFields(){
		if(count($this->TopUpResponseFields) != 7) {
			throw new Exception("Fields must be nine (9)");
			return;
		}else{
			return $this->TopUpResponseFields;
		}
	}

	//set trans id
	public function setTransID(){
		$this->transID = md5(\Carbon::now());
	}

	// get trans id 
	public function getTransID(){
		return $this->transID;
	}

	// method 1
	public function arsTpPOSTHttpRequest(){
		$base_url = $this->getBaseUrl();
		$fields   = $this->getTopUpRequestFields();
		return $this->execRequest($base_url, $fields);
	}

	public function arsTpFieldsPOSTHttpRequest($fields){
		$base_url = $this->getBaseUrl();
		return $this->execRequest($base_url, $fields);
	}

	// method 2
	public function arsTpRstPOSTHttpRequest(){
		$base_url = $this->getBaseUrl();
		$fields   = $this->getTopUpResponseFields();
		return $this->execRequest($base_url, $fields);
	}

	// method 2
	public function arsTpRstFieldsPOSTHttpRequest($fields){
		$base_url = $this->getBaseUrl();
		//$fields   = $this->getTopUpResponseFields();
		return $this->execRequest($base_url, $fields);
	}

}
