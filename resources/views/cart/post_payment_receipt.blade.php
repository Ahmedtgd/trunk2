@extends('common.default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3>Transaction Receipt</h3>
			<table class="table table-striped">
			  <thead></thead>
			  <tbody>
			    	<tr>
			  		<th>Payment Method</th>
			  		<td>FPX</td>
			  	</tr>
			  	<tr>
			  		<th>Transaction Date</th>
			  		<td>{{$t_date or "--"}}</td>
			  	</tr>
			  	<tr>
			  		<th>Transaction Amount</th>
			  		<td>{{$currentCurrency}} {{$t_amount or "--"}}</td>
			  	</tr>
			  	<tr>
			  		<th>Seller Reference Number</th>
			  		<td>{{$t_refno or "--"}}</td>
			  	</tr>
			  	<tr>
			  		<th>FPX Transaction ID</th>
			  		<td>{{$t_fpx_id or "--"}}</td>
			  	</tr>
	  		  	<tr>
			  		<th>Buyer Bank Name</th>
			  		<td>{{$t_bank or "--"}}</td>
			  	</tr>
	  		  	<tr>
			  		<th>Transaction Status</th>
			  		<td>{{$t_status or "--"}}</td>
			  	</tr>

			  </tbody>

			</table>
		</div>
	</div>
</div>
@stop