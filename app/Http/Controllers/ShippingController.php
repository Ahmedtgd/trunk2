<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Country;
use App\Models\Courier;
use App\Models\Merchant;
use App\Models\POrder;
use App\Models\SalesStaff;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Requests;

class ShippingController extends Controller
{
    public function getShippingMasterDetails()
    {
        return view('admin.shipping-details');
    }

    public function getShippingWorldData()
    {
        $orders = POrder::select('porder.*','courier.shipping_id','merchant.id as merchant_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->get();

        return $orders;
        // return view('admin.analysis-sales',compact('orders'));
    }

    public function getOrderDetails(Request $request)
    {
        $order = POrder::select('porder.*','courier.shipping_id','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->where('porder.id','=',$request->get('orderId'))
            ->first();

        return view('admin.order-details-modal',compact('order'));
    }

    public function getShippingCountryDetails()
    {
        $countries = Country::all();
    // return view('admin.shipping-country',compact('countries'));
        return $countries;
    }

    public function getShippingMerchantDetails()
    {
        $merchants = Merchant::all();
        // return view('admin.shippingByMerchant',compact('merchants'));
        return $merchants;
    }

    public function getShippingMerchantConsultantDetails()
    {
        $merchantsConsultants = SalesStaff::select('users.*')
            ->join('users','users.id','=','sales_staff.user_id')
            ->where('sales_staff.type','=','mct')
            ->get();

        // return view('admin.shippingByMerchantConsultant',compact('merchantsConsultants'));
        return $merchantsConsultants;
    }

    public function getShippingBuyerDetails()
    {
        $buyers = Buyer::select('users.*')
            ->join('users','users.id','=','buyer.user_id')
            ->get();

        // return view('admin.shippingByBuyers',compact('buyers'));
        return $buyers;
    }

    public function getShippingCourierDetails()
    {
        $couriers = Courier::all();

        // return view('admin.shippingByCouriers',compact('couriers'));
        return $couriers;
    }

    public function getSalesByCountry(Request $request)
    {
        $countryCode = $request->get('countryCode');

        $orders = POrder::select('porder.*','courier.shipping_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->join('address','address.id','=','porder.address_id')
            ->join('city','city.id','=','address.city_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('city.country_code','=',$countryCode)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getSalesByState(Request $request)
    {
        $stateCode = $request->get('stateCode');

        $orders = POrder::select('porder.*','courier.shipping_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->join('address','address.id','=','porder.address_id')
            ->join('city','city.id','=','address.city_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('city.state_code','=',$stateCode)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getSalesByMerchantConsultant(Request $request)
    {
        $merchantId = $request->get('merchantId');

        $orders = POrder::select('porder.*','courier.shipping_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('merchant.id',$merchantId)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getSalesByMerchantID(Request $request)
    {
        $merchantId = $request->get('merchantId');

        $orders = POrder::select('porder.*','courier.shipping_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('merchantproduct.merchant_id',$merchantId)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getSalesByBuyer(Request $request)
    {
        $buyerId = $request->get('buyerId');

        $orders = POrder::select('porder.*','courier.shipping_id','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('porder.user_id','=',$buyerId)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getSalesByCourier(Request $request)
    {
        $courierId = $request->get('courierId');

        $orders = POrder::select('porder.*','courier.shipping_id','payment.status as payment_status','courier.description','courier.name as shipping_company','payment.created_at as date_payment','payment.receivable as payment_receivable','merchant.id as merchant_id')
            ->leftJoin('courier','porder.courier_id','=','courier.id')
            ->leftJoin('payment','porder.payment_id','=','payment.id')
            ->leftJoin('orderproduct','porder.id','=','orderproduct.porder_id')
            ->leftJoin('merchantproduct','orderproduct.product_id','=','merchantproduct.product_id')
            ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
            ->join('product','product.id','=','orderproduct.product_id')
            ->where('courier.id','=',$courierId)
            ->get();

        // return view('admin.analysis-sales',compact('orders'));
        return $orders;
    }

    public function getStatesByCountry(Request $request)
    {
        $countryCode = $request->get('countryCode');

        $states = State::where('country_code',$countryCode)->get();

        // return view('admin.shipping-states-dropdown',compact('states'));
        return $states;
    }

    public function getmerchantDetails(Request $request)
    {
        $merchant = Merchant::find($request->get('merchantId'));

        return view('admin.merchant-details-modal',compact('merchant'));
    }


}
