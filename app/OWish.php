<?php
/**
 * Created by PhpStorm.
 * User: Chronoa
 * Date: 1/3/2016
 * Time: 9:19 PM
 */

namespace App;


use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use DB;
use App\Http\Controllers\TokenController;

class OWish {

    public function facebook($linkData=array(),$user_id=null)
    {
        $fb = new Facebook(Config::get('facebook.credentials'));
    //    $access_token = Auth::user()->access_token;
        $test_token = new TokenController();
        
        if ($user_id==null) {
            $user_id=Auth::user()->id;
        }
        $message = $test_token->testfbtoken($user_id);
        if($message == 'Your token is valid'){
            $access_token = DB::table('oauth_session')->where('user_id' ,
				$user_id)->pluck('access_token');
        //    dd($access_token);
        }else {
            $errorCheck['ok'] = false;
            $errorCheck['message'] = $message;
            return $errorCheck;
        }
      //  dd( $access_token);
        try {
            // Returns a `Facebook\FacebookResponse` object

            $response = $fb->post('me/feed', $linkData, $access_token);
        } catch(FacebookResponseException $e) {
            if ($e->getMessage()=="(#200) The user hasn't authorized the application to perform this action") {
                echo "Please give publish_action permission to the OpenSupermall App. Please click <a href='https://www.facebook.com/settings?tab=applications' target='_blank'>here</a> to visit FB App Centre.";
            }else{
                echo 'Graph returned an error: ' . $e->getMessage();
            }
            
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphNode = $response->getGraphNode();
        $errorCheck['ok'] = true;
        $errorCheck['graphNode'] = $graphNode;
        return $errorCheck;
        return $graphNode;
    }
}
