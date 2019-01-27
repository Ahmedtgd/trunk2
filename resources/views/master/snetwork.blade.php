<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 30);
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

	<h2>Station Master: Merchant Details</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridnetwork">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Merchant&nbsp;ID</th>
					<th class="text-center blarge">Name</th>
					<th class="text-center blarge">Country</th>
					<th class="text-center blarge">State</th>
					<th class="text-center blarge">City</th>
					<th class="text-center blarge">Area</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($merchants as $merchant)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>
					<td class="text-center">
					<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$merchant->id }}"> 
						{{IdController::nM($merchant->id)}} </a> 
					</td>
					<td class="">
						<?php
							/* Processed note */
							$pfullnote = null;
							$pnote = null;
							$elipsis = "...";
							$pfullnote = $merchant->company_name;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT)
								$pnote = $pnote . $elipsis;
						?> 
						<span title='{{$pfullnote}}'>{{$pnote}}</span>						
						<input type="hidden" value="{{$merchant->company_name}}" id="mname{{ $merchant->id }}" />
					</td>
			
					<td class="text-center">{{$merchant->countryname}}</td>					
					<td class="text-center">{{$merchant->statename}}</td>					
					<td class="text-center">{{$merchant->cityname}}</td>					
					<td class="text-center">{{$merchant->areaname}}</td>												
				</tr>
				@endforeach
			</tbody>
		</table>
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
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
		],
        "fixedColumns":  true
    });
	
	$('.view-merchant-modal').click(function(){

var id=$(this).attr('data-id');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
	var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
	$('#merchant-error-messages').html(msg);
	}
	}
	});
});
 });
</script>
@yield("left_sidebar_scripts")
@stop
