<?php
use App\Http\Controllers\IdController;
?>
<div class="container">
	<div class="row">
		<?php $count=0; ?>
		<div id="porderf">
			<div class="col-md-12">
				<table class="table table-bordered" id="tproduct" style="max-width: 870px; min-width: 870px;">
				<thead>
				<?php 
					$ii=1;
					$totalqty=0;
					$totalamount=0;
				?>
				<tr style="background-color: #F29FD7; color: #FFF;">
					<th class="text-center no-sort">No</th>
					<th class="text-center">PO&nbsp;ID</th>
					<th class="text-center">Merchant&nbsp;ID</th>
					<th class="text-center">Merchant&nbsp;Name</th>
					<th class="text-center">Qty</th>
					<th class="text-center" >Amount</th>
				</tr>
				</thead>	
				<tbody>
				@foreach($definite_purchase as $purchase)
					@foreach($purchase['tproducts'] as $tproduct)
					<?php 
						$totalqty += $tproduct->quantity;
						$totalamount += ($tproduct->order_price/100)*$tproduct->quantity;
						$count++;
					?>
					@endforeach
					<tr>
						<td class="text-center">{{$ii}}</td>
						<td class="text-center">
							<a href="{{URL::to('/')}}/purchase_o/{{$purchase['porder']->id}}"
							target="_blank">{{str_pad($purchase['porder']->id,10,'0',STR_PAD_LEFT)}}</a></td>
						<td class="text-center">{{IdController::nM($purchase['merchant']->id)}}</td>
						<td class="text-left">{{ $purchase['merchant']->company_name}}</td>
						<td class="text-center">{{$count}}</td>
						<td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($totalamount,2)}}</td>
					</tr>
				 <?php $ii++; ?>
				 @endforeach
				</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br>
</div>
<script>
	$(document).ready(function () {	
	
		var ttable = $('#tproduct').DataTable({
			"order": [],
			"scrollX":false
		});
		
		setTimeout(function(){ 
			ttable.columns.adjust();
		}, 500);
		
		$('.purchaseosave').click(function (e) {
			var poid= $(this).attr("rel");
			var merchantid= $(this).attr("mrel");
			$.ajax({
				url: JS_BASE_URL + "/add_invoice_po",
				type: "post",
				data: {poid:poid, merchantid: merchantid},
				async: false,
				success: function (data) {
					console.log(data);
					if(data == "OK"){
						toastr.info("New Purchase Order created!");
						$("#buttos_po" + poid).hide();
						var win = window.open(JS_BASE_URL + "/invoice/" + poid, '_blank');
						if (win) {
							win.focus();
						}
					} else {
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
