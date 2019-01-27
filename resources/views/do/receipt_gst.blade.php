<style type="text/css">
	.table-nonfluid {
		width: 57% !important;
	}
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

?>
@section("content")
	<div class="container"><!--Begin main cotainer-->
		<div class="">
			{{--Paul on 10 April 2017 at 6:50pm--}}
			{{--<div class="col-sm-12" style="padding-top:20px;">--}}
				{{--<div class="col-sm-12" style="">--}}
					{{--<p style="font-size:20px;">--}}
						{{--<span>Home </span> >--}}
						{{--<span> Station</span> >--}}
						{{--<span style="color:#777" class='title'>--}}
						{{--Tax Invoice </span></p>--}}
				{{--</div>--}}
			{{--</div>--}}
            {{--Paul on 10 April 2017 at 1 30 am--}}
			{{--<div class="col-sm-11 col-sm-offset-1" style="padding-left:0;padding-right:0">--}}
				{{-- <div class="col-sm-12 form-horizontal" style="margin: 2% 0;padding-left:0;padding-right:0"> --}}

				{{--@if(isset($deliveryorder))--}}
					{{--<div class="">--}}
						{{--<div class="col-sm-12">--}}
							{{--<div class="">--}}
								{{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
									{{--<b>{{$array_delivery[0]['merchant_name']}}</b>--}}
									{{--<br>--}}
									{{--{{$array_delivery[0]['mbiz']}}--}}
									{{--<br></div>--}}
								{{--<div class="col-sm-3"></div>--}}
								{{--<div class="col-sm-1 pull-left">--}}

									{{--<a href="{{url()."/download/receipt/pdf/".$receipt_id}}" class="btn btn-primary btn-info" style="margin-left: -20px;"><span class="glyphicon glyphicon-download-alt"></span> Download</a>--}}

								{{--</div>--}}
								<?php
                                    //$password = $array_delivery[0]['password'];
                                ?>

								{{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
									{{--{{$array_delivery[0]['muser_address']}}</div>--}}

								{{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
									{{--{{$array_delivery[0]['mline2']}}</div>--}}

								{{--<div class="col-sm-4 col-sm-offset-4 text-center">--}}
									{{--{{$array_delivery[0]['mline3']}}</div>--}}
								{{--<div class="col-sm-4 col-sm-offset-4 text-center">GST No: {{$array_delivery[0]['merchant_gst']}}</div>--}}

							{{--</div>--}}
						{{--</div>--}}
						{{--@endif--}}
            {{--</div>--}}

					{{--<div class="col-sm-12">--}}
						{{--<div class="row">--}}
							{{--<div class="col-sm-4"--}}
								 {{--style="padding-left:0">--}}
								{{--<b>Date: </b>--}}
								{{--{{UtilityController::s_date($array_delivery[0]['orderdate'])}}</div>--}}

                        {{--Not commented by Paul--}}
						<!--<div class="col-sm-4 text-center">GST Reg. No:{{$array_delivery[0]['merchant_gst']}}</div>-->
                        {{--Upto Here--}}
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
						{{--<div class="row" >--}}
							{{--<div class="col-sm-6"--}}
								 {{--style="padding-bottom: 10px;padding-left:0">--}}
								{{--<div class="" style="">--}}
									{{--<b>Order ID:</b>--}}

									{{--{{IdController::nO($receipt_id)}}--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="col-sm-6 pull-right"--}}
								 {{--style="padding-right:0">--}}
								{{--<p align="right"><b>Tax Invoice No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}</p>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="col-sm-12">--}}
							{{--<div class="">--}}
								{{--<div class="col-sm-4 col-sm-offset-4 text-center"--}}
									 {{--style="font-size: 20px;">--}}
									{{--<b>Tax Invoice</b>--}}
									{{-- {{$array_delivery[0]['merchant_name']}}   --}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}

					{{--</div>--}}
                {{--Ends Here--}}
					<input type="hidden" id="mporder_id" value="{{$receipt_id}}" />
					<div class="col-sm-12" style="padding-left:0;padding-right:0">

						<table class="table">
                            {{--Paul on 9 April 2017 at 11:50 am--}}
                            @if(isset($deliveryorder))
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" class="text-center">
                                        <b>{{$array_delivery[0]['merchant_name']}}</b><br>
                                        {{$array_delivery[0]['mbiz']}}<br>

                                        <?php
                                            $password = $array_delivery[0]['password'];
                                        ?>

                                        @if($array_delivery[0]['muser_address'] != "")
                                            {{$array_delivery[0]['muser_address']}}<br>
                                        @endif

                                        @if($array_delivery[0]['mline2'] != "")
                                            {{$array_delivery[0]['mline2']}}<br>
                                        @endif

                                        @if($array_delivery[0]['mline3'] != "")
                                            {{$array_delivery[0]['mline3']}}<br>
                                        @endif

                                        SST No: {{$array_delivery[0]['merchant_gst']}}
                                    </td>
                                    <td colspan="3" class="text-right">
                                        <a href="{{url()."/download/receipt/pdf/".$receipt_id}}" class="btn btn-primary btn-info" style="margin-left: -20px;"><span class="glyphicon glyphicon-download-alt"></span> Download</a>
										<br>
										<?php 
											
											$qr = DB::table('receiptqr')->join('qr_management','qr_management.id','=','receiptqr.qr_management_id')
											->where('receipt_id',$array_delivery[0]['original_id'])->orderBy('receiptqr.id','DESC')->first();
										?>
										@if(!is_null($qr))
											<img src="{{URL::to('/')}}/images/qr/receipt/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png"  style="margin-right:-10px;" class="pull-right" style="margin-top: -10px;"  width="120px" />
										@endif	                                   
								   </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="6">
                                    {{$array_delivery[0]['user_name']}}<br>
                                    {{$array_delivery[0]['user_address']}}<br>
                                    {{$array_delivery[0]['line2']}}<br>
                                    {{$array_delivery[0]['line3']}}<br>
                                    <b>Date: </b>
                                    {{UtilityController::s_date($array_delivery[0]['orderdate'])}}<br>
                                </td>
								<td>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit">
                                    <b>Order ID:</b>

                                    {{IdController::nO($receipt_id)}}
                                </td>
                                <td colspan="2" class="text-center" style="font-size: 25px; vertical-align: bottom">
                                    <b style="font-size: 25px; margin-top:-10px">Tax Invoice</b>

                                </td>
                                <td></td>
                                <td colspan="2" class="text-right" style="height: 50px; vertical-align: inherit">
                                    <b>Tax Invoice No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
                                </td>
                            </tr>
                            {{--Ends Here--}}
							<tr style="border-bottom: 1px solid #ddd;background:#666666;color:#ffffff;">
								<th class="text-center">No</th>
								<th class="text-center">Product&nbsp;ID</th>
								<th colspan="2">Description</th>
								<th class="text-center">Qty</th>
								<th class="text-right">Unit&nbsp;Price</th>
								<th class="text-right">Amount</th>
							</tr>
							<?php $counter =1; $sum_qty = 0;
							$sum_amount = 0;
							$totalDeliveryPaid=0;
							$glob=DB::table('global')->first()->gst_rate;
							// dump($deliveryorder[0]->products);exit();
							?>

							@if(isset($orderproduct))


								

									@foreach($orderproduct as $product)
										<tr>
											<?php
											
											$prime_product = DB::table('product')->where('id',$product->product_id)->first();
											$parent_product = DB::table('product')->where('id',$prime_product->parent_id)->first();
											?>
											<td class="text-center">{{ $counter++ }}</td>
											<td class="text-center">{{ IdController::nP($parent_product->id) }}</td>

											<td colspan="2">{{ $parent_product->name }}</td>
											<td class="text-center">{{ $product->quantity or 0 }}</td>
											<td class="text-right">

												<?php

												$op = DB::table('orderproduct')->where('porder_id',$receipt_id)->where('product_id',$prime_product->id)->first();
												
												if(!is_null($op)){
													$delp=$op->order_delivery_price;
													$opc=$op->order_price;
													$tempTotal=$delp+($opc*$op->quantity);
													$revenue = number_format($tempTotal/100,2);

													$totalPaid=($op->quantity * $opc);
													$amount = number_format($totalPaid/100,2);
													$totalDeliveryPaid+=$delp;

												} else {
													$revenue = number_format(($parent_product->retail_price/100),2,".","");
													$amount = number_format((($product->quantity * $parent_product->retail_price)/100),2,".","");
												}
												$sum_qty += $product->quantity;
												$sum_amount += $tempTotal;

												// $sum_amount = number_format($sum_amount, 2, '.', '');
												?>

												{{$currency}} {{number_format($opc/100,2)}}
											</td>
											<td class="text-right">{{$currency}} {{ $amount }}</td>

										<!-- <td><input type="checkbox" value="{{ $product->id }}"></td> -->
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>

											<td class="pull-left">Delivery&nbsp;</td>
											<td></td>
											<td></td>
											<td class="pull-right">{{$currency}} {{number_format($delp/100,2)}}</td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td  colspan="1" class="pull-left">Note: A cashback of {{$currentCurrency}} 15.43 was given and will be credited to your OpenCredit account. This cashback shall be voided if the product is returned.</td>
											<td></td>
											<td></td>
											<td class="pull-right">{{$totalcashback}}</td>
										</tr>
									@endforeach
							
								
								<tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
									<td></td>

									<td colspan="2"></td>
									<?php
									// $aux = ($sum_amount*6)/100;
									$total = $sum_amount;

									$rawTotal= $total/(1+($glob/100));
									$gstTotal= $total-$rawTotal;

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
								<td style="padding-right: 10px">Total includes {{$gst[0]->gst_rate}}% SST</td>
								<td>{{$currency}} {{number_format($gstTotal/100,2)}}</td>
							</tr>

							</tr>
							<tr>
								<td style="padding-right: 10px">Items Total</td>
								<td>{{$currency}} {{ number_format($rawTotal/100,2) }}</td>
							</tr>
						</table>
					</div>

			</div>
		</div>
	</div>   <!---This new div close fixes the bad layout -->
	</div><!--Begin main cotainer-->
	<style>
		.table>tbody>tr>td{
			border-top: 0px solid #ddd;
		}
	</style>


	<script type="text/javascript">
		function processdelivery()
		{
			var items = [];
			$("input:checkbox:checked").each(function(){
				items.push($(this).attr('value'));
			});
			console.log(items);
			jQuery.ajax({
				type: "POST",
				url: "{{ url('deliveryorder/process')}}",
				data: { items:items,porder_id:$('#mporder_id').val(),password:$('#orderpassworld').val() },
				beforeSend: function(){},
				success: function(response){
					console.log(response);
					if(response == 1){
						toastr.info("Password matched. Thank you for the purchase");
						window.location.reload();

					}else if(response == -1){
						toastr.warning("Password do not match. Please try again");
					} else {
						toastr.error("An unexpected error ocurred. Please try again or contact OpenSupermall Support");
					}
				}
			});
		}

	</script>

@stop
