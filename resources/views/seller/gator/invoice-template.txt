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
          
                        {{--Ends Here--}}
                    <input type="hidden" id="mporder_id" value="{{$receipt_id}}" />
                    <div class="col-sm-12" style="padding-left:0;padding-right:0">

                        <table class="table">
                            {{--Paul on 9 April 2017 at 11:50 am--}}
                            @if(isset($deliveryinvoice))
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="3" class="text-center">
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
                                    </td>
                                    <td colspan="2" class="text-right">
                                        <a href="{{url()."/download/receipt/pdf/".$receipt_id}}" class="btn btn-primary btn-info" style="margin-left: -20px;"><span class="glyphicon glyphicon-download-alt"></span> Download</a>
										<br>	
										<?php 
											
											$qr = DB::table('invoiceqr')->join('qr_management','qr_management.id','=','invoiceqr.qr_management_id')
											->where('invoice_id',$array_delivery[0]['original_id'])->orderBy('invoiceqr.id','DESC')->first();
										?>
										@if(!is_null($qr))
											<img src="{{URL::to('/')}}/images/qr/invoice/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" style="margin-right:-10px; margin-top: -10px;" class="pull-right" style=""  width="120px" />
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
                                    {{UtilityController::s_date($array_delivery[0]['orderdate'])}} <br>
                                </td>
								<td>

                                </td>
                            </tr>
                            <tr>
                                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit">
                                        <b>Order ID:</b>{{IdController::nO($receipt_id) }}
                                    </td>
                                    <td colspan="3" class="text-center" style="font-size: 20px; vertical-align: inherit">
                                        <b>Invoice</b>
                                    </td>
									
                                    <td  style="height: 50px; vertical-align: inherit">
                                        <b>Invoice&nbsp;No:</b>&nbsp;<br>
										<b>Term:</b>&nbsp;
                                    </td>
									<td class="text-right" style="height: 50px; vertical-align: inherit">
										{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}<br>
										{{$array_delivery[0]['duration']}}&nbsp;Days
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

                                            <td colspan="2">{{ $prime_product->name }}</td>
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
                                            <td colspan="2"></td>

                                            <td class="pull-left">Delivery&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-right">{{$currency}} {{number_format($delp/100,2)}}</td>
                                        </tr>
                                @endforeach
                                <tr>

                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                                    <td ></td>

                                    <td colspan="2"></td>
                                    <?php
                                    // $aux = ($sum_amount*6)/100;





                                    ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">

                                        <b>Total&nbsp;{{$currency}}&nbsp;{{ number_format($sum_amount/100,2) }}
                                        </b></td>
                                </tr>
                            @endif
							
						<?php	$invoices= DB::table('invoice')
							->join('invoicepayment', 'invoice.id', '=', 'invoicepayment.invoice_id')
							->leftJoin('bank', 'invoicepayment.bank_id', '=', 'bank.id')
							->where('invoice.porder_id', $receipt_id)
							->select('invoicepayment.*','bank.name as bname')
							->orderBy('invoicepayment.created_at','DESC')
							->get(); 
							$e = 1;
						?>
						<tr style="background-color: #FF6600; color: #FFF;">
							<th class="text-center bsmall">No.</th>
							<th class="text-center">Date&nbsp;Paid</th>
							<th class="large text-center">Bank</th>
							<th class="large text-center">Method</th>
							<th class="text-center">Note</th>
							<th class="text-right" colspan='2'>Amount Paid</th>
						</tr>
						@if(count($invoices) > 0)
							@foreach($invoices as $inv)
								<tr>
									<td class="text-center">{{$e}}</td>
									<td class="text-center">
										{{UtilityController::s_datenotime($inv->date_paid)}}
									</td>
									<td class="text-center"> 
										{{$inv->bname}}
									</td>
									<td class="text-center">
										{{ucfirst($inv->method)}}
									</td>
									<td class="text-left">
										{{$inv->note}}
									</td>
									<td class="text-right" colspan='2'>
										MYR {{number_format($inv->amount/100,2)}}
									</td>
								</tr>
							<?php $e++;?>
							@endforeach
						@endif						
                        </table>
                    </div>


                {{--</div>--}}
            {{--</div>--}}
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
