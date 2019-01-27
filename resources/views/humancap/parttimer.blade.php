
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
	#datatable_parttime_wrapper{
		width: 70%;
	}
</style>
<div class="container" style="margin-top:0px;">
	<style>
		#paysliptable{
			border-collapse:collapse;
		}
		#paysliptable td{
			padding: 3px;
			margin: 0;
			text-align: center;
		}
	</style>
	<table style="width:55%;margin-bottom: 10px;">
		<tr>
			<td width="40%">
				<div><h3><b>{{$user->first_name}}&nbsp;{{$user->last_name}}</b></h3></div>
				<div style="font-size: 16px;margin-bottom:8px">Staff ID: 000{{$user->id}}</div>
				<div>
					<select style="padding: 8px 30px;background-color:white;">
						<option>Today</option>
						<option>Weekly</option>
						<option>Yearly</option>
						<option>Since</option>
					</select>
				</div>
				<h3 style="margin-bottom:5px">Part Timer</h3>
			</td>
		</tr>
	</table>

	<table width="100%" id="datatable_parttime"
		class="cell-border"> 
		<thead> 
			<tr class="text-center">
				<td style="background-color:  #1E5DCF; color:white;"><b>Date</b></td>
				<td style="background-color:#259469;color:white"><b>In</b></td>
				<td style="background-color:#D93131;color:white">Out</td>
				<td style="background-color:#EF942B;color:white"><b>Total Hours</b></td>
				<td style="background-color:#2057CE;color:white"><b>MYR</b></td>
			</tr>
		</thead>

		<tbody>
		@foreach($partime as $part)
			<tr class="center">
				<td>{{$part->created_at}}</td>
				<td><?php if($attendance){
						echo $attendance->checkin;
					}else{
						echo "--";
					} ?></td>
				<td><?php if($attendance){
						echo $attendance->checkout;
					}else{
						echo "--";
					}?></td>
				<td>{{$part->rate_hr}}</td>
				<td>{{number_format($part->block,2)}}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>

<script>
    $('#datatable_parttime').DataTable();
</script>
