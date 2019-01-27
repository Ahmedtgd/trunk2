<?php
$cf = new \App\lib\CommonFunction();
use App\Http\Controllers\IdController;
$selectListForBusinessType =  $cf->getBusinessType();
use App\Classes;
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
?>

@extends("common.default")
@section("content")
@include('common.sellermenu')

<style>
	.select-container{
		width: 45px !important;
	}
	#productledger{
		max-width: 100%;
		overflow-x: hidden;
		overflow-y:hidden;
	}
</style>

	<div class="container" style="margin-top:30px;">
		<div class="" style="margin-bottom: 28px;">
			<div class="col-md-12" style="margin-bottom:10px;
			padding-left:0;padding-right:0">
				<div class="col-md-8" style="padding-left:0">
					<h2>Allocated Product Rack Ledger</h2>
				</div>
				<div class="col-md-4 text-right" style="padding-right:0">
					<h4>{{$name}}</h4>
					<h4>Rack No:&nbsp; <span id="rack_no">{{$rack_id}}</span></h4>
				</div>
			</div>

		<table class="table table-bordered" cellspacing="0"
			   id="productledger" style="width:100% !important;">
			<thead style="color:white">
			<tr class="bg-warehouse">
				<td class="text-center" width="35px;">No</td>
				<td class="text-center">Report ID</td>
				<td class="text-center">Type</td>
				<td class="text-center">Last Update</td>
				<td class="text-center">Qty</td>
			</tr>
			</thead>
			<tbody>
			<?php $num = 0; ?>

			@foreach($product_rack as $product)
				<?php
				$desc = "";
				switch($product->ttype){
					case"tin":
						$desc = "Stock In";
						break;
					case"tout":
						$desc = "Stock Out";
						break;
					case "smemo":
						$desc = "Sales Memo";
						break;
					case "stocktake":
						$desc = "Stock Take";
						break;
					case "voided":
						$desc = "Voided";
						break;
					case "gator_sorder":
						$desc = "Gator Sales Order";
						break;
					case "wastage":
					$desc = "Wastage";
						break;
				}

				$report_id = str_pad($product->id, 10, '0', STR_PAD_LEFT);
				?>
			<tr>
				<td style="text-align: center;">{{ ++$num }}</td>
				<td class="text-center" style="vertical-align: middle"><a href="{{url('stockreport/'.$product->id.'')}}" target="_blank">{{$report_id}}</a></td>
				<td class="text-center" style="vertical-align: middle">{{$desc}}</td>
				<td class="text-center" style="vertical-align: middle">
					<?php  $date = strtotime($product->updated_at);
					echo date('dMY H:i:s', $date);
					?></td>
				<td class="text-center" style="vertical-align: middle">{{$product->quantity}}</td>
			</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop


@section('scripts')

	<script>
	$('#productledger').DataTable({
		"order": [],
		"scrollX": false,
	});
	
	$(document).ready(function () {
		$("select[name=productledger_length]").select2("destroy");
	});

	function pad($n) {
		var str = "" + $n
		var pad = "00000"
		var ans = pad.substring(0, pad.length - str.length) + str
		return ans
	}
	var r = $('#rack_no').text();
	
	$('#rack_no').text(pad(r));
	


	</script>
@stop
<!-- @yield("left_sidebar_scripts") -->

