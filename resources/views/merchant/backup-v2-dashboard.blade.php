@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>

    .details-control, .details-control-2 {
        cursor: pointer;
    }
    td{
        min-width: 40%;
    }
    td.details-control:after ,td.details-control-2:after {
        font-family: 'FontAwesome';
        content: "\f0da";
        color: #303030;
        font-size: 17px;
        float: right;
        padding-right: 25px;
    }
    tr.shown td.details-control:after, tr.shown td.details-control-2:after {
        content: "\f0d7";
    }
    table td.absorbing-column {
    width: 50%;
}

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }
    .panel {
    border: 0;
}

.top-margin{
    margin-top: -30px;
}
    .ct{
        text-align: center;
    }
    .rt{
        text-align: right;
    }
    table
    {
        counter-reset: Serial;
        table-layout: auto;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
                    <img src="/images/banner.png" title="banner" class="img-responsive banner">
<<<<<<< HEAD
                    {{-- <hr> --}}
=======
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b
                    <div class="col-sm-12"><h2>MERCHANT DASHBOARD</h2></div>
                    {{-- Tabbed Nav --}}
                        <div class="panel with-nav-tabs panel-default ">
                         <div class="panel-heading b">
                        <ul class="nav nav-tabs b">
                            <li class="active"><a href="#orders" data-toggle="tab">Orders</a></li>
                            <li><a href="#payment" data-toggle="tab">Payment</a></li>
                            <li><a href="#shipping" data-toggle="tab">Shipping</a></li>
                            <li><a href="#voucher" data-toggle="tab">Voucher</a></li>
                            <li><a href="#dopenwish" data-toggle="tab">Open Wish</a></li>
                            <li><a href="#dautolink" data-toggle="tab">Autolink</a></li>
                            <li><a href="#loyalty" data-toggle="tab">Loyalty Program</a></li>
                            <li><a href="#sales" data-toggle="tab">Sales Report</a></li>
                            <li><a href="#inventory" data-toggle="tab">Inventory</a></li>
                            <li><a href="#dauctions" data-toggle="tab">Auctions</a></li>

                        </ul>
                </div>

                    {{--ENDS  --}}
                    <form class="form-horizontal">
                        <div id="dashboard" class="row" class="panel-body " >
                        <div class="tab-content top-margin">
                        <div id="orderssec" class="tab-pane fade in active">
                            <div class="table-responsive col-sm-12 " >
                            <h2>Order Details</h2>

							<br>
                                <table class="table text-muted " id="product_details_table">
                                    <thead>
                                   {{--  <tr class="bg-black">
                                        <th colspan="11">Order Details</th>
                                    </tr> --}}
                                    <?php $i=1;?>
                                    <tr class="bg-black">

                                        <th class="text-center">No</th>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-center">Order Received</th>
                                        <th class="text-center">Order Executed</th>
                                        {{-- <th>SKU</th> --}}
                                        <th>Description</th>
                                        <th class="text-center">Order Total</th>

                                        {{-- <th>Delivery Order</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($orders))
                                        @foreach($orders as $p)
                                            <tr>
                                                <td class="ct">{{$i}}</td>
                                                <td class="ct"><a href="#" class="uniqporder" id="uniqporder"data="{{$p['oid']}}">{{UtilityController::s_id($p['oid'])}}</a>
                                                </td>
                                                
                                                <td class="ct">{{UtilityController::s_date($p['o_rcv'])}}</td>
                                                <td class="ct">
                                                {{UtilityController::s_date($p['o_exec'])}}
                                                {{-- {{$p['o_exec']}}</td> --}}
                                                {{-- <td>{{$p['sku']}}</td> --}}
                                                <td class="ct">{{$p['description'] or ''}}</td>
                                                <td class="rt">{{$currentCurrency}} {{$p['total']}}</td>
                                                {{-- <td><a href="{{ url('deliveryorder/'.$p['oid']) }}">Delivery Order</a></t></td> --}}
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
     
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="clearfix"> </div> --}}
                            </div>
                            {{-- Payment --}}
                            <div class="tab-pane fade " id="payment">
                                                            <div class="table-responsive col-sm-12 ">
                                <table class="table text-muted counter_table" id="payment_detail_products">
                                <h2>Payment Details</h2>

								<br>

                                    <thead>
                                    <tr class="bg-info">
                                        <th colspan="3">Payment Details</th>
                                        <th colspan="3">Commission Receivable</th>
                                        <th colspan="5">Payment Gateway</th>
                                    </tr>
                                 {{--    <tr class="bg-info">
                                    <th colspan="8">Product Details</th>
                                    <th colspan="2">Time Detail</th>
                                    <th></th>
                                    </tr> --}}
                                    <tr class="bg-info">
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        {{-- <th>Product ID</th> --}}
                                        <th>Sales</th>
                                        <th>%</th>
                                        <th>{{$currentCurrency}}</th>
                                        <th>%</th>
                                        <th>{{$currentCurrency}}</th>
                                        <th>Receivable</th>
                                        <th>Due Date</th>
                                        <th>Date Received</th>
                                        {{-- <th>Note</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($orders))

                                    @foreach($orders as $order )
                                        <tr>
                                            <td class="ct"></td>
                                            <td class="ct">
                                            {{UtilityController::s_date($order['payment']->created_at)}}
                                            </td>
                                            <td class="ct">{{UtilityController::s_id($order['oid'])}}</td>
                                            {{-- <td>{{$order['sku']}}</td> --}}
                                            <td class="rt">{{$order['payment']->receivable}}</td>
                                            <td class="ct">{{(($order['comm']* $order['payment']->receivable)/$order['payment']->receivable)*100}}%</td>
                                            <td>{{($order['comm']* $order['payment']->receivable)}}</td>
                                            <td>{{$bank}}%</td>
                                            <?php $b_com= ($bank/100)*$order['payment']->receivable;?>
                                            <td>{{$b_com}}</td>
                                            <td>{{$order['payment']->receivable-$b_com}}</td>
                                            <td></td>
                                            <td></td>
                                            {{-- <td>{{$order['payment']->note}}</td> --}}
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>

                                </table>

                            </div>

                            </div>
                            {{-- payment ends --}}
                            {{-- Product Ends --}}
                            <div class="tab-pane fade" id="shipping">
                            <div class="table-responsive col-sm-12">
                                <table class="table text-muted counter_table" id="shipping_details_table">
                                <h2>Shipping Details</h2>
                                    <br>
                                    <thead>
                                    <tr class="bg-move">
                                        <th colspan="10">Shipping Details</th>
                                    </tr>
                                    <tr class="bg-move">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Merchant ID</th>
                                        <th>External Shipping ID</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Days since order</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($shipping))

                                    @foreach($shipping as $courier )
                                        <tr>
                                            <td></td>
                                            <td>{{$courier->porder_id}}</td>
                                            <td>Merchant ID</td>
                                            <td>S{{UtilityController::s_id($courier->shipping_id)}}</td>
                                            <td>{{ucfirst($courier->name)}}</td>
                                            <td>Status</td>
                                            <td>
                                            <?php
                                                    $now = time(); // or your date as well
                                                     $your_date = strtotime($courier->created_at);
                                                     $datediff = $now - $your_date;
                                                     $days=floor($datediff/(60*60*24));
                                            ?>
                                            {{$days}} days</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>

                            </div>

                            </div>
                            {{--  --}}
                            {{-- Voucher --}}
                            <div class="tab-pane fade" id="voucher">
                                <div class="table-responsive col-sm-12">
                                <h2>Voucher Details</h2>
                                <br>
                                    <table class="table " id="voucher_detail_table">
                                        <thead>
{{--                                         <tr class="bg-success">
                                            <th colspan="11">Voucher Details</th>
                                        </tr> --}}
                                        <tr class="bg-success">
                                            <th>No</th>
                                            <th>Order ID</th>
                                            {{--<th>Product ID</th>--}}
                                            <th>Order Received</th>
                                            <th>Expiry Date</th>
                                            <th>Status</th>
                                            {{--<th>Description</th>--}}
                                            {{--<th>Quantity</th>--}}
                                            {{--<th>Price</th>--}}
                                            <th>User ID(Buyer)</th>
                                            <th>Order Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(! empty($voucher_orders))

                                        @foreach($voucher_orders as $order )
                                            <tr>
                                                    {{ ($i = 0) ? '': '' }}
                                                    @foreach($order->products as $pro)
                                                    {{$i++}}
                                                    data-id-{{$i}}="{{$pro->id}}"
                                                    data-name-{{$i}}="{{$pro->name}}"
                                                    data-des-{{$i}}="{{$pro->category->description}}"
                                                    data-qty-{{$i}}="{{$pro->pivot->quantity}}"
                                                    data-price-{{$i}}="{{$pro->retail_price}}"
                                                    data-total-{{$i}}="{{$pro->retail_price*$pro->pivot->quantity}}"
                                                    @endforeach
                                                    data-last="{{$i}}"
                                            >
                                                <td>1</td>
                                                <td>{{$order->id}}</td>
                                                <td>{{$order->created_at}}</td>
                                                <td>{{$order->delivery_tstamp}}</td>
                                                <td>{{$order->payment->status}}</td>
                                                <td>{{$order->user->first_name.' '.$order->user->last_name}}</td>
                                                <td>{{$order->orderTotal($order)}}</td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                </div>


                                <div class="table-responsive col-sm-12 ">
                                    <h2>Voucher Payment Details</h2>

                                        <br>
                                    <table class="table text-muted counter_table" id="voucher_payment_detail">
                                        <thead>
                                  {{--       <tr class="bg-success">
                                            <th colspan="10"></th>
                                        </tr> --}}
                                        <tr class="bg-success">
                                            <th>No</th>
                                            <th>Order ID</th>
                                            <th>Receivable</th>
                                            <th>Commission</th>
                                            <th>%</th>
                                            <th>Day since Consignment</th>
                                            <th>Note</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(! empty($voucher_orders))
                                        @foreach($voucher_orders as $order )
                                            <tr>
                                                <td></td>
                                                <td>{{$order->id}}</td>
                                                <td>S{{$order->payment->receivable}}</td>
                                                <td>S{{$order->payment->osmall_commission}}</td>
                                                <td></td>
                                                <td>S{{$order->payment->consignment}}</td>
                                                <td>{{$order->payment->note}}</td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div> 
                            {{-- Voucher Ends --}}
                            <div class="tab-pane fade" id="dopenwish">
                                <div class="table-responsive col-sm-12 ">
                                    <h2>OpenWish</h2>

                                    <br>
                                    <table class="table text-muted counter_table" id="open_wish_table">

                                        <thead>
                                      {{--   <tr class="bg-pink">
                                            <th colspan="14">Open Wish Database</th>
                                        </tr> --}}
                                        <tr class="bg-pink">
                                            <th colspan="5">Product Details</th>
                                            <th colspan="2">Time Detail</th>
                                            <th colspan="4">Payment Detail</th>
                                        </tr>
                                        <tr class="bg-pink">
                                            <th>No</th>
                                            <th>OpenWish ID</th>
                                       {{--      <th>UserID (Buyer)</th>
                                            <th>User</th> --}}
                                            <th>Product ID</th>
                                            <th>Date Started</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Price</th>
                                            <th>Time</th>
                                            <th>Time Left</th>
                                            <th>Pledge</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th>Merchant Help</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($openwish))
                                                <?php $i=1; ?>
                                                @foreach($openwish as $o)
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{UtilityController::s_id($o->id)}}</td>
                                                        {{-- <td>{{$o->user_id}}</td> --}}
                                                        {{-- <td>{{$o->first_name}} {{$o->last_name}}</td> --}}
                                                        <td>{{UtilityController::s_id($o->product_id)}}</td>
                                                        <td>{{UtilityController::s_date($o->created_at)}}</td>

                                                        {{-- <td>Description????</td> --}}
                                                        <td class="absorbing-column">{{$currentCurrency}} {{$o->retail_price}}</td>
                                                        <td>{{$o->duration}} Days</td>
                                                        {{-- Time Left --}}
                                                        <?php
                                                        //Convert to date
                                                        $now = new DateTime();
                                                        $future_date = new DateTime($o->created_at);
                                                        $interval = $future_date->diff($now);
                                                        ?>
                                                        {{--  --}}
                                                        <td>
                                                        {{$interval->format("%a d %h h %i m")}}
                                                        </td>
                                                        <td>{{$currentCurrency}} {{$o->pledged_amt}}</td>
                                                        <td>{{$currentCurrency}} {{$o->retail_price-$o->pledged_amt}}</td>
                                                        <td>{{ucfirst($o->status)}}</td>
                                                        <td>{{$currentCurrency}} What here?</td>
                                                 <?php $i++;?>
                                                @endforeach

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Openwish ends --}}
                            <div class="tab-pane fade" id="dautolink">
                                <div class="col-sm-12">
                                     <h2>AutoLink</h2>
                            {{-- <hr> --}}
                                    <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <a class="btn btn-darkgreen" href="#" style="float:left;"><i
                                            class="bt glyphicon glyphicon-link" style="padding: 6px 0"></i> AutoLink</a>
                                <div class="input-group input-group-sm btn btn-darkgreen">
                                    <input type="text" placeholder="Tech_" class="form-control">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>
                                      </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <a class="btn btn-darkgreen" href="#" style="float:left;"><i
                                            class="bt glyphicon glyphicon-link" style="padding: 6px 0"></i> Others:</a>
                                <div class="input-group input-group-sm btn btn-darkgreen">
                                        <input type="text" placeholder="fill in the blank" class="form-control">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>
                                      </span>
                                </div>
                                <div class="clearfix margin-top"></div>
                                <select multiple class="select-darkgreen  form-control" style="font-family: FontAwesome">
                                    <option class="active" onclick="$(this).remove();">&#xf00d; Architect</option>
                                    <option onclick="$(this).remove();">&#xf00d; Interior Designer</option>
                                </select>
                            </div>
                            <div class="clearfix margin-top"></div>
                            <div class="col-sm-3">
                                <label><em>Target:</em></label>
                                <select multiple class="select-darkgreen form-control">
                                    <option>Architect</option>
                                    <option>Developer</option>
                                    <option class="active">Interior Designer</option>
                                </select>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-xs-12 margin-top">
                                <label>Target O-Shop:</label>
                            </div>
                            <div class="col-sm-3">
                                <label>Category</label>
                                <select multiple class="select-darkgreen  form-control">
                                    <option class="active">Architect</option>
                                    <option>Developer</option>
                                    <option>Interior Designer</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Sub Category</label>
                                <select multiple class="select-darkgreen form-control">
                                    <option>Architect</option>
                                    <option class="active">Developer</option>
                                    <option>Interior Designer</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>&nbsp;</label>
                                <select multiple class="select-darkgreen form-control"  style="font-family: FontAwesome">
                                    <option onclick="$(this).remove();">&#xf00d; Architect</option>
                                    <option onclick="$(this).remove();">&#xf00d; Developer</option>
                                </select>
                            </div>

                            <div class="clearfix"></div>
							<hr>

                        </div>
                                </div>
                                {{-- Form --}}
                                <hr>
                                <div class="table-responsive col-sm-12">

                                   <h2>AutoLink</h2>
									<br>

                                    <table class="table text-muted counter_table " id="auto_link_table">
                                        <thead>
                                        {{-- <tr class="bg-darkgreen"> --}}
                                            {{-- <th>AutoLink</th> --}}
                                        {{--     <th colspan="4">initiator</th>
                                            <th colspan="4">Responder</th> --}}
                                        {{-- </tr> --}}
                                        <tr class="bg-darkgreen"> 
                                            <th>NO</th>
                                            <th>ID</th>
                                            <th>Mode</th>
                                            <th>Initiator ID</th>
                                            <th>Responder ID</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Target</th>
                                            <th>Linked Since</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Approval</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;?>
                                        @if(isset($autoLinks))
                                                            <?php $j=1;?>
                                            @foreach($autoLinks as $link)
                                                <tr>
                                                    <td>{{$j}}</td>
                                                    <td>{{UtilityController::s_id($link['id'])}}</td>
                                                    <td>{{ucfirst($link['mode'])}}</td>
                                                    <td>{{UtilityController::s_id($link['iid'])}}</td>
                                                    <td>{{UtilityController::s_id($link['rid'])}}</td>
                                                    <td>{{ucfirst($link['cat'])}}</td>
                                                    <td>{{ucfirst($link['subcat'])}}</td>
                                                    <td>Target What here?</td>
                                                    <td>{{UtilityController::s_date($link['l_s'])}}</td>
                                                    <td>{{ucfirst($link['status'])}}</td>
                                                    <td>Remarks</td>
                                                    <td>Status</td>

                                                    <td>
                                                                              <span id= "action_area">
                                @if($link['status']=='request') 
                                <button type="button" class="btn btn-primary btn-success" id="accept" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-ok"></span> </button>
                                <button type="button" class="btn btn-primary btn-warning" id="req_delete" data-value=
                                "{{$link['id']}}"><span class="glyphicon glyphicon-trash"></span> </button>
                                @else
                                <button type= "button" class="btn btn-primary btn-danger" id="link_delete" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-remove"></span> </button>
                                @endif
                            </td>
                            </span>
                                                    </td>
                                        
                                                </tr>

                                                <?php $j++; ?>
                                            @endforeach
                                        @endif
                                        </tbody>
                            </table>      
                        
                        
                        </div>
                        </div>
                        {{-- Autolink --}}
                        <div id="dauctions" class="tab-pane fade">
                        <div class="col-sm-12">
                                <div id="auctions" class="row">
                                    <div class="col-xs-12">

									<!--
                                        <a href="#" class="btn btn-success col-sm-2"><i class="fa fa-legal"></i> Auctions</a>
									-->
									<h2>Auction</h2>
									<br>
                                    </div>
                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4>
                                                    <div class="clearfix"> </div>
                                                </div>
                                                <h1 class="large-text">100</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img class="img-responsive" src="/images/radio.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
                                                <h1 class="large-text">200</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img style="width: 75%;" class="img-responsive" src="/images/iphone6-gold-select-2014.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
                                                <h1 class="large-text">10</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>

                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img class="img-responsive" src="/images/watchCblack.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                            </div>
                    {{--     </div>
                        </div> --}}
                        {{-- Auction Ends --}}

                        <div id="loyalty" class="row tab-pane fade">
                        <div class="col-sm-12">
