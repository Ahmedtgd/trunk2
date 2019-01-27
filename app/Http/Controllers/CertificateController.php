<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Signboard;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function index(Request $req)
    {
		$id = $req->id;
        $merchant = Merchant::find($id);

        $profile = Merchant::withProfile($id);


        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        return view('shops.oshopcertificate')->with('certificates',
			Certificate::where('merchant_id', $id))->with('profile', $profile);
    }
}
