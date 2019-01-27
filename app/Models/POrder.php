<?php

namespace App\Models;

use App\SProduct;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POrder extends Model
{
    use SoftDeletes;


    protected $table = 'porder';
    //  Paul on 25 April 2017 at 8 50 pm
    protected $fillable = ['status'];
    protected $softDelete = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'orderproduct','porder_id','product_id')->withTimestamps()->withPivot(['quantity','deleted_at']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier(){
        return $this->belongsTo('App\Models\Courier');
    }

    //---Payment Method---//
    public function payment(){
        return $this->belongsTo('App\Models\Payment','payment_id');
    }

    //---User Method---//
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    //---GetSubTotalAttribute Method---//
    public function orderTotal($order){
        $total = 0;

        foreach ($order->products as $product) {
            $total += $product->pivot->quantity * $product->retail_price;
        }

        return $total;
    }

    public function address(){
        return $this->belongsTo('App\Models\Address');
    }

    public static function getTransictionsPerYear($supplier)
    {
        $sinceDate = date('Y').'-01-01 00:00:00';

        $businessTrnscInYear = POrder::select('porder.*','payment.*')
            ->join('payment','payment.id','=','porder.payment_id')
            ->where('porder.user_id',$supplier)
            ->where('porder.created_at','<=',$sinceDate)
            ->get();

        $receivable = 0;
        foreach($businessTrnscInYear as $b)
        {
            $receivable = $receivable + $b['receivable'];
        }
        return $receivable;
    }

    public static function getTransactionsCurrentMonth($supplier)
    {
        $date = date('Y-m').'-01 00:00:00';

        $businessTrnscInYear = POrder::select('porder.*','payment.*')
            ->join('payment','payment.id','=','porder.payment_id')
            ->where('porder.user_id',$supplier)
            ->where('porder.created_at','<=',$date)
            ->get();

        $receivable = 0;
        foreach($businessTrnscInYear as $b)
        {
            $receivable = $receivable + $b['receivable'];
        }
        return $receivable;
    }

    public static function getTransictionsAverage($supplier)
    {
        $station = Station::where('user_id',$supplier)->first();
        $date1 = $station['created_at'];
        if(! $date1) {
            $date1 = date('Y').'-'.date('M').'-01 00:00:00';
        }
        if($station['created_at']) {
            $date1 = date('Y-m-d H:i:s', $date1->timestamp);
        }
        $date2 = date('Y-m-d h:i:s');

        $months = POrder::countMonths($date1,$date2);

        $trancs = POrder::select('porder.*','payment.*')
            ->join('payment','payment.id','=','porder.payment_id')
            ->where('porder.user_id',$supplier)
            ->where('porder.created_at','>=',$date1)
            ->where('porder.created_at','<=',$date2)
            ->get();

        $receivable = 0;
        foreach($trancs as $t)
        {
            $receivable = $receivable + $t['receivable'];
        }

        return $receivable/$months;
    }

    public static function countMonths($date1,$date2)
    {
        $output = [];
        $time   = strtotime($date1);
        $last   = date('m-Y', strtotime($date2));

        do {
            $month = date('m-Y', $time);
            $total = date('t', $time);

            $output[] = [
                'month' => $month,
                'total' => $total,
            ];

            $time = strtotime('+1 month', $time);
        } while ($month != $last);


        return count($output);
    }

    public static function getItemsOfStation($id)
    {
        $station_product =  \DB::table('product')
            ->select('product.id as id', 'product.name as name', 'product.stock as stock', 'product.available as available', 'product.parent_id as parent_id')
            ->join('sproduct', 'product.id', '=', 'sproduct.product_id')
            ->join('stationsproduct', 'sproduct.id', '=', 'stationsproduct.sproduct_id')
            ->where('stationsproduct.station_id', '=', $id)
            ->get();

        return count($station_product);
    }

        public static function getItemsOfMerchant($id)
    {

        $merchant_product =  \DB::table('product')
            ->select('product.id as id', 'product.name as name', 'sproduct.stock as stock', 'sproduct.available as available', 'product.parent_id as parent_id')
            ->join('merchantproduct', 'product.parent_id', '=', 'merchantproduct.product_id')
            ->where('merchantproduct.merchant_id', '=', $id)
            ->get();

        return count($merchant_product);
    }

    public static function getLowItems($supplier)
    {
        $items = Station::select('stationsproduct.*')
            ->join('stationsproduct','station.id','=','stationsproduct.station_id')
            ->where('station.user_id',$supplier)
            ->get();

        $count = 0;
        foreach($items as $item)
        {
            $product = SProduct::where('id',$item['sproduct_id'])->first();
            if($product) {
                if((($product['stock']-$product['available']) / $product['stock']) * 100 < 30) {
                    $count++;
                }
            }
        }
        return $count;
    }    
	
	public static function getItemsOfmStation($id, $mid)
    {
        $sproducts = DB::table('sproduct')->join('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->join('product','sproduct.product_id','=','product.id')->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')->where('merchantproduct.merchant_id',$mid)->where('stationsproduct.station_id',$id)->select('product.id as productid', 'product.name as productname','sproduct.available as qtyleft','sproduct.stock as qtystock')->get();

        return count($sproducts);
    }

	public static function isLowItem($id,$pid)
    {
		$station = DB::table('station')->where('user_id',$id)->first();
		if(is_null($station)){
			return count(0);
		} else {
		
			$sproducts=DB::select(DB::raw("
				SELECT
				product.id as productid,
				product.photo_1 as photo_1,
				product.name as productname,
				sproduct.available as qtyleft,
				sproduct.stock as qtystock
				FROM 
				sproduct
				JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
				JOIN product on sproduct.product_id = product.id
				JOIN merchantproduct on merchantproduct.product_id =
					product.parent_id
				WHERE
				sproduct.available < (sproduct.stock*30)/100 AND
				product.id = ".$pid." AND
				stationsproduct.station_id = ".$station->id."
            "));
			
			return count($sproducts);
		}
	}
	
    public static function getmLowItems($id,$mid)
    {
        // $sproducts = DB::table('sproduct')
        // ->join('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')
        // ->join('product','sproduct.product_id','=','product.id')
        // ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
        // ->where('merchantproduct.merchant_id',$mid)
        // ->where('stationsproduct.station_id',$id)
        // ->where('sproduct.available','<','(sproduct.stock*30)/100')
        // ->select('product.id as productid', 'product.name as productname','sproduct.available as qtyleft','sproduct.stock as qtystock')
        // ->groupBy('sproduct.id')
        // ->get();
        $sproducts=DB::select(DB::raw("
            SELECT
            product.id as productid,
            product.photo_1 as photo_1,
            product.name as productname,
            sproduct.available as qtyleft,
            sproduct.stock as qtystock
            FROM 
            sproduct
            JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
            JOIN product on sproduct.product_id = product.id
            JOIN merchantproduct on merchantproduct.product_id =
                product.parent_id
            WHERE
            sproduct.available < (sproduct.stock*30)/100 AND
            merchantproduct.merchant_id = ".$mid." AND
            stationsproduct.station_id = ".$id."
            "));
        // Converted to raw query by Zurez
        return count($sproducts);
    }
	
    public static function getStationDistributorType($supplier)
    {
        $items = Station::select('stationsproduct.*')
            ->join('stationsproduct','station.id','=','stationsproduct.station_id')
            ->where('station.user_id',$supplier)
            ->get();

        $count = 0;
        foreach($items as $item)
        {
            $product = SProduct::where('id',$item['sproduct_id'])->first();
            if($product) {
				if($product['stock'] > 0){
					if((($product['stock']-$product['available']) / $product['stock']) * 100 < 30) {
						$count++;
					}
				} else {
					$count++;
				}
            }
        }
		if($count > 0){
			$count = "Active";
		} else {
			$count = "Pasive";
		}
        return $count;
    }	
	
    public static function getHighItems($supplier)
    {
        $items = Station::select('stationsproduct.*')
            ->join('stationsproduct','station.id','=','stationsproduct.station_id')
            ->where('station.user_id',$supplier)
            ->get();

        $count = 0;
        foreach($items as $item)
        {
            $product = SProduct::where('id',$item['sproduct_id'])->first();
            if($product) {
                if((($product['stock']-$product['available']) / $product['stock']) * 100 > 30) {
                    $count++;
                }
            }
        }
        return $count;
    }	

	
    public static function getmHighItems($id,$mid)
    {
        // $sproducts = DB::table('sproduct')->join('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->join('product','sproduct.product_id','=','product.id')->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')->where('merchantproduct.merchant_id',$mid)->where('stationsproduct.station_id',$id)->where('sproduct.available','>=','(sproduct.stock*30)/100')->select('product.id as productid', 'product.name as productname','sproduct.available as qtyleft','sproduct.stock as qtystock')->get();
		      $sproducts=DB::select(DB::raw("
            SELECT
            product.id as productid,
            product.photo_1 as photo_1,
            product.name as productname,
            sproduct.available as qtyleft,
            sproduct.stock as qtystock
            FROM 
            sproduct
            JOIN stationsproduct on stationsproduct.sproduct_id=sproduct.id
            JOIN product on sproduct.product_id = product.id
            JOIN merchantproduct on merchantproduct.product_id =
                product.parent_id
            WHERE
            sproduct.available >= (sproduct.stock*30)/100 AND
            merchantproduct.merchant_id = ".$mid." AND
            stationsproduct.station_id = ".$id."
            "));
        return count($sproducts);
    }
	
    public function getPrefixofID($id)
    {
        return str_pad($id,10,0,STR_PAD_LEFT);
    }

    public function getSinceDate($date)
    {
        $date1 = new DateTime($date);
        $date2 = new DateTime(Carbon::now());
        $interval = $date1->diff($date2);
        return $interval->d."d ".$interval->h."h ".$interval->m."m";
    }
}
