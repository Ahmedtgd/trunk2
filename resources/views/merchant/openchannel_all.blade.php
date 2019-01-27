<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
@include('common.sellermenu')
<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
    <h2>Merchant OpenChannel</h2>
            <table class="table table-bordered" cellspacing="0" id="merchant-open-channel" style="width:1500px !important;">
                <thead style="background-color: #db4249; color: white;">
                <tr>
                    <td class="text-center" colspan="3">Station</td>
					@if(Auth::user()->hasRole('adm'))
						<td class="text-center" colspan="3">Sales</td>
					@endif
                    <td class="text-center" colspan="3">Inventory</td>
                    <td class="text-center" colspan="1">Connection</td>
                    <td class="text-center" colspan="1">Geographical</td>
					@if(Auth::user()->hasRole('mer'))
						<td class="text-center medium" style="background-color: #F29FD7">Term</td>
					@endif
                </tr>
                <tr style="background-color: #db4249; color: white;">
                    <td class="text-center bsmall no-sort">No.</td>
                    <td class="text-center large">Station&nbsp;ID</td>
                    <td class="text-center blarge">Name</td>
					@if(Auth::user()->hasRole('adm'))
						<td class="text-center medium">Since</td>
						<td class="text-center medium">YTD</td>
						<td class="text-center medium">MTD</td>
					@endif
                    <td class="text-center bsmall">Item</td>
                    <td class="text-center bsmall">High>30%</td>
                    <td class="text-center bsmall">Low<30%</td>
                    <td class="text-center medium">Distributor</td>
                    <td class="text-center large">State</td>
					@if(Auth::user()->hasRole('mer'))
						<td class="text-center medium" style="background-color: #F29FD7">&nbsp;</td>
					@endif
                </tr>
                </thead>
                <tbody>
                <?php $num = 1; ?>

						@foreach($stations as $station)
								<tr>
									<td align="center">{{ $num }}</td>
									<td>
										@if(Auth::user()->hasRole('adm'))
											<a href="javascript:void(0)" class="view-station-modal" data-id="{{ $station['id']}}">
										@endif
										 {{IdController::nS($station['id'])}}
										 @if(Auth::user()->hasRole('adm'))
											 </a>
										@endif
									</td>
									<td align="left">@if(Auth::user()->hasRole('adm'))<a href="javascript:void(0)" class="station-terms" data-id="{{ $station['id']}}">@endif{{ $station['station_name'] }}@if(Auth::user()->hasRole('adm'))</a>@endif</td>
									@if(Auth::user()->hasRole('adm'))
										<td align="right">{{$currentCurrency}} {{ number_format($station['since_sum'],2,".","") }}</td>
										<td align="right">{{$currentCurrency}} {{ number_format($station['YTD'],2,".","") }}</td>
										<td align="right">{{$currentCurrency}} {{ number_format($station['MTD'],2,".","") }}</td>
									@endif
									<td align="center"><a href="{{route('inventoryAll', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getItemsOfmStation($station['id'], $station['merchantid']) }}</a></td>
									<td align="center"><a href="{{route('inventoryHigh', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getmHighItems($station['id'], $station['merchantid']) }}</a></td>
									<td align="center"><a href="{{route('inventoryLow', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getmLowItems($station['id'], $station['merchantid']) }}</a></td>
									<td align="center">{{ \App\Models\POrder::getStationDistributorType($station['user_id']) }}</td>
										<?php
											$addretxt = $station['line1']; 
											if($station['line2'] != "" && !is_null($station['line2']) && sizeof($station['line2']) > 0){
												$addretxt .= $station['line2'];
											}
											$addretxt .= "," . $station['cityname'] . "," . $station['statename'] . ", Malaysia";
										?>
										<td align="center"><a href="javascript:void(0)" class="openchannel_address" rel-address="{{$addretxt}}" country="Malaysia" state="{{ $station['statename'] }}" city="{{ $station['cityname'] }}" marea="{{ $station['areaname'] }}">{{ $station['statename'] }}</a></td>
									@if(Auth::user()->hasRole('mer'))
										<td align="center"><a href="javascript:void(0)" class="station-terms" data-id="{{ $station['id']}}">Term</a></td>
									@endif
								</tr>
								<?php $num++; ?>
						@endforeach
                </tbody>
            </table>
            </div>
