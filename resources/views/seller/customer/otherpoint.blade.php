<?php
use App\Http\Controllers\UtilityController;
?>
<table class="table" id="customer_otherpoints" >
	<thead style="background-color:#66ff66;border-color:#66ff66;color:white;">
		<tr>
			<th class="text-center">No.</th>
			<th class="text-center">Date</th>
			<th class="text-center">Transaction ID</th>
			<th class="text-center">Pts</th>
			<th class="text-center">IN/OUT</th>
			<th class="text-center">Source</th>
			<th class="text-center">Remarks</th>

		</tr>
	</thead>
	<tbody>
		@def $i=1
		@foreach($logs as $log)
			<tr>
				<td class="text-center">{{$i}}</td>
				<td class="text-center">{{UtilityController::s_date($log->created_at)}}</td>
				<td class="text-center">
				<a href="javascript:void(0)" onclick="show_detail('{{$log->id}}')">
				{{$log->id}}
				</a>
				</td>
				<td class="text-center">{{$log->points}}</td>
				<td class="text-center">{{$log->type}}</td>
				<td class="text-center">Opossum</td>
				<td class="text-center"></td>
			</tr>
			<?php $i++;?>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$("#customer_otherpoints").DataTable()
	})
</script>
<script type="text/javascript">
    function show_detail(log_id) {
        // body...

       /* $(".modal").modal("hide");*/
        url="{{url('seller/customer/otherpoint/detail')}}/"+log_id;
      
        $("#cpattymodalbody").load(url);
        $("#copModal").modal("show")
    }
</script>