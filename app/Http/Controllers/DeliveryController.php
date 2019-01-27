<?php

namespace App\Http\Controllers;

use DB;
use App\Classes\Delivery;
use App\Models\Buyer;
use App\Models\Country;
use App\Models\Courier;
use App\Models\Merchant;
use App\Models\POrder;
use App\Models\SalesStaff;
use App\Models\State;
use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
use App\Http\Requests;

class DeliveryController extends Controller {

    public function getDeliveryMasterDetails() {
        return view('admin.delivery_details');
    }

    public function getDeliveryData() {
//        $orders = POrder::select('porder.*','users.first_name as user_name')
//            ->leftJoin('users','porder.user_id','=','users.id')
//            ->get();
//
//        return $orders;

        $orders = POrder::select('porder.*', 'courier.shipping_id', 
                'merchant.id as merchant_id', 'payment.status as payment_status', 
                'courier.description', 'courier.name as shipping_company', 
                'payment.created_at as date_payment', 'payment.receivable as payment_receivable', 
                'users.first_name as user_name', 'merchant.company_name as merchant_name',
                'merchant.office_no',DB::raw('CONCAT_WS(address.line1,address.line2,address.line3,address.line4) as merchant_address'),
                'city.name as sender_city','ci.name as user_city','users.mobile_no',
                DB::raw('CONCAT_WS(ad.line1,ad.line2,ad.line3,ad.line4) as user_address'))
                ->leftJoin('courier', 'porder.courier_id', '=', 'courier.id')
                ->leftJoin('payment', 'porder.payment_id', '=', 'payment.id')
                ->leftJoin('orderproduct', 'porder.id', '=', 'orderproduct.porder_id')
                ->leftJoin('omerchantproduct as merchantproduct', function($join) {
					 $join->on('orderproduct.product_id', '=', 'merchantproduct.product_id')
					 ->where('orderproduct.created_at','>=','merchantproduct.created_at')
					 ->orWhere(function ($query) {
						$query->whereNull('merchantproduct.deleted_at')
							  ->where('merchantproduct.deleted_at', '>', 'orderproduct.created_at');
					});
				})
                ->leftJoin('users', 'porder.user_id', '=', 'users.id')
                ->join('merchant', 'merchantproduct.merchant_id', '=', 'merchant.id')
                ->leftJoin('address', 'merchant.address_id', '=', 'address.id')
                ->leftJoin('city', 'address.city_id', '=', 'city.id')
                ->leftJoin('address as ad', 'porder.address_id', '=', 'ad.id')
                ->leftJoin('city as ci', 'ad.city_id', '=', 'ci.id')
                ->join('product', 'product.id', '=', 'orderproduct.product_id')
                ->get();

        return $orders;
        // return view('admin.analysis-sales',compact('orders'));
    }

    public function getOrderDetails(Request $request) {
        $order = POrder::select('porder.*', 'courier.shipping_id', 'courier.description', 'courier.name as shipping_company', 'payment.created_at as date_payment', 'payment.receivable as payment_receivable')
                ->leftJoin('courier', 'porder.courier_id', '=', 'courier.id')
                ->leftJoin('payment', 'porder.payment_id', '=', 'payment.id')
                ->where('porder.id', '=', $request->get('orderId'))
                ->first();

        return view('admin.order-details-modal', compact('order'));
    }

    public function getShippingMerchantDetails() {
        $merchants = Merchant::all();
        // return view('admin.shippingByMerchant',compact('merchants'));
        return $merchants;
    }

    public function getShippingBuyerDetails() {
        $buyers = Buyer::select('users.*')
                ->join('users', 'users.id', '=', 'buyer.user_id')
                ->get();

        // return view('admin.shippingByBuyers',compact('buyers'));
        return $buyers;
    }

    public function getShippingCourierDetails() {
        $couriers = Courier::all();

        // return view('admin.shippingByCouriers',compact('couriers'));
        return $couriers;
    }

    public function getmerchantDetails(Request $request) {
        $merchant = Merchant::find($request->get('merchantId'));

        return view('admin.merchant-details-modal', compact('merchant'));
    }

	public function get_delpricebyid(Request $req)
    {
		$del_calculation = new Delivery;
		$product = DB::table('product')->where('id',$req->pid)->first();
        $qty=$req->qty;
		$delivery_pricec = 0;
		$merchantp = 0;
		$mproduct = DB::table('merchantproduct')->where('product_id',$req->pid)->first();
		if(!is_null($mproduct)){
			$merchantp = $mproduct->merchant_id;
		}
		if(!is_null($product)){
            // Check if delivery waiver is applied or not.
            $product_price=UtilityController::realPrice($product->id);
            $total_price=$product_price*$qty;
            if ($total_price >= $product->free_delivery_with_purchase_amt) {
                $delivery_pricec=0;
            }else{
                $delivery_pricec = $del_calculation->calculate_price($product->weight * $req->qty,$product->length * $req->qty,$product->width * $req->qty,$product->height * $req->qty, $product->del_option,$merchantp);
            }

			
		}
		
		return $delivery_pricec/100;
	}	
}
