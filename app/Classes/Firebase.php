<?php
/**
* 
*/

namespace App\Classes;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

use LaravelFCM\Message\Topics;
use App\Models\OAuth;
use FCM;

use DB;
use Log;
use Carbon;
class Firebase 
{
	public $title,$data,$tokens;
	private $time_to_live=60*20;

	function __construct()
	{
		$this->set_credentials();
	}

	public function set_credentials()
	{
		
	}

	public function set_title($title)
	{
		$this->title=$title;
		return $this;
	}
	public function set_actiontype($actiontype)
	{
		$this->data['actiontype']=$actiontype;
		return $this;
	}
	public function set_data($data)
	{
		$this->data=$data;
		return $this;

	}

	public function tokens($type,$id)
	{
		$ret = null;
		switch ($type) {
			case 'staff_location':
				$ret = $this->get_stafflocation_tokens($id);
				break;
			
			default:
				$ret = $this;
		}
		return $ret;
	}

	/*Returns array of tokens*/
	public function get_stafflocation_tokens($location_id)
	{
		$tokens=[];
		$raw_tokens=DB::table("locationusers")
		->join("users","users.id","=","locationusers.user_id")
		->join("oauth_session","oauth_session.user_id","=","users.id")
		->where("locationusers.location_id",$location_id)
		->whereNotNull("oauth_session.ftoken")
		->where("oauth_session.ftoken","!=","")
		->select("oauth_session.ftoken")

		->get()
		;
		foreach ($raw_tokens as $t) {
			array_push($tokens,$t->ftoken);
		}
		$this->tokens=$tokens;
		return $this;
	}


	public function send()
	{
		$optionBuilder = new OptionsBuilder();
		$optionBuilder->setTimeToLive($this->time_to_live);
		$option=$optionBuilder->build();
		/*NOTIFICATION*/
		$notificationBuilder = new PayloadNotificationBuilder($this->title);
        $notificationBuilder->setSound('default');
        $notificationBuilder->setBody("You have got a notification from OpenSupermall.com");
        $notification=$notificationBuilder->build();
        /*DATA*/
		$dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($this->data);
        $data=$dataBuilder->build();

        $response=FCM::sendTo($this->tokens, $option,$notification,$data);
        dump($response);
	}

}
