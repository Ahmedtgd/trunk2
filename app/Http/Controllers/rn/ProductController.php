<?php

namespace App\Http\Controllers\rn;

use App\Classes\Delivery;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\MerchantCategory;
use App\Models\MerchantProduct;
use App\Models\OpenWish;
use App\Models\Autolink;
use App\Models\OpenWishPledge;
use App\Models\productspec;
use App\Models\ProfileProduct;
use App\Models\State;
use Facebook\Facebook;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\ProductDealer;
use App\Models\TProductDealer;
use App\Models\Specification;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\GlobalT;
use App\Models\SubCatLevel1Spec;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\IdController;
use App\Http\Controllers\UserController; 
use Validator;
use Input;
use Cart;
use URL;
use Response;
use DateTime;
use JWTAuth;
use App\Models\User;
use App\Models\Product;
use App\Models\Wholesale;
use App\Models\Twholesale;
use App\Http\Requests\ProductRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exceptions\CustomException;
use Exception;
use Log;
use \Illuminate\Database\QueryException;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\UtilityController;
class ProductController extends Controller
{


    
    public function name($long_name)
    {
        $limit=100;
        $len=strlen($long_name);
        if ($len>$limit) {
            $long_name=substr($long_name,0,$limit)."...";
        }
        return $long_name;
    }
    public function showProducts(){ 
        $products = Product::all();
        return response()->json($products);
    }

    public function addProduct(Request $request){
        $user_id = Auth::user()->id;
        $merchant_data = Merchant::where('user_id', $user_id)->first();
        $merchant_id = $merchant_data->id;

        /*
         * Product table section
         */
        $product = new Product($request);
        $product_data = $product->store($request, $merchant_id);

        $file = $request->file('product_photo');
        $fileNameUniq = uniqid();
        $destinationPath = public_path() . 'images/product/' . $product->id . '/';


        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $fileName = uniqid();
        if (move_uploaded_file($file, 'images/product/' . $product->id . '/' . $fileName . '.' . $extension)) {
            $product->photo_1 = $fileName . '.' . $extension;
          }
          return json_encode("Product added!");
   }

