<div class="table-responsive">
	<table class="table table-bordered table popup-table" id="wholesale_table">
		<thead>
			<tr>
				<th>Delivery</th>
				<th style="width:25%;">Coverage</th>
			</tr>
		</thead>
		<tbody id="delivery_table_tbody">
			<tr>
				<td>Country</td>
				<td>
					<select id="country">
						<option value="0">No country set</option>
						@if(isset($countries))
						@foreach($countries as $country)
							<?php 
								$country_selected = "";
								if($country->id == $deliverycoverage->cov_country_id){
									$country_selected = "selected";
								}
							?>
							<option value="{{$country->id}}" {{$country_selected}}>{{$country->name}}</option>
						@endforeach
						@endif						
					</select>
				</td>
			</tr>
			<tr>
				<td>State</td>
				<td>
					<select id="state">
						<option value="0">No state set</option>
						@if(isset($states))
						@foreach($states as $state)
							<?php 
								$state_selected = "";
								if($state->id == $deliverycoverage->cov_state_id){
									$state_selected = "selected";
								}
							?>
							<option value="{{$state->id}}" {{$state_selected}}>{{$state->name}}</option>
						@endforeach
						@endif							
					</select>					
				</td>
			</tr>	
			<tr>
				<td>City</td>
				<td>
					<select id="city">
						<option value="0">No city set</option>
						@if(isset($cities))
						@foreach($cities as $city)
							<?php 
								$city_selected = "";
								if($city->id == $deliverycoverage->cov_city_id){
									$city_selected = "selected";
								}
							?>
							<option value="{{$city->id}}" {{$city_selected}}>{{$city->name}}</option>
						@endforeach
						@endif							
					</select>					
				</td>
			</tr>
			<tr>
				<td>Area</td>
				<td>
					<select id="area">
						<option value="0">No area set</option>
						@if(isset($areas))
						@foreach($areas as $area)
							<?php 
								$area_selected = "";
								if($area->id == $deliverycoverage->cov_area_id){
									$area_selected = "selected";
								}
							?>
							<option value="{{$area->id}}" {{$area_selected}}>{{$area->name}}</option>
						@endforeach
						@endif							
					</select>					
				</td>
			</tr>			
		</tbody>
	</table>
	<p align="right"><button type="button" id="edit_coverage" class="btn btn-primary">Save</button></p>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('#country').on('change', function(){
			var country_id = $('#country').val();
			$.ajax({
				url: "/state/list/" + country_id,
				type: "GET",
				async: false,
				success: function(response)
				{
					var states = response[0].data;
					var stateselect = $('#state');
					stateselect.empty();
					stateselect.append($('<option></option>').val("0").html("No state set"));
					$.each(states, function(index, value) {
						stateselect.append($('<option></option>').val(index).html(value));
					}); 
				}
			});			
		});
		
		$('#state').on('change', function(){
			var state_id = $('#state').val();
			$.ajax({
				url: "/city/list/" + state_id,
				type: "GET",
				async: false,
				success: function(response)
				{
					var cities = response[0].data;
					var cityselect = $('#city');
					cityselect.empty();
					cityselect.append($('<option></option>').val("0").html("No city set"));
					$.each(cities, function(index, value) {
						cityselect.append($('<option></option>').val(index).html(value));
					}); 
				}
			});			
		});		
		
		$('#city').on('change', function(){
			var city_id = $('#city').val();
			$.ajax({
				url: "/area/list/" + city_id,
				type: "GET",
				async: false,
				success: function(response)
				{
					var areas = response[0].data;
					var areaselect = $('#area');
					areaselect.empty();
					areaselect.append($('<option></option>').val("0").html("No area set"));
					$.each(areas, function(index, value) {
						areaselect.append($('<option></option>').val(index).html(value));
					}); 
				}
			});			
		});		

		$('#edit_coverage').on('click', function(){
			var country_id = $('#country').val();
			var state_id = $('#state').val();
			var city_id = $('#city').val();
			var area_id = $('#area').val();
			var productId = $("#productid").val();
			$('#edit_coverage').html("Saving...");
			$.ajax({
				url: "/editdeliverycoverage",
				type: "POST",
				data: {
					productID : productId,
					country_id : country_id,
					state_id : state_id,
					city_id : city_id,
					area_id : area_id
				},
				async: false,
				success: function(response)
				{
					$('#edit_coverage').html("Saved!");
					setTimeout(function () {
						$('#edit_coverage').html("Save");
					}, 3000);					
				}
			});
		});		
			
	});
</script>