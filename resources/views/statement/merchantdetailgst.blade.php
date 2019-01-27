<?php use App\Http\Controllers\UtilityController;

$total=0;
$c=1;
?>
<div>
<h3 style="float:left">{{$month}} {{$year}}</h3>
@if($mode != '')
<h3 style="float:right">Default Mode: {{ucfirst($mode)}}</h3>
@endif
</div>
<table id="stmntdt" cellspacing="0" class="table table-striped" width="100%">
    <thead>
		<tr style="background-color: #0e0b3f; color: #FFF;">
			<th>No.</th>
			<th class="text-center" style="width: 120px !important;">Date</th>
			<th class="text-center" style="width: 120px !important;">Receipt&nbsp;No</th>
			<th class="text-center" style="width: 120px !important;">Sales</th>
			<th class="text-center" style="width: 120px !important;">Total&nbsp;Items</th>
			<th class="text-center" style="width: 120px !important;">SST</th>     
		</tr>
    </thead>

    <tbody>

		<?php $num = 1; ?>
		@foreach($recs as $rec)
			<tr>
				<td align="center">{{ $num }}</td>
				<td align="center">{{ UtilityController::s_date($rec->created_at) }}</td>
				<td align="center">{{ str_pad($rec->receipt_no,10,"0",STR_PAD_LEFT) }}</td>
				<td align="right">{{$currentCurrency}} {{  number_format($rec->sales/100,2) }}</td>
				<td align="right">{{$currentCurrency}} {{  number_format($rec->total_items/100,2) }}</td>
				<td align="right">{{$currentCurrency}} {{  number_format($rec->sst/100,2) }}</td>
			</tr>
			<?php $num++; ?>
		@endforeach
    </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function(){
    var id="#myModalLabel2";
    $(id).text('SST Report');
    $('#stmntdt').DataTable({
			 "order": []
			 /*     "scrollX":true,*/
		});
	});
</script>


