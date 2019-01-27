<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
<?php $i=1; ?>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')

	<h2>Investment Master</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridnetwork">
			<thead style="background-color: #A218A2; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Name</th>
					<th class="text-center medium">Company&nbsp;Name</th>
					<th class="text-center medium">Email</th>
					<th class="text-center medium">Mobile</th>
					<th class="text-center medium">URL</th>
					<th class="text-center medium">Country</th>
					<th class="text-center medium">Category</th>
					<th class="text-center blarge">Remarks</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($investments as $investment)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>		
					<td class="text-center">{{$investment->first_name}}&nbsp;{{$investment->last_name}}</td>					
					<td class="text-center">{{$investment->company_name}}</td>					
					<td class="text-center">{{$investment->email}}</td>					
					<td class="text-center">{{$investment->mobile}}</td>					
					<td class="text-center">{{$investment->url}}</td>					
					<td class="text-center">
						<?php 
							$country = DB::table('country')->where('id',$investment->country_id)->first();
						?>
						@if(!is_null($country))
							{{$country->name}}
						@endif
					</td>					
					<td class="text-center">{{ucfirst($investment->investor_type)}}</td>
					<td class="text-center">
						<?php 
							$description = substr($investment->description,0,20);
						?>
						<span title="{{$investment->description}}">{{$description}}</span>
					</td>													
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div id="transferModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">O-Shop Transfer</h4>
      </div>
      <div class="modal-body">
      	{{-- Inputs --}}
      	<input type="hidden" id="transferToMerchant" value="">
      	<input type="hidden" id="oshop" value="">
        <p>Do you wish to transfer this O-Shop?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" id="processTransfer">Yes</button>
      </div>
    </div>

  </div>
</div>
{{--  --}}
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
    $('#gridnetwork').DataTable({
        "order": [],
        "scrollX": true,
        "scrollY": false,
        "columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "100px" },
			{"targets": "large",  "width": "120px" },
		//	{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
		],
        "fixedColumns":  true
    });

 });
</script>
@yield("left_sidebar_scripts")
@stop
