<?php

namespace App\Classes;

/**
* ALl methods for PlatyPOS module

*/
use DB;
use Log;
use Carbon;
use App\Http\Controllers\UtilityController;
use App\Classes\Firebase;
class PlatyPOS 
{
	public $merchant;

	private $location_id;
	private $mode;

	public function __construct($location_id)
	{
		$this->set_merchant($location_id);
	}

	public function set_merchant($location_id)
	{
		try {
			$fairlocation=DB::table("fairlocation")
			->where("id",$location_id)
			->first();

			$this->merchant=DB::table("merchant")
			->where("user_id",$fairlocation->user_id)
			->whereNull("deleted_at")
			->select("id","user_id")
			->first();
			;
			
		} catch (\Exception $e) {
			Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
		}
	}

	public function staffs()
	{
		try {
			$company_id=DB::table("company")
			->where("owner_user_id")
			->whereNull("deleted_at")
			->first();
			
		} catch (\Exception $e) {
			Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
		}
	}

	
	public function  menu($location_id)
	{
		/*quantity is not product's quantity*/
		$query="
			SELECT 
				c.name as category_name,
				c.id as category_id,
				s.id as subcategory_id,
				s.name as subcategory_name,
				p.name as product_name,
				p.id as product_id,
				p.thumb_photo as product_image,
				
				0 as quantity
				FROM 
				product p 

				JOIN category c on c.id=p.category_id
				LEFT JOIN subcat_level_1 s on s.id=p.subcat_id
				LEFT JOIN locationproduct l on l.product_id=p.id
				
				WHERE 

				p.status='active'
				AND p.deleted_at IS NULL
				AND l.deleted_at IS NULL
				AND p.type='platypos'

				GROUP BY p.id
				/*AND l.id=$location_id*/
				
				
		";
		$data=DB::select(DB::raw($query));

		foreach ($data as $product) {
			/*Get special*/
			$specials=DB::table("plat_productspecial")
			->join("plat_special","plat_special.id","=","plat_productspecial.special_id")
			->join("q1def","q1def.id","=","plat_special.q1def_id")
			->where("plat_productspecial.product_id",$product->product_id)
			->select("plat_special.id as special_id","plat_special.name as special_name","q1def.unit as special_unit",DB::raw("0 as quantity"))
			->get();
			$product->specials=$specials;
			$product->product_image=asset('images/product/'.$product->product_id.
			'/thumb/'.$product->product_image);
		}
		return $data;
	}

	public function submenu($category_id)
	{
		# code...
	}

	public function items($subcategory_id)
	{
		# code...
	}

	public function specials($product_id)
	{
		# code...
	}

	//-----------------------------------------
	// Created by Zurez
	//-----------------------------------------
	
	public function tables($location_id=null)
	{
		$ret=array();
		$ret["status"]="failure";
		
		try{
			$table="opos_ftype";
			$data=DB::table($table)
			->leftJoin("opos_tabletxn","opos_tabletxn.ftype_id","=","opos_ftype.id")
			->where($table.".ftype","table")		
			->whereNull($table.".deleted_at")
			//->where("opos_tabletxn.status","active")
			->orderBy("opos_tabletxn.created_at","DESC")
			->select("opos_ftype.*","opos_tabletxn.status as txnstatus")
			->get();
	
			
			$ret["status"]="success";
			$ret["data"]=$data;
		}
		catch(\Exception $e){
			$ret["short_message"]=$e->getMessage();
			Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
		}
		return response()->json($ret);
	}

	public function transaction($r)
	{
		switch ($r->action) {
			case 'start_transaction':
				# code...
				return $this->start_transaction($r);
				break;
			case 'end_transaction':
				# code...
				break;
			default:
				# code...
				break;
		}
	}

	public function create_receipt()
	{
		$data=[
			"updated_at"=>Carbon::now(),
			"created_at"=>Carbon::now()
		];
		return DB::table("opos_receipt")->insertGetId($data);
	}
	public function start_transaction($r)
	{
		$ftype_id=$r->ftype_id;
		$receipt_id=$this->create_receipt();
		$location_id=$r->location_id;
		Log::debug("Location ID PLATY ".$location_id);
		$data=[
			 "ftype_id"=>$r->ftype_id,
			 "receipt_id"=>$receipt_id,
			"updated_at"=>Carbon::now(),
			"created_at"=>Carbon::now(),
			"checkin_tstamp"=>Carbon::now()
		];
		DB::table("opos_tabletxn")->insert($data);
			/*Send Firebase*/
		$data=[
			"action_type"=>"platypos_tableupdateorder",
			"ftype_ids"=>[$r->ftype_id]

		];
		/*Needs to be handled by a job ~ Zurez*/
		$f= new Firebase();
		$f->set_title("Table has order")
		->tokens("staff_location",$location_id)
		->set_data($data)
		->send();
		Log::debug((array)$f);
		return $receipt_id;
	}
	

