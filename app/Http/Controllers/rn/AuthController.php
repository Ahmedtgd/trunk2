<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Models\OAuth;
use DB;
use Carbon;
use Log;
class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
		Log::debug($credentials);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {

            Log::info("something went wrong whilst attempting to encode the token");
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user=User::where('email',$request->email)->first();
        $oauth=DB::table("oauth_session")
        ->where("user_id",$user->id)
        ->whereNull("deleted_at")
        ->orderBy("created_at","DESC")
        ->first();
        if (empty($oauth)) {
            $o= new OAuth();
            $o->user_id=$user->id;
        }else{
            $o=OAuth::find($oauth->id);
        }
        $o->ftoken=$request->ftoken;
        $o->save();

        Log::info("Auth: ftoken=".$o->ftoken);

        $company=DB::table('company')->where('owner_user_id',$user->id)
            ->first();
        // all good so return the token
        return response()->json(compact('token','user','company'));
    }


    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                Log::info("user_not_found");
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            Log::info("token_expired");
            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            Log::info("token_invalid");
            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            Log::info("token_absent");
            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
