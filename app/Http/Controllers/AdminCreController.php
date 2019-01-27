<?php
// Created by Syed Salman Ali (salman.falcon@gmail.com)

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cre;
use App\Models\SalesStaff;
use App\Models\User;
use App\Models\Currency;
use App\Models\POrder;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\AdminReview;
use App\Models\OrderProduct;
use App\Models\Ocredit;
use DB;
use Carbon;
use App\Classes\SecurityIDGenerator;

class AdminCreController extends Controller {

	//---__construct Method---//
	public function __construct() {
		$this->middleware('auth', ['only', 'getDashboard']);
	}

	/**
	 * Get the o shops list
	 * @return $this
	 */

	public function index() {

            $cre=DB::table('cre')
            ->join('porder as por','cre.porder_id','=','por.id')
            ->join('orderproduct as ord','ord.porder_id','=','por.id')
            ->leftJoin('crereasons as crs','ord.crereason_id','=','crs.id')
            ->join('users as us','us.id','=','por.user_id')
            ->join('merchantproduct as mp','ord.product_id','=','mp.product_id')
            ->join('merchant as mer','mp.merchant_id','=','mer.id')
            
            ->groupBy('por.id')
            ->orderBy('cre.id','DESC')
            ->select(
                
                    'cre.id as cre_id',
                    'por.id as porder_id',
                    'ord.product_id as product_id',
                    'ord.id as op_id',
                    'us.id as user_id',
                    'us.first_name as first_name',
                    'us.last_name as last_name',
                    'us.mobile_no as contact',
                    'us.email as email',
                    'por.status as status',
                    'cre.type as iwishto',
                    'cre.created_at as created_at',
                    'crs.reason_text as reason'
                

                )
            ->orderBy('cre.created_at','DESC')->get();

		// Removed iwishto from select, chanded user_id to porder.user_id
		return response()->view('admin.tblmgmt', ['cre' => $cre])

		       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');;
	}
	
