<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Obfuscate;
use Auth;
class UrlShortenerController extends Controller
{
    
    public function shorten($url_to_be_shortened,$referrer="generic",$referrer_id=0)
    {
        $n=4;
        $m=3;
        $o="OSM";
        // Generate a random [n] alphabets
        $random= $o.str_random($n).str_random($m);
        // Check if the random is is actually a random
        $ob=Obfuscate::where('surl',$random)->first();
        while ($ob!=null) {
            $random= $o.str_random($n).str_random($m);
            $ob=Obfucate::where('surl',$random)->first();
            if ($ob==null) {

                break;
            }
        }
        // return $random;
        // Get user id
        $user_id=Auth::user()->id;
        // Save
        try {
            $obf= new Obfuscate;
            $obf->url=$url_to_be_shortened;
            $obf->surl=$random;
            $obf->user_id=$user_id;
            $obf->referrer=$referrer;
            $obf->referrer_id=$referrer_id;
            $obf->save();

        } catch (\Exception $e) {
            return $e;
        }
        return $random;

    }


    public function handler($shortened_url)
    {
        try {
            $ob=Obfuscate::where('surl',$shortened_url)->first();
            if (!$ob==null) {
                return redirect($ob->url);
            }
            else{
                return "The url was invalid or expired";
            }
        } catch (\Exception $e) {
            return "The url was invalid or expired";
        }
    }
}
