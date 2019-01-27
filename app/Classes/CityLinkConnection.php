<?php namespace App\Classes;

use DB;
use App\Exceptions\CustomException;
use QueryException;
use SoapVar;
use SoapClient;
use SoapHeader;

class CityLinkSoapClient extends SoapClient {
	function __doRequest($input, $location, $action,
		$version, $one_way = null) {

		/* We distinguish CTLShipReq (XML File) from TrackHeader (array) */
		if (strpos($input, 'CTLShipReq')) {
			$decoded_xml = html_entity_decode($input);

			/* Gotta hack away the SOAP header to reconstruct the
			 * original file. First we have to delimited the header
			 * line by line */
			$orig_xml = str_replace("><",">\n<", $decoded_xml);

			/* Hack off the first 5 lines!
			<?xml version="1.0" encoding="UTF-8"?>\n
			<SOAP-ENV:Envelope
				xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
				xmlns:ns1="http://www.citylinkexpress.com.my/">\n
			<SOAP-ENV:Body>\n
			<ns1:CTLShipReq/>\n
			<param1>\n */
			$hacked_f5 = implode("\n",
				array_slice(explode("\n", $orig_xml),5));

			/* Hack off the last 4 lines!
			</param1>\n
			</SOAP-ENV:Body>\n
			</SOAP-ENV:Envelope>\n */ 

			$hacked_l3 = preg_replace("~</param1>.*$\n~m", "", $hacked_f5);
			$hacked_l2 = preg_replace("~</SOAP-ENV.*$\n~m", "", $hacked_l3);

			$b64_string = base64_encode($hacked_l2);

			/*
			dump($hacked_f5);
			dump($hacked_l3);
			dump($hacked_l2);
			*/

			$request = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><CTLShipReq xmlns="http://www.citylinkexpress.com.my/"><XMLbyte>'.$b64_string.'</XMLbyte></CTLShipReq></soap:Body></soap:Envelope>';

		} else if (strpos($input, 'CTLCancelReq')) {
			$request = $input;

		} else if (strpos($input, 'CTLLabelReq')) {
			$request = $input;

		} else if (strpos($input, 'CTLValidateAccountReq')) {
			$request = $input;

		/* For TrackHeader & TrackDetail */
		} else {
			$request = $input;
		}

		//dump($request);

		$ret = parent::__doRequest($request, $location, $action,
			$version, $one_way);

		$this->__last_request = $request;

		return $ret;
	}
}

class CityLinkConnection {

	/* CTLShipReq */
    public function shipReq($xml_file){

		//$DOC  = "http://delta.opensupermall.com/citylink/good.xml";
		$SVC  = "http://www.citylinkexpress.com:81/CTLShip/Service.asmx";
		$WSDL = $SVC."?WSDL";

		//$xml_file = file_get_contents($DOC);

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		$response = $client->__soapCall('CTLShipReq',
			array(null, $xml_file));

		$response_xml = simplexml_load_string($response->CTLShipReqResult);	

		$ret = simplexml_load_string($response->CTLShipReqResult);
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			///$ret = json_encode(['error'=>true, 'type'=>$type]);
		} else {
			//$ret = json_encode(['error'=>false]);
		}

		//dump($response_xml);

