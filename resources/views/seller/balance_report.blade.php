@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
?>
@section("content")
@include('common.sellermenu')
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	<div id="employees">
		<div class="row">

			<div class=" col-sm-12">
				@include('seller.ageingTabs')
				<h2>Ageing Report: Balance</h2>
				
			</div>
			<div class=" col-sm-6">
				&nbsp;
			</div>
		</div>
		<?php $e=1;?>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="invoices-table" width="100%">
					<thead>
					
					<tr class="bg-ageing">
						<th class="large text-center">Credit&nbsp;Limit</th>
						<th class="large text-center">Used</th>
						<th class="large text-center">Balance</th>
					</tr>
					</thead>					
					<tbody>
						<tr>
							<td class="text-right">
								{{$currentCurrency}}&nbsp;{{number_format($term_limit,2)}}
							</td>
							<td class="text-right"> 
								{{$currentCurrency}}&nbsp;{{number_format($total_owned,2)}}
							</td>
							<td class="text-right">
								{{$currentCurrency}}&nbsp;{{number_format($diff,2)}}
							</td>
						</tr>
					</tbody>
				</table>
		</div>
		</div>    
	</div>
	</div>
	</div>
 </div>
</section>
@stop
