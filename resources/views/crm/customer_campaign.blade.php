<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
$ii = 1;
?>
<div class="row">
	<div class=" col-sm-12">
		<table class="table table-bordered"  id="campaign-table" width="100%">
			<thead>
			
			<tr class="bg-black">
				<th class="bsmall">No</th>
				<th class="text-center">Date</th>
				<th class="text-center">Name</th>
			</tr>
			</thead>						
			<tbody>
			@foreach($campaigns as $campaign)
				<tr>
					<td class="text-center">{{$ii}}</td>
					<td class="text-center">
						{{UtilityController::s_date($campaign->created_at)}}
					</td>
					<td class="text-center">											
						{{$campaign->name}}	
					</td>
				</tr>
				<?php $ii++; ?>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function(){		
		var camp_table = $('#campaign-table').DataTable({
		"order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				{ "width": "300px" },
				{ "width": "300px" },
			]
		});		
		$(".dataTables_empty").attr("colspan","100%");	

    });
</script>