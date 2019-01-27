<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderProduct;
use App\Models\Employee;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\OrderProduct;
use App\Models\POrder;
use App\Models\Product;
use App\Models\User;
use App\Models\Wholesale;
use App\SOrder;
use App\SProduct;
use GuzzleHttp\Message\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Support\Facades\DB;

class AdminDeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_orders = DeliveryOrder::paginate(10);
        $users = DB::table('users')->get();

        $users_fullname = array();
        foreach($users as $user) {
            $users_fullname[$user->id] = $user->first_name . " " . $user->last_name;
        }
        $porders = POrder::all();
       return view('admin.deliveryOrders',['delivery_orders'=>$delivery_orders,'usersfullname'=>$users_fullname,'porders'=>$porders]);
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
        $order = DeliveryOrder::create($request->all());
        //return redirect('admin/deliveryorder');
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show_po_details($id)
    {
        $order_product = OrderProduct::where('porder_id','=', $id)->firstOrFail();
        $merchant_product = MerchantProduct::find($order_product->product_id);
        $merchant = Merchant::find($merchant_product->merchant_id);
        $merchant_address = Address::find($merchant->id);
        $delivery_order_products = DeliveryOrderProduct::where('do_id','=',$id)->get();
        $sorder = SOrder::where('porder_id','=',$id)->firstOrFail();
        $porder = POrder::find($id);
        $station = Station::where('user_id', '=', $porder->user_id)->firstOrFail();
        $station_address = Address::find($station->address_id);
        $products = [];
        foreach($delivery_order_products as $delivery_order_product){
            $products[$delivery_order_product->id] = Product::find($delivery_order_product->product_id);
        }

        $delivery_order_details = [
            'merchant_id'               =>      $merchant->id,
            'merchant_name'             =>      $merchant->company_name,
            'merchant_address'          =>      [
                                                    'line1'     =>      $merchant_address->line1,
                                                    'line2'     =>      $merchant_address->line2,
                                                    'line3'     =>      $merchant_address->line3,
                                                    'line4'     =>      $merchant_address->line4,
                                                    'postcode'  =>      $merchant_address->postcode
                                                ],
            'station_address'          =>       [
                                                     'line1'    =>      $station_address->line1,
                                                     'line2'    =>      $station_address->line2,
                                                     'line3'    =>      $station_address->line3,
                                                     'line4'    =>      $station_address->line4,
                                                     'postcode' =>      $station_address->postcode
                                                ],
            'station_id'                =>      $station->id,
            'station_name'              =>      $station->station_name,
            'delivery_order_products'   =>      $delivery_order_products,
            'products'                  =>      $products,
            'qty'                       =>      $sorder->order_qty
        ];
        return response()->json($delivery_order_details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $order = DeliveryOrder::find($id);
        //return $id;

        return response()->json($order);
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
        $order = DeliveryOrder::find($id);
        //$order->order = $request->order;
        $order->porder_id = $request->porder_id;
        $order->employee_id = $request->employee_id;
        $order->status = $request->status;
        $order->save();
        $user_full_name = $order->employee->users['first_name']." " . $order->employee->users['last_name'];
        $order['userfullname'] = $user_full_name;
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $order = DeliveryOrder::destroy($id);

    }
}
