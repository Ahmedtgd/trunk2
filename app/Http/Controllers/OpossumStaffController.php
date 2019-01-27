<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OposReceipt;
use App\Models\OposReceiptproduct;
use App\Models\Merchant;
use DB;
use App\Models\Product;
use Auth;
use Carbon;
use Log;
use PDF;

class OpossumStaffController extends Controller
{
	public function oposStaffList($terminal_id)
	{
		Log::debug('***** oposStaffList('.$terminal_id.') *****');

        if (!Auth::check()) {
            # code...
            return "authorization error";
        }

		$staffs = DB::select(DB::raw("
			SELECT 
				u.id as uid,
				m.id as mid,
				u.email,
				m.name as mname,
				s.name as sname,

				concat(u.first_name,' ',u.last_name) as name ,
				count(DISTINCT sl.id) as performance,
				c.id as company_id,
				s.nickname
			FROM	
				opos_terminal t,
				opos_locationterminal lt,
				fairlocation l,
				member m 
				JOIN company c on c.id=m.company_id
				LEFT JOIN users u on u.id=m.user_id
				LEFT JOIN nstaff s ON m.id = s.member_id 
				LEFT JOIN opos_saleslog sl ON m.id=sl.masseur_id AND
					sl.start IS NOT NULL AND
					sl.end IS NOT NULL AND
					sl.status='completed'
			WHERE 
				lt.terminal_id = t.id AND
				lt.location_id = l.id AND
				l.user_id = c.owner_user_id AND
				m.type='member' AND
				t.id = $terminal_id
			GROUP BY
				m.id"
        ));


		Log::debug('***** staffs *****');
		Log::debug($staffs);


        foreach ($staffs as $staff){
			$staff->attendance = DB::table('hcap_attendance')->
				where('staff_user_id', $staff->uid)->count();
        }

		return view('opposum.trunk.oposstafflist',
			compact('staffs'));
	}


