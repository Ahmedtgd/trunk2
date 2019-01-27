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

    .table-nonfluid {
        width: 57% !important;
    }
	
	@media(min-width: 1201px){
		.bcspacing{
			letter-spacing: 10px;
		}
	}
	@media(min-width: 1000px) and (max-width: 1200px){
		.bcspacing{
			letter-spacing: 7px;
		}
	}
	@media(min-width: 768px) and (max-width: 999px){
		.bcspacing{
			letter-spacing: 4px;
		}
	}
	@media(min-width: 680px) and (max-width: 767px){
		.bcspacing{
			letter-spacing:25px;
		}
	}
	@media(min-width: 600px) and (max-width: 679px){
		.bcspacing{
			letter-spacing:20px;
		}
	}
	@media(min-width: 550px) and (max-width: 599px){
		.bcspacing{
			letter-spacing:17px;
		}
	}
	
	@media(min-width: 500px) and (max-width: 549px){
		.bcspacing{
			letter-spacing:14px;
		}
	}
	@media(min-width: 450px) and (max-width: 499px){
		.bcspacing{
			letter-spacing:11px;
		}
	}
	@media(min-width: 400px) and (max-width: 459px){
		.bcspacing{
			letter-spacing:9px;
		}
	}
	@media(min-width: 350px) and (max-width: 399px){
		.bcspacing{
			letter-spacing:7px;
		}
	}
</style>
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
    <div class="container"><!--Begin main cotainer-->
                <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
                @if(isset($salesmemo))
                        <input type="hidden" value="{{$salesmemo->id}}" id="deliveryid"/>
                        <div class="col-sm-12">
                            <div class="row">
								<div class="col-sm-4">
									<img src="{{URL::to('/')}}/salesmemobarcode/{{$salesmemo->id}}/barcode.png" width="100%" />
									<p class="bcspacing">{{IdController::nSM($salesmemo->id)}}</p>
								</div>	
                                <div class="col-sm-4 text-center">
								<!--
                                    <b>{{$array_delivery[0]['oshop_name']}}</b>
								-->
								</div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">

                                </div>
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
                                        <br>GST Reg. No:
                                        {{$array_delivery[0]['merchant_gst']}}
                                    </p>
                                </div>
								<div class="col-sm-4">
									<br>
									<?php 
										
										$qr = DB::table('salesmemoqr')->join('qr_management','qr_management.id','=','salesmemoqr.qr_management_id')
										->where('salesmemo_id',$salesmemo->id)->orderBy('salesmemoqr.id','DESC')->first();
									?>
									@if(!is_null($qr))
										<img src="{{URL::to('/')}}/images/qr/salesmemo/{{$salesmemo->id}}/{{$qr->image_path}}.png" style="margin-right:-10px;" class="pull-right"  width="120px" />
									@endif									
								</div>
                            </div>
                            @endif
                        </div>
                        <div class="row">


                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4" style="padding-right: 23px !important; padding-left: 23px !important;">
									<b>SalesMan Information</b>
									 <br>
									 @if($buyer->name != ""){{IdController::nB($buyer->id)}}
									  <br>
                                    @endif
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
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12" style="padding-right: 23px !important; padding-left: 23px !important;">

                                    <b>Date: </b>
                                    {{UtilityController::s_date($array_delivery[0]['orderdate'])}}
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6" style="padding-bottom: 10px;">
                                    <div class="" style="vertical-align: middle;margin-top: 10px;">

                                        &nbsp;
                                    </div>

                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="mporder_id" value="{{$deliveryorderid}}"/>
                        <div class="col-sm-12">

                            <table class="table">
                                <tr>
                                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit">
                                        <b>Sales Memo No:</b>{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
                                    </td>
                                    <td colspan="2" class="text-center" style="font-size: 20px; vertical-align: inherit">
                                        <b>Sales Memo</b>
                                    </td>
									<?php
										$flocation = DB::table('fairlocation')->where('id',$salesmemo->id)->first();
									?>
                                    <td colspan="2"  style="height: 50px; vertical-align: inherit">
										@if(!is_null($flocation))
											<b class="pull-right">Location: {{$flocation->location}}</b> 
										@endif
										<br>
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
                                $glob = DB::table('global')->first()->gst_rate;
								$tproducts = DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo->id)->get();
                                ?>

                                @if(isset($tproducts))
                                    @foreach($tproducts as $product)
                                            <tr>
                                                <?php
                                                $prime_product = DB::table('product')->where('id', $product->product_id)->first();
                                                //$parent_product = DB::table('product')->where('id', $prime_product->parent_id)->first();
                                                ?>
                                                <td class="text-center">{{ $counter++ }}</td>
                                                <td class="text-center">{{ IdController::nTp($product->product_id) }}</td>
                                                <td>{{ $prime_product->name }}</td>
                                                <td class="text-center">{{ $product->quantity or 0 }}</td>
                                                <td class="text-right">

                                                    <?php
                                                    //$op = DB::table('orderproduct')->where('porder_id', $deliveryorderid)->where('product_id', $prime_product->id)->first();

                                                  //  if (!is_null($op)) {


                                                      //  $delp = $product->order_delivery_price;
                                                        $opc = $product->order_price;
                                                        $tempTotal = ($opc * $product->quantity);
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
                        <div class="col-sm-12 text-right" style="padding-right: 23px !important; padding-left: 23px !important; padding-bottom: 20px;">
                            <table style="float:right;text-align:right;">
                                <tr>
                                    <td style="padding-right: 10px">
                                        Total&nbsp;includes&nbsp;{{$gst[0]->gst_rate}}% GST
                                    </td>
                                    <td>{{$currency}}&nbsp;{{number_format($gstTotal/100,2)}}</td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px">Items&nbsp;Total</td>
                                    <td>{{$currency}}&nbsp;{{ number_format($rawTotal/100,2) }}</td>
                                </tr>
                            </table>
                        </div>
            </div>

        </div>
    </div><!--Begin main cotainer-->
    <style>
        .table > tbody > tr > td {
            border-top: 0px solid #ddd;
        }
    </style>

</body>
</html>	
