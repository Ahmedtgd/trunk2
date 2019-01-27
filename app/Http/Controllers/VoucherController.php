<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\ProductDealer;
use App\Models\Specification;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel1Spec;
use App\Models\TimeSlot;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\User;
use App\Models\Wholesale;
use DB;
use Auth;

class VoucherController extends Controller
{
    public function index()
    {
		/* OMG! What kind of dev are you! What if we have 500K records in brand table,
		 * 500k records in category table??? Every refresh server needs to pull in 1M 
		 * records????!!!! */
        $brand = Brand::all();
        $category = Category::all();
        $user = User::all();
        return view('product.create_new_voucher',
			compact('brand', 'category', 'subcat_level1', 'User'));
    }

    public function store(Request $request)
    {
        /*$validation = Validator::make($request->all(), [
            'name' => 'required',
            'O-Shop' => 'required',
            'short_description' => 'required',
            'product_photo' => 'required',
            'retail_price' => 'required',
            'original_price' => 'required',
            'available' => 'required',
            'owarehouse_moq' => 'required',
            'owarehouse_price' => 'required',
            'product_details' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect('create_new_product')
                ->withErrors($validation)
                ->withInput();
        }
        else {*/
        /*
        * Get product last id from product table
       */
        $product_id = Product::orderBy('id', 'desc')->take(1)->get();
        foreach ($product_id as $PI) {
            $Pid = $PI->id;
        }
        if (!isset($Pid)) {
            $Pid = 0;
        }
        $Pid = $Pid + 1;
        /*
         * Product table section
         */
        $destination = 'public/images/product/' . $Pid . '/';
        $image = $request->file('product_photo');
        $image_name = $image->getClientOriginalName();

        if ($image->move($destination, $image_name)) {
            //if image moved
            $pro_table = new Product();
            $pro_table->name = $request->name;
            $pro_table->brand_id = $request->brand_id;
            $pro_table->category_id = $request->category_id;
            $pro_table->subcat_id = $request->subcat_id;
            $pro_table->photo_1 = $destination . $image_name;
            /*
                The original name convention was original price and retail price
                The new conventions are retail price and discounted price
                
            */
            $pro_table->discounted_price = $request->retail_price;
            $pro_table->retail_price = $request->original_price;
            $pro_table->available = $request->Quantity;
       //     $pro_table->product_details = $request->product_details;
            $pro_table->type = 'voucher';

            $pro_table->save();

            /*
             * address table
             */
            $address_table = new Address();
            $address_table->city_id = 0;
            $address_table->line1 = $request->VL1;
            $address_table->line2 = $request->VL1;
            $address_table->line3 = $request->VL1;
            $address_table->line4 = $request->VL1;
            $address_table->save();

            /*
            * get last enter adress id
            */
            $address_id = Address::orderBy('id', 'desc')->take(1)->get();
            foreach ($address_id as $AI) {
                $Aid = $AI->id;
            }
            /*
            * Voucher section....voucher table
            */
            //for($i=0;$i<count($request->wholeweek);$i++) {if user chose multi checkboxs
            $voucher_table = new voucher();
            $voucher_table->product_id = $Pid;
            $voucher_table->validity = $request->whole;
            $voucher_table->weekly_duration = $request->wholeweek;
            $voucher_table->start_duration = $request->start_duration;
            $voucher_table->end_duration = $request->years . '-' . $request->months . '-' . $request->days;
            $voucher_table->address_id = $Aid;

            $voucher_table->save();
            //}
            /*
            * get last enter voucher id
            */
            $voucher_id = voucher::orderBy('id', 'desc')->take(1)->get();
            foreach ($voucher_id as $VI) {
                $Vid = $VI->id;
            }
            /*
            * Timealot section....timeslot table
             * timeslot may b many
            */
            for ($i = 0; $i < count($request->from); $i++) {

                $timeslot_table = new timeslot();
                $timeslot_table->voucher_id = Vid;
                $timeslot_table->from = $request->from[$i];
                $timeslot_table->to = $request->to[$i];
                $timeslot_table->price = $request->myrprice[$i];
                $timeslot_table->pax_per_table = $request->fixedprice[$i];

                $timeslot_table->save();
            }

            /*
            * Unit and price section....Wholesaletable
            */
            for ($i = 0; $i < count($request->wunit); $i++) {
                $wholwsale_table = new wholesale();
                $wholwsale_table->product_id = $Pid;
                $wholwsale_table->unit = $request->wunit[$i];
                $wholwsale_table->price = $request->wprice[$i];
                $wholwsale_table->save();
            }
            /*
            * Dealer section with speacial price....productdealer table
            */
            for ($i = 0; $i < count($request->dealer); $i++) {

                $productdealer_table = new productdealer();
                $productdealer_table->product_id = $Pid;
                $productdealer_table->dealer_id = $request->dealer[$i];
                $productdealer_table->special_unit = $request->sunit[$i];
                $productdealer_table->special_price = $request->sprice[$i];
                $productdealer_table->save();
            }
            /*
             * Product Specification section..specification table
             */
            /*
            * get last spec id
            */
            $spec_id = specification::orderBy('id', 'desc')->take(1)->get();
            foreach ($spec_id as $SI) {
                $Sid = $SI->id;
            }
            if (!isset($Sid)) {
                $Sid = 1;
            }
            for ($i = 1; $i <= 6; $i++) {
                $spec_table = new specification();
                $spec_table->name = $request->product_specification_name;
                $spec_table->description = $request->product_specification_[$i];
                $spec_table->save();

                //save into subcat_level_1 table;
                $subcat = new SubCatLevel1Spec();
                $subcat->subcat_level_1_id = $request->category_id;
                $subcat->spec_id = $Sid;
                $subcat->save();

                $Sid = $Sid + 1;
            }

            /*
             * Seller information section..address table
             */
            $address_table = new Address();
            $address_table->city_id = 0;
            $address_table->line1 = $request->SFA1;
            $address_table->line2 = $request->SFA3;
            $address_table->line3 = $request->SFA3;
            $address_table->save();

            /*
            * get last enter adress id
            */
            $address_id = Address::orderBy('id', 'desc')->take(1)->get();
            foreach ($address_id as $AI) {
                $Aid = $AI->id;
            }
            /*
            * O-shop and shot-description section ....merchant table
            */
            $merchant_table = new Merchant();
            $merchant_table->user_id = 1;//here we get user id//Auth()::user()->id;
            $merchant_table->oshop_name = $request->O - Shop;
            $merchant_table->oshop_name = $request->description;
            $merchant_table->oshop_address_id = $Aid;
            $merchant_table->contact_person = $request->seller_name;
            $merchant_table->return_policy = $request->return_policy;

            $merchant_table->save();

            return "Data saved into tables";
        }

        //}
    }

