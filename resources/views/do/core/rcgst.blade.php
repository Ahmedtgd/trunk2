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
					<td colspan="2">
					</td>
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
						@if(!is_null($array_delivery[0]['line2']))
						{{$array_delivery[0]['line2']}}<br>
						@endif
						@if(!is_null($array_delivery[0]['line3']))
						
						{{$array_delivery[0]['line3']}}<br>
						@endif
						<b>Date: </b>
						{{UtilityController::s_date($array_delivery[0]['orderdate'])}}<br>
					</td>
					<td colspan="4">
					</td>
				</tr>
                <tr>
                    <td colspan="2" class="text-left">
                        <b>Order ID:</b>
                        {{IdController::nO($receipt_id)}}
                    </td>
                    <td class="text-center" style="font-size: 14px;">
                        <b>Tax Invoice</b>
                    </td>
                    <td colspan="3" class="text-right">
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
                                   
                                    $tempTotal=0;
                                    $opc=0;
                                    $delp=0;
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
                                <td class="text-right">{{$currency}}&nbsp;{{$amount}}</td>

                            
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

                            <b>Total&nbsp;{{$currency}}&nbsp;{{number_format($sum_amount/100,2)}}
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