<?php
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
@include("common.sellermenu")
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2 class="heading">Purchase Order</h2>
		</div>
		<?php $count=0; ?>
		@foreach($definite_purchase as $purchase)
			<div id="porder{{$purchase['porder']->id}}">
				<div class="col-sm-5">
					<h4>Merchant&nbsp;ID: {{IdController::nM($purchase['merchant']->id)}}</h4>
					<h4>Merchant&nbsp;Name: {{ $purchase['merchant']->company_name}}</h4>
				</div>
				<div class="col-sm-2">
				</div>
				<div class="col-sm-5">
					<h4>Term&nbsp;Duration: {{ $purchase['stationterm']->term_duration}} days</h4>
					<h4>Credit&nbsp;Limit: {{$currentCurrency}} {{ number_format(($purchase['stationterm']->credit_limit/100),2)}}</h4>
					<h4>Balance&nbsp;Credit&nbsp;Limit: {{$currentCurrency}} {{ number_format(($purchase['stationterm']->credit_limit/100) +$returned - $purchase['total_owned'],2)}}</h4>
				</div>
				<div class="col-sm-12">
				<table class="table table-bordered" id="tproduct{{$purchase['porder']->id}}" width="100%">
				<thead>
				<?php 
					$ii=1;
					$totalqty=0;
					$totalamount=0;
				?>
				<tr style="background-color: #F29FD7; color: #FFF;">
					<th class="text-center no-sort">No</th>
					<th class="text-center">Product&nbsp;ID</th>
					<th class="text-center">Name</th>
					<th class="text-center">Qty</th>
					<th class="text-center">Price</th>
					<th class="text-center" >Amount</th>
				</tr>
				</thead>	
				<tbody>
				@foreach($purchase['tproducts'] as $tproduct)
					<tr>
						<td class="text-center">{{$ii}}</td>
						<td class="text-center">{{IdController::nTp($tproduct->tproduct_id)}}</td>
						<td class="text-left">{{$tproduct->name}}</td>
						<td class="text-center">{{$tproduct->quantity}}</td>
						<td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($tproduct->order_price/100,2)}}</td>
						<td class="text-right">{{$currentCurrency}}&nbsp;{{number_format(($tproduct->order_price/100)*$tproduct->quantity,2)}}</td>
					</tr>
					<?php 
						$totalqty += $tproduct->quantity;
						$totalamount += ($tproduct->order_price/100)*$tproduct->quantity;
						$ii++;
					?>
				@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2"></th>
						<th class="text-right">Total</th>
						<th class="text-center">
							{{$totalqty}}</th>
						<th colspan="2" class="text-right"
							style="padding-right:10px">
							{{$currentCurrency}}&nbsp;{{number_format($totalamount,2)}}</th>
					</tr>
				</tfoot>
				</table>
				<script>
				$(document).ready(function () {	
					 $('#tproduct{{$purchase["porder"]->id}}').DataTable({
						"order": [],
						"scrollX":false
					});
				});
				</script>
				</div>
				<br><br>

				<div class="col-sm-12"
					style="margin-top:10px"
					id="buttos_po{{$purchase['porder']->id}}">
					<div class="pull-right">
						<a href="javascript:void(0)"
						rel="{{$purchase['porder']->id}}"
						style="border-radius:5px"
						class="btn btn-danger purchaseodelete">
							&nbsp;Delete&nbsp;</a>

						@if($purchase['cansave'])
							<a href="javascript:void(0)"
							style="border-radius:5px"
							rel="{{$purchase['porder']->id}}"
							mrel="{{$purchase['merchant']->id}}"
							class="btn btn-info purchaseosave">Confirm</a>
						@else
							<a href="javascript:void(0)"
							style="border-radius:5px"
							title="{{$purchase['error_msg']}}"
							style="background-color: #ddd;"
							class="btn btn-default">Confirm</a>
						@endif
					</div>
				</div>
			</div>
			<?php $count++; ?>
		@endforeach
		@if($count == 0)
			<div class="col-sm-12">
				<h4 align="center" class="heading">No Purchase Orders</h4>
			</div>
		@endif
	</div>
	<br><br>
</div>
<script>
	$(document).ready(function () {	
		$('.purchaseosave').click(function (e) {
			var poid= $(this).attr("rel");
			var merchantid= $(this).attr("mrel");
			$.ajax({
				url: JS_BASE_URL + "/add_invoice_po",
				type: "post",
				data: {poid:poid, merchantid: merchantid},
				async: false,
				success: function (data) {
					if(data.trim() == "OK"){
						toastr.info("New Purchase Order created!");
						$("#buttos_po" + poid).hide();
						var win = window.open(JS_BASE_URL + "/invoice/" + poid, '_blank');
						if (win) {
							win.focus();
						}
					} else {
						console.log('***** data *****');
						console.log(data);
						toastr.error("There was an error processing your transaction, please Contact OpenSupport!");
					}
					
				},
				error: function (data) {
					toastr.error("An unexpected error occurred!");
				}
			});
		});
		
		$('.purchaseodelete').click(function (e) {
			var poid= $(this).attr("rel");
			var merchantid= $(this).attr("mrel");
			$.ajax({
				url: JS_BASE_URL + "/delete_invoice_po",
				type: "post",
				data: {poid:poid, merchantid: merchantid},
				async: false,
				success: function (data) {
					console.log(data);
					toastr.info("Invoice successfully deleted!");
					$("#porder" + poid).hide();
					//thisbtn.attr("disabled", false);
					//location.reload();
				},
				error: function (data) {
					toastr.error("An unexpected error occurred!");
				}
			});
		});
	});
</script>
@stop