    public function update(Request $request)
    {
        $newValues = array();
        if ($request->ajax()) {
            // return $request->all();
            $newValues['cell_value'] = $this->updateData($request);
            $newValues['row_id'] = "row_" . $request->id;
            $newValues['col_name'] = $request->column;
            $newValues['item_id'] = $request->id;


            return response()->json($newValues);

        } else {
            return redirect()->back();
        }

    }


    private function updateData(Request $request)
    {
        $currency = Currency::where('active', 1)->first();

        $voucher = Voucher::find($request->id);
        $product_voucher = $voucher->product;
        $newValue = "";

        switch ($request->column) {
            case "brand":
                if ((count($product_voucher->brand) > 0)) {
                    $product_voucher->brand->name = $request->brand ? $request->brand : "";
                    $product_voucher->brand->save();
                    $newValue = $product_voucher->brand->name;
                }
                break;
            case "category" :
                if ((count($product_voucher->category) > 0)) {
                    $product_voucher->category->description = $request->category ? $request->category : 0;
                    $product_voucher->category->save();
                    $newValue = $product_voucher->category->description;
                }
                break;
            case "sub_cat"  :
                if ((count($product_voucher->subCat) > 0)) {
                    $product_voucher->subCat->description = $request->sub_cat ? $request->sub_cat : "";
                    $product_voucher->subCat->save();
                    $newValue = $product_voucher->subCat->description;
                }

                break;
            case "name" :
                if ($request->name) {
                    $product_voucher->name = $request->name;
                    $newValue = $product_voucher->name;
                }

                break;
            case "created_at" :
                if ($request->created_at) {
                    $voucher->created_at = Carbon::parse($request->created_at);
                    $newValue = $voucher->created_at->format('Y-m-d H:i');
                }

                break;
            case "oshop_selected" :
                $product_voucher->oshop_selected = $request->oshop_selected;
                $newValue = $product_voucher->oshop_selected;
                break;
            case "smm_selected" :
                $product_voucher->smm_selected = $request->smm_selected;
                $newValue = $product_voucher->smm_selected;
                break;
            case "retail_price" :
                if ($request->retail_price) {
                    $amount = intval(splitStringGetEnd(" ", $request->retail_price));
                    $product_voucher->retail_price = $amount ? $amount : 0;
                    $newValue = $currency->code." ".$product_voucher->retail_price;
                }
                break;
        }

        $product_voucher->save();
        $voucher->save();
        Log::info("value " . print_r($newValue, true));
        return $newValue;


    }

