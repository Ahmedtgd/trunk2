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

	<h2>Merchant Master: Station Details</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1720px" id="gridnetwork">
			<thead style="background-color: #4E2E28; color: white;">
				<tr>
					<th class="text-center" colspan="7">Station</th>
					<th class="text-center" colspan="2">MTD</th>
					<th class="text-center" colspan="2">YTD</th>
					<th class="text-center" colspan="2">Since</th>
				</tr>
				<tr>
					<th class="no-sort text-left bsmall">No</th>
					<th class="text-left medium">Station&nbsp;ID</th>
					<th class="text-left blarge">Name</th>
					<th class="text-left blarge">Country</th>
					<th class="text-left blarge">State</th>
					<th class="text-left blarge">City</th>
					<th class="text-left blarge">Area</th>
					<th class="text-left medium">No</th>
					<th class="text-left medium">Amount</th>
					<th class="text-left medium">No</th>
					<th class="text-left medium">Amount</th>
					<th class="text-left medium">No</th>
					<th class="text-left medium">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($stations as $station)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>
					<td class="text-center">
					<a href="javascript:void(0)" class="view-station-modal" data-id="{{$station->id }}"> 
						{{IdController::nS($station->id)}} </a> 
					</td>
					<td class="">
						<?php
							/* Processed note */
							$pfullnote = null;
							$pnote = null;
							$elipsis = "...";
							$pfullnote = $station->company_name;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT)
								$pnote = $pnote . $elipsis;
						?> 
						<span title='{{$pfullnote}}'>{{$pnote}}</span>						
						<input type="hidden" value="{{$station->company_name}}" id="mname{{ $station->id }}" />
					</td>
			
					<td class="text-center">{{$station->countryname}}</td>					
					<td class="text-center">{{$station->statename}}</td>					
					<td class="text-center">{{$station->cityname}}</td>					
					<td class="text-center">{{$station->areaname}}</td>					
					<td class="text-center">{{$station->mtd_no}}</td>					
					<td class="text-center">{{number_format($station->mtd_amount,2)}}</td>					
					<td class="text-center">{{$station->ytd_no}}</td>					
					<td class="text-center">{{number_format($station->ytd_amount,2)}}</td>			
					<td class="text-center">{{$station->since_no}}</td>					
					<td class="text-center">{{number_format($station->since_amount,2)}}</td>								
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
        $('.view-station-modal').click(function(){

            var station_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+station_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/station/"+station_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#station-error-messages').html(msg);
                    }
                }
            });


        });	
 });
</script>
@yield("left_sidebar_scripts")
@stop