	public function add_products($r)
	{
		
		$ftype_id=$r->ftype_id;

		$receipt_id=$this->active_receipt_id($ftype_id);
		if (empty($receipt_id)) {
			$receipt_id=$this->start_transaction($r);
		}
		$dishes=$r->menu;
		
		/*foreach ($dishes as $dish) {*/
		for ($i=0; $i < sizeof($dishes); $i++) { 
			$dish=$dishes[$i];
		
			if ($dish["quantity"]>0) {
				$price=UtilityController::realPrice($dish["product_id"]);
				Log::debug("Price of ".$dish['product_id']." ".$price);
				$rdata=[
					"receipt_id"=>$receipt_id,
					"product_id"=>$dish["product_id"],
					"price"=>$price,
					"quantity"=>$dish["quantity"],
					"updated_at"=>Carbon::now()
				];
				
				/*Check if record exists*/
				$does_exists=DB::table("opos_receiptproduct")
				->where("receipt_id",$receipt_id)
				->where("product_id",$dish["product_id"])
				->first();
				if (!empty($does_exists)) {
					# code...
					DB::table("opos_receiptproduct")
					->where("receipt_id",$receipt_id)
					->where("product_id",$dish["product_id"])
					->update($rdata);
					$rp_id=$does_exists->id;
				}else{
					$rdata["created_at"]=Carbon::now();
					$rp_id=DB::table("opos_receiptproduct")->insertGetId($rdata);
				}
				

				$specials=$dish["specials"];
				foreach ($specials as $special) {
					# code...
					$quantity=$special["quantity"];
					
					if ($quantity!=0) {
						$type="more";
						if ($quantity<0) {
							# code...
							$type="less";
						}
						$sdata=[
						"receiptproduct_id"=>$rp_id,
						"special_id"=>$special["special_id"],
						"type"=>$type,
						"quantity"=>$quantity,
						"updated_at"=>Carbon::now(),
						"created_at"=>Carbon::now()
						];
						DB::table("opos_receiptproductspecial")->insert($sdata);
					}
				}
			}
			
		}
		return response()->json(["status"=>"success","short_message"=>"Dishes added successfully"]);
	}

	public function active_receipt_id($ftype_id,$location_id=NULL)
	{
		# code...
		return DB::table("opos_tabletxn")
		->where("ftype_id",$ftype_id)
		->whereNull("checkout_tstamp")
		->where("status","active")
		->pluck("receipt_id")
		;
	}

	public function kitchen_dishes($location_id=NULL)
	{
		/*Get all active orders.*/
		$query='
		SELECT
		SUM(rp.quantity) as total,
		SUM(rp.quantity) as quantity,
		0 as cooking,
		CASE 
		WHEN rp.delivered IS NULL THEN 0
		ELSE rp.delivered 
		END as delivered,
		rp.status,
		p.name as product_name,
		rp.id,
		p.thumb_photo as product_image,
		p.id as product_id
		FROM 
		opos_receipt r
		JOIN opos_tabletxn ott on ott.receipt_id=r.id
		JOIN opos_receiptproduct rp on rp.receipt_id=r.id
		JOIN product p on rp.product_id=p.id


		WHERE 

		r.status="active"
		AND ott.status="active"
		AND rp.status IN ("pending","active","partialcooking","cooking")
		AND  r.deleted_at IS NULL
		GROUP BY p.id

		';
		$dishes=DB::select(DB::raw($query));
		Log::debug($dishes);
		/*Get special*/
		foreach ($dishes as $dish) {
			# code...
			$specials=DB::table("opos_receiptproductspecial")
			->where("receiptproduct_id",$dish->id)
			->get();
			$dish->specials=$specials;
			$dish->product_image=asset('images/product/'.$dish->product_id.
			'/thumb/'.$dish->product_image);

		}

		return $dishes;
	}

	public function customer_order($r,$location_id=NULL)
	{
		$ftype_id=$r->ftype_id;
		$receipt_id=$this->active_receipt_id($ftype_id);
		Log::debug([$ftype_id,$receipt_id]);
		$dishes=DB::table("opos_receiptproduct")
		->join("product","product.id","=","opos_receiptproduct.product_id")
		->where("opos_receiptproduct.receipt_id",$receipt_id)
		->whereNull("opos_receiptproduct.deleted_at")
		->select("opos_receiptproduct.*","product.name as product_name",
			"product.id as product_id","product.thumb_photo as product_image"
		)
		->get();
		foreach ($dishes as $dish) {
			# code...
			$specials=DB::table("opos_receiptproductspecial")
			->join("plat_special","opos_receiptproductspecial.special_id","=","plat_special.id")
			->where("opos_receiptproductspecial.receiptproduct_id",$dish->id)
			->select("opos_receiptproductspecial.*","plat_special.name as special_name")
			->get();
			$dish->specials=$specials;
			$dish->product_image=asset('images/product/'.$dish->product_id.
			'/thumb/'.$dish->product_image);
		}
		return $dishes;
	}

