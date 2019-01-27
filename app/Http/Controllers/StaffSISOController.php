<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Merchant;
use Auth;
use DB;
use Log;
use Carbon;
use File;
use Image;
class StaffSISOController extends Controller
{
    public function stockin($location_id,$rack_no=null)
    {

        if (!Auth::check()) {
            # code...
            return view("common.generic")
            ->with('message','Please login to access this page.')
            ->with('message_type','error')
            ;   
        }
        $user_id     = Auth::user()->id;


        if (empty($location_id)) {
            return "Invalid Location ID";
        }

        $fairlocation=DB::table("fairlocation")->
            where("id",$location_id)->
            whereNull('deleted_at')->
            first();
        $merchant_user_id=$fairlocation->user_id;
        if (empty($merchant_user_id)) {
            return "Invalid Merchant";
        }

        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        if (empty($merchant)) {
            return "Invalid Merchant";
        }
        $merchant_id=$merchant->id;
   
        $merchant_pro=DB::select(DB::raw('
            select
        product.id, 
        product.parent_id, 

        product.name, 
        product.thumb_photo, 
        product.available,
        locationproduct.quantity as available_quantity,
        (select remark from stockreportproduct where locationproduct.product_id = stockreportproduct.product_id order by id desc limit 1) as last_remark,
        (select image from stockreportproduct where locationproduct.product_id = stockreportproduct.product_id order by id desc limit 1) as last_image

        from product inner join merchantproduct on product.id = merchantproduct.product_id
        left join locationproduct on locationproduct.product_id=product.id and locationproduct.id=(SELECT max(id) from locationproduct where location_id='.$location_id.' AND product_id=product.id AND locationproduct.deleted_at IS NULL)

        where merchantproduct.merchant_id ='.$merchant_id.' and merchantproduct.deleted_at is null and product.deleted_at is null
        and product.status NOT IN ("deleted","","transferred")
        and product.type NOT IN  ("service","voucher")

        group by  product.id order by product.created_at desc
    
            '));

        // echo '<pre>'; print_r($merchant_pro); die();
        $ttype="tin";
        $racks=array();
        $warehouse=DB::table('warehouse')->where('location_id',$location_id)
        ->whereNull('deleted_at')->first();
        if (!empty($warehouse)) {
            # code...
            $racks=$this->get_racks($location_id);
        }

        return view('seller.staff.staffsiso',compact('merchant_pro','ttype','location_id','racks','warehouse','fairlocation','rack_no'));
        
    }


    public function stockinExport($location_id,$rack_no=null){
        if (!Auth::check()) {
            # code...
            return view("common.generic")
            ->with('message','Please login to access this page.')
            ->with('message_type','error')
            ;   
        }
        $user_id = Auth::user()->id;


        if (empty($location_id)) {
            return "Invalid Location ID";
        }

        $fairlocation=DB::table("fairlocation")->
            where("id",$location_id)->
            whereNull('deleted_at')->
            first();
        $merchant_user_id=$fairlocation->user_id;
        if (empty($merchant_user_id)) {
            return "Invalid Merchant";
        }

        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        if (empty($merchant)) {
            return "Invalid Merchant";
        }
        $merchant_id=$merchant->id;
   
        $merchant_pro=DB::select(DB::raw('
            select
        product.id, 
        product.parent_id, 

        product.name, 
        product.available,
        locationproduct.quantity as available_quantity,
        (select nproduct_id from nproductid where product.id = nproductid.product_id limit 1) as lproduct_id

        from product inner join merchantproduct on product.id = merchantproduct.product_id
        left join locationproduct on locationproduct.product_id=product.id and locationproduct.id=(SELECT max(id) from locationproduct where location_id='.$location_id.' AND product_id=product.id AND locationproduct.deleted_at IS NULL)

        where merchantproduct.merchant_id ='.$merchant_id.' and merchantproduct.deleted_at is null and product.deleted_at is null
        and product.status NOT IN ("deleted","","transferred")
        and product.type NOT IN  ("service","voucher")

        group by  product.id order by locationproduct.quantity desc'));

        // echo '<pre>'; print_r($merchant_pro); die();
        $ttype="tin";
        $racks=array();
        $warehouse=DB::table('warehouse')->where('location_id',$location_id)
        ->whereNull('deleted_at')->first();
        if (!empty($warehouse)) {
            # code...
            $racks=$this->get_racks($location_id);
        }




        $num = 0;

        foreach($merchant_pro as $key => $item){
            $data[$key]['No'] = number_format(++$num);
            $data[$key]['Product ID'] = $item->lproduct_id;
            $data[$key]['Product Name'] = $item->name;
            $data[$key]['Qty'] = $item->available_quantity>0?$item->available_quantity:'0';
            // $data[$key]['Rack']= $item->available_quantity>0 ? $item->racks_id: '-';
        }

        return Excel::create('Stock In'.'-'.\date('d/m/y'), function($excel) use ($data, $fairlocation) {
            $excel->sheet('mySheet', function($sheet) use ($data, $fairlocation)
            {

                $sheet->fromArray(array(array($fairlocation->location,\date('d/m/y H:i:s'))));
                $sheet->fromArray($data)->setAutoSize(true);

                $sheet->cells('A1:A'.(count($data)+10), function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('B1:B'.(count($data)+10), function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('D1:D'.(count($data)+10), function($cells) {
                    $cells->setAlignment('center');
                });

            });
        })->export('xlsx');

    }
   
   
    public function get_racks($location_id)
    {
        return DB::table("warehouse")
                ->join("rack","rack.warehouse_id","=","warehouse.id")
                ->whereNull("warehouse.deleted_at")
                ->whereNull("rack.deleted_at")
                

                ->where("warehouse.location_id",$location_id)
              
                ->select("rack.*")
                ->orderBy("rack.created_at","DESC")
                ->get();
    }


    public function get_racks_so($warehouse_id,$product_id)
    {
        return DB::select(DB::raw(
            "
            SELECT
                
           rack.*,
           rackproduct.quantity
           
           
            FROM 
          
            rack
            

            JOIN  warehouse on warehouse.id=rack.warehouse_id

            JOIN rackproduct on rackproduct.rack_id =rack.id 

            


            WHERE 
            rack.deleted_at IS NULL
            AND rack.warehouse_id=$warehouse_id 
          
            AND rackproduct.product_id=$product_id
            AND rackproduct.quantity>0
           
            group by  rack.id
            "
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockout($location_id,$rack_no=null)
    {
        if (!Auth::check()) {
            # code...
            return view("common.generic")
            ->with('message','Please login to access this page.')
            ->with('message_type','error')
            ;   
        }
        $user_id     = Auth::user()->id;
       
        
        if (empty($location_id)) {
            return "Invalid Terminal ID";
        }
        $fairlocation=DB::table("fairlocation")->
            where("id",$location_id)->
            whereNull('deleted_at')->
            first();
        $merchant_user_id=$fairlocation->user_id;
        
        if (empty($merchant_user_id)) {
            return "Invalid Merchant";
        }
         $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        if (empty($merchant)) {
            return "Invalid Merchant";
        }
        $merchant_id=$merchant->id;
   
        
        $ttype="tout";
        
        
        $warehouse=DB::table('warehouse')->where('location_id',$location_id)
        ->whereNull('deleted_at')->first();

            $merchant_pro=DB::select(DB::raw('
                select 
            product.id, 
            product.parent_id, 


            product.name, 
            product.thumb_photo, 
            product.available,
            locationproduct.quantity as available_quantity,
            (select remark from stockreportproduct where locationproduct.product_id = stockreportproduct.product_id order by id desc limit 1) as last_remark,
            (select image from stockreportproduct where locationproduct.product_id = stockreportproduct.product_id order by id desc limit 1) as last_image

            from product inner join merchantproduct on product.id = merchantproduct.product_id
            join locationproduct on locationproduct.product_id=product.id

            where merchantproduct.merchant_id = '.$merchant_id.' and merchantproduct.deleted_at is null and product.deleted_at is null
            and product.status NOT IN ("deleted","","transferred")
            and product.type NOT IN ("service","voucher") 
            and locationproduct.id=(SELECT max(id) from locationproduct where location_id='.$location_id.' AND product_id=product.id AND locationproduct.deleted_at IS NULL)
            and locationproduct.quantity >0

            group by  product.id order by product.created_at desc
                '));
       
        
      
        if (!empty($warehouse)) {
            foreach ($merchant_pro as $p) {
                $p->racks=$this->get_racks_so($warehouse->id,$p->id);

            }
        }

        return view('seller.staff.staffsiso',compact('merchant_pro','ttype','location_id','warehouse','fairlocation','rack_no'));
    }

    public function add_rack_ledger($rack_id,$stockreportproduct_id,$ttype)
    {
        DB::table('rackproductledger')
        ->insert([
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'rack_id'=>$rack_id,
            'transaction_id'=>$stockreportproduct_id,
            'type'=>$ttype
        ]);
    }
    public function update_rackproduct($rack_id,$product_id,$quantity,$ttype)
    {
        if ($ttype=="tout") {
            $quantity=$quantity*-1;
        }
        $does_exists=DB::table('rackproduct')
        ->where('rack_id',$rack_id)
        ->where('product_id',$product_id)
        ->whereNull('deleted_at')
        ->first();
        if (empty($does_exists)) {
            DB::table('rackproduct')
            ->insert([
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'rack_id'=>$rack_id,
                'quantity'=>$quantity,
                'product_id'=>$product_id
            ]);
        }else{
            $newquantity=$does_exists->quantity+$quantity;
            if ($newquantity<0) {
                Log::error('Quantity went negative for rack '.$rack_id.' for product_id '.$product_id);
                $newquantity=0;
            }
            DB::table('rackproduct')
            ->where('id',$does_exists->id)
            ->update([
                'quantity'=>$newquantity,
                'updated_at'=>Carbon::now()
            ]);
        }
    }
     public function do_stockreport(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            /*Create a stockreport*/
            $ttype=$r->ttype;
            $location_id=$r->location_id;
            $mode="normal";
            if ($ttype=="tout" && $r->has('mode')) {
                $mode=$r->mode;
            }
            if (empty($location_id)) {
                $ret["short_message"]="No location";
                return response()->json($ret);
            }

            if (empty($ttype) or !in_array($ttype,["tin","tout"])) {
                $ret["short_message"]="Incorrect ttype";
                return response()->json($ret);
            }
            $products=json_decode($r->products);
          /*  dd($products);*/
            if (empty($products)) {
                # code...
                $ret["short_message"]="No product specified";
                return response()->json($ret);
            }
            $is_location_warehouse=DB::table("fairlocation")
            ->join("warehouse","warehouse.location_id","=","fairlocation.id")
            ->whereNull("fairlocation.deleted_at")
            ->whereNull("warehouse.deleted_at")
            ->where("fairlocation.id",$location_id)
            ->first();
            

            $action="minus";
            $message="Stock Out successfully done!";
            if ($ttype=="tin") {
                $action="add";
                $message="Stock In successfully done!";
            }
            
            $company_id=DB::table("fairlocation")
            ->where("fairlocation.id",$location_id)
            ->join("company","company.owner_user_id","=","fairlocation.user_id")
            ->whereNull("company.deleted_at")
            ->whereNull("fairlocation.deleted_at")
            ->pluck("company.id");

            if (empty($company_id)) {
                # code...
                $ret["short_message"]="No company found for the terminal";
                return response()->json($ret);
            }
            $method="web";
            $image_name="";
            /*save image*/
            if ($r->hasFile('file')) {
                $r1 = str_random(10);
                $r2 = str_random(5);
                $r3 = str_random(2);
                $pname = $r1 . $r2 . $r3;
                $base_path = "images/siso";
                $full_path = $base_path;
                // try {
                try {
                    File::makeDirectory(public_path($full_path), 0775, true);
                } catch (\Exception $e) {
                    
                }
                

                $img = $r->file('file');
                $imgext = $img->getClientOriginalExtension();
                $image_name = $pname . "." . $imgext;

                // Image::make($img)->resize('400', '300')->save($full_path . "/" . $image_name);
                Image::make($img)->save($full_path . "/" . $image_name);

                
            } //photo
            $table="stockreport";
            $insert_data=[
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "checked_on"=>Carbon::now(),
            "creator_user_id"=>$user_id,
            "checker_user_id"=>$user_id,
            "checker_company_id"=>$company_id,
            "creator_company_id"=>$company_id,
            "checker_location_id"=>$location_id,
            "creator_location_id"=>$location_id,
            "remark"=>$r->remark,
            "ttype"=>$ttype,
            "method"=>$method,
            "status"=>"confirmed",
            "image"=>$image_name,
            "mode"=>$mode
            ];
            $stockreport_id=DB::table($table)
            ->insertGetId($insert_data);

            foreach ($products as $product) {
                $quantity=$product->quantity;
                $product_id=$product->product_id;
                $remark=$product->remark;
                $image=$product->image;
                if ($quantity<1 or $product_id<1) {
                    Log::debug("Incorrect quantity or product_id");

                }else{
                    UtilityController::locationproduct($location_id,$product_id,$quantity,$action);
                    $insert_data=[
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                    "stockreport_id"=>$stockreport_id,
                    "product_id"=>$product_id,
                    "quantity"=>$quantity,
                    "received"=>$quantity,
                    "status"=>"checked",
                    "remark"=>$remark,
                    "image"=>$image
                    ];
                    $stockreportproduct_id=DB::table("stockreportproduct")->insertGetId($insert_data);
                    if (!empty($is_location_warehouse)) {
                        $rack_id=$product->rack_id;

						if (!empty($rack_id)) {
							$this->add_rack_ledger(
								$rack_id,$stockreportproduct_id,$ttype);

							$this->update_rackproduct(
								$rack_id,$product_id,$quantity,$ttype);
						} else {
							Log::error('****** $rack_id is NULL *****');
							Log::error(json_encode($product));
						}
                    }
                }
            }
           
            $ret["status"]="success";
            $ret["short_message"]=$message;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    public function get_warehouse_racks($warehouse_id)
    {
        return DB::table('rack')
        ->whereNull('deleted_at')
        ->where('warehouse_id',$warehouse_id)
        ->get()
        ;
    }
}