    public function getVoucherTimeslots(Request $request)
    {
        if ($request->ajax()) {
            $slots = Voucher::find($request->voucher_id)->timeSlots;
            Log::info("order" . print_r($slots, true));
            return view('voucher.voucher_slots', compact('slots'));
        } else {
            return redirect()->back();
        }
    }

    public function getBuyerVoucher() {
        $vouchers = Voucher::all();
        $voucher_data = [];
        foreach ($vouchers as $i) {
            $temp['voucher'] = $i;
            $temp['voucher_timeslot'] = $i->timeSlots;
            $temp['voucher_product'] = $i->product;
            $temp['voucher_address'] = $i->address;


            $voucher_data[] = $temp;
        }
        return $voucher_data;
    }

    public function masterVoucher() {
        $vouchers = Voucher::orderBy('created_at','DESC')->get();
        $voucher_data = [];
        foreach ($vouchers as $i) {
            $temp['voucher'] = $i;
            //$temp['voucher_timeslot'] = $i->timeSlots;
            $temp['voucher_product'] = $i->product;
            $temp['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $i->id)->first();
            $temp['voucher_timeslot_from']=date("H:i",strtotime($temp['voucher_timeslot']->from));
            $temp['voucher_timeslot_to']=date("H:i",strtotime($temp['voucher_timeslot']->to));
            $temp['merchant_id'] = DB::table('oshopproduct')->select('*')->where('product_id', $i->product_id)->first();
			$temp['merchant_status'] = null;
			if(!is_null($temp['merchant_id'])){
				 $temp['merchant_status'] = DB::table('merchant')->select('status')->where('id' , $temp['merchant_id']->merchant_id)->first();
			}       
            $temp['voucher_address'] = $i->address;
            $voucher_data[] = $temp;
        }
        //return $voucher_data;
        return view('voucher.master-voucher', ['vouchers' => $voucher_data]);
    }

    public function get_vouchers($id) {
        $voucher_data = [];

        $voucher = Voucher::find($id);
       // $product = Product::find($voucher->product_id);


        $voucher_data['voucher'] = $voucher;
        $voucher_data['voucher_outlets'] = DB::table('sproperty')
						->select(DB::raw('sproperty.id as spid, sproperty.biz_name as biz_name, address.*, city.name as city_name'))
						->join('outletvoucher','outletvoucher.sproperty_id','=','sproperty.id')
						->leftJoin('address','address.id','=','sproperty.address_id')
						->leftJoin('city','address.city_id','=','city.id')
						->where('outletvoucher.voucher_id',$voucher_data['voucher']->id)
						->get();
        //$voucher_data['product'] = $product;
        $voucher_data['voucher_id'] = "[" . str_pad($voucher->id, 10, '0', STR_PAD_LEFT) . "]";
        $voucher_data['voucher_timeslots'] = $voucher->timeSlots;
        $voucher_data['voucher_product'] = $voucher->product;
		$voucher_data['voucher_category'] =  DB::table('category')->where('id',$voucher_data['voucher_product']->category_id)->first();
		$voucher_data['voucher_subcategory'] =  DB::table('subcat_level_1')->where('id',$voucher_data['voucher_product']->subcat_id)->first();
        $voucher_data['voucher_address'] = $voucher->address;
        $voucher_data['voucher_retail_price'] = number_format(($voucher->product->retail_price) / 100, 2);
        $voucher_data['voucher_timeslot'] = DB::table('timeslot')->select('*')->where('voucher_id', $voucher->id)->first();
		if($voucher_data['voucher_product']->segment == 'v1'){
			$voucher_data['voucher_timeslot_from']=date("H:i",strtotime($voucher_data['voucher_timeslot']->from));
			$voucher_data['voucher_timeslot_to']=date("H:i",strtotime($voucher_data['voucher_timeslot']->to));
			$voucher_data['voucher_discounted_price'] = number_format(($voucher_data['voucher_timeslot']->price) / 100, 2);       
			$voucher_data['voucher_timeslot_booking'] = date("dMy H:i", strtotime($voucher_data['voucher_timeslot']->booking));
		
			$voucher_data['merchant_id'] = DB::table('merchantproduct')->select('*')->where('product_id', $voucher->product->id)->first();
			$voucher_data['voucher_total_price'] = number_format((($voucher_data['voucher_discounted_price']) / 100) * $voucher_data['voucher_timeslot']->qty_ordered, 2);
			/*$voucher_data['voucher_percentage'] = number_format(((($voucher->product->retail_price - $voucher_data['voucher_discounted_price'])/$voucher->product->retail_price))*100,1);*/
		
			$voucher_data['voucher_address'] = $voucher->address;
		}
        //$voucher_data[]=$temp;

        return $voucher_data;
    }
    public function voucher_information($id){
        return view('productvoucher');
    }
    public function buy_voucher($id){
        $voucher_data=$this->get_vouchers($id);
        return view('voucher.buy_voucher',['voucher_data'=>$voucher_data]);

    }

    public function voucherList(){
        $user_id=Auth::user()->id;
        // print_r(Auth::user()); exit();
        $selluser = User::find($user_id);
        // $voucher = DB::select("select * from voucher v join opos_pvoucher op on v.id = op.voucher_id where source = 'opossum'");
        $voucher = DB::select("
            select v.*, p.name,p.voucher_qty_limit,op.doc_no, op.platform, op.description
            from voucher v 
            left join product p 
                on p.id = v.product_id 
            left join opos_pvoucher op
                on v.id = op.voucher_id
            where source = 'opossum'
            order by id desc
            ");

        $update = DB::select("
            update voucher v 
                set v.vleft = (select p.voucher_qty_limit from product p where p.id = v.product_id ) - (select count(rv.id) 
                from opos_receiptvoucher rv where rv.voucher_id = v.id )
            where source = 'opossum'
        ");
        
        return view('vouchers.voucherlist',['voucher_list'=>$voucher,'selluser'=>$selluser]);
    }

    public function searchVoucher(Request $request){
        // $voucher = DB::select("select * from voucher v join opos_pvoucher op on v.id = op.voucher_id where source = 'opossum'");
        $voucher = DB::select("select v.*,op.*, p.name from voucher v left join opos_pvoucher op on v.id = op.voucher_id left join product p on p.id = v.product_id where source = 'opossum' AND v.id=".$request->voucher_id);
        // echo "<pre>"; print_r($voucher); exit();
        return $voucher;
    }

    public function voucherRedeem(Request $request){
        DB::table('voucher')
            ->where('id', $request->voucher_id)
            ->update(['vleft' => $request->qty]);
    }

    public function SavePaperVoucher(Request $request){
        $id = DB::table('voucher')->insertGetId(
            ['nature' => 'Paper','source' => 'opossum','status' => 'active','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]
        );
        DB::table('opos_pvoucher')->insert(
            ['voucher_id' => $id,'staff_user_id' => $request->com_user_id, 'platform' => $request->com_platform,'doc_no' => $request->com_doc_no,'description' => $request->com_description,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]
        );
    }

    public function digitalVoucher(){
        // $user_id=Auth::user()->id;
        // print_r(Auth::user()); exit();
        // $selluser = User::find($user_id);
        // $voucher = DB::select("select * from voucher v join opos_pvoucher op on v.id = op.voucher_id where source = 'opossum'");
        return view('vouchers.digitalvoucher');
    }
    
    public function getvoucherlist($voucher_id){
        $user_id=Auth::user()->id;
        
        $selluser = User::find($user_id);
        $voucher = DB::select("
            select v.*, p.voucher_package_qty,voucherbuyer.qty_left,nbuyerid.nbuyer_id,voucherbuyer.status,users.first_name,users.last_name from voucher v 
            left join product p 
                on p.id = v.product_id 
            left join voucherbuyer 
                on voucherbuyer.voucher_id = v.id 
            join users 
                on voucherbuyer.buyer_id = users.id 
            join nbuyerid
                on nbuyerid.user_id=users.id
            where voucher_id = $voucher_id  
            order by id desc
            ");
        // $voucher = DB::select("
        //     select v.*, voucherbuyer.qty_left,nbuyerid.nbuyer_id,voucherbuyer.status,users.first_name,users.last_name, count(rv.id) as usedcount from voucher v 
        //     left join voucherbuyer 
        //         on voucherbuyer.voucher_id = v.id 
        //     join users 
        //         on voucherbuyer.buyer_id = users.id 
        //     join nbuyerid
        //         on nbuyerid.user_id=users.id
        //     join opos_receiptvoucher rv
        //         on rv.voucher_id = v.id            
        //     where voucherbuyer.voucher_id = $voucher_id 
        //     AND rv.deleted_at IS NULL            
        //     order by id desc
        //     ");

        // if(count($voucher) > 0)
        // {
        //     $vleft = $voucher[0]->package_qty - $voucher[0]->usedcount;
        //     $voucherid = Voucher::find($voucher_id);
        //     if(count($voucherid) > 0)
        //     {
        //         $voucherid->vleft = $vleft;
        //         $voucherid->save();
        //     }     
        // }          

        return view('vouchers.VoucherListData',['voucher_list'=>$voucher,'selluser'=>$selluser]);

    }
    public function getvoucherledgerlist($voucher_id){
        $voucher = DB::select("
            select v.*,voucherbuyer.created_at, voucherbuyer.qty_left,buyer_id,voucherbuyer.status,users.first_name,users.last_name,fairlocation.location 
            from voucher v left 
            join voucherbuyer 
                on voucherbuyer.voucher_id = v.id 
            join users 
                on voucherbuyer.buyer_id = users.id 
            join voucherledger 
                on voucherledger.voucher_id = v.id
            join fairlocation 
                on fairlocation.id = voucherledger.location_id
            where voucherbuyer.voucher_id = $voucher_id 
            order by id desc" );
        return view('vouchers.voucherledger',['voucher_list'=>$voucher]);

    }
}
