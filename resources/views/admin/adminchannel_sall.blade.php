<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
    <div class="table-responsive" style="margin-bottom: 28px;">
    <h2>OpenChannel Master: Merchant Detail</h2>
            <table class="table table-bordered" cellspacing="0" id="station-open-channel" style="width:1500px !important;">
                <thead style="background-color: black; color: white;">
                <tr>
                    <td colspan="3">Station</td>
					<td colspan="3">Sales</td>
                    <td colspan="3">Inventory</td>
                    <td colspan="1">Connection</td>
                    <td colspan="1">Geographical</td>
                </tr>
                <tr style="background-color: black; color: white;">
                    <td class="no-sort bsmall text-center">No.</td>
                    <td class="large text-center">Station&nbsp;ID</td>
                    <td class="large text-center">Name</td>
                    <td class="medium text-center">Since</td>
                    <td class="medium text-center">YTD</td>
                    <td class="medium text-center">MTD</td>
                    <td class="medium text-center">Item</td>
                    <td class="medium text-center">High>30%</td>
                    <td class="medium text-center">Low<30%</td>
                    <td class="medium text-center">Distributor</td>
                    <td class="large text-center">State</td>
                </tr>
                </thead>
                <tbody>
                <?php $num = 1; ?>

						@foreach($merchants as $station)
								@if($mode == 'all' || ($mode == 'pasive' && $station['apcount'] == 0) || ($mode == 'active' && $station['apcount'] > 0))
									<tr>
										<td align="center">{{ $num }}</td>
										<td>
											 <a href="javascript:void(0)" class="view-station-modal" data-id="{{ $station['id']}}">  {{IdController::nM($station['id'])}} </a>
										</td>
										<td align="left">{{ $station['company_name'] }}</td>
										<td align="right">{{$currentCurrency}} {{ number_format($station['since_sum'],2,".","") }}</td>
										<td align="right">{{$currentCurrency}} {{ number_format($station['YTD'],2,".","") }}</td>
										<td align="right">{{$currentCurrency}} {{ number_format($station['MTD'],2,".","") }}</td>
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
										<td align="center"><a href="javascript:void(0)" class="openchannel_address" rel-address="" country="Malaysia" state="{{ $station['statename'] }}" city="{{ $station['cityname'] }}" marea="{{ $station['areaname'] }}">{{ $station['statename'] }}</a></td>
									</tr>
									<?php $num++; ?>
								@endif
						@endforeach
                </tbody>
            </table>
            </div>
</div>

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
						<tr style="background-color: black; color: white;">
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

                var table = $('#station-open-channel').DataTable({
              
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