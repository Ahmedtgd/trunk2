<!DOCTYPE html>
<html>
<head>
	<title>Delivery Order</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/lato.css')}}">
 	<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
 	<style type="text/css">
 	td {
 		padding: 10px;
 	}
 	</style>
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
</head>
<body>
<div class="container">
<div class="col-xs-12">
<h3>Delivery Order</h3>
<table>
	<tr>
		<td>Merchant ID</td>
		<td>{{$merchant->id}}</td>
	</tr>
	<tr>
		<td>Merchant Name</td>
		<td>{{$merchant->company_name}}</td>
	</tr>
	<tr>
		<td>Merchant Address</td>
		<td>
			{{$address->line1}} <br>
			{{$address->line2}} <br>
			{{$address->line3}} <br>
		</td>
	</tr>
</table>
<hr>
<h5>Delivery Order: {{$order_id}}</h5>
<hr>
<table class="table borderless">
	<thead>
		<th>No</th>
		<th>Product ID</th>
		<th>Description</th>
		<th>Qty</th>
		<th>Unit Price</th>
		<th>Amount</th>
		<th>Remarks</th>
		<th></th>
	</thead>
	<?php $i=1;?>
	<tbody>

		<tr>
			<td>1</td>
			<td>P001</td>
			<td>Kleenso</td>
			<td class="quantity">1</td>
			<td>{{$currentCurrency}} 10</td>
			<td class="price">{{$currentCurrency}} 10</td>
			<td>---</td>
			<td><input type="checkbox" checked="checked" disabled="disabled"></td>
		</tr>
				<tr>
			<td>2</td>
			<td>P002</td>
			<td>NeverLand</td>
			<td class="quantity">2</td>
			<td>{{$currentCurrency}} 10</td>
			<td class="price">{{$currentCurrency}} 20</td>
			<td>---</td>
			<td><input type="checkbox" checked="checked" disabled="disabled"></td>
		</tr>
		@foreach($infos as $info)
			<td>{{$i}}</td>
			<td>{{$info->product_id}}</td>
			<td>{{$info->product_desc}}</td>
			<td class="quantity">{{$info->quantity}}</td>
			<td>{{$currentCurrency}} {{$info->unit_price}}</td>
			<td class="price">{{$info->unit_price * $info->quantity}}</td>
			<td>{{$info->remarks}}</td>
			<td>
				@if($info->status=='b-collected')
				<input type="checkbox" checked="checked" disabled="disabled">
				@else
				<input type="checkbox" disabled="disabled">
				@endif
			</td>
			<?php $i++;?>
		@endforeach
	</tbody>
	<tfoot>
		<td></td>
		<td></td>
		<td>Total Quantity</td>
		<td id="total_q"></td>
		<td>Total Price</td>
		<td id="total_p"></td>
	</tfoot>
</table>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var sum_p = 0;
		var sum_q=0;
		// iterate through each td based on class and add the values
		$(".price").each(function() {var value = $(this).text();
			value= value.slice(4);
		    if(!isNaN(value) && value.length != 0) {

		    	
		        sum_p += parseFloat(value);
		    }
		});
		$(".quantity").each(function() {var value = $(this).text();
			// value= value.slice(4);
		    if(!isNaN(value) && value.length != 0) {
		        sum_q += parseFloat(value);
		    }
		});
		// alert(sum_p);
		$('#total_p').append('{{$currentCurrency}} '+ sum_p);
		$('#total_q').append( sum_q);
	});
</script>
</body>
</html>