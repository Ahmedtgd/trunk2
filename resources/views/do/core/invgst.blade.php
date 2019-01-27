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
        <?php
        //$password = $array_delivery[0]['password'];
        ?>

        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['muser_address']}}</div>--}}

        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['mline2']}}</div>--}}

        {{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
        {{--{{$array_delivery[0]['mline3']}}</div>--}}
        {{--<div class="col-sm-4 col-sm-offset-4 text-center">GST--}}
        {{--No: {{$array_delivery[0]['merchant_gst']}}</div>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--<div class="col-sm-12">--}}
        {{--<div class="row">--}}
        {{--<div class="col-sm-4"--}}
        {{--style="padding-left:0">--}}
        {{--<b>Date: </b>--}}
        {{--{{UtilityController::s_date($array_delivery[0]['orderdate'])}}</div>--}}
        {{--<!----}}
        {{--<div class="col-sm-4 text-center">GST Reg. No:--}}
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
        {{--style="padding-left:0">--}}
        {{--<b>Order ID:</b>--}}

        {{--{{IdController::nO($receipt_id)}}--}}

        {{--</div>--}}
        {{--<div class="col-sm-6 pull-right"--}}
        {{--style="padding-right:0">--}}
        {{--<b>Tax&nbsp;Invoice&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-12">--}}

        {{--<div class="col-sm-4 col-sm-offset-4 text-center"--}}
        {{--style="font-size: 14px !important;">--}}
        {{--<b>Tax Invoice</b>--}}
        {{-- {{$array_delivery[0]['merchant_name']}}   --}}

        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}
        <input type="hidden" id="mporder_id" value="{{$receipt_id}}"/>
        <div class="col-sm-12" style="padding-left:0;padding-right:0">

            <table class="table borderless">
				<tr>
					<td colspan="2"></td>
                   <td colspan="2" class="text-center">
						@if(isset($deliveryorder))
                    
                            <b>{{$array_delivery[0]['merchant_name']}}</b><br>
                            {{$array_delivery[0]['mbiz']}}<br>

                            <?php   $password = $array_delivery[0]['password']; ?>

                            {{$array_delivery[0]['muser_address']}}<br>

                            @if($array_delivery[0]['mline2'] !="" )
                                {{$array_delivery[0]['mline2']}}<br>
                            @endif

                            @if($array_delivery[0]['mline3'] !="" )
                                {{$array_delivery[0]['mline3']}}<br>
                            @endif

                            @if($array_delivery[0]['merchant_gst'] != "")
                                GST No:{{$array_delivery[0]['merchant_gst']}}<br>
                            @endif

						@endif
					</td>
					<td colspan="2" class="text-right">
						<?php 
							
							$qr = DB::table('invoiceqr')->join('qr_management','qr_management.id','=','invoiceqr.qr_management_id')
							->where('invoice_id',$array_delivery[0]['original_id'])->orderBy('invoiceqr.id','DESC')->first();
						?>
						@if(!is_null($qr))
							<img src="{{URL::to('/')}}/images/qr/invoice/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" class="pull-right" style="margin-top: -10px; margin-right: -10px;"  width="120px" />
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
                        <b>Invoice</b>
                    </td>
                    <td colspan="3" class="text-right" style="height: 50px; vertical-align: bottom">
                        <b>Invoice&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
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
                            <?php $counter =1; $sum_qty = 0;
                            $sum_amount = 0;
                            $totalDeliveryPaid=0;
                            $glob=DB::table('global')->first()->gst_rate;
							$tproducts = DB::table('ordertproduct')->where('porder_id',$receipt_id)->get();
                            ?>

                            @if(isset($tproducts))


                                @foreach($tproducts as $tproduct)
                                        <tr>
                                            <?php

                                            $prime_product = DB::table('tproduct')->where('id',$tproduct->tproduct_id)->first();
                                         //   $parent_product = DB::table('product')->where('id',$prime_product->parent_id)->first();
                                            ?>
                                            <td class="text-center">{{ $counter++ }}</td>
                                            <td class="text-center">{{ IdController::nTp($prime_product->id) }}</td>

                                            <td>{{ $prime_product->name }}</td>
                                            <td class="text-center">{{ $tproduct->quantity or 0 }}</td>
                                            <td class="text-right">

                                                <?php
                                                $op = DB::table('ordertproduct')->where('porder_id',$receipt_id)->where('tproduct_id',$prime_product->id)->first();

                                                    $delp=$op->order_delivery_price;
                                                    $opc=$op->order_price;
                                                    $tempTotal=$delp+($opc*$op->quantity);
                                                    $revenue = number_format($tempTotal/100,2);

                                                    $totalPaid=($op->quantity * $opc);
                                                    $amount = number_format($totalPaid/100,2);
                                                    $totalDeliveryPaid+=$delp;

                                                $sum_qty += $tproduct->quantity;
                                                $sum_amount += $tempTotal;

                                                // $sum_amount = number_format($sum_amount, 2, '.', '');
                                                ?>

                                                {{$currency}} {{number_format($opc/100,2)}}
                                            </td>
                                            <td class="text-right">{{$currency}} {{ $amount }}</td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>

                                            <td class="pull-left">Delivery&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-right">{{$currency}} {{number_format($delp/100,2)}}</td>
                                        </tr>
                                @endforeach
                                <tr>

                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                                    <td></td>

                                    <td></td>
										<?php
										// $aux = ($sum_amount*6)/100;
										$total = $sum_amount;

										$rawTotal = $total / (1 + ($glob / 100));
										$gstTotal = $total - $rawTotal;

										?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">

                                        <b>Total&nbsp;{{$currency}}&nbsp;{{ number_format($sum_amount/100,2) }}
                                        </b></td>
                                </tr>
                            @endif
            </table>
        </div>
        <div class="col-sm-12 text-right"
             style="padding-bottom: 20px;padding-left:0;padding-right:8px">
            <table style="float:right;text-align:right;">
                <tr>
                    <td style="padding-right: 10px">Total&nbsp;includes&nbsp;{{$gst[0]->gst_rate}}&nbsp;%GST</td>
                    <td>{{$currency}}&nbsp;{{number_format($gstTotal/100,2)}}</td>
                </tr>

                </tr>
                <tr>
                    <td style="padding-right: 10px">Items&nbsp;Total</td>
                    <td>{{$currency}}&nbsp;{{ number_format($rawTotal/100,2) }}</td>
                </tr>
            </table>
        </div>

    </div>
</div>
{{--</div>   <!---This new div close fixes the bad layout -->--}}
{{--</div><!--Begin main cotainer-->--}}
</body>
</html>