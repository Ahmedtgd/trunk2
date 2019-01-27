
<style>
	button.btn.btn-red.btn-mid{
		margin-bottom: 3px;
		font-size: 14px;
		padding: 8px 60px;
		background-color: #f50909b8;
		width: 100%;
		border-radius: 15px;
	}
	.select2-container{width: 50% !important;}
</style>
<div class="container">
	<style>
		#paysliptable{
			border-collapse:collapse;
		}
		#paysliptable td{
			padding: 3px;
			margin: 0;
			text-align: center;
		}
		#datatable_commission_wrapper{
			width: 81%;
		}
	</style>
	<table style="width:55%;margin-bottom: 10px;">
		<tr>
			<td width="40%">
				@if($staff)
					<div><h3><b>{{$staff[0]->name}}</b></h3></div>
					<div style="font-size: 16px;">Staff ID: {{sprintf('%010d',$staff[0]->uid)}}</div>
				@endif
				<div>

					<select style="padding: 8px 60px;background-color: white; font-weight: bold;">
						<option>Today</option>
						<option>Weekly</option>
						<option>Yearly</option>
						<option>Since</option>
					</select>
				</div>
			</td>
		</tr>
	</table>

	<table width="100%" id="datatable_commission">
		<thead style="color:white">
			<tr>
				<td width="10%" class="text-center" style="background-color:  #48247E; color:white;"><b>No</b></td>
				<td class="text-center" width="30%" style="background-color:#48247E;color:white"><b>Description</b></td>
				<td class="text-center" width="10%" style="background-color:#48247E;color:white">Sales&nbsp;(MYR)</td>
				<td class="text-center" width="20%"  style="background-color:#1F7E60;color:white"><b>Start</b></td>
				<td class="text-center" width="20%" style="background-color:#C43233;color:white"><b>End</b></td>
				<td class="text-center" width="10%" style="background-color:#2060C4;color:white"><b>MYR</b></td>
			</tr>
		</thead>
		<tbody>
		<?php $total = 0?>
		<p style="display:none">{{$count = 1}}</p>
		@foreach($products as $prod)
			<tr>
				<td class="text-center">{{$count++}}</td>
				<td class="text-left"><img src="{{ asset('images/product/'.$prod->id.'/thumb/'.$prod->thumb_photo) }}"
						 alt="thumb &nbsp;" width="30" height="30">&nbsp;&nbsp;{{$prod->name}}</td>
				<td class="text-right">{{number_format($prod->retail_price/100, 2)}}</td>
				<td class="text-center">{{date('dMy H:i:s', strtotime($prod->start))}}</td>
				<td class="text-center">{{date('dMy H:i:s', strtotime($prod->end))}}</td>
				<td class="text-right">{{number_format($prod->commission_amt/100, 2)}}</td>
				<p style="display:none">{{$total = $total + $prod->commission_amt }}</p>
			</tr>
		@endforeach
		</tbody>

	</table>

</div>

<script>
    $('#datatable_commission').DataTable();
</script>