	public function update_dish_status($receiptproduct_id,$newstatus)
	{
		DB::table("opos_receiptproduct")
		->where("id",$receiptproduct_id)
		->update([
			"updated_at"=>Carbon::now(),
			"status"=>$newstatus
		]);
		/*Run Firebase Command here*/
		/*$firebase=new Firebase();
		return $firebase->new_firecommand_out($r);*/
		/*Up*/
	}

	public function distribution_logic($product_id,$quantity)
	{
		$active_orders=DB::table("opos_receiptproduct")
		->where("product_id",$product_id)
		->whereIn("status",["active","pending","partialcooking","partialoutfordelivery"])
		->orderBy("created_at","ASC")
		->get();
		$newstatus="";
		
		foreach ($active_orders as $order) {
			$current_status=$order->status;
			switch ($current_status) {

				case 'active':
					# code...
					$newstatus="cooking";
					break;
				case 'cooking':
					# code...
					$newstatus="outfordelivery";
					break;

				default:
					# code...
					$newstatus="cooking";
					break;
			}
			
			if ($order->quantity>$order->delivered) {
				$required=$order->quantity-$order->delivered;
				Log::debug([$required]);
				if ($quantity>=$required) {
					$delivered=$required;
					$quantity-=$delivered;

				}elseif ($quantity<$required) {
					$delivered=$quantity;
					$quantity=0;
					$newstatus="partialcooking";
					
				}
				

			}else{
				continue;
			}
			
			$update=[
			 "updated_at"=>Carbon::now(),
			 "status"=>$newstatus
			];
			if ($newstatus=="cooking" or $newstatus=="partialcooking") {
				# code...
				$update["delivered"]=$delivered+$order->delivered;
			}
			Log::debug($update);
			DB::table("opos_receiptproduct")->update($update);
			if ($quantity==0) {
				break;
			}
		}
		Log::debug($newstatus);
		$status="success";
		return compact('newstatus','delivered','status');

	}

	public function kitchen_cooking($r)
	{

		$ret=$this->distribution_logic($r->product_id,$r->quantity);
		return response()->json($ret);
	}

	public function end_cooking($r)
	{

		$update=[
			"updated_at"=>Carbon::now()
		];
		$product_id=$r->product_id;
		$location_id=$r->location_id;
		$orders_to_be_updated=[];
		$active_orders=DB::table("opos_receiptproduct")
		->whereIn("status",['partialcooking','cooking'])
		->where("product_id",$product_id)
		->get();
		foreach ($active_orders as $order) {
			$status="outfordelivery";
			if ($order->status=="partialcooking") {
				# 
				$status="partialoutfordelivery";
			}
			$update["status"]=$status;
			DB::table("opos_receiptproduct")
			->where("id",$order->id)
			->update($update);
			/*Get ftype*/
			$ftype_id=DB::table("opos_tabletxn")
			->where("receipt_id",$order->receipt_id)
			->pluck("ftype_id");
			array_push($orders_to_be_updated,$ftype_id);
		}
		/*Send Firebase*/
		$data=[
			"action_type"=>"platypos_tableupdatepickup",
			"ftype_ids"=>$orders_to_be_updated

		];
		/*Needs to be handled by a job ~ Zurez*/
		try {
			$f= new Firebase();
			$f->set_title("Food ready for delivery")
			->tokens("staff_location",$location_id)
			->set_data($data)
			->send();
		} catch (\Exception $e) {
			
		}

		return response()->json(["status"=>"success"]);

	}

	public function customer_order_deliver($r)
	{
		# code...
		$product_id=$r->product_id;
		$active_receipt_id=$this->active_receipt_id($r->ftype_id);
		$rp=DB::table("opos_receiptproduct")
		->where("receipt_id",$active_receipt_id)
		->where("product_id",$product_id)
		->first();
		$status="delivered";
		if ($rp->delivered<$rp->quantity) {
			# code...
			$status="partialdelivered";
		}
		$update=[
			"updated_at"=>Carbon::now(),
			"status"=>$status
		];
		DB::table("opos_receiptproduct")
		->where("id",$rp->id)
		->update($update);
	}

