@extends("common.default")

@section("content")
	<div class="container"><!--Begin main cotainer-->
		<h2>Payment Master</h2>
		<table class="table" id="smmclick">
		<tr>
			<th>S.No.</th>
			<th>SMMId</th>
			<th>Name</th>
			<th>Payment Earned Since</th>
			<th>Earning YTD</th>
			<th>Outstanding</th>
		</tr>
		<?php $counter=1;?>
		@foreach($result as $key=>$smm)
			<tr>
				<td>{{ $counter++ }}</td>
				<td>{{ $key }}</td>
				<td>{{ $smm['name'] }}</td>
				<td></td>
				<td></td>
				<td>{{ $smm['payable'] or 0 }}</td>
			</tr>
		@endforeach
		</table>
		<h2>SMM Details</h2>
		<table class="table">
		<tr>
			<th>S.No.</th>
			<th>SMMId</th>
			<th>Name</th>
			<th>Viewers</th>
			<th>Shared Item</th>
			<th>Shared Times</th>
			<th>Clicked</th>
			<th>Items Sold</th>
			<th>Bought</th>
			<th>Last Share</th>
			<th>Source</th>
			<th>Country</th>
			<th>State</th>
			<th>Area</th>
			<th>Status</th>
		</tr>
		<?php $counter=1;?>
		@foreach($result as $key=>$smm)
			<tr>
				<td>{{ $counter++ }}</td>
				<td>{{ $key }}</td>
				<td>{{ $smm['name'] }}</td>
				<td>{{ $smm['view'] }}</td>
				<td>{{ $smm['items'] }}</td>
				<td>{{ $smm['shares'] }}</td>
				<td>{{ $smm['buy'] }}</td>
				<td>{{ $smm['buy'] }}</td>
				<td>{{ $smm['bought'] }}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endforeach
		</table>
	</div>
@stop