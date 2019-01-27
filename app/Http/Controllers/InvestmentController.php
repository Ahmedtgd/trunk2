<?php

namespace App\Http\Controllers;

use App;
use App\AuthenticateUser;
use App\Models\Autolink;
use App\Http\Requests\OpenwishPledgeRequest;
use App\Jobs\OpenwishPledgeJob;
use App\Models\Address;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Brand;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\Buyer;
use App\Models\BuyerCategory;
use App\Models\Credit;
use App\Models\Courier;
use App\Models\Currency;
use App\Models\Director;
use App\lib\Date;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Product;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\User;
use App\Models\Website;
use App\Models\Document;
use App\Models\MerchantDocument;
use App\Models\StationDocument;
use App\Models\Occupation;
use App\Models\Language;
use App\Models\Station;
use App\Models\StationBrand;
use App\Models\MerchantBrand;
use App\Models\RoleUser;
use App\Models\Sproperty;
use App\Models\Districenter;
use App\Models\StationAddress;
use App\Models\Outlet;
use App\Models\OrderProduct;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Controllers\EmailController;
use Exception;
use Input;
use App\OWish;
use Collection;
use GuzzleHttp;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Jobs\WishListJob;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//use Moltin\Cart\Cart;
use Cart;
use Hash;
use Mailgun\Mailgun;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function master(Request $request){
		$investments = DB::table('investment')->orderBy('created_at','DESC')->get();
		return view('master.investment',['investments'=>$investments]);
	}
	public function investment(Request $request){
		$first_name = Input::get('first_name');
		$last_name = Input::get('last_name');
		$company_name = Input::get('company_name');
		$url = Input::get('url');
		$email = Input::get('email');
		$mobile = Input::get('mobile');
		$country_id = Input::get('country');
		$investor_type = Input::get('type');
		$description = Input::get('description');
		DB::table('investment')->insert([
			'first_name'=>$first_name,
			'last_name'=>$last_name,
			'company_name'=>$company_name,
			'url'=>$url,
			'email'=>$email,
			'mobile'=>$mobile,
			'country_id'=>$country_id,
			'investor_type'=>$investor_type,
			'description'=>$description,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s')
		]);
		return Response(['ok'=>array('This is OK Updated')],200);
	} 
	 
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
