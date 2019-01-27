<?php

namespace App\Http\Controllers;
// use App\Models\Merchant;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\View;
// Models
use App\Models\User;
use App\Models\Merchant;
// use App\Models\;
// use App\Models\;
// use App\Models\;
// use App\Models\;
// use App\Models\;
// use App\Models\;
// use App\Models\;

use Auth;
// END

class SearchController extends Controller
{
  public function searchPage()
  {
      return view('search.search');
  }

  public function search(Request $request)
  { if (!Auth::user()) {
    # code...
    return "Please login";
  }
  $query=$request->search_key_word;
  if ($query==null) {
    # code...
    return "Please do a valid query";
  }
  $merchant=False;
  // Check if merchant
    $m=Merchant::find(Auth::user()->id);
    if (count($m)==1) {
      # code...
      $merchant=True;
    }
    try{
      $result = User::whereRaw('MATCH(username,first_name,last_name) AGAINST (? IN BOOLEAN MODE)',array($query))->get();
      $result[0];
     } catch(\Exception $e){
        try {
            $result=User::search($query)->get();
        } catch (\Exception $e) {
             $result = User::where('first_name','like','%'.$query.'%')->orWhere('last_name','like','%'.$query.'%')->orWhere('username','like','%'.$query.'%')->get();
        }
     } 
     // return $result;
      $response=array();
      foreach ($result as $r) {
        # code...
        array_push($response,['first_name'=>$r->first_name,'last_name'=>$r->last_name,'raw_id'=>$r->id,'user_id'=>UtilityController::s_id($r->id)]);
      }
      return view('search.search')->with('response',$response)->with('query',$query)
      ->with('merchant',$merchant);
      // return response()->json();
  }
  public function autolink(Request $request)
  {
    # code...
      if (!Auth::user()) {
          # code...
          return "Please login";
        }
      $query=$request['query'];
        try{
      $result = User::whereRaw('MATCH(username,first_name,last_name) AGAINST (? IN BOOLEAN MODE)',array($query))->get();
      $result[0];
     } catch(\Exception $e){
        try {
            $result=User::search($query)->get();
        } catch (\Exception $e) {
             $result = User::where('first_name','like','%'.$query.'%')->orWhere('last_name','like','%'.$query.'%')->orWhere('username','like','%'.$query.'%')->get();
        }
     } 
     // return $result;
      $response=array();
      foreach ($result as $r) {
        # code...
        array_push($response,['first_name'=>$r->first_name,'last_name'=>$r->last_name,'raw_id'=>$r->id,'user_id'=>UtilityController::s_id($r->id)]);
      }
      return response()->json(['response'=>$response,'count'=>count($response),'query'=>$query,'status'=>'success']);
  }
  public function filter_search($query,$arg="")
  {
      if ($arg=="username") {

        return $this->search_username($query);
      }
      elseif ($arg=="userid") {
        return $this->search_user_id($query);
      }
      else {
          # code...
        return "Some other arg";
      }
  }
  public function search_all()
  {
      # code...
  }
  public function search_dealers($query)
  {
      # code...
        
  }
  public function search_oshop($query)
  {
      # code...
  }
  public function search_company($query)
  {
      # code..

    
  }
  public function search_username($query)
  {
      # code...
    $users= User::where('username','LIKE',"%%")->get();
    return $users;
    $this->return_response($users);
  }
  public function search_user_id($query)
  {
      $user= User::where('last_name','like',"%")->get();
      foreach ($user as $u) {
          # code...
        echo $u->id."<br>";
      }
  }
  /* Formatted response . 
    tite and link is required
  */
  public function return_response($response)
  {
      return $response;
      $response= array();
      foreach ($users as $key => $value) {
          
      }
  }
}