   public function addProductRetail(Request $request){
        $product = new Product();
        $product_data = $product->storep($request,$merchant_id);
        $file = $request->file('product_photo');
        $fileNameUniq = uniqid();
        $destinationPath = public_path().'images/product/'.$product->id.'/';

        $extension = pathinfo($file->getClientOriginalName(),
            PATHINFO_EXTENSION);

        $fileName = uniqid();
        if (move_uploaded_file($file,'images/product/'.$product->id .'/'.
            $fileName.'.'.$extension)) {
            $product->photo_1 = $fileName . '.' . $extension;
        }

        $merchant_pro = new MerchantProduct();
        $merchant_pro_data = $merchant_pro->storeproduct($product_data,
            $merchant_id);
        
        $pdetail = DB::table('productdetail')->insertGetId(['data'=>$request->get('product_details'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        
        DB::table('product')->where('id',$product_data->id)->update(['productdetail_id'=>$pdetail]);
        
        if($request->get('oshop_id') > 0){
            DB::table('oshopproduct')->insert(['oshop_id'=>$request->get('oshop_id'),'product_id'=>$product_data->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }
        
   }

    public function addProduct_sp(Request $request){
        try {
            $input = $request->all();
            $product_id = $request->get('myproduct_id');
            $product_data = Product::where('id', $product_id)->first();
            DB::table('productdealer')->where('product_id', $product_data->id)->where('dealer_id',$request->get('did'))->delete();
            $productDealer = new ProductDealer();
            $productDealer->storeproductDealer($request, $product_data);
            return json_encode($input);
        } catch(QueryException $e){
            return json_encode("error");
        }       
    }

    public function addProduct_hyper(Request $request)
    {
        $input = $request->all();
        $moq = $request->get('moq');
        $hyper_id = $request->get('hyper_id');
        $owarehouse_id = $request->get('owarehouse_id');
        $moqcaf = $request->get('moqcaf');
        $global_system_vars = GlobalT::orderBy('id', 'desc')->first();
        $duration = $global_system_vars->hyper_duration;
        $hyperprice = $request->get('hyperprice');
        $hqty = $request->get('hqty');
        //$deliveryqty = $request->get('deliveryqty');
        $states_hyper = $request->get('states_hyper');
        $cities_hyper = $request->get('cities_hyper');
        $areas_hyper = $request->get('areas_hyper');
        $del_option_hyper = 'system';
        $hyper_terms = $request->get('hyper_terms');
        $hyper_terms = $request->get('hyper_terms');
        $free_delivery = $request->get('free_delivery');
        $free_delivery_with_purchase_qty = $request->get('free_delivery_with_purchase_qty');
        $prod_del_timehyper = $request->get('prod_del_timehyper');
        $prod_del_time_tohyper = $request->get('prod_del_time_tohyper');
        //dd($free_delivery);
        $parent_id = $request->get('parent_id');
        //dd($rfree_delivery);
        $retail = Product::find($parent_id);
        $merchant_id = DB::table('merchantproduct')->where('product_id',$retail->id)->pluck('merchant_id');
        if($hyper_id == 0){
            $hyper = $retail->replicate();
            $hyper->save();
            $return_id = $hyper->id;
            
            DB::table('product')->where('id',$return_id)
                        ->update(
                            [
                                'parent_id' => $parent_id,
                                'segment' => 'hyper',
                                'available' => $hqty,
                                'cov_state_id' => $states_hyper,
                                'cov_city_id' => $cities_hyper,
                                'cov_area_id' => $areas_hyper,
                                'cov_area_id' => $areas_hyper,
                                'free_delivery' => 1,
                                'free_delivery_with_purchase_qty' => $free_delivery_with_purchase_qty,
                                'free_delivery_with_purchase_amt' => $free_delivery_with_purchase_qty,
                                'owarehouse_moq' => $moq,
                                'owarehouse_moqperpax' => $moqcaf,
                                'return_policy' => $hyper_terms,
                                'delivery_time' => 30,
                                'delivery_time_to' => 37,
                                'owarehouse_price' => $hyperprice*100
                            ]
                        );
                                
            $hypernn = DB::table('owarehouse')->insertGetId(
                                    [
                                        'product_id' => $return_id,
                                        'moq' => $moq,
                                    //  'deliverypax' => $deliveryqty,
                                        'duration' => $duration,
                                        'collection_units' => 0,
                                        'collection' => 'box',
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'collection_price' => $hyperprice*100
                                    ]
                                );  
                                
            $newid = UtilityController::generaluniqueid($hypernn ,'6','1', date('Y-m-d H:i:s'), 'nhyperid', 'nhyper_id');
            DB::table('nhyperid')->insert(['nhyper_id'=>$newid, 'hyper_id'=>$hypernn, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);   
            DB::table('product')->where('id',$parent_id)
                                ->update(
                                    [
                                        'owarehouse_moq' => $moq,
                                        'owarehouse_moqperpax' => $moqcaf,
                                        'owarehouse_price' => $hyperprice*100
                                    ]
                                );
            $user_id = Auth::user()->id;
            $merchant_data = Merchant::where('id', $merchant_id)->first();                              
            $merchantuniqueq = DB::table('nsellerid')->where('user_id',$merchant_data->user_id)->first();
            //dump($merchantuniqueq);
            if(!is_null($merchantuniqueq)){
            //  dump("MUNIQUE");
                $newid = UtilityController::productuniqueid($merchant_id,$merchantuniqueq->nseller_id,'hyper',0, $return_id);
            //  dump($newid);
                if($newid != ""){
                    DB::table('nproductid')->insert(['nproduct_id'=>$newid, 'product_id'=>$return_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }
                
            }
            $return_id = $return_id . "-" . $hypernn;
        } else {
            //  dd($hyper_id);
                    DB::table('product')->where('id',$hyper_id)
                            ->update(
                                [
                                    'available' => $hqty,
                                    'owarehouse_moq' => $moq,
                                    'owarehouse_moqperpax' => $moqcaf,
                                    'return_policy' => $hyper_terms,
                                    'free_delivery' => 1,
                                    'free_delivery_with_purchase_qty' => $free_delivery_with_purchase_qty,
                                    'free_delivery_with_purchase_amt' => $free_delivery_with_purchase_qty,
                                    'cov_state_id' => $states_hyper,
                                    'cov_city_id' => $cities_hyper,
                                    'cov_area_id' => $areas_hyper,
                                    'del_option' => $del_option_hyper,                                      
                                    'delivery_time' => 30,
                                    'delivery_time_to' => 37,
                                    'owarehouse_price' => $hyperprice*100
                                ]
                            );
                            
                    DB::table('owarehouse')->where('id',$owarehouse_id)
                            ->update(
                                [
                                    'duration' => $duration,
                                    'moq' => $moq,
                                //  'deliverypax' => $deliveryqty,
                                ]
                            );                          

                    DB::table('product')->where('id',$parent_id)
                                        ->update(
                                            [
                                                'owarehouse_moq' => $moq,
                                                'owarehouse_moqperpax' => $moqcaf,
                                                'owarehouse_price' => $hyperprice*100
                                            ]
                                        );

    
                $return_id = $hyper_id . "-" . $owarehouse_id;
        }
        return response()->json($return_id);
    }

    public function addProduct_b2b(Request $request)
    {
        try {
            $user_id = $request->get('userid');
            $merchant_data = Merchant::where('user_id', $user_id)->first();
            $merchant_id = $merchant_data->id;          
            $input = $request->all();
            //dd($input);
            $product_id = $request->get('myproduct_id');
            $product_data = Product::where('id', $product_id)->first();
        //  dd($product_id);
            /* Assign Specification to product
            */
            /*
            * Unit and price section....Wholesaletable
            */
            /***/
            $parent_id = $product_data->id;
            $product_new = Product::where('id', $parent_id)->first();
            $photo = $product_new->photo_1;
            $thumb_photo = $product_new->thumb_photo;

            $product = new Product();
            $product_b2b = Product::where('parent_id', $parent_id)->where('segment', 'b2b')->first();
            if(is_null($product_b2b)){
                $product_data = $product->storeb2b($request,$parent_id,$photo,$thumb_photo);
                $pdetail = DB::table('productdetail')->
                    insertGetId(['data'=>$request->
                    get('product_detailsb2b'),
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')]);
        
                DB::table('product')->
                    where('id',$product_data->id)->
                    update(['productdetail_id'=>$pdetail]);
                $merchantuniqueq = DB::table('nsellerid')->where('user_id',$user_id)->first();
                if(!is_null($merchantuniqueq)){
                    $newid = UtilityController::productuniqueid($merchant_id,$merchantuniqueq->nseller_id,'b2b',0, $product_data->id);
                    if($newid != ""){
                        DB::table('nproductid')->insert(['nproduct_id'=>$newid, 'product_id'=>$product_data->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                    }
                    
                }
                UtilityController::createQr($product_data->id,'product',URL::to('/') . '/productconsumer/' . $parent_id);

            } else {
                $product_data = $product->storeb2bedit($request,$parent_id,$photo,$thumb_photo);
                $pdetail = DB::table('productdetail')->
                    where('id',$product_data->productdetail_id)->first();

                if(!is_null($pdetail)){
                    $pdetail = DB::table('productdetail')->
                        where('id',$product_data->productdetail_id)->
                        update(['data'=>$request->
                        get('product_detailsb2b')]);

                } else {
                    $pdetail = DB::table('productdetail')->
                        insertGetId(['data'=>$request->
                        get('product_detailsb2b'),
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')]);
        
                    DB::table('product')->
                        where('id',$product_data->id)->
                        update(['productdetail_id'=>$pdetail]);
                }
            }

            DB::table('wholesale')->where('product_id',
                $product_data->id)->delete();

            $wholesale = new Wholesale();
            $wholesale->storewholesale($request, $product_data);

            return json_encode($input);

        } catch(QueryException $e){
           dump($e);
        }       
    }


    public function findProduct($id){
        $product = Product::find($id);
        return response()->json($product); 
    }

    public function get_product_details($id){
        $pdetail = DB::table('productdetail')->where('id',$id)->first();
        if(!is_null($pdetail)){
            $pdetail = $pdetail->data;
        } else {
            $pdetail = "-";
        }
        return response()->json($pdetail);
    }


    public function product_info(Request $r)
    {

        $product=array();
        // return response()->json(["id"=>$r->product_id]);
        try {
            $product=Product::where('product.id',$r->product_id)
            ->leftJoin('productqr','productqr.product_id','=','product.id')
            ->leftJoin('qr_management','productqr.qr_management_id','=','qr_management.id')
            ->leftJoin('nproductid','nproductid.product_id','=','product.id')
            ->select("product.id","product.name","product.photo_1","qr_management.image_path","nproductid.nproduct_id")
            ->where("qr_management.type","qr")
            ->first()
            ;
            if (empty($product)) {
                return response()->json(['error' => 'invalid_product'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $product->name=$this->name($product->name);
        $product->image_uri=asset('images/product/'.$product->id.'/'.$product->photo_1);
        $product->qr_uri=asset('images/qr/product/'.$product->id.'/'.$product->image_path).".png";
        return response(json_encode(compact('product'),JSON_UNESCAPED_SLASHES));
    }

    public function product_info_bc(Request $r)
    {
        $product=array();

        Log::info("********LOGGING FOR BARCODE*************");

        try {
            $barcode=$r->barcode;
            $company_id=$r->company_id;
             //Log::info("barcodeF ".$barcode);
           

           
            
            $mode="";
            if ($r->has("mode")) {
                $mode=$r->mode;
            }

            $company=DB::table('company')->where('id',$company_id)->first();

            $merchant_id=DB::table('merchant')->
				where('user_id',$company->owner_user_id)->pluck('id');

            /*Log::info("Merchant ID = ".$merchant_id);*/
             /*Check if the barcode is nproduct_id*/
            /*$is_nproductid=DB::table("product")
            ->join("nproductid","product.id","=","nproductid.product_id")
            ->join("merchantproduct","merchantproduct.product_id","=","product.id")

            ->whereNull("product.deleted_at")
            ->where("nproductid.nproduct_id",$barcode)
            ->where("merchantproduct.merchant_id",$merchant_id)
            ->whereNull("merchantproduct.deleted_at")
            ->whereNull("nproductid.deleted_at")
            ->orderBy("nproductid.created_at","DESC")
            ->first();*/
            $product=DB::table("bc_management")->
            join("productbc","productbc.bc_management_id","=","bc_management.id")->
            join("merchantproduct","merchantproduct.product_id","=","productbc.product_id")->

            join("product","merchantproduct.product_id","=","product.id")->
            leftJoin("productqr","productqr.product_id","=","product.id")->
            leftJoin("nproductid","nproductid.product_id","=","product.id")->
            leftJoin("qr_management","qr_management.id","=","productqr.qr_management_id")->
            
            where("merchantproduct.merchant_id",$merchant_id)->
            whereNull("merchantproduct.deleted_at")->
            whereNull("productbc.deleted_at")->
            whereNull("product.deleted_at")->
            whereNull("bc_management.deleted_at")->
            orderBy("productbc.created_at","DESC")->
            where("bc_management.barcode",$barcode)->
            orWhere("nproductid.nproduct_id",$barcode)->
            select("product.id",
                    "product.photo_1",
                    "product.name"
                ,"qr_management.image_path","merchantproduct.merchant_id","product.thumb_photo as thumbnail","nproductid.nproduct_id")->
            first();

            if (empty($product)) {
                # code...
                return response()->json(['status'=>'failure','short_message'=>"Product not part of inventory",'debug'=>[$company_id,$merchant_id]],501);
            }


        } catch (\Exception $e) {
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            return response()->json(['error' => $e->getMessage(),'line'=>$e->getLine()], 500);
        }
        $product->name=$this->name($product->name);
        $product->company_id=$company_id;
        //$product->nproduct_id="1234";
        $product->image_uri=asset('images/product/'.$product->id.'/'.$product->photo_1);
        $product->qr_uri=asset('images/qr/product/'.$product->id.'/'.$product->image_path).".png";
        $product->price=UtilityController::realPrice($product->id);
        $debug=["barcode"=>$barcode,"company_id"=>$company_id,"merchant_id"=>$merchant_id];
        if ($r->has("mode")) {
            $debug["mode"]=$r->mode;
        }
        return response(json_encode(compact('product','debug'),JSON_UNESCAPED_SLASHES));   
    }

    
       /*
        $products = is_array($products) && !empty($products) ? $products : null;
        if (isset($products)) {
            $sl = $products[0]->subcat_level;
            $sid = $products[0]->subcat_id;
            $subcat = DB::table('subcat_level_'.$sl)->where('id', $sid)->first(['name', 'category_id']);
            if (isset($subcat)) {
                $category = DB::table('category')->where('id', $subcat->category_id)->first()->name;
                $products[0]->category = str_replace("_"," ",$category);
                $products[0]->subcategory = str_replace("_"," ",$subcat->name);
            } else {
                $products[0]->category = null;
                $products[0]->subcategory = null;
            }

            $return_address = $this->getReturnAddress($product_id);
            if(isset($return_address)) {
                $products[0]->return_address = $return_address[0]->ra;
            } else {
                $products[0]->return_address = null;
            }
        }

       return response()->json($products);
    }
    */

    public function plquery($location_id)
    {
        # code...
        return  $query="
            SELECT 
                p.id,
                p.thumb_photo,
                p.name,
                lpt.quantity as quantity,
                lpt.quantity as received
                

            FROM 
                product p 
                JOIN locationproduct  lpt on lpt.product_id=p.id
                JOIN (
                    SELECT l.product_id as product_id,max(l.created_at) as created_at FROM 
                    locationproduct l JOIN fairlocation f on f.id=l.location_id
                    WHERE l.deleted_at IS NULL
                    AND l.location_id=$location_id
                    GROUP BY l.product_id

                ) lp on lp.product_id=lpt.product_id AND lp.created_at=lpt.created_at
               

                WHERE
                p.deleted_at IS NULL
             
                AND p.status NOT IN ('transferred','deleted','')
                GROUP BY p.id
            ";

    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function products_location($location_id,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        $ret['data']=[];
        $user = JWTAuth::parseToken()->authenticate();
        if (empty($user)) {
            # code...
            return "";
        }
        $user_id=$user->id;
       
        try{
            $table="product";

            $query=$this->plquery($location_id);
            $data=DB::select(DB::raw($query));
            
            foreach ($data as $product) {
                # code...
                $product->name=$this->name($product->name);
                $product->image_uri=asset('images/product/'.$product->id.'/thumb/'.$product->thumb_photo);
            }
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
}