	public function oposStaffProduct($terminal_id,$member_id)
	{
        $location_id=DB::table("opos_locationterminal")
        ->where("terminal_id",$terminal_id)
        ->pluck("location_id");
        $merchant_user_id=DB::table("fairlocation")
        ->where("id",$location_id)
        ->pluck("user_id");
        $merchant = Merchant::where('user_id','=',$merchant_user_id)->first();
        $merchant_id=$merchant->id;

           $products=DB::select(DB::raw("
            SELECT
            product.id as id,

            product.name as name,

            product.retail_price as price,
            np.nproduct_id as npid,
            product.description as description,
            product.thumb_photo as thumb_photo,
            hcap_productcomm.commission_amt as amt,
            hcap_productcomm.time as ProductTimeMin

            FROM 

            product 
            JOIN merchantproduct mp on mp.product_id=product.parent_id
            LEFT JOIN nproductid np on np.product_id=product.id
            LEFT JOIN hcap_productcomm on hcap_productcomm.product_id=product.id AND hcap_productcomm.sales_member_id=$member_id
            WHERE
            mp.merchant_id=$merchant_id
            AND product.deleted_at IS NULL
            AND mp.deleted_at IS NULL
            GROUP BY product.id
            ORDER BY amt DESC,id DESC
            "));
           
		return view('opposum.trunk.oposstaffproduct',compact('products','member_id'));
	}

    public function hcap_productcomm($product_id,$commission,$member_id,$time)
    {
       
        # code...
        $prod_commission = DB::table('hcap_productcomm')
        ->where([
        'sales_member_id' => $member_id,
        'product_id' => $product_id
        ])
        ->whereNull('deleted_at')
        ->first();

        $UpdateArray = array(
            'updated_at' => Carbon::now()
        );
        if($time != null){
            $UpdateArray['time'] = $time;
        }  
        
        if($commission != 0){

            $DacimelAmount = $commission * 100;
            $UpdateArray['commission_amt'] = $DacimelAmount;
        }
        if($prod_commission){
                DB::table('hcap_productcomm')
                ->where([
                'sales_member_id' => $member_id,
                'product_id' => $product_id
                ])
                ->whereNull('deleted_at')
                ->update($UpdateArray);

        }else{
        DB::table('hcap_productcomm')->
        insert([
        'product_id'=> $product_id,
        'commission_amt' => $commission * 100,
        'sales_member_id' => $member_id,
        'time' => $time,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
        ]);
        }

    }

    public function save_commission(Request $r)
    {
        # code...
        $member_id=$r->member_id;
        $products=$r->products;
        $ProductTimeMin = $r->timeproducts;
        $productarray = array();

        if(!empty($products)){
            foreach ($products as $product_id => $commission) {
                
                    $productarray[$product_id]['commission'] = $commission;
                // $time = $ProductTimeMin[$product_id];
                // $this->hcap_productcomm($product_id,$commission,$member_id,$time);
                
            }
        }
        if(!empty($ProductTimeMin)){
 
            foreach ($ProductTimeMin as $Timeproduct_id => $Time){
                $productarray[$Timeproduct_id]['Time'] = $Time;
               
                // $time = $ProductTimeMin[$product_id];
                // $this->hcap_productcomm($product_id,$commission,$member_id,$time);
                
            }
        }
       
        foreach ($productarray as $keyProductId => $value) {
            $time= null;
            $commission = 0;
            if(isset($value['Time']) && !empty($value['Time'])){
                $time = $value['Time'];
            }
            if(isset($value['commission']) && !empty($value['commission'])){
                $commission = $value['commission']; 
            }
           $this->hcap_productcomm($keyProductId,$commission,$member_id,$time);
        }


        return json_encode(array(
            'status' => 'true'));
    }


    public function performance_data($member_id)
    {
       return  DB::table("opos_saleslog")
        ->join("product", "product.id","=","opos_saleslog.product_id")
        ->join("hcap_productcomm","hcap_productcomm.product_id","=","product.id")
        ->leftjoin("nproductid","nproductid.product_id","=","product.id")
        ->where("opos_saleslog.masseur_id",$member_id)
        ->where("hcap_productcomm.sales_member_id",$member_id)
        ->whereNull("opos_saleslog.deleted_at")
        ->whereNotNull("opos_saleslog.start")
        ->whereNotNull("opos_saleslog.end")
        ->where('opos_saleslog.status','completed')
        ->select("product.name","product.id as pid","product.thumb_photo","opos_saleslog.*","hcap_productcomm.commission_amt as commission","hcap_productcomm.time as productTime","nproductid.nproduct_id as nproduct_id")
        ->get();
    }

    public function performancePDF_data($member_id)
    {
        return DB::table("opos_saleslog")
        ->join("product", "product.id","=","opos_saleslog.product_id")
        ->join("hcap_productcomm","hcap_productcomm.product_id","=","product.id")
        ->leftjoin("nproductid","nproductid.product_id","=","product.id")
        ->where("opos_saleslog.masseur_id",$member_id)
        ->where("hcap_productcomm.sales_member_id",$member_id)
        ->whereNull("opos_saleslog.deleted_at")
        ->whereNotNull("opos_saleslog.start")
        ->whereNotNull("opos_saleslog.end")
        ->where('opos_saleslog.status','completed')
        ->select("product.name","product.id as pid",'nproductid.nproduct_id as nproduct_id ',"product.thumb_photo","opos_saleslog.*",DB::raw("sum(hcap_productcomm.commission_amt) as commission"),DB::raw("sum(hcap_productcomm.time) as productTime"),DB::raw("sum(opos_saleslog.price) as price"),DB::raw("sum(opos_saleslog.quantity) as quantity"))
        ->groupby('product.id')
        ->get();

    }


    public function performance($member_id)
    {
        
        $logs=$this->performance_data($member_id);
        return view("opposum.trunk.oposperformance",compact("logs","member_id"));
    }



    public function performance_download($member_id,$fromemail = Null)
    {
        $logs=$this->performancePDF_data($member_id);
       
        $file_name=str_random().".pdf";
        $params = ['title' => 'Commission Summary'];

        $pdf=PDF::loadView('opposum.trunk.oposperformance',compact('logs','member_id'))->save(storage_path($file_name)); 
        //->setOption('header-center','Commission Summary')->setOption('header-font-size',20)->setOption('header-spacing',1)
        $headers = array(
              'Content-Type: application/pdf',
            );

        if($fromemail == 'ComssisonEmail'){
            return storage_path($file_name);
        }else{
            return response()->download(storage_path($file_name),$file_name,$headers)->deleteFileAfterSend(true);
        }
        
    }

}
?>
