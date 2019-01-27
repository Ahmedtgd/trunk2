<?php

namespace App;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Http\Controllers\TokenController;
use Request;
use Session;
class AuthenticateUser {

    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var User
     */
    private $users;
    /**
     * @var Guard
     */
    private $auth;

    private $URL;
    /**
     * @param Socialite $socialite
     * @param User $users
     * @param Guard $auth
     */
    public function __construct(Socialite $socialite, User $users, Guard $auth)
    {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
        $this->URL = URL::previous();
    }

    /**
     * @param $hasCode string         URL Parameter
     * @param $provider string        Facebook, Github, Twitter, Linkedin
     * @param string $redirect
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute( $hasCode, $provider, $redirect ,$requestSource='')
    {

        //Check if code parameter is set.
        if ( !$hasCode ) return $this->getAuthorizationFirst( $provider );

        $data=$this->getProviderUser( $provider );
        if (empty($data->email) or !isset($data->email) or $data->email==null) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please provide email permissions.')
            ;
        }
        //Get user data from provider
        $user = $this->users->findByEmailOrCreate($this->getProviderUser( $provider ));
    
        //Get user interface
        $this->auth->login($user, true);

        //Redirects to kleenso products.
        //return redirect('/sub-cat-details/1/15');
        if( !empty($redirect) ) {
            return redirect($redirect);
        }
        // 
        $customURL=url('/create_new_buyer');
      
        if ($this->URL==$customURL) {

            # code...
            // Session::put('fbloginStatus','success');
            return redirect('buyer/dashboard');
        }
        // return response()->json(['status'=>'success','long_message'=>'You have been successfully signed in through facebook']);
        return redirect('/');

    }
    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst( $provider )
    {
        //Pass scope in order to authorize fb user to publish
		return $this->socialite->driver( $provider )->scopes([
            'email',
            'public_profile',
            'user_friends',
            'publish_actions',
        ])->redirect();
    }

    /**
     * Get authenticated user from provider
     * @param $provider
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getProviderUser($provider)
    {
        return $this->socialite->driver( $provider )->user();
    }

}
