<style type="text/css">
	.table-nonfluid {
	   width: 57% !important;
	}
	.no-padding{
		padding-left:0px;
	}
	.btn-confirm{
		color: #fff;
    	background: rgb(39,169,138);
	}
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController; ?>
@section("content")
		<div class="container"><!--Begin main cotainer-->
			<div class="row">

               	 <div class="col-sm-12" style="padding-top:20px;">
               		<div class="col-sm-12" style="">
                        <p style="font-size:20px;"> <span>Home </span> > <span> Station</span> ><span style="color:#777" class='title'> Delivery Order </span></p>
                 	</div>
                 </div>
                <div class="col-sm-11 col-sm-offset-1">

		            <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
			           <div class="col-sm-12">
			           		<div class="row">
			           			<div class="col-sm-6">DELIVERY ORDER</div>
			           			<div class="col-sm-6 text-right">FURNITURE</div>
			           		</div>
			           		<div class="row">
			           			<div class="col-sm-12">{{ $array_delivery[0]['merchant_address'] }}</div>
			           		</div>
			           </div>
		            </div>

	               <div class="col-sm-12">
	               		 	<table class="table">
	               		 		<tr style="border-bottom: 1px solid #ddd;">
	               		 			<th colspan="2">List of Goods</th>
	               		 			<!-- <th>Product ID</th> -->
	               		 			<!-- <th>Description</th> -->
	               		 			<th>Qty</th>
	               		 			<th>Unit Price</th>
	               		 			<th>Amount</th>
	               		 			<!-- <th>Status</th> -->
	               		 			<th></th>
	               		 		</tr>
	               		 		<?php $counter =1; $sum_qty = 0; $sum_amount = 0;?>
	               		 		@if(isset($deliveryorder))
	               		 		@foreach($deliveryorder->products as $product)
	               		 		<tr>
	               		 			<td>{{ $counter++ }}</td>
	               		 			<!-- <td>{{ UtilityController::s_id($product->product->id) }}</td> -->
	               		 			<td>{{ $product->product->name }}</td>
	               		 			<td>{{ $product->quantity or 0 }}</td>
	               		 			<td>
	               		 			<?php
									$revenue = number_format(($product->product->retail_price/100),2);
									$amount = number_format((($product->quantity * $product->product->retail_price)/100),2);
									$sum_qty += $product->quantity;
									$sum_amount += $amount;
									$sum_amount = number_format($sum_amount, 2, '.', '');
			            			?>
									{{$currency}} {{$revenue}}
									</td>
	               		 			<td>{{$currency}} {{ $amount }}</td>
	               		 			<!-- <td>{{ $product->product->status }}</td> -->
	               		 			<td><input type="checkbox" value="{{ $product->id }}"></td>
	               		 		</tr>
	               		 		@endforeach
	               		 		<tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
	               		 			<td></td>
	               		 			<td></td>
	               		 			<td></td>
	               		 			<td>{{ $sum_qty }}</td>
	               		 			<td><b>{{$currency}} {{ $sum_amount }}</b></td>
	               		 			<td></td>
	               		 			<td></td>
	               		 		</tr>
	               		 		@endif
	               		 	</table>
		            </div>

		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-6">Station ID: </div>
		           			<div class="col-sm-6 pull-right">00000000001</div>
		           		</div>
		           </div>
                   <div class="col-sm-12">
               			<div class="row" >
               				<div class="col-sm-6">
		                   		<div class="" style="">
			                   		Delivery Person ID:
		                   		</div>
		                   	</div>
		                   	<div class="col-sm-6 pull-right">00000000001
		                   	</div>
		               </div>
	               </div>
		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-6">Order ID: </div>
		           			<div class="col-sm-6 pull-right">00000000001</div>
		           		</div>
		           </div>
		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-6">Delivery ID: </div>
		           			<div class="col-sm-6 pull-right">00000000001</div>
		           		</div>
		           </div>

		           <div class="col-sm-12" style="margin-top:25px;">
		           		<div class="row">
		           			<div class="col-sm-6">Receipt Confirmation </div>
		           			<div class="col-sm-6"></div>
		           		</div>
		           </div>
	               <div class="col-sm-12">
	               		<div class="row">
						  <div class="col-sm-1" style="border:1px solid #ddd; border-bottom:none;">Factory</div>
						  <div class="col-sm-1"></div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-bottom:none;">Station</div>
						  <div class="col-sm-4 text-center" style="border-bottom:1px solid #ddd;color:rgb(39,169,138);">External Logistics</div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-bottom:none;">Station</div>
						  <div class="col-sm-2"></div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-bottom:none;">Buyer</div>
						  <div class="col-sm-1"></div>
						</div>
						<div class="row">
						  <div class="col-sm-1" style="border:1px solid #ddd; border-top:none;">&nbsp;</div>
						  <div class="col-sm-1" style="border-bottom:1px solid #ddd;"></div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-top:none;">&nbsp;</div>
						  <div class="col-sm-4"></div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-top:none;">&nbsp;</div>
						  <div class="col-sm-2" style="border-bottom:1px solid #ddd;"></div>
						  <div class="col-sm-1" style="border:1px solid #ddd; border-top:none;">&nbsp;</div>
						  <div class="col-sm-1"></div>
						</div>
						<div class="row">
						  <div class="col-sm-1"></div>
						  <div class="col-sm-1"></div>
						  <div class="col-sm-1 no-padding"><input type="text" maxlength="6" size="11" name="" id="" /></div>
						  <div class="col-sm-4 no-padding"><input type="submit" class="btn-confirm"  onclick=""/></div>
						  <div class="col-sm-1 no-padding"><input type="text" maxlength="6" size="11" name="" id="" placeholder="" /></div>
						  <div class="col-sm-2 no-padding"><input type="submit" class="btn-confirm"  onclick=""/></div>
						  <div class="col-sm-1 no-padding"><input type="text" maxlength="6" size="11" name="" id="" placeholder="" /></div>
						  <div class="col-sm-1 no-padding"><input type="submit" class="btn-confirm"  onclick=""/></div>
						</div>
	               </div>
<br>
		            <div class="col-sm-12 text-right" style="margin-top:50px; padding-bottom: 20px;">
		            <input type="submit" class="btn btn-green" style="font-size: 1.30em;" value="Back To Main Page"/>
		            </div>
                </div>
			</div>

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
				jQuery.ajax({
					type: "POST",
					url: "{{ url('deliveryorder/process')}}",
					data: { items:items,deliveryid:$('#deliveryid').text(),password:$('#orderpassworld').val() },
					beforeSend: function(){},
					success: function(response){
						console.log(response);
						if(response == 1)
							window.location.assign("{{ url('/') }}");
						else
							alert('Password does not match');
					}
				});
			}

		</script>

@stop
