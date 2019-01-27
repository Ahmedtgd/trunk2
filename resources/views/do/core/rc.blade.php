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
        <div class="col-xs-12">

        </div>
    </div>

    <div class="col-sm-12 form-horizontal"
         style="margin: 2% 0;padding-left:0;padding-right:0">

        {{--@if(isset($deliveryorder))--}}

        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--<b>{{$array_delivery[0]['merchant_name']}}</b>--}}
        {{--<br>--}}
        {{--{{$array_delivery[0]['mbiz']}}--}}
        {{--<br></div>--}}


        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['muser_address']}}</div>--}}

        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['mline2']}}</div>--}}

        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['mline3']}}</div>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-4"--}}
        {{--style="padding-left:0">--}}
        {{--<b>Date: </b>--}}
        {{--{{UtilityController::s_date($array_delivery[0]['orderdate'])}}</div>--}}
        {{--<!--<div class="col-sm-4 text-center">GST Reg. No:--}}
        {{--{{$array_delivery[0]['merchant_gst']}}</div>--}}
        {{---->--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-4"--}}
        {{--style="padding-left:0">--}}
        {{--{{$array_delivery[0]['user_name']}}<br>--}}
        {{--{{$array_delivery[0]['user_address']}}<br>--}}
        {{--{{$array_delivery[0]['line2']}}<br>--}}
        {{--{{$array_delivery[0]['line3']}}<br>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-6"--}}
        {{--style="padding-bottom: 10px;padding-left:0">--}}
        {{--<div class="" style="">--}}
        {{--<b>Order ID:</b>--}}
        {{--{{IdController::nO($receipt_id)}}--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-6 pull-right"--}}
        {{--style="padding-right:0">--}}
        {{--<p align="right">--}}
        {{--<b>Receipt&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}--}}
        {{--</p>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-4 col-sm-offset-4 text-center"--}}
        {{--style="font-size: 14px !important;">--}}
        {{--<b>Receipt</b></div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        <input type="hidden" id="mporder_id" value="{{$receipt_id}}"/>
        <div class="col-sm-12" style="padding-left:0;padding-right:0">

            <table class="table borderless">
				<tr>
				    <td colspan="2">
                        <b>Date: </b>
                        {{UtilityController::s_date($array_delivery[0]['orderdate'])}}<br>
                        {{$array_delivery[0]['user_name']}}<br>
                        {{$array_delivery[0]['user_address']}}<br>
                        {{$array_delivery[0]['line2']}}<br>
                        {{$array_delivery[0]['line3']}}<br>
                    </td>
					<td colspan="2" class="text-center">
						@if(isset($deliveryorder))
							<b>{{$array_delivery[0]['merchant_name']}}</b><br>
                            {{$array_delivery[0]['mbiz']}}<br>
                            {{$array_delivery[0]['muser_address']}}<br>

                            @if($array_delivery[0]['mline2'] !="" )
                                {{$array_delivery[0]['mline2']}}<br>
                            @endif

                            @if($array_delivery[0]['mline3'] !="" )
                                {{$array_delivery[0]['mline3']}}<br>
                            @endif

                            @if($array_delivery[0]['merchant_gst'] != "")
                                GST Reg. No:{{$array_delivery[0]['merchant_gst']}}<br>
                            @endif
						@endif
					</td>
					 <td colspan="2">
						<?php 
							
							$qr = DB::table('receiptqr')->join('qr_management','qr_management.id','=','receiptqr.qr_management_id')
							->where('receipt_id',$array_delivery[0]['original_id'])->orderBy('receiptqr.id','DESC')->first();
						?>
						@if(!is_null($qr))
							<img src="{{URL::to('/')}}/images/qr/receipt/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" class="pull-right" style="margin-top: -10px; margin-right: -10px;"  width="120px" />
						@endif	
					</td>					
				</tr>
				<tr>
				    <td colspan="2">
                        {{$array_delivery[0]['user_name']}}<br>
                        {{$array_delivery[0]['user_address']}}<br>
                        {{$array_delivery[0]['line2']}}<br>
                        {{$array_delivery[0]['line3']}}<br>
                        <b>Date: </b>
                        {{UtilityController::s_date($array_delivery[0]['orderdate'])}}<br>
                    </td>
					<td colspan="4">
                    </td>
				</tr>
                <tr>
                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: bottom">
                        <b>Order ID:</b>
                        {{IdController::nO($receipt_id)}}
                    </td>
                    <td class="text-center" style="font-size: 14px; vertical-align: bottom">
                        <b>Receipt</b>
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
                </tr>
                <?php $counter = 1; $sum_qty = 0;
                $sum_amount = 0;
                $totalDeliveryPaid = 0;
                $glob = DB::table('global')->first()->gst_rate;
                ?>

                @if(isset($orderproduct))


                    
                        @foreach($orderproduct as $op)
                            <tr>
                                <?php

                                $prime_product = DB::table('product')->where('id', $op->product_id)->first();
                                $parent_product = DB::table('product')->where('id', $prime_product->parent_id)->first();
                                ?>
                                <td class="text-center">{{ $counter++ }}</td>
                                <td class="text-center">{{ IdController::nP($parent_product->id) }}</td>

                                <td>{{ $parent_product->name }}</td>
                                <td class="text-center">{{ $op->quantity or 0 }}</td>
                                <td class="text-right">

                                    <?php
                                    $op = DB::table('orderproduct')->where('porder_id', $receipt_id)->where('product_id', $prime_product->id)->first();

                                    if (!is_null($op)) {
                                        $delp = $op->order_delivery_price;
                                        $opc = $op->order_price;
                                        $tempTotal = $delp + ($opc * $op->quantity);
                                        $revenue = number_format($tempTotal / 100, 2);

                                        $totalPaid = ($op->quantity * $opc);
                                        $amount = number_format($totalPaid / 100, 2);
                                        $totalDeliveryPaid += $delp;

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
                                <td class="text-right">{{$currency}} {{ $amount }}</td>

                            <!-- <td><input type="checkbox" value="{{ $op->id }}"></td> -->
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>

                                <td class="pull-left">Delivery&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td class="pull-right">{{$currency}}&nbsp;{{number_format($delp/100,2)}}</td>
                            </tr>
                        @endforeach
                   
                    <tr>

                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                        <td></td>

                        <td></td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">

                            <b>Total&nbsp;{{$currency}}&nbsp;{{ number_format($sum_amount/100,2)}}
                            </b></td>
                    </tr>
                @endif
            </table>
        </div>


    </div>
    {{-- <div class="row">
    <div class="col-sm-4">
    <img src="{{$qrFilePath}}">
    </div>
    </div> --}}
</div><!--Begin main cotainer-->
<style>
    .table > tbody > tr > td {
        border-top: 0px solid #ddd;
    }
</style>


</body>
</html>
