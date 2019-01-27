<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cprofile;
use App\Models\Fsection_a;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FooterViewController extends Controller
{     
	public function content() 
    {
		$data    = Fsection_a::find(1);
        $content = $data['about_us'];
        return view('cprofile/content', ['content' => $content]); 
    }
 
    public function aboutUs() 
    {
		$data    = Cprofile::find(1);
        $cover = $data['cover'];
        return view('cprofile/about_us', ['about_us' => $cover]); 
    }

    public function howToBuy()
    {
        $data    = Fsection_a::find(1);
        $content = $data['how_to_buy'];
        return view('how_to_buy', ['content' => $content]);

    }

    public function howToSell()
    {
        $data    = Fsection_a::find(1);
        $content = $data['how_to_sell'];
        return view('how_to_sell', ['content' => $content]);
    }
}
