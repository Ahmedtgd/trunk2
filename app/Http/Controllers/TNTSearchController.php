<?php

namespace App\Http\Controllers;
use TeamTNT\TNTSearch\TNTSearch;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use storage;
class TNTSearchController extends Controller
{


    public function getConfig()
    {
        return [
            "driver"=>'mysql',
            "host"=>env('DB_HOST'),
            "database"=>env('DB_DATABASE'),
            "username"=>env('DB_USERNAME'),
            "password"=>env('DB_PASSWORD'),
            'storage'=>storage_path('searchindex')
        ];
    }
    public function search(Request $r)
    {
    
    $m=["status"=>"failure","long_message"=>"Some error happened. Contact OpenSupport"];
    try {
      $query=$r->search_key_word;
      $tnt= new TNTSearch;
      $tnt->loadConfig($this->getConfig());
      $tnt->selectIndex("products");
      $tnt->fuzziness = true;
      $ret=$tnt->search($query);
      $matchedProductIds=$ret['ids'];
      return view('search.search',compact('matchedProductIds','query'));;
    } catch (\Exception $e) {
        // $m['short_message']=$e->getMessage();
      $matchedProductIds=array();
    }
     return view('search.search',compact('matchedProductIds','query'));;
    }

    public function searchPage()
    {
      return redirect("/"); 
    }
}