<<<<<<< HEAD
                           
                            {{-- <hr> --}}
                                <div class="col-xs-12">
                                    <h2>Loyalty Program</h2>
=======
                            <h2>Loyalty Program</h2>
                            <br>
                              {{--   <div class="col-xs-12">
                                    <a class="btn btn-orange col-sm-3" href="#"><i class="fa fa-volume-up"></i> Loyalty Programme</a>
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b
                                </div>  <div class="clearfix"></div>


                                <div class="col-sm-5">
                                    <div class="form-group">


                                        <label class="col-sm-12 control-label">Let your customers know you are Care with them!</label>
                                        <div class="col-sm-12">

                                            <select data-style="btn-darkgreen" class="selectpicker form-control show-menu-arrow">
                                                <option>Standared Promotion Sentences</option>
                                                <option>50% Store Wide Discount!</option>
                                                <option>Something you can't miss it!</option>
                                                <option>10% DM discount on products only!</option>
                                                <option>Our chef are prepared Something Special!</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 text-right margin-top">
                                            <input type="submit" value="Send" class="btn btn-green btn-sm">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-sm-offset-1">

                                    <label class="control-label">Tell Customers about your promotion!</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" placeholder="...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-green" type="button">Send</button>
                                              </span>
                                    </div>
                                    <span class="help-block">Tell Customers about your promotion!</span>
                                </div>

                                <div class="clearfix"></div>
                                </div>

                        </div>
                      
                        <div id="sales" class="row tab-pane fade">
                        <div class="col-sm-12">
                            <div class="col-xs-12 margin-top">
<<<<<<< HEA
D                                {{-- <a class="btn btn-sale col-sm-3" href="#"><i class="fa fa-line-chart"></i> Sales Report</a> --}}
                                <h2>Sales Report</h2>
=======
								<!--
                                <a class="btn btn-sale col-sm-3" href="#"><i class="fa fa-line-chart"></i> Sales Report</a>
								-->
								<h2>Sales Report</h2>
								<br>
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b
                            </div>  <div class="clearfix"></div>

                            <div class="col-xs-12 margin-top">
                                <script>

                                    $(function () {
                                        $('#container').highcharts({
                                            title: {
                                                text: 'Monthly Sale Report',
                                                x: -20 //center
                                            },
                                            subtitle: {
                                                text: '2015',
                                                x: -20
                                            },
                                            xAxis: {
                                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Sales'
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#718DA3'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ''
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            series: [{
                                                name: '',
                                                data: [
                                                    @if(! empty($all))
                                                        @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                            {!! $val !!},
                                                        @endforeach
                                                    @endif
                                                    ]
                                            }]
                                        });
                                    });

                                </script>
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                            <div class="col-sm-7">
                                <div class="table-responsive">
                                    <table class="table table-striped ">
                                        <tr>
                                            <th nowrap>Custom Date Range</th>
                                            <th>From</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepicker" class="date form-control bg-sale"></th>
                                            <th>To</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepickerr" class="date form-control bg-sale"></th>
                                        </tr>
                                        <tr>
                                            <td>Since</td>
                                            <td><span id="dateSince"></span></td>
                                            @if(! empty($currency)) 
                                            <td colspan="3">{{$currency->code}} <span id="amountSince"></span></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Year to Date</td>
                                            <td></td>
                                            @if(! empty($currency))
                                            <td colspan="3">{{$currency->code}} <span id="amountBetween"></span></td>
                                            @endif
                                        </tr>

                                    </table>


                                </div>

                                <div class="faqs col-sm-8 row">
                                    <h4>Years</h4>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2015</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2015,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs1" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div id="faqs1" class="collapse in" style="" aria-expanded="true">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>

                                    <div class="faqs-head">
                                        <span class="col-xs-3">2016</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2016,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs2" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class="collapse" id="faqs2" aria-expanded="false" style="height: 0px;">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2016,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2017</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2017,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs3" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs3" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))@foreach(amountCountMonthly(2017,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2018</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2018,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs4" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs4" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2018,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>



                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-1" >

                                <div style="border:1px solid #718DA3">
                                    <div class="col-xs-6" >
                                        <p>Max</p>
                                        <p>Min</p>
                                        <p>Average/Day</p>
                                        <p>Average/Deal</p>
                                        <p>Viewed</p>
                                    </div>
                             {{--        <div class="col-xs-6 bg-sale " style="text-align: right;">
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMaxVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMinVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getAvgDaySale(2015, amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all_pro)){{Helper::getAvgDeal($all_pro)}}@endif</p>
                                        <p>@if(! empty($all_pro)){{Helper::getTotalView($all_pro)}}@endif</p>

                                    </div>
                                    <div class="clearfix"></div>
 --}}
                                </div>
                            </div>
                            </div>
                        </div>
<<<<<<< HEAD
                        {{-- <hr> --}}
=======
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b

                        <div id="inventory" class="row tabe-pane fade">
                        <div class="col-sm-12">
                            <div class="col-xs-12 margin-top">
<<<<<<< HEAD
                                {{-- <a class="btn btn-gold col-sm-3" href="#"><i class="fa fa-line-chart"></i>Inventory Report & Analysis</a> --}}
                                <h2>Inventory Report</h2>
=======
							<!--
                                <a class="btn btn-gold col-sm-3" href="#"><i class="fa fa-line-chart"></i>Inventory Report & Analysis</a>
							-->
							<h2>Inventory Report & Analysis</h2>
							<br>
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b
                            </div>  <div class="clearfix"></div>

                            <div class="table-responsive col-sm-12">
                                <table class="table text-muted counter_table" id="lower_product_detail_table">
                                    <thead>
                                    <tr class="bg-gold">
                                        <th colspan="10">Products Details</th>
                                        <th class="bg-lightgold" colspan="2">Wholesale</th>
                                        <th class="bg-lightgold" colspan="5">&nbsp;</th>
                                    </tr>

                                    <tr class="bg-gold"> 
                                        <th style="vertical-align:middle">No</th>
                                        {{-- <th style="vertical-align:middle">SKU</th> --}}
                                        <th style="vertical-align:middle">Name</th>
                                        <th style="vertical-align:middle">Category</th>
                                        <th style="vertical-align:middle">SubCategory</th>
                                        <th style="vertical-align:middle">Description</th>
                                        <th style="vertical-align:middle">Quantity</th>
                                        <th style="vertical-align:middle">Retail Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Original Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Discount%</th>

                                        <th class="bg-lightgold">Price</th>
                                        <th class="bg-lightgold">Unit</th>

                                        <th class="bg-lightgold">Viewed</th>
                                        <th class="bg-lightgold">Bought</th>
                                        <th class="bg-lightgold">Type</th>
                                        <th class="bg-lightgold">Source</th>
                                        <th class="bg-lightgold">Dealers</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(! empty($all_pro))
                                        @foreach($all_pro as $product)
                                        <tr>
                                            <?php 
                                                $discount=($product->original_price-$product->retail_price)/100;
                                            ?>
                                            <td></td>
                                            <td>{{$product->name}}</td>
                                            <td>{{ucfirst($product->category)}}</td>
                                            <td>{{ucfirst($product->subcat)}}</td>
                                            <td>{{ucfirst($product->description)}}</td>
                                            <td>{{$product->available}}</td>
                                            <td>{{$product->retail_price}}</td>
                                            <td>{{$product->original_price}}</td>
                                            <td>{{$discount}}</td>
                                            <td>What Here?</td>
                                            <td>What Here?</td>
                                            <td>What Here?</td>
                                            <td>What Here?</td>
                                        </tr>
                                        @endforeach
                                          @endif

                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>

                        </div>


                    </form>


                </div>
            </div>
            </div>
        </div><!--End main cotainer-->
    </section>


<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


<script>
    (function(){

        function format ( tr ) {

            var j = tr.attr('data-last');

            var table='<table class="table child_table" cellspacing="0" width="100%">';
            table+='<thead>';
            table+='<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
            table+='</thead>';
            table+='<tbody>';

            for (i = 1;i<=j;i++){
                var id = tr.attr('data-id-'+i);
                var name = tr.attr('data-name-'+i);
                var qty = tr.attr('data-qty-'+i);
                var price = tr.attr('data-price-'+i);
                var des = tr.attr('data-des-'+i);
                var total = tr.attr('data-total-'+i);
                table+='<tr><td>'+id+'</td><td>'+name+'</td><td>'+des+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>';
            }

            table+='</tbody>';
            table+='</table>';

            return table;
        }

        var table = $('#product_details_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className": 'details-control',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('#product_details_table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#shipping_details_table').DataTable();
        $('#lower_product_detail_table').DataTable();
        $('#payment_detail_products').DataTable();
        $('#voucher_payment_detail').DataTable();
        $('#open_wish_table').DataTable();
        $('#auto_link_table').DataTable(
             {
                // scrollX:false
             }
            );
    
        // $('#auto_link_table_2').DataTable();


        var vtable = $('#voucher_detail_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className":      'details-control-2',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('td.details-control-2').on('click', function () {
            console.log('clicked');
            var tr = $(this).closest('tr');
            var row = vtable.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#datetimepicker , #datetimepickerr').on('change',function(){
            var date1 = $('#datetimepicker').val();
            var date2 = $('#datetimepickerr').val();

            $('#dateSince').html(date1);

            $.ajax({
               url: '{{url('/merchant/calc-sale')}}',
               data: {'date1': date1, 'date2' : date2},
               headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
               error: function() {

               },
               success: function(response) {
                  $('#amountSince').html(response.payment);
                  $('#amountBetween').html(response.paymentSince);
               },
               type: 'POST'
            });
        });
    })();
</script>
<<<<<<< HEAD

=======
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
>>>>>>> 882f39a749fd3fc135bcfaaa5463d27c14fa258b
                <script>
$(document).ready(function(){
    $('.uniqporder').click(function(){
        
        // event.preventDefault();
        var porder_id= $(this).attr('data');
        var url= JS_BASE_URL+"/order/product/"+porder_id;
        newwindow = window.open(url, 'Order Details', 'height=500,width=800');
        if (window.focus) {newwindow.focus()}
        setTimeout(function () {newwindow.close();}, 30000);
});
});

</script>

@stop
