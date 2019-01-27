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
				<h2>Ageing Report: Status</h2>
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
						<th class="text-center bsmall">Start</th>
						<th class="text-center">Due&nbsp;Date</th>
						<th class="large text-center">Term</th>
					</tr>
					</thead>					
					<tbody>
						<tr>
							<td class="text-center">
								{{UtilityController::s_date($date)}}
							</td>
							<td class="text-center">
								{{UtilityController::s_date($due_date)}}
							</td>
							<td class="text-center"> 
								{{$term_duration}}&nbsp;days
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
