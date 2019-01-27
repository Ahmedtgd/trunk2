<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OposReceipt;
use App\Models\OposReceiptproduct;
use DB;
use App\Models\Product;
use Auth;
use Carbon;
use Log;
class SalesController extends Controller
{

    public function viewSales($uid=null)
    {
        if (!Auth::check()) {
            # code...
            return "Authentication Error";
        }
        $user_id=Auth::user()->id;
        if (Auth::user()->hasRole("adm") and !empty($uid)) {
            # code...
            $user_id=$uid;
        }
        $selluser = \App\Models\User::find($user_id);

        $sellerData = OposReceipt::join('opos_receiptproduct','opos_receipt.id','=','opos_receiptproduct.receipt_id')
                    		->leftjoin('product','opos_receiptproduct.product_id','=','product.id')
                    		->leftjoin('rawmaterial','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
                    		->leftjoin('nproductid','nproductid.product_id','=','rawmaterial.raw_product_id')
                    		->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
                    		->select('product.id as pid','product.name as pname','product.thumb_photo','opos_receipt.id','opos_receiptproduct.product_id','opos_receipt.receipt_no','opos_receipt.created_at','opos_receipt.staff_user_id','opos_receiptproduct.price','opos_receiptproduct.discount','opos_receiptproduct.quantity',DB::raw('SUM(opos_receiptproduct.price + opos_receiptproduct.discount) as amount'),'users.name as staffname',DB::raw('COUNT(rawmaterial.id) as raw_count'))
                    		->whereNull("opos_receiptproduct.deleted_at")
                    		->whereNull("opos_receipt.deleted_at")
                    		->where('opos_receipt.status',"completed")
                    		->groupby('opos_receiptproduct.id')
                    		->orderby('opos_receipt.id','desc')
                    		->get();
                    
        return view('seller.saleslist',compact('sellerData','selluser'));
    }

    public function viewRawMaterial($product_id)
    {
        $rawMaterials = DB::table('rawmaterial')
                    			->join('product','rawmaterial.raw_product_id','=','product.id')
                    			->join('nproductid','nproductid.product_id','=','rawmaterial.raw_product_id')
                    			->select('rawmaterial.*','product.name','product.thumb_photo','nproductid.nproduct_id as npid')
                    			->where('rawmaterial.item_product_id',$product_id)
                    			->get();

        $productDetail = Product::select('id','name','thumb_photo')
                          			->where('id',$product_id)
                          			->first();

        return view('seller.saleslist_ajax',compact('rawMaterials','productDetail'));
    }

    public function viewSalesLog(Request $request)
    {
        $data = (object) $request->all();

        $location_id=DB::table("opos_locationterminal")
                        ->where("terminal_id",$data->terminal_id)
                        ->whereNull("deleted_at")
                        ->pluck("location_id");

        $lockertxn = DB::table('opos_lockerkeytxn')
                        ->select('lockerkey_ftype_id')
                        ->where('checkout_tstamp',null)
                        ->get();

        $keys = array();
        foreach ($lockertxn as $value) {
            $keys[] = $value->lockerkey_ftype_id;
        } 
       
        $lockerkeys = DB::table('opos_ftype')
                        ->select('id','fnumber')
                        ->whereNotIn('id', $keys)
                        ->whereNull("deleted_at")
                        ->where('ftype','lockerkey')
                        ->where('location_id',$location_id)
                        ->orderby('id','desc')
                        ->get();

        $sparoom = DB::table('opos_lockerkeytxnsparoom')
                      ->select('sparoom_ftype_id')
                      ->where('sparoom_checkout',null)
                      ->get();

        $spakeys = array();
        foreach ($sparoom as $value) {
            $spakeys[] = $value->sparoom_ftype_id;
         }

        $sparoomkeys = DB::table('opos_ftype')
                          ->select('id','fnumber')
                          ->whereNotIn('id', $spakeys)
                          ->whereNull("deleted_at")
                          ->where('ftype','sparoom')
                          ->where('location_id',$location_id)
                          ->orderby('id','desc')
                          ->get();

        $products = DB::table('opos_receipt')
                      ->join('opos_receiptproduct','opos_receipt.id','=','opos_receiptproduct.receipt_id')
                      ->join('product','product.id','=','opos_receiptproduct.product_id')
                      ->leftjoin('opos_lockerkeyproducts', function($join)
                      {
                          $join->on('opos_lockerkeyproducts.receipt_id','=','opos_receipt.id');
                          $join->on('opos_lockerkeyproducts.product_id','=','product.id');
                      })
                      ->leftjoin('opos_ftype','opos_ftype.id','=','opos_lockerkeyproducts.lockerkey_id')
                      ->leftjoin('opos_masseurtxn','opos_masseurtxn.id','=','opos_receiptproduct.masseur_member_id')
                      ->leftjoin('member','member.id','=','opos_masseurtxn.masseur_member_id')
                    
                      ->select('opos_receiptproduct.price','opos_receipt.id','product.id','product.name','product.thumb_photo','opos_receiptproduct.quantity','member.name as masseur_name','opos_receiptproduct.masseur_member_id','opos_masseurtxn.checkout_tstamp','opos_masseurtxn.checkin_tstamp','opos_lockerkeyproducts.lockerkey_id as lockerid','opos_ftype.fnumber','opos_receiptproduct.id as receiptproduct_id')
                      ->where('opos_receipt.id',$data->active_receipt_id)
                      ->get();
       
        $members = DB::table('member')
                      ->join('role_users','role_users.user_id','=','member.user_id')
                      ->join('roles','role_users.role_id','=','roles.id')
                      ->select('member.id','member.name')
                      ->where('roles.slug',"mas")
                      ->get();

        $terminal = DB::table('opos_terminal')
                     /* ->select('start_work','end_work')*/
                      ->where('id',$data->terminal_id)
                      ->first();

        return view('opposum.trunk.saleslog',compact('lockerkeys','sparoomkeys','products','members','terminal'));
    } 

    public function startMasseurData(Request $request)
    {
        $data = (object) $request->all();
        $ret=array();

        $insertedData = [
                          "receipt_id" => $data->receipt_id,
                          "masseur_member_id" => $data->masseur_id,
                          "checkin_tstamp" => Carbon::now(),
                          "created_at"=>Carbon::now(),
                          "updated_at"=>Carbon::now()
                        ];

        $memberid = DB::table('opos_masseurtxn')->insertgetId($insertedData);

        $receiptproduct = DB::table('opos_receiptproduct')->where('product_id',$data->product_id)->where('receipt_id',$data->receipt_id)->update(["masseur_member_id" => $memberid]);

        $ret["status"] = "success";
        $ret["data"] = $insertedData;
        $ret["massureid"] = $memberid;
        return response()->json($ret);

    }

    public function endMasseurData(Request $request)
    {
        $data = (object) $request->all();

        $ret=array();

        $insertedData = [
                        "checkout_tstamp"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                      ];

        $memberData = DB::table('opos_masseurtxn')->where('id',$data->saved_id)->Update($insertedData);

        $ret["status"] = "success";
        $ret["data"] = $memberData;
        return response()->json($ret);

    }

    public function saveSalesLog(Request $request)
    {
        $formdata = (object) $request->all();
        $saveData = $formdata->formData;
        
        $receiptftype = array();
        foreach($saveData as $data)
        {
            $isSaved = DB::table('opos_receiptftype')
                         ->where('receipt_id',$formdata->active_receipt_id)
                         ->where('ftype_id',$data['lockerkey_id'])
                         ->where('ftype',"lockerkey")->first();

            if(count($isSaved) > 0 && $isSaved->ftype_id == $data['lockerkey_id'])
            {
                // echo "in";
                // $receiptftype[] = [];
            }
            else
            {
                if(isset($data['sparoomid']) && !empty($data['sparoomid']))
                {
                    $receiptftype[] = [
                                "receipt_id" => $formdata->active_receipt_id,
                                "ftype_id" => $data['sparoomid'],
                                "ftype" => "sparoom",
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()
                            ];
                }

                if(isset($data['lockerkey_id']) && !empty($data['lockerkey_id']))
                {
                    $receiptftype[] = [
                                "receipt_id" => $formdata->active_receipt_id,
                                "ftype_id" => $data['lockerkey_id'],
                                "ftype" => "lockerkey",
                                "created_at"=>Carbon::now(),
                                "updated_at"=>Carbon::now()
                            ];
                }
            }
            
        }

        $receiptftype = DB::table('opos_receiptftype')->insert($receiptftype);
        
        return  response()->json($receiptftype);
    }

    public function savelockerproduct(Request $request)
    {
        $formdata = (object) $request->all();
        $lockerproduct = [
                            "receipt_id" => $formdata->receipt_id,
                            "lockerkey_id" => $formdata->lockerkey_id,
                            "product_id" => $formdata->product_id,
                            "quantity" => $formdata->quantity,
                            "created_at"=>Carbon::now(),
                            "updated_at"=>Carbon::now()
                        ];

        $lockerproducts = DB::table('opos_lockerkeyproducts')->insert($lockerproduct);

        $ret["status"] = "success";
        $ret["data"] = $lockerproducts;
        return response()->json($ret);
    }

    public function makeid($n=10) {
        $text = "";
        $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for($i = 1; $i<=$n; $i++)
        {
              $a = rand(1,62);
              $text .= substr($possible,$a, 1);
        }
        return $text;
    } 

    public function checkproducts(Request $request)
    {
        $ret=array();

        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;

        $selectedProducts = $request->data; 
        $old_receipt_id = $request->active_receipt_id;

        $receiptproduct = DB::table('opos_receiptproduct')->select('id')->where('receipt_id',$request->active_receipt_id)->get();
        
        $products = array();
        foreach ($receiptproduct as $value) {
          $products[] = $value->id;
        }

        $diff = array_diff($products,$selectedProducts);
        
        if(count($diff) > 0)
        {
            $ref_no = $this->makeid();
            $insert_data=[
                "ref_no"=>$ref_no,
                "terminal_id"=>$request->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];

            $new_receipt_id=DB::table('opos_receipt')->insertgetId($insert_data);            

            //-------------------------- update lockerkeyproducts --------------------------------
            
            $selectedProductsId = implode(",",$selectedProducts);
            $updatelockerproducts = DB::select(" 
                                  update `opos_receiptproduct` 
                                  inner join `opos_lockerkeyproducts` on `opos_lockerkeyproducts`.`product_id` = `opos_receiptproduct`.`product_id` 
                                  and `opos_lockerkeyproducts`.`receipt_id` = " .$old_receipt_id. "
                                  set `opos_lockerkeyproducts`.`receipt_id` = " .$new_receipt_id. " 
                                  where `opos_receiptproduct`.`id` in (".$selectedProductsId.");
                                  ");

            //----------------------------update lockerkeytxnref----------------------------------------

            $updatelockerkeytxnref = DB::select(" 
                                  update `opos_lockerkeyproducts` 
                                  inner join `opos_lockerkeytxn` 
                                  on `opos_lockerkeytxn`.`lockerkey_ftype_id` = `opos_lockerkeyproducts`.`lockerkey_id` 
                                  inner join `opos_lockerkeytxnref` 
                                  on `opos_lockerkeytxnref`.`lockerkeytxn_id` = `opos_lockerkeytxn`.`id`
                                  and `opos_lockerkeytxnref`.`receipt_id` = " .$old_receipt_id. "
                                  set `opos_lockerkeytxnref`.`receipt_id` = " .$new_receipt_id. "
                                  where `opos_lockerkeyproducts`.`receipt_id` = " .$new_receipt_id. ";
                                  ");
          
            //----------------------------update receiptproduct--------------------------------------

            $updatereceiptproduct = DB::table('opos_receiptproduct')->whereIn('id',$selectedProducts)->update(['receipt_id'=>$new_receipt_id]);

            //-----------------------------update masseurtxn------------------------------------------

            $masseur_ids = DB::table('opos_receiptproduct')->select('masseur_member_id')->where('receipt_id',$new_receipt_id)->get();

            $massureids = array();
            foreach($masseur_ids as $id)
            {
                $massureids[] = $id->masseur_member_id;
                
            }

            $updatemasseur = DB::table('opos_masseurtxn')
                               ->whereIn('id',$massureids)
                               ->where('receipt_id',$old_receipt_id)
                               ->update(['receipt_id'=>$new_receipt_id]);

            $ret["status"]="success";
            $ret["receipt_id"]=$new_receipt_id;
        }
        else
        {
            $ret["status"]="success";
            $ret["receipt_id"]=$old_receipt_id;
        }

        return response()->json($ret);
    }  


 /*   public function getUpdatedProducts(Request $request)
    {
        
         try {
           $selectedProducts = $request->data;
        $receipt_id=$request->active_receipt_id;
        $terminal_id=$request->terminal_id;
        $product_ids=array_keys($selectedProducts);
        $products =DB::table("opos_saleslog")
        ->join("product","product.id",'=',"opos_saleslog.product_id")
        ->select("opos_saleslog.*","product.name","product.thumb_photo",DB::raw('1 as quantity'))
        ->whereIn("opos_saleslog.product_id",$product_ids)
        ->where('opos_saleslog.terminal_id',$terminal_id)
        ->where("opos_saleslog.status","active")
        ->whereNull("opos_saleslog.deleted_at")
        ->groupBy("opos_saleslog.product_id")
        ->get();
        /*Add these products to opos_receiptproduct*/
    /*    $i=0;
        foreach ($products as $product) {
            $price=$product->price;
            if (empty($price)) {
              # code...
              $price=0;
            }
            $discount=$product->discount;
            if (empty($discount)) {
              # code...
              $discount=0;
            }
            $quantity=$selectedProducts[$product->product_id];
            if (empty($quantity)) {
              # code...
              $quantity=0;
            }
            $insert_data=[
              "receipt_id"=>$receipt_id,
              "product_id"=>$product->product_id,
              "quantity"=>$quantity,
              "price"=>$price,
              "discount"=>$discount,
              "discount_id"=>$product->discount_id,
              "status"=>"active",
              "updated_at"=>Carbon::now(),
              "created_at"=>Carbon::now(),
              "saleslog_id"=>$product->id
            ];
            DB::table("opos_receiptproduct")->insert($insert_data);
            $product->quantity=$quantity;
            $i++;
        }
        

         } catch (\Exception $e) {
           return 'Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage();
         }
         return response()->json($products);
    }
*/
        public function getUpdatedProducts(Request $request)
    {
        
         try {
           
        $receipt_id=$request->active_receipt_id;
        $terminal_id=$request->terminal_id;
        $saleslog_ids=array_keys($request->data);

        $saleslogs=DB::table("opos_saleslog")
        ->whereIn("opos_saleslog.id",$saleslog_ids)
        ->join("product","product.id","=","opos_saleslog.product_id")
        ->select(DB::raw("opos_saleslog.*,product.name,product.thumb_photo"))
        ->get();

        /*Add these products to opos_receiptproduct*/
        $products=[];
        $i=0;
        foreach ($saleslogs as $saleslog) {
            
            
            /*Check if update or insert*/
            $does_exist=DB::table("opos_receiptproduct")
            ->where("receipt_id",$receipt_id)
            ->where('product_id',$saleslog->product_id)
            ->whereNull('deleted_at')
            ->first();
            if (empty($does_exist)) {
              $product=(object)array();
              # code...
              $insert_data=[
              "receipt_id"=>$receipt_id,
              "product_id"=>$saleslog->product_id,
              "quantity"=>$saleslog->quantity,
              "price"=>$saleslog->price,
              "discount"=>$saleslog->discount,
              "discount_id"=>$saleslog->discount_id,
              "status"=>"active",
              "updated_at"=>Carbon::now(),
              "created_at"=>Carbon::now()
              ];
              $rp_id=DB::table("opos_receiptproduct")->insertgetId($insert_data);
              $product->product_id=$saleslog->product_id;
              $product->quantity=$saleslog->quantity;
              $product->price=$saleslog->price;
              $product->discount=$saleslog->discount;
              $product->discount_id=$saleslog->discount_id;
            /* $product=DB::table("product")->where("id",$saleslog->product_id)->first();*/
              $product->thumb_photo=$saleslog->thumb_photo;
              $product->name=$saleslog->name;

              array_push($products,$product);
            }else{
              DB::table("opos_receiptproduct")
              ->where("id",$does_exist->id)
              ->update([
                "updated_at"=>Carbon::now(),
                "quantity"=>$does_exist->quantity+1
              ]);
              $rp_id=$does_exist->id;
              foreach ($products as $product) {
                # code...
                if ($product->product_id==$saleslog->product_id) {
                    $product->price=$saleslog->price;
                    $product->quantity+=$saleslog->quantity;
                }
              }
            }
            /*Create link*/
            DB::table("opos_receiptproductsaleslog")
            ->insert([
              "saleslog_id"=>$saleslog->id,
              "receiptproduct_id"=>$rp_id,
              "updated_at"=>Carbon::now(),
              "created_at"=>Carbon::now()
            ]);
            $i++;
        }
        

         } catch (\Exception $e) {
            Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
           return 'Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage();
         }
         return response()->json($products);
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

