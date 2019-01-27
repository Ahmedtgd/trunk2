<?php

namespace App\Api;
use App\Models\EMail;
use Mail;
use Crypt;

class SendMail
{
	public static function sendmails()
	{
		
		$mails = EMail::where('status','pending')->get();
		foreach($mails as $email)
		{
			
			if($email->type == 'deliverypassword')
			{
				SendMail::deliveryorderpassword($email);
			}
			
			$email['status']='sent';
			$email->save();
		}
	}
	
	private static function deliveryorderpassword($email)
	{
		try{
		
		$password=$email->deliveryorder->password;
		Mail::send('emails.deliveryorderpassword', compact('email','password'), function($message) use ($email)
		{
			$message->to($email->user->email, $email->user->name)->subject('Thanks For Your Order At OpenSuperMall');
			//$message->to('libran.ankur@gmail.com', 'Ankur')->subject('Thanks For Your Order At OpenSuperMall');
		});
		}catch (\Exception $e){
            dd($e);
        }
	}
}