		return $ret;

    }


	/* TrackHeader, hawb_type='H' */
    public function trackHeaderH($hawb_type, $hawb_value){
		$SVC  = "http://www.citylinkexpress.com:85/TrackService.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of 'H', and the AWB No.
		 * ord() is CRITICAL! Otherwise it'll NEVER work! */
		/*$hawb_type  = 'H';
		$hawb_value = '060306600093627';*/

		$params = array('AccountNo'=>"",
				  'isHawbType'=>ord($hawb_type), 'Value'=>$hawb_value);	

		$response = $client->__soapCall('TrackHeader', array($params));

		//dump($response);

		$response_xml = simplexml_load_string(
			$response->TrackHeaderResult->any);	

		//dump($response_xml);

		$ret = $response_xml;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authentication";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }

	
	/* TrackHeader, hawb_type='X' */
    public function trackHeaderX($hawb_type, $hawb_value){
		$SVC  = "http://www.citylinkexpress.com:85/TrackService.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of 'H', and the AWB No.
		 * ord() is CRITICAL! Otherwise it'll NEVER work! */
		/*$hawb_type  = 'X';
		$hawb_value = '433078310';*/

		$params = array('AccountNo'=>"",
				  'isHawbType'=>ord($hawb_type), 'Value'=>$hawb_value);	

		$response = $client->__soapCall('TrackHeader', array($params));

		//dump($response);

		$response_xml = simplexml_load_string(
			$response->TrackHeaderResult->any);	

		//dump($response_xml);

		$ret = $response_xml;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }

	/* TrackDetail */
    public function trackDetail($hawb_value){
		$SVC  = "http://www.citylinkexpress.com:85/TrackService.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of the AWB No. */
		//$hawb_value = "060306600093627";
		//$hawb_value = "060307001284015";

		$params = array('Hawb'=>$hawb_value);	

		$response = $client->__soapCall('TrackDetail', array($params));

		//dump($response);

		$response_xml = simplexml_load_string(
			$response->TrackDetailResult->any);	

		//dump($response_xml);

		$ret = $response_xml;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }

	/* CTLCancelReq */
    public function cancelReq($transaction_id, $company_code, $account_no, $meter_num, $hawb_no){
		$SVC  = "http://www.citylinkexpress.com:81/CTLShip/Service.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of the AWB No. */
	/*	$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		$hawb_no		= "060306600093627";*/

		$params = array(
			'TransactionIdentifier'=>$transaction_id,
			'CompanyCode'	=> $company_code,
			'AccountNo'		=> $account_no,
			'MeterNum'		=> $meter_num,
			'HAWB_NO'		=> $hawb_no);

		$response = $client->__soapCall('CTLCancelReq', array($params));

		//dump($response);

		$response_xml = simplexml_load_string(
			$response->CTLCancelReqResult);	

		//dump($response_xml);

		$ret = $response_xml;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }

	/* CTLLabelReq */
    public function labelReq($transaction_id, $company_code, $account_no, $meter_num, $hawb_no){
		$SVC  = "http://www.citylinkexpress.com:81/CTLShip/Service.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of the AWB No. */
		/*$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		//$hawb_no		= "060306600093627";
		$hawb_no		= "06039900996880";*/

		$params = array(
			'TransactionIdentifier'=>$transaction_id,
			'CompanyCode'	=> $company_code,
			'AccountNo'		=> $account_no,
			'MeterNum'		=> $meter_num,
			'HAWB_NO'		=> $hawb_no);

		$response = $client->__soapCall('CTLLabelReq', array($params));

		//dump($response);

		$response_xml = simplexml_load_string(
			$response->CTLLabelReqResult);	

		/*$label = $response_xml->Label->OutboundLabel;
		//dump(base64_decode($label));

		/*$label_output_file = "/tmp/label_".$hawb_no.".pdf";
		$label_fp = fopen($label_output_file, "wb"); 
		fwrite($label_fp, base64_decode($label)); 
		fclose($label_fp); */
		//dump($label_output_file);

		$ret = $response_xml;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }

	/* CTLValidateAccountReq */
    public function validateAccountReq($transaction_id, $company_code, $account_no, $meter_num, $hawb_no){
		$SVC  = "http://www.citylinkexpress.com:81/CTLShip/Service.asmx";
		$WSDL = $SVC."?WSDL";

		$client = new CityLinkSoapClient($WSDL, array(
			"trace" => 1, "exception" => 1, "cache_wsdl" => 0));

		/* This is where we plug in the values of the AWB No. */
		$transaction_id	= 'ID1234';
		$company_code	= 'CT';
		$account_no		= 'TEST';
		$meter_num		= 'TEST_123';
		//$hawb_no		= "060306600093627";
		$hawb_no		= "06039900996880";

		$params = array(
			'TransactionIdentifier'=>$transaction_id,
			'CompanyCode'	=> $company_code,
			'AccountNo'		=> $account_no,
			'MeterNum'		=> $meter_num);

		$response = $client->__soapCall('CTLValidateAccountReq',array($params));
	//	dump($response);

		$account_is_valid = $response->CTLValidateAccountReqResult;
	//	dump($account_is_valid);

		$ret = $account_is_valid;
		/*
		if(isset($response_xml->Error)){
			$type = "Unknown";
			if(isset($response_xml->Error->AuthenticationError)){
				$type = "Authetincation";
			}
			if(isset($response_xml->Error->InternalError)){
				$type = "Internal";
			}	
			if(isset($response_xml->Error->ValidationError)){
				$type = "Validation";
			}			
			$ret = json_encode(['error'=>true, 'type'=>$type]);

		} else {
			$ret = json_encode(['error'=>false]);
		}
		*/

		return $ret;
    }
}
