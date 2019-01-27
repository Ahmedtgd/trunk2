<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
?>
@extends("common.default")

@section("content")

    <?php $i=1; ?>
@section("content")
    <div class="container" style="margin-top:30px;">

        @include('admin/panelHeading')
        <h2>Station Rotation Intelligence</h2>
		<div class="row" >
			<div class='col-sm-6'>
				<b>Merchant</b>
			</div>
			<div class='col-sm-6'>
				<b>Product</b>
			</div>
		</div>	
		<div class="row" style="margin-top:10px;">
			<div class='col-sm-6'>
				<select id="merchants">
					<option value="">Choose Option</option>
					@foreach($merchants as $merchant)
						<option value="{{$merchant->id}}">{{$merchant->company_name}}</option>
					@endforeach
				</select>	
			</div>
			<div class='col-sm-6'>
				<select id="products">
					<option value="">Choose Option</option>
				</select>
			</div>
		</div>			
		<div class="row" style="margin-top:10px;">
			<div class='col-sm-3'>
				<b>Country</b>
			</div>
			<div class='col-sm-3'>
				<b>State</b>
			</div>
			<div class='col-sm-3'>
				<b>City</b>
			</div>
			<div class='col-sm-3'>
				<b>Area</b>
			</div>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class='col-sm-3'>
					<select disabled>
						<option>Malaysia</option>
					</select>
			</div>
			<div class='col-sm-3'>
					<select id="states">
						<option value="">Choose Option</option>
						@foreach($states as $state)
							<option value="{{$state->id}}">{{$state->name}}</option>
						@endforeach
					</select>		
			</div>
			<div class='col-sm-3'>
					<select id="cities">
						<option value="">Choose Option</option>
					</select>		
			</div>
			<div class='col-sm-3'>
					<select id="areas">
						<option value="">Choose Option</option>
					</select>			
			</div>
		</div>	

		
        <div class="table-responsive" style="margin-top:30px;">
            <table class="table table-bordered" cellspacing="0" width="1420px" id="gridstation">
                <thead style="background-color: #4E2E28; color: white;">
					<tr>
						<th style="background-color:#4E2E28;color:#fff" class="no-sort text-center bsmall">No.</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center bmedium">Station&nbsp;ID</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center bmedium">Type</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">Name</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">Country</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">State</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">City</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">Area</th>
						<th style="background-color:#4E2E28;color:#fff" class="text-center blarge">Last&nbsp;Selected</th>
					</tr>
                </thead>
				<tbody>
					@foreach($stations as $station)
					<?php 
						$style = "";
						if($i == 1){
							$style = "background-color: #00F878;";
						}
					?>
					<tr style="{{$style}}">
						<td class="text-center"> {{$i}}</td>
						<td class="text-center"> <a href="{{URL::to('admin/popup/station/' . $station->id)}}" target="_blank" >{{IdController::nSeller($station->user_id)}}</a></td>
						<td class="text-center"> Network</td>
						<td class="text-center"> {{$station->company_name}}</td>
						<td class="text-center"> Malaysia</td>
						<td class="text-center"> </td>
						<td class="text-center"> </td>
						<td class="text-center"> </td>
						<td class="text-center"> @if(!is_null($station->last_selection)){{UtilityController::s_date($station->last_selection)}}@endif</td>
						<?php $i++; ?>
					</tr>	
					@endforeach
				</tbody>
            </table>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
			function pad(str, max) {
				str = str.toString();
				return str.length < max ? pad("0" + str, max) : str;
			}			
           var thetable = $('#gridstation').DataTable({
                "scrollX": true,
				"columnDefs": [
					{"targets": "no-sort", "orderable": false},
					{"targets": "medium", "width": "80px"},
					{"targets": "bmedium", "width": "100px"},
					{"targets": "large",  "width": "120px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "approv", "width": "180px"}, //Approval buttons
					{"targets": "blarge", "width": "200px"}, // *Names
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
				],
				order: []
            });
			
			$('#products').on('change', function () {
				$(this).removeClass('error');
				$(this).siblings('label.error').remove();
				var val = $(this).val();
				if (val != "") {
					var state_id = $("#states").val();
					var city_id = $("#cities").val();
					var area_id = $("#areas").val();
					
					$.ajax({
						type: "GET",
						url: JS_BASE_URL + '/admin/station/selection/product/' + val,
						cache: false,
						data: {state_id: state_id, city_id: city_id, area_id: area_id},
						dataType: 'json',
						success: function (responseData, textStatus, jqXHR) {
							
							if(responseData.length == 0){
								thetable.clear().draw();
								$(".dataTables_empty").html("No data available in table");
							} else {
								thetable.clear().draw();
								for(var i = 0; i < responseData.length; i++ ){
									//console.log("HELLO");
									var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), "", "",responseData[i].last_selection ] ).draw().node();
									if(i == 0){
										console.log("HERE");
										$( rowNode )
										.css( 'background-color', '#00F878' );
									}
								}
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});	
				} else {
					
					var text = $('#merchants option:selected').text();
					//$('#states_p').html(text);
					$.ajax({
						type: "post",
						url: JS_BASE_URL + '/merchantproducts',
						data: {id: val},
						cache: false,
						success: function (responseData, textStatus, jqXHR) {
							if (responseData != "") {
								$('#products').html(responseData);
								document.getElementById('products').disabled = false;
							}
							else {
								$('#products').empty();
								$('#select2-products-container').empty();
								document.getElementById('products').disabled = false;
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
										
					var state_id = $("#states").val();
					var city_id = $("#cities").val();
					var area_id = $("#areas").val();
					
					$.ajax({
						type: "GET",
						url: JS_BASE_URL + '/admin/station/selection/merchant/' + val,
						cache: false,
						data: {state_id: state_id, city_id: city_id, area_id: area_id},
						dataType: 'json',
						success: function (responseData, textStatus, jqXHR) {
							
							if(responseData.length == 0){
								thetable.clear().draw();
								$(".dataTables_empty").html("No data available in table");
							} else {
								thetable.clear().draw();
								for(var i = 0; i < responseData.length; i++ ){
									var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), "", "",responseData[i].last_selection ] ).draw().node();
									
									if(i == 0){
										$( rowNode )
										.css( 'background-color', '#00F878' );
									}
								}
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});					
				}
			});			
			
			$('#merchants').on('change', function () {
				$(this).removeClass('error');
				$(this).siblings('label.error').remove();
				var val = $(this).val();
				if (val == "") {
					$('#select2-products-container').empty();
					$('#products').html('<option value="" selected>Choose Option</option>');
				} else {
					
					var text = $('#merchants option:selected').text();
					//$('#states_p').html(text);
					$.ajax({
						type: "post",
						url: JS_BASE_URL + '/merchantproducts',
						data: {id: val},
						cache: false,
						success: function (responseData, textStatus, jqXHR) {
							if (responseData != "") {
								$('#products').html(responseData);
								document.getElementById('products').disabled = false;
							}
							else {
								$('#products').empty();
								$('#select2-products-container').empty();
								document.getElementById('products').disabled = false;
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
										
					var state_id = $("#states").val();
					var city_id = $("#cities").val();
					var area_id = $("#areas").val();
					
					$.ajax({
						type: "GET",
						url: JS_BASE_URL + '/admin/station/selection/merchant/' + val,
						cache: false,
						data: {state_id: state_id, city_id: city_id, area_id: area_id},
						dataType: 'json',
						success: function (responseData, textStatus, jqXHR) {
							
							if(responseData.length == 0){
								thetable.clear().draw();
								$(".dataTables_empty").html("No data available in table");
							} else {
								thetable.clear().draw();
								for(var i = 0; i < responseData.length; i++ ){
									var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), "", "",responseData[i].last_selection ] ).draw().node();
									
									if(i == 0){
										$( rowNode )
										.css( 'background-color', '#00F878' );
									}
								}
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});					
				}
			});
			
			$('#states').on('change', function () {
				$(this).removeClass('error');
				$(this).siblings('label.error').remove();
				var val = $(this).val();
				var merchant_id = $("#merchants").val();
				var product_id = $("#products").val();
				if (val != "") {
					var text = $('#states option:selected').text();
					$('#states_p').html(text);
					$.ajax({
						type: "post",
						url: JS_BASE_URL + '/city',
						data: {id: val},
						cache: false,
						success: function (responseData, textStatus, jqXHR) {
							if (responseData != "") {
								$('#cities').html(responseData);
								document.getElementById('cities').disabled = false;
							}
							else {
								$('#cities').empty();
								$('#select2-cities-container').empty();
								document.getElementById('cities').disabled = false;
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
					
					$.ajax({
						type: "GET",
						url: JS_BASE_URL + '/admin/station/selection/state/' + val,
						cache: false,
						data: {merchant_id: merchant_id, product_id: product_id},
						dataType: 'json',
						success: function (responseData, textStatus, jqXHR) {
							
							if(responseData.length == 0){
								thetable.clear().draw();
								$(".dataTables_empty").html("No data available in table");
							} else {
								thetable.clear().draw();
								for(var i = 0; i < responseData.length; i++ ){
									var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), "", "",responseData[i].last_selection ] ).draw().node();
									
									if(i == 0){
										$( rowNode )
										.css( 'background-color', '#00F878' );
									}
								}
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});					
				}
				else {
					$('#select2-cities-container').empty();
					$('#cities').html('<option value="" selected>Choose Option</option>');
				}				
			});
			$('#cities').on('change', function () {
			        $(this).removeClass('error');
					$(this).siblings('label.error').remove();
					var val = $(this).val();
					var merchant_id = $("#merchants").val();
					var product_id = $("#products").val();
					if (val != "") {
						var text = $('#cities option:selected').text();
						$('#cities_p').html(text);
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#areas').html(responseData);
									document.getElementById('areas').disabled = false;
								}
								else {
									$('#areas').empty();
									$('#select2-areas-container').empty();
									document.getElementById('areas').disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
						
						$.ajax({
							type: "GET",
							url: JS_BASE_URL + '/admin/station/selection/city/' + val,
							cache: false,
							dataType: 'json',
							data: {merchant_id: merchant_id, product_id: product_id},
							success: function (responseData, textStatus, jqXHR) {
								
								if(responseData.length == 0){
									thetable.clear().draw();
									$(".dataTables_empty").html("No data available in table");
								} else {
									thetable.clear().draw();
									for(var i = 0; i < responseData.length; i++ ){
										var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), "", "",responseData[i].last_selection ] ).draw().node();
										
										if(i == 0){
											$( rowNode )
											.css( 'background-color', '#00F878' );
										}
									}
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});						
						
					}
					else {
						$.ajax({
							type: "GET",
							url: JS_BASE_URL + '/admin/station/selection/state/' + $("#states").val(),
							cache: false,
							dataType: 'json',
							data: {merchant_id: merchant_id, product_id: product_id},
							success: function (responseData, textStatus, jqXHR) {
								
								if(responseData.length == 0){
									thetable.clear().draw();
									$(".dataTables_empty").html("No data available in table");
								} else {
									thetable.clear().draw();
									for(var i = 0; i < responseData.length; i++ ){
										var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>" + responseData[i].nid + "</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), $("#cities option:selected").text(), "",responseData[i].last_selection ] ).draw().node();
										
										if(i == 0){
											$( rowNode )
											.css( 'background-color', '#00F878' );
										}
									}
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});						
						$('#select2-areas-container').empty();
						$('#areas').html('<option value="" selected>Choose Option</option>');
					}
			});
			$('#areas').on('change', function () {
				$(".dataTables_empty").html("Loading...");
				var val = $(this).val();
				var merchant_id = $("#merchants").val();
				var product_id = $("#products").val();
				if (val != "") {
					$.ajax({
						type: "GET",
						url: JS_BASE_URL + '/admin/station/selection/area/' + val,
						cache: false,
						data: {merchant_id: merchant_id, product_id: product_id},
						success: function (responseData, textStatus, jqXHR) {
							if(responseData.lenght == 0){
								thetable.clear().draw();
								$(".dataTables_empty").html("No data available in table");
							} else {
								thetable.clear().draw();
								for(var i = 0; i < responseData.lenght; i++ ){
									var rowNode = thetable.row.add( [i+1, "<a href='" + JS_BASE_URL+ "admin/popup/station/" + responseData[i].id + "' class='update' data-id='" + responseData[i].id + "'>[" + pad(responseData[i].id.toString(), 10) + "]</a>", 'Network', responseData[i].company_name, "Malaysia", $("#states option:selected").text(), $("#cities option:selected").text(), $("#areas option:selected").text(),responseData[i].last_selection ] ).draw().node();
									
									if(i == 0){
											$( rowNode )
											.css( 'background-color', '#00F878' );
									}
								}
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
				} else {
					
				}
			});
        })
    </script>
@stop
