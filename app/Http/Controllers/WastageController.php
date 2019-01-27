<?php

namespace App\Http\Controllers;

use Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use App\Models\Receipt;
use App\Models\OrderProduct;
use App\Models\DeliveryOrderProduct;
use App\Models\POrder;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\EMail;
use App\Models\User;
use App\Models\Product;
use Response;
use Hash;
use App\Models\Currency;
use App\Exceptions\CustomException;
use App\Http\Controllers\UtilityController;
use Exception;
use Auth;
use PDF;
use QrCode;
use Carbon;
use App\Models\Stockreportproduct;
use App\Models\Stockreport;

class WastageController extends Controller {

    //---__construct Method---//
    public function __construct() {
        $this->middleware('auth', ['only', 'getDashboard']);
    }

    
public function wastageform($report_id){
    try{
        if (!Auth::check()) {
            return view('common.generic')
            ->with('message_type','error')
            ->with('message','Please login to access this page');
        }
        $user_id = Auth::id();
        $selluser = User::find($user_id);
        $report_data = Stockreport::with('checker','creator','checker_company'
                ,'creator_company','fairlocation'
                ,'report_products.product')
                ->find($report_id);
        
        return view('do.report', compact('report_data','selluser'));
    }catch(\Exception $e){
        Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
        throw new CustomException($e);        
    }
}

}