	public function approval($id) {
		// $cre = Cre::join('crereasons', 'cre.crereason_id', '=', 'crereasons.id')
		// 		->join('buyer_help', 'cre.porder_id', '=', 'buyer_help.porder_id')
		// 		->join('porder', 'cre.porder_id', '=', 'porder.id')
		// 		->join('orderproduct', 'porder.id', '=', 'orderproduct.porder_id')
		// 		->join('buyer', 'porder.user_id', '=', 'buyer.user_id')
		// 		->select(['cre.id', 'orderproduct.porder_id', 'orderproduct.product_id', 'porder.user_id', 'buyer_help.name', 'buyer_help.phone', 'buyer_help.email', 'porder.status', 'buyer.photo_1', 'buyer.photo_2', 'buyer.photo_3', 'crereasons.reason_text'])
		// 		->orderBy('cre.created_at','DESC')
		// 		->get();

		 // $cre1= DB::table('cre')
   //          ->join('porder as por','cre.porder_id','=','por.id')
   //          ->join('orderproduct as ord','ord.porder_id','=','por.id')
   //          ->leftJoin('crereasons as crs','cre.crereason_id','=','crs.id')

   //          ->join('users as us','us.id','=','por.user_id')
   //          ->join('merchantproduct as mp','ord.product_id','=','mp.product_id')
   //          ->join('merchant as mer','mp.merchant_id','=','mer.id')
			// ->where('cre.id',$id)
            
          

   //          ->groupBy('por.id')
           
            

       
   //          ->select(
                    
   //                  'cre.id as cre_id',
   //                  'por.id as porder_id',
   //                  'ord.product_id as product_id',
   //                  'ord.id as op_id',
   //                  'us.id as user_id',
   //                  'us.first_name as first_name',
   //                  'us.last_name as last_name',
   //                  'us.mobile_no as contact',
   //                  'us.email as email',
   //                  'ord.status as status',
   //                  'cre.type as iwishto',
   //                  'cre.created_at as created_at',
   //                  'crs.reason_text as reason'
                

   //              );
            // return $cre1;
			
            $cre=DB::table('cre')
			->join('porder as por','cre.porder_id','=','por.id')
            ->join('orderproduct as ord','ord.porder_id','=','por.id')
            ->leftJoin('crereasons as crs','ord.crereason_id','=','crs.id')
            ->leftJoin('adminreview as admr','ord.id','=','admr.orderproduct_id')
            ->join('users as us','us.id','=','por.user_id')
			->join('merchantproduct as mp','ord.product_id','=','mp.product_id')
            ->join('merchant as mer','mp.merchant_id','=','mer.id')
            ->where('cre.id',$id)
            
            ->orderBy('cre.id','DESC')
            // ->groupBy('ord.product_id')
            ->select(
                
                    'cre.id as cre_id',
                    'por.id as porder_id',
                    'ord.product_id as product_id',
                    'ord.id as op_id',
                    'us.id as user_id',
                    'us.first_name as first_name',
                    'us.last_name as last_name',
                    'us.mobile_no as contact',
                    'us.email as email',
                    'por.status as status',
                    'ord.status as ostatus',
                    'cre.type as iwishto',
                    'cre.created_at as created_at',
                    'crs.reason_text as reason',
                    'admr.conclusion as conclusion'
                

                )
            ->orderBy('cre.created_at','DESC')
            ->get();
			//dump("Test");
			//dd($cre);

        // $cre= $cre2->union($cre1)->orderBy('created_at','DESC')->get();
		// return $cre;
		// Removed iwishto from select, chanded user_id to porder.user_id
		//dd("HOLA2");
		return response()->view('admin.tblmgmt', ['cre_approval' => $cre])

		       ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
      )->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');;
	}	
	
	/* Get image for  a particular CRE 
		using the cre id
		The image would come from public/cre/cre_id folder
		The route is : cre/reasons/{id}/images
	*/
	public function show_cre_images($cre_id)
	{
		# code...
		$cre_images=$this->get_cre_images($cre_id);
		return view('admin.master.cre.gallery')
		->with('cre_id',$cre_id)
		->with('cre_images',$cre_images)
		;
	}
	public function get_cre_images($cre_id)
	{
		$cre_images=array();
		try {
			$document_ids=DB::table('credocument')->where('cre_id',$cre_id)->lists('document_id');
			$cre_images=DB::table('document')->whereIn('id',$document_ids)->lists('path');
		} catch (\Exception $e) {
			
		}
		return $cre_images;
	}
	// return a resource
	public function get_single_image_cre($path)
	{
		
	}

  public function getReview($oid)
  {

      $ops=DB::table('orderproduct')->where('id',$oid)
      ->where('status','rejected')
      ->first();
      $porder_id=$ops->porder_id;
      $merchant_id=UtilityController::porderMerchantId2($porder_id);
      $seller=DB::table('merchant')
      ->where('id',$merchant_id)
      ->select(DB::raw("
        merchant.company_name as name,
        merchant.office_no as phone,
        merchant.id as id
        "))
      ->first();
    
      $buyer=User::join('porder','porder.user_id','=','users.id')
      ->select(DB::raw("
        users.name as name,
        users.id as id,
        users.mobile_no as phone
        "))->first();
      return view('admin.modal.crereview')
      ->with('oid',$oid)
      ->with('ops',$ops)
      ->with('seller',$seller)
      ->with('buyer',$buyer);
  }
  public function doReview(Request $r)
  {
      try {
        $cb=$r->cb;
        $cm=$r->cm;
        $oid=$r->oid;
        $boef=$r->boef;
        $conclusion=$r->conclusion;
        $value=0;
        $reward=$r->reward;
        $op=OrderProduct::find($oid);
        $awardee="";
        if ($reward == "byr") {
          $awardee="buyer";
          if ($op->status == "rejected") {
            $value+=$op->order_price * $op->quantity;
          }
          if ($value!=0) {
            $oc= new Ocredit;
            $oc->porder_id=$op->porder_id;
            $oc->mode="credit";
            $oc->status="success";
            $sidg= new SecurityIDGenerator;
            $oc->security_id=$sidg->generate(Carbon::now()->toDateString());
            $oc->value=$value;
            $oc->save();
          }
          
        }else{
          $awardee="merchant";
        }
        $op->status="reviewed";
        $op->save();
        $ar= new AdminReview;
        $ar->boef=$boef;
        $ar->call_merchant=$cm;
        $ar->call_buyer=$cb;
        $ar->awarded=$awardee;
        $ar->status="success";
        $ar->orderproduct_id=$oid;
        $ar->conclusion=$conclusion;
        $ar->save();
        $ops= OrderProduct::where('porder_id',$op->porder_id)
        ->where('status','rejected')->get();
        if (sizeof($ops) == 0) {
            $por=POrder::find($op->porder_id);
            $por->status="reviewed";
            $por->save();
        }
        $m=[
          "status"=>"success",
          "long_message"=>"Review Done"
        ];
      } catch (\Exception $e) {
        dump($e);
        try {
          Ocredit::destroy($oc->id);
        } catch (\Exception $e) {
          Ocredit::destroy($oc->id);
        }
        $m=[
          "status"=>"failure",
          "long_message"=>"Some error happened. Please contact OpenSupport",
          "short_message"=>"excep#1"
        ];
      }
      return response()->json($m);
  }
}
