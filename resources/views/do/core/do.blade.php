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
                    <h1 class='title'>Delivery Order</h1>
                 <hr>
            </div> --}}
            </div>
            <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
            @if(isset($deliveryorder))
                @if($deliveryorder->employee != null)
                    <!-- <div class="col-sm-3">{{ $deliveryorder->employee->users->station->first()->id or '' }}</div> -->
                    @else
                    @endif

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
							<div class="col-sm-4" style="padding-right: 23px !important; padding-left: 23px !important;"> 
									<?php 
										
										$qr = DB::table('deliveryorderqr')->join('qr_management','qr_management.id','=','deliveryorderqr.qr_management_id')
										->where('deliveryorder_id',$array_delivery[0]['original_id'])->orderBy('deliveryorderqr.id','DESC')->first();
									?>
									@if(!is_null($qr))
										<img src="{{URL::to('/')}}/images/qr/deliveryorder/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" style="margin-top: -120px;" class="pull-right"  width="120px" />
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
                                <td colspan="2" class="text-left" style="height: 50px; vertical-align: bottom">
                                    <b>Order ID:</b>
                                    {{IdController::nO($deliveryorderid) }}
                                </td>
                                <td class="text-center" style="font-size: 20px; vertical-align: bottom">
                                    <b>Delivery Order</b>
                                </td>
                                <td colspan="3" class="text-right" style="height: 50px; vertical-align: bottom">
                                    <b>Receipt&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
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

                            </tr>
                            <?php $counter = 1; $sum_qty = 0;
                            $sum_amount = 0;

                            ?>

                            @if(isset($orderproduct))
                                @foreach($orderproduct as $op)
                                    <tr>
                                        <?php
                                        $prime_product = DB::table('product')->where('id', $op->product_id)->first();
                                        $parent_product = DB::table('product')->where('id', $prime_product->parent_id)->first();
                                        ?>
                                        <td class="text-center">{{ $counter++ }}</td>
                                        <td class="text-center">{{ IdController::nP($op->product_id) }}</td>
                                        <td>{{ $parent_product->name }}</td>
                                        <td class="text-center">{{ $op->quantity or 0 }}</td>
                                        <td class="text-right">

                                            <?php
                                            // $op = DB::table('orderproduct')->where('porder_id', $deliveryorderid)->where('product_id', $prime_product->id)->first();

                                            if (!is_null($op)) {


                                                $delp = $op->order_delivery_price;
                                                $opc = $op->order_price;
                                                $tempTotal = $delp + ($opc * $op->quantity);
                                                $revenue = number_format($tempTotal / 100, 2);

                                                $totalPaid = ($op->quantity * $opc);
                                                $amount = number_format($totalPaid / 100, 2);
                                            } else {
                                                $revenue = number_format(($parent_product->retail_price / 100), 2, ".", "");
                                                $amount = number_format((($op->quantity * $parent_product->retail_price) / 100), 2, ".", "");
                                            }
                                            $sum_qty += $op->quantity;
                                            $sum_amount += $tempTotal;
                                            // $sum_amount = number_format($sum_amount, 2, '.', '');
                                            ?>
                                            {{$currency}}&nbsp;{{number_format($opc/100,2)}}
                                        </td>
                                        <td class="text-right">{{$currency}}
                                            &nbsp;{{ number_format($totalPaid/100,2)}}</td>

                                        <td>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="pull-left">Delivery</td>
                                        <td></td>
                                        <td></td>
                                        <td class="pull-right">{{$currency}}&nbsp;{{number_format($delp/100,2)}}</td>
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