</div>

        <div id="termsModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:600px;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms</h4>
              </div>
              <div class="modal-body" style="height: 170px !important;">
				<div class="form-group">
					<label class="col-sm-4">Credit Term</label>
					<div class="col-sm-6"><input type="text" id="term_days" value="" class="form-control" placeholder="Credit Term" /></div>
					<div class="col-sm-2">days</div>
				</div>
				<div class="form-group" >
					<label class="col-sm-4" style="margin-top: 15px;">Credit Limit ({{$currentCurrency}})</label>
					<div class="col-sm-6" style="margin-top: 15px;"><input type="text" id="term_limit" value="" class="form-control" placeholder="Credit Limit ({{$currentCurrency}})" /></div>
					<div class="col-sm-2" style="margin-top: 15px;">&nbsp;</div>
				</div>
				<br><br>
				<div class="form-group">
					<div class="col-sm-4">&nbsp;</div>
					<div class="col-sm-4 text-center"><a href="javascript:void(0);" style="background-color: #27a98a !important; border-color: #27a98a !important; margin-top: 15px;" class="btn btn-primary btn-success" id="saveTerms">
                    &nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</a></div>
					<div class="col-sm-4">&nbsp;</div>
				</div>
				<br><br>
				<input type="hidden" id="term_station_id" value="0" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
		<input type="hidden" id="selluser" value="{{$selluser->id}}" />
        <div id="addressModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:800px;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Address</h4>
              </div>
              <div class="modal-body">
                    <table id="myTable" class="table table-bordered myTable">
						<tr style="background-color: #db4249; color: white;">
							<th>Country</th>
							<th>State</th>
							<th>City</th>
							
							<th>Area</th>
						</tr>
						<tr>
							<td id="modalcountry"></td>
							<td id="modalstate"></td>
							<td id="modalcity"></td>
							<td id="modalarea"></td>						
						</tr>
					</table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

    <script>
        $(document).ready(function(){
			$("#term_days").number(true,0,".","");
			$("#term_limit").number(true,2,".","");
			$(document).delegate( '.openchannel_address', "click",function (event) {
				var country = $(this).attr('country');
				var state = $(this).attr('state');
				var city = $(this).attr('city');
				var area = $(this).attr('marea');
				$("#modalcountry").html(country);
				$("#modalcity").html(city);
				$("#modalstate").html(state);
				$("#modalarea").html(area);
				$("#addressModal").modal('show');
			});		
		
		$('#saveTerms').click(function(){
			var selluser = $("#selluser").val();
			var station_id = $("#term_station_id").val();
			var term_limit = $("#term_limit").val();
			var term_days = $("#term_days").val();
			$("#saveTerms").html("Saving...");
			if(term_limit == "" || term_days == "" || parseInt(term_limit) == 0 || parseInt(term_days) == 0){
				toastr.warning("Plase assing valid values to credit term and limit!");
			} else {
				$.ajax({
					type: "POST",
					data: {selluser: selluser, station_id: station_id, term_limit: term_limit, term_days: term_days},
					url: "/terms/create",
					dataType: 'json',
					success: function (data) {
						toastr.info("Terms Successfully Created!");
						$("#termsModal").modal('toggle');
						$("#saveTerms").html("&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});				
			}
		})
		
		$('.station-terms').click(function(){
			var station_id = $(this).attr('data-id');
			var selluser = $("#selluser").val();
			$.ajax({
                url: JS_BASE_URL + "/stationterm",
                type:'GET',
				data: {station_id: station_id, selluser: selluser},
                success:function (r) {
					$("#term_limit").val(r.term_limit/100);
					$("#term_days").val(r.term_days);
					$("#term_station_id").val(station_id);
					$("#termsModal").modal('show');
                }
            });			

			
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

		var table = $('#merchant-open-channel').DataTable({
			'bScrollCollapse': true,
			'scrollX':true,
			'autoWidth':false,
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":  false
		});
    });
 
    </script>
@yield("left_sidebar_scripts")
@stop
