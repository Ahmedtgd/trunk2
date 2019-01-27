<?php
	use App\Http\Controllers\UtilityController;
	use App\Http\Controllers\IdController;
	use App\Classes;
?>
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
			<th class="text-center">Order&nbsp;Received</th>
			<th class="text-center">Order&nbsp;Executed</th>
			{{-- <th>SKU</th> --}}
			<th class="text-center">Description</th>
			<th class="text-center">Order Total</th>
			<th class="text-center">Status</th>
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
					{{-- <td><a href="{{ url('receipt/'.$pb['oid']) }}">Delivery Order</a></t></td> --}}
				</tr>
				<?php $i++; ?>
			@endforeach
		@endif

		</tbody>
	</table>
</div>

{{-- <div class="clearfix"> </div> --}}