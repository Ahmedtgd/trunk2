<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/lato.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
</head>
<body>
<style type="text/css">
    body {
        font-family: 'Lato', sans-serif;
        font-size: 12px;
    }

    .table-nonfluid {
        width: 57% !important;
    }

    .borderless td, .borderless th {
        border: none !important;
    }
</style>

<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
<div class="container"><!--Begin main cotainer-->
    <div class="row">

        <div class="col-sm-11 col-sm-offset-1">
            <div class="col-sm-12">
                {{-- <div class="row">
                    <h1 class='title'>Invoice</h1>
                 <hr>
            </div> --}}
            </div>
            <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
            @if(isset($deliveryorder))

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                <b>{{$array_delivery[0]['oshop_name']}}</b></div>
                            <div class="col-sm-3"></div>

                        </div>
                        <div class="row">
                            {{-- Buyer --}}
                            <div class="col-sm-4"></div>
                            {{--B ENDS  --}}
                            <div class="col-sm-4">
                                <p style="text-align: center;">
                                    {{$array_delivery[0]['merchant_name']}}
                                    <br>
                                    {{$array_delivery[0]['mbiz']}}
                                    <br>
                                    @if($array_delivery[0]['oshop_address_id'] == 0)
                                        @if($array_delivery[0]['user_address'] != "")
                                            {{$array_delivery[0]['user_address']}}
                                            <br>
                                        @endif
                                        @if($array_delivery[0]['line2'] != "")
                                            {{$array_delivery[0]['line2']}}
                                            <br>
                                        @endif
                                        @if($array_delivery[0]['line3'] != "")
                                            {{$array_delivery[0]['line3']}}
                                        @endif
                                    @else

                                        @if($array_delivery[0]['muser_address'] != "")
                                            {{$array_delivery[0]['muser_address']}}
                                            <br>
                                        @endif
                                        @if($array_delivery[0]['mline2'] != "")
                                            {{$array_delivery[0]['mline2']}}
                                            <br>
                                        @endif
                                        @if($array_delivery[0]['mline3'] != "")
                                            {{$array_delivery[0]['mline3']}}
                                        @endif


                                    @endif

                                </p>
                            </div>
							<div class="col-sm-4">
									<?php 
										
										$qr = DB::table('deliveryinvoiceqr')->join('qr_management','qr_management.id','=','deliveryinvoiceqr.qr_management_id')
										->where('deliveryinvoice_id',$array_delivery[0]['original_id'])->orderBy('deliveryinvoiceqr.id','DESC')->first();
									?>
									@if(!is_null($qr))
										<img src="{{URL::to('/')}}/images/qr/deliveryinvoice/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" style="margin-top: -120px;" class="pull-right" width="120px" />
									@endif									
							</div>
                        </div>
                        @endif
                    </div>
                    {{-- EXTRA DIV --}}
                    <div class="row">
                        {{-- <div class="col-sm-5"></div> --}}


                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4" style="padding-right: 23px !important; padding-left: 23px !important;">

                                @if($buyer->name != ""){{$buyer->name}}
                                <br>
                                @endif
                                @if($buyer->line1 != "")
                                    {{$buyer->line1}}
                                    <br>
                                @endif
                                @if($buyer->line2 != "")
                                    {{$buyer->line2}}
                                    <br>
                                @endif
                                @if($buyer->line3 != "")
                                    {{$buyer->line3}}
                                @endif
                                <br>
                                Malaysia - {{$buyer->postcode}}

                            </div>
                        </div>
                        {{--Paul on 11 April 2017 at 8 45pm--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-sm-4 col-sm-offset-4 text-center"--}}
                        {{--style="font-size: 20px;"><br>--}}
                        {{--<b>Delivery Order</b></div>--}}
                        {{--</div>--}}
                        {{--Ends Here--}}
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4" style="padding-right: 23px !important; padding-left: 23px !important;">
                                <b>Date: </b>
                                {{UtilityController::s_date($array_delivery[0]['orderdate'])}}</div>
                        </div>
                    </div>
                    {{--Paul on 11 April 2017 at 8 45pm--}}
                    {{--<div class="col-sm-12">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-sm-6" style="padding-bottom: 10px;">--}}
                    {{--<b>Order ID:</b>--}}
                    {{--{{IdController::nO($deliveryorderid) }}--}}
                    {{--<span class="pull-right"><b>Receipt&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}</span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--Ends Here--}}

                    <div class="col-sm-12">

                            <table class="table">
                                <tr>
                                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit">
                                        <b>Delivery ID:</b>{{IdController::nO($deliveryorderid) }}
                                    </td>
                                    <td colspan="2" class="text-center" style="font-size: 20px; vertical-align: bottom">
                                        <b>Invoice</b>
                                    </td>
                                    <td colspan="4" class="text-right" style="height: 50px; vertical-align: inherit">
                                        <b>Tax&nbsp;Invoice&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;background:#666666;color:#ffffff;">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Product&nbsp;ID</th>
                                    <th>Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Unit&nbsp;Price</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right"></th>
                                    {{-- Paul on 07 April 2017 at 11PM --}}
                                    <th class="text-right">
                                        
                                    </th>
                                </tr>
                                <?php $counter = 1; $sum_qty = 0;
                                $sum_amount = 0;
                                $glob = DB::table('global')->first()->gst_rate;
								$tproducts = DB::table('ordertproduct')->where('porder_id',$deliveryorderid)->get();
                                ?>

                                @if(isset($tproducts))
                                    @foreach($tproducts as $product)
                                            <tr>
                                                <?php
                                                $prime_product = DB::table('tproduct')->where('id', $product->tproduct_id)->first();
                                                //$parent_product = DB::table('product')->where('id', $prime_product->parent_id)->first();
                                                ?>
                                                <td class="text-center">{{ $counter++ }}</td>
                                                <td class="text-center">{{ IdController::nTp($product->tproduct_id) }}</td>
                                                <td>{{ $prime_product->name }}</td>
                                                <td class="text-center">{{ $product->quantity or 0 }}</td>
                                                <td class="text-right">

                                                    <?php
                                                    //$op = DB::table('orderproduct')->where('porder_id', $deliveryorderid)->where('product_id', $prime_product->id)->first();

                                                  //  if (!is_null($op)) {


                                                        $delp = $product->order_delivery_price;
                                                        $opc = $product->order_price;
                                                        $tempTotal = $delp + ($opc * $product->quantity);
                                                        $revenue = number_format($tempTotal / 100, 2);

                                                        $totalPaid = ($product->quantity * $opc);
                                                        $amount = number_format($totalPaid / 100, 2);
                                                /*    } else {
                                                        $revenue = number_format(($parent_product->retail_price / 100), 2, ".", "");
                                                        $amount = number_format((($product->quantity * $parent_product->retail_price) / 100), 2, ".", "");
                                                    }*/
                                                    $sum_qty += $product->quantity;
                                                    $sum_amount += $tempTotal;
                                                    // $sum_amount = number_format($sum_amount, 2, '.', '');
                                                    ?>
                                                    {{$currency}} {{number_format($opc/100,2)}}
                                                </td>
                                                <td class="text-right">{{$currency}} {{ number_format($totalPaid/100,2)}}</td>
                                                <?php

                                                $status = DB::table('deliveryinvoicetproduct')->
                                                where('tproduct_id', $prime_product->id)->
                                                where('di_id', $deliveryorder->id)->first();


                                                $checked = "";
                                                $disabled = "";
                                                if ($status == "b-collected") {
                                                    $checked = "checked";
                                                    $disabled = "disabled";
                                                }
                                                ?>
                                                <td>	
                                                </td>

                                            </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-left">Delivery</td>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-right">{{$currency}}
                                                &nbsp;{{number_format($delp/100,2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                        <?php
                                        // $aux = ($sum_amount*6)/100;
                                        $total = $sum_amount;
                                        $rawTotal = $total / (1 + ($glob / 100));
                                        $gstTotal = $total - $rawTotal;
                                        ?>
                                        <td class="pull-right">
                                            <b>Total&nbsp;{{$currency}}&nbsp;{{number_format($sum_amount/100,2) }}
                                            </b></td>

                                    </tr>
                                @endif
                            </table>
                    </div>


            </div>
        </div>

    </div>
    <style>
        .table > tbody > tr > td {
            border-top: 0px solid #ddd;
        }
    </style>


</body>
</html>