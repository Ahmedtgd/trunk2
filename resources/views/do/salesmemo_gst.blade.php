<style type="text/css">
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
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
<?php 
	$sstatus = $array_delivery[0]['salesmemostatus'];
	$stylev = "";
	$stylevbtn = "";
	if($sstatus != 'voided'){
		$stylev = "display: none;";
	} else {
		$stylevbtn = "display: none;";
	}
?>
@section("content")
    <div class="container"><!--Begin main cotainer-->
        <div class="row">
            <div class="col-sm-12" style="padding-top:20px;">
                <div class="col-sm-12" style="">
                    <p style="font-size:20px;"><span>Home </span> ><span style="color:#777" class='title'>Sales Memo</span>
                    </p>
                </div>
            </div>
                </div>
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

                                    <a href="{{url()."/download/posm/pdf/".$salesmemo->id}}"
                                       class="btn btn-primary btn-info pull-right"><span
                                                class="glyphicon glyphicon-download-alt action_butt"></span> Download</a>
									<br class="void_salesmemo_br" style="{{$stylevbtn}}">
									<br class="void_salesmemo_br" style="{{$stylevbtn}}">
									<a href="javascript:void(0)" style="{{$stylevbtn}}"
                                       class="btn btn-primary btn-danger pull-right void_salesmemo action_butt"><span
                                                class="glyphicon glyphicon-ban-circle"></span> Void</a>												
									<br>		
									<br>		
									<a href="javascript:void(0)"
                                       class="btn btn-primary btn-info
									   pull-right print_salesmemo action_butt">
									   <span class="glyphicon glyphicon-print">
									   </span> Print</a>

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
                                        <br>SST Reg. No:
                                        {{$array_delivery[0]['merchant_gst']}}
                                    </p>
									
									<div id="voided_memo" style="paddign: 10px; border: 2px solid red; width: 120px; margin: auto; border-radius: 10px; {{$stylev }}">
									 <p style="text-align: center; font-size: 40px; color: red; margin: 0 !important;">
										<b>VOID</b>
									 </p>
									</div>
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
								<div class="col-sm-6">
									<b>Date: </b>
                                    {{UtilityController::s_date($array_delivery[0]['orderdate'])}}
								</div>
								<div class="col-sm-3">
								&nbsp;
								</div>
								<div class="col-sm-1">
									<span><b>Sales&nbsp;Memo&nbsp;No:</b></span>
								</div>
								<div class="col-sm-2">
									<span class="pull-right">{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}</span>
								</div>
								<div class="col-sm-6">
									
								</div>
								<div class="col-sm-3">
								&nbsp;
								</div>
								<div class="col-sm-1">
									<span><b>SalesMan&nbsp;ID:</b> </span>
								</div>
								<div class="col-sm-2">
									<span class="pull-right">@if($buyer->name != ""){{IdController::nB($buyer->id)}}
                                    @endif</span>
								</div>
								<div class="col-sm-6">
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
								<div class="col-sm-3">
								&nbsp;
								</div>
								<div class="col-sm-1">
									<span><b>SalesMan:</b> </span>
								</div>
								<div class="col-sm-2">
									<span class="pull-right">@if($buyer->name != ""){{$buyer->name}}
                                    @endif</span>
								</div>
                            </div>
                        </div>
                        <input type="hidden" id="mporder_id" value="{{$deliveryorderid}}"/>
                        <div class="col-sm-12">

                            <table class="table">
                                <tr>
                                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit; padding-left: 0px; important!">
                                        SST Reg. No:
                                        {{$array_delivery[0]['merchant_gst']}}
                                    </td>
                                    <td colspan="2" class="text-center"
									style="font-size:20px;vertical-align:inherit">
                                        <b>Sales Memo</b>
                                    </td>
									<?php
										$flocation = DB::table('fairlocation')->where('id',$salesmemo->fairlocation_id)->first();
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
                                                        $opc = $product->price;
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
                                        Total&nbsp;includes&nbsp;{{$gst[0]->gst_rate}}% SST
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


    <script type="text/javascript">

        /*	Paul on 07 April 2017 at 12AM	*/
        $("#chkSelectAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
		$(document).ready(function(){
			$(document).delegate( '.print_salesmemo', "click",function (event) {
				myWindow=window.open(JS_BASE_URL + "/print/posm/{{$array_delivery[0]['salesmemoid']}}");
		//		myWindow.document.write("<p>This is 'myWindow'</p>");
		//		myWindow.document.close(); //missing code

				myWindow.focus();
				myWindow.print(); 
			});
			$(document).delegate( '.void_salesmemo', "click",function (event) {
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/salesmemo/status/voided/{{$array_delivery[0]['salesmemoid']}}",
					success: function (data) {
						toastr.info("Status changed!");
						$("#voided_memo").show();
						$(".void_salesmemo").hide();
						$(".void_salesmemo_br").hide();
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Send");
					}

				});					
			});
		});
		
		
		function openWin()
		  {

		  }
        function processdelivery() {
            var items = [];
            $("input:checkbox:checked").each(function () {
                items.push($(this).attr('value'));
            });

            console.log(items);
            if (items.length > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "{{ url('deliveryinvoice/process')}}",
                    data: {
                        items: items,
                        porder_id: $('#mporder_id').val(),
                        password: $('#orderpassworld').val().trim()
                    },
                    beforeSend: function () {
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            toastr.info("Password matched. Thank you for the purchase");
                            window.location.reload();

                        } else if (response == -1) {
                            toastr.warning("Password do not match. Please try again");
                        } else {
                            toastr.error("An unexpected error ocurred. Please try again or contact OpenSupermall Support");
                        }
                    }
                });
            } else {
                toastr.warning("Please select the products!");
            }

        }

    </script>

@stop
