@extends("common.default")
@section("content")
<?php
	use App\Http\Controllers\UtilityController;
	use App\Http\Controllers\IdController;
	use App\Classes;
?>
<style>
    table#product_details_table,#payment_detail_products
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
@include('common.sellermenu')
<div class="container"><!--Begin main cotainer-->
	<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong class='cart-info'></strong>
	</div>
<div class="row">
<div class="  " > <!-- col-sm-12 -->
<h2>Buying Order</h2>
<br>
	<table class="table table-bordered" id="orderb_details_table" style="width: 100%">
		<thead>
	   {{--  <tr class="bg-black">
			<th colspan="11">Order</th>
		</tr> --}}
		<?php $i=1;?>
		<tr class="bg-black">
			<th class="text-center no-sort">No</th>
			<th class="text-center">Order ID</th>
			<th class="text-center">Received</th>
			<th class="text-center">Completed</th>
			{{-- <th>SKU</th> --}}
			<th class="text-center">Segment</th>
			<th class="text-center">Total</th>
			<th class="text-center">Status</th>
			<th class="no-sort text-center" style="background:green;">Action</th>
			{{-- <th>Delivery Order</th> --}}
		</tr>
		</thead>
		<tbody>
		@if(isset($orders))
			@foreach($orders as $pb)
				<tr>
					<td style="text-align: center;">{{$i}}</td>
					<td style="text-align: center;"><a href="{{route('Receipt', ['id' => $pb['oid']])}}" class="uniqporder" id="uniqporder"data="{{$pb['oid']}}">{{IdController::nO($pb['oid'])}}</a>
					</td>

					<td style="text-align: center;">{{UtilityController::s_date($pb['o_rcv'])}}</td>
					<td style="text-align: center;">
					{{UtilityController::s_date($pb['o_exec'])}}
					{{-- {{$pb['o_exec']}}</td> --}}
					{{-- <td>{{$pb['sku']}}</td> --}}
					<td style="text-align: right;">{{$pb['description'] or ''}}</td>
					<?php $total = number_format($pb['total']/100,2); ?>
					<td style="text-align: right;">{{$currentCurrency}} {{$total}}</td>
					<td style="text-align: center;">{{$pb['status'] or ''}}</td>
					<td style="text-align: center;">ToDo</td>
				</tr>
				<?php $i++; ?>
			@endforeach
		@endif

		</tbody>
	</table>
</div>
</div>
</div>
<br>
<br>
<script>
$(document).ready(function () {
        var table = $('#orderb_details_table').DataTable({
            "order": [],
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			]
        });
});
</script>
@stop
{{-- <div class="clearfix"> </div> --}}