	public function linkedproducts($r)
	{
		
		$receipt_id=$this->active_receipt_id($r->ftype_id);
		$query="
					SELECT 
					p.id as product_id,
					p.name,
					p.thumb_photo,
					rp.quantity,
					rp.price,
                    rp.discount,
					rp.actual_discounted_amt as discount_amt
					
					FROM opos_receiptproduct rp
					JOIN opos_receipt r on r.id=rp.receipt_id
				
					
					JOIN product p on p.id=rp.product_id

					WHERE rp.deleted_at IS NULL
					AND r.status = 'active'
					AND p.deleted_at IS NULL
					AND rp.receipt_id=$receipt_id 
			
				
				";
		$data=DB::select(DB::raw($query));
		$status="success";
		return response()->json(compact('data','status','receipt_id'));
	}

	public function tables1()
	{
		return DB::table("opos_ftype")
            ->leftJoin("opos_tabletxn","opos_tabletxn.ftype_id","=","opos_ftype.id")
            ->whereNull("opos_ftype.deleted_at")
            ->where("opos_ftype.ftype",$type)
            ->select("opos_ftype.*","opos_tabletxn.status as txnstatus")
            ->orderBy('opos_ftype.fnumber','ASC')->get();
	}

	public function receipt_no($r)
    {
    	$ret=1;
    	$terminal_id=$r->terminal_id;
    	$old_receipt_number=DB::table("opos_terminal")
    	->where("id",$terminal_id)
    	->pluck("receipt_no");
    	if (!empty($old_receipt_number)) {
    		$ret=$old_receipt_number+1;
    	}
    	Log::info("New receipt no for terminal id ".$terminal_id." is ".$ret);
    	DB::table("opos_terminal")
    	->where("id",$terminal_id)
    	->update([
    		"receipt_no"=>$ret,
    		"updated_at"=>Carbon::now()
    	]);
    	return $ret;
    }
    public function handle_payment($receipt_id)
    {

  
        
        try{
            $table="opos_receipt";
            $payment_type="cash";
            if (!empty($r->creditcard_no) && $r->creditcard_no!=0 && $r->creditcard_no!="0" ) {
                # code...
                $payment_type="creditcard";
            }
		

            $receipt=DB::table('opos_receipt')->where("id",$receipt_id)->first();
           
           
            if (empty($receipt)) {
                $ret["short_message"]="Receipt is not valid";
                return response()->json($ret);
            }
            /*Cash*/
        
            $cash_received=$r->cash_received;
            $receipt_no=$this->receipt_no($r);
                
            $servicecharge_id=DB::table("opos_servicecharge")
            ->select("id")
            ->where("value","=",!empty($r->service_charges)?$r->service_charges:0)
            ->first();
            $servicecharge_id=!empty($servicecharge_id->id)?$servicecharge_id->id:"";

            $update_data=[
                "terminal_id"=>$r->terminal_id,
                "updated_at"=>Carbon::now(),
                "receipt_no"=>$receipt_no,
                'cash_received'=>$cash_received,
                'cash_10k'=>$r->cash_10000,
                'cash_1k'=>$r->cash_1000,
                'cash_100'=>$r->cash_100,
                'cash_50'=>$r->cash_50,
		        'cash_20'=>$r->cash_20,
                'cash_10'=>$r->cash_10,
                'cash_5'=>$r->cash_5,
                'cash_2'=>$r->cash_2,
                'cash_1'=>$r->cash_1,
                'cents_1'=>$r->cents_1,
                'cents_5'=>$r->cents_5,
                'cents_10'=>$r->cents_10,
                'cents_20'=>$r->cents_20,
                'cents_50'=>$r->cents_50,
                'creditcard_no'=>$r->creditcard_no,
                'payment_type'=>$payment_type,
                "servicecharge_id"=>$servicecharge_id,
                'points'=>$r->points,
                'status'=>'completed'
            ];
            
   	  $data=DB::table($table)
            ->where("{$table}.id","=",$r->receipt_id)
            ->update($update_data);
            
     
			Log::debug('***** Update data *****');
			Log::debug($update_data);
            $ret["status"]="success";
            $ret["data"]=$data;

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
	public function end_transaction($r)
	{
		$receipt_id=$this->active_receipt_id($r->ftype_id);
		$r->receipt_id=$receipt_id;
		$txn=[
		"updated_at"=>Carbon::now(),
		"checkout_tstamp"=>Carbon::now(),
		"status"=>"completed"
		];
		DB::table("opos_tabletxn")
		->where("receipt_id",$receipt_id)
		->where("ftype_id",$r->ftype_id)
		->update($txn);
		$this->handle_payment($receipt_id);
		return response()->json(["data"=>compact("receipt_id")]);
		
	}
}
