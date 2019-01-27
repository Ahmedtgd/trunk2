<?php

namespace App\Http\Controllers;

use App\AuthenticateUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Buyer;
use App\Models\RoleUser;
use GuzzleHttp\Client;
use App\Http\Controllers\TokenController;
use Facebook;
use DB;
use Carbon;
class AuthController extends Controller
{
 
    protected $graphUrl = 'https://graph.facebook.com';
    protected $version = 'v2.8';
    protected $fields = ['name', 'email', 'gender', 'verified', 'link'];
    public function login(AuthenticateUser $authenticateUser, Request $request, $provider,$requestSource='')
    {
        //return $request;
        $redirect='';
        if ($requestSource=="br") {
            # code...
            $redirect=url('buyer/dashboard');
        }
        return $authenticateUser->execute( $request->has('code'), $provider,$redirect,$requestSource );
    }
    
    
    public function redirectToProvider()
    {
        // $state="ffjkwj";
        session_start();
        $login_url = Facebook::getLoginUrl(['email','publish_actions','user_friends'],env('FACEBOOK_CALLBACK'));
        return redirect($login_url);
        // return Socialite::driver('facebook')->redirect();
    }
 
    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        
       
        try {
            $token = Facebook::getAccessTokenFromRedirect(env("FACEBOOK_CALLBACK"));
            } catch (Facebook\Exceptions\FacebookSDKException $e) {

                return view('common.generic')
            ->with('message_type','error')
            ->with('message',"An error occured while trying to log you in via Facebook. Please try again.");
                dump($e->getMessage());
            }
        if (! $token) {
            // Get the redirect helper
            $helper = Facebook::getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            // User denied the request
            return view('common.generic')
            ->with('message_type','error')
            ->with('message',"Login via Facebook failed.");
            // dd(
            //     $helper->getError(),
            //     $helper->getErrorCode(),
            //     $helper->getErrorReason(),
            //     $helper->getErrorDescription()
            // );
        }
        /*
        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = Facebook::getOAuth2Client();
            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }
        */
        Facebook::setDefaultAccessToken($token);
        $clientSecret=env('FACEBOOK_CLIENT_SECRET');
        $meUrl = $this->graphUrl.'/'.$this->version.'/me?access_token='.$token.'&fields='.implode(',', $this->fields);

        if (! empty($clientSecret)) {
            $appSecretProof = hash_hmac('sha256', $token, $clientSecret);

            $meUrl .= '&appsecret_proof='.$appSecretProof;
        }

        $client=new Client;
        $resp_1=$client->get($meUrl, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $user = json_decode($resp_1->getBody(), true);
        $user=(object)$user;
        // dd($user);
        // END
        if (empty($user->email) or !isset($user->email) or $user->email==null) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please provide email permissions.')
            ;
        }
        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        return redirect()->route('home');
    }
 
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('email',$facebookUser->email)->first();
 
        if ($authUser){
            return $authUser;
        }
       
        if($facebookUser->email == null)
        {
            $facebookUser->email = rand(10000000000,9999999999) . rand(999999,10000000) . date('YmdiHs');
        }

        $user=User::create([
            'name' => $facebookUser->name,
            'first_name' => $facebookUser->name,
            'last_name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'provider_id' => $facebookUser->id,
            'provider' => 'facebook'
        ]);
        /*Create a buyer*/
        $roleuser=new RoleUser;
        $roleuser->user_id=$user->id;
        $roleuser->role_id=2;
        $roleuser->save();
        $buyer= new Buyer;
        $buyer->user_id=$user->id;
        $buyer->status='active';
        $buyer->active_date=Carbon::now();
        $buyer->save(); 
        /*Add nbuyerid record
            City Id is hardcoded to Kuala Lumpur
        */
        $city_id=2464;
        $uniqueid = UtilityController::buyeruniqueid($city_id);
        DB::table('nbuyerid')->insert(['nbuyer_id'=>$uniqueid, 'buyer_id'=>$buyer_profile->id, 'user_id' => $user->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]); 
        /*Add record in oauth_session */
        $oauth=OAuth::create([
            'user_id'=>$user->id,
            'smedia_id'=>1,
            'access_token'=>$facebookUser->token

            ]); 
        return $user;
    }
}
