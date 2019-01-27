$(document).ready(function () {
	$('body').on('click', '.add_outlet', function() {
		var current_outlet = parseInt($("#current_outlet").val());
		current_outlet++;
		$("#current_outlet").val(current_outlet)
		
		var html_add = '<div id="oulet_'+current_outlet+'"><div class="row" id="location_'+current_outlet+'"><hr>';
			html_add += '<div class="col-sm-8">';
			html_add += '<div class="col-sm-10 no-padding">';
			html_add += '<h2 style="margin-top:0px;"class="col-sm-3 no-padding">Outlet: </h2>';
			html_add += '<div class="col-sm-7">';
			html_add += '<input aria-required="true" placeholder="Please fill in Outlet Name" class="form-control" required="required" name="outlet_name[]" value="" type="text">';
			html_add += '</div>';
			html_add += '<div class="col-sm-2">&nbsp;</div>';
			html_add += '</div>	';
			html_add += '</div>	';
			html_add += '<div class="col-sm-4"><a href="javascript:void(0);" class="delete_outlet btn btn-danger pull-right" rel="'+current_outlet+'">x</a></div>';
			html_add += '<div class="col-sm-12">';
			html_add += '<h3 style="margin-top:0px;">Location</h3>';
			html_add += '</div>';		
			html_add += '<div class="col-sm-5">';
			html_add += '	<label>&nbsp;</label>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Country: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<input aria-required="true" disabled class="form-control" id="station_country_id" required="required" name="country_id" value="Malaysia" type="text">';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">State: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '			<select class="form-control station_states" rel="'+current_outlet+'" id="station_states'+current_outlet+'" name="state_idst[]">';
			html_add += '				<option value="">Choose Option</option>';
			html_add += '			</select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">City: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control station_cities" rel="'+current_outlet+'" id="station_cities'+current_outlet+'" name="city_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Area: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control" id="station_areas'+current_outlet+'" rel="'+current_outlet+'" name="area_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-5 control-label">Postcode /Zip Code: </label>';
			html_add += '						<div class="col-sm-7">';
			html_add += '							<input type="text" name="zipcode[]" class="form-control" required="" value="">		';							
			html_add += '						</div>';
			html_add += '					</div>		';		
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">Address</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line1[]" class="form-control" value="" >';
			html_add += '						</div>	';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line2[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line3[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line4[]" class="form-control" value="">';
			html_add += '						</div>	';
			html_add += '					</div>		';	
			html_add += '</div>';
			html_add += '<div class="col-sm-7">';
			html_add += '	<div id="map-container'+current_outlet+'" class="custom-container" style="width:575px; height:435px;">';
			html_add += '		  <div id="map-canvas'+current_outlet+'" style="width: 540px; height: 400px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden;"></div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';			
			html_add += '<div class="row" id="property">';
			html_add += '			<div class="col-sm-12">';
			html_add += '<input id="geoip_lat'+current_outlet+'" name="geoip_lats[]" value="0" type="hidden">';
			html_add += '<input id="geoip_lon'+current_outlet+'" name="geoip_lons[]" value="0" type="hidden">';			
			html_add += '<input name="biz_owner_contact[]" value="0" type="hidden" />';					
			html_add += '<input name="biz_owner_first_name[]" value="0" type="hidden" />';				
			html_add += '<input name="biz_owner_last_name[]" value="0" type="hidden" />';			
			html_add += '<div class="form-group">';			
			html_add += '	<label for="shop_size" class="col-sm-2 control-label">Shop Size</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="shop_size[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Business Name</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="biz_name[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';				
			html_add += '<div class="form-group">';
			html_add += '	<label for="owner" class="col-sm-2 control-label">Owner</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" data-bv-trigger="keyup" required="required" placeholder="First Name" class="form-control" name="firstname_property" value="" type="text">';
			html_add += '	</div>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" data-bv-trigger="keyup" required="required" placeholder="Last Name" class="form-control" name="lastname_property[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '<div class="form-group">';
			html_add += '	<label for="contact_property" class="col-sm-2 control-label">Contact</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="contact_property[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '	<div class="row" id="business">';
			html_add += '	<div class="col-sm-12">';
			html_add += '		<div class="form-group">';
			html_add += '			<label class="col-sm-2 control-label">Outlet </label>';
			html_add += '			<div class="col-sm-4">';
			html_add += '			<select class="form-control" name="outlet_business[]" id="outlet_business'+current_outlet+'"></select>';
			html_add += '			</div>';
			html_add += '		</div>';
			html_add += '		<div class="form-group">';
			html_add += '			<label for="delivery_business" class="col-sm-2 control-label">Delivery</label>';
			html_add += '			<div class="col-sm-4">';
			html_add += '			<select class="form-control" name="delivery_business[]" id="delivery_business'+current_outlet+'"></select>';			
			html_add += '			</div>';
			html_add += '			<div class="col-sm-6">';
			html_add += '				<a href="javascript:void(0);" class="add_outlet btn btn-info pull-right">+</a>';
			html_add += '			</div>';
			html_add += '		</div>';
			html_add += '	</div>';			
			html_add += '	</div>';			
			html_add += '	</div>';			
			$("#outlets").append(html_add);
			var cloneStates = $("#station_states0 > option").clone();
			var cloneBussiness = $("#outlet_business0 > option").clone();
			var cloneDelivery = $("#delivery_business0 > option").clone();
			$('#station_states'+current_outlet).html(cloneStates);
			$('#outlet_business'+current_outlet).html(cloneBussiness);
			$('#delivery_business'+current_outlet).html(cloneDelivery);
			$('#station_states'+current_outlet).select2();
			$('#station_cities'+current_outlet).select2();
			$('#station_areas'+current_outlet).select2();
			$('#outlet_business'+current_outlet).select2();
			$('#delivery_business'+current_outlet).select2();
		
				$('#station_states' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_cities' +current_outlet).html(responseData);
									document.getElementById('station_cities' +current_outlet).disabled = false;
								}
								else {
									$('#station_cities' +current_outlet).empty();
									$('#select2-station_cities'+current_outlet+'-container').empty();
									document.getElementById('station_cities'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_cities'+current_outlet+'-container').empty();
						$('#station_cities'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});

				$('#station_cities' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$(this).siblings('span.select2').removeClass('errorBorder');
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_areas' +current_outlet).html(responseData);
									document.getElementById('station_areas' +current_outlet).disabled = false;
								}
								else {
									$('#station_areas0').empty();
									$('#select2-station_areas'+current_outlet+'-container').empty();
									document.getElementById('station_areas'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_areas'+current_outlet+'-container').empty();
						$('#station_areas'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});		
				
				var city_value = $("#station_cities"+current_outlet+" option:selected").text();
				var state_value = $("#station_states"+current_outlet+" option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat" +current_outlet).val();
				var lot_value = $("#geoip_lon" +current_outlet).val();

				var mapOptions = {
					zoom: 12,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[current_outlet] = new google.maps.InfoWindow({
					content: contentString
				});

				map[current_outlet] = new google.maps.Map(document.getElementById('map-canvas' +current_outlet), mapOptions);

				marker[current_outlet] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[current_outlet]
				});

				infowindow[current_outlet].open(map[current_outlet], marker[current_outlet]);				
		
	});
	
	$('body').on('click', '.add_dist', function() {
		var current_outlet = parseInt($("#current_dist").val());
		current_outlet++;
		$("#current_dist").val(current_outlet)
		
		var html_add = '<div id="dist_'+current_outlet+'"><div class="row" id="location_'+current_outlet+'"><hr>';
			html_add += '<div class="col-sm-10">';
			html_add += '<div class="col-sm-10 no-padding">';
			html_add += '<h2 style="margin-top:0px;"class="col-sm-5 no-padding">Distribution Center: </h2>';
			html_add += '<div class="col-sm-7">';
			html_add += '<input aria-required="true" placeholder="Please fill in Outlet Name" class="form-control" required="required" name="dc_name[]" value="" type="text">';
			html_add += '</div>';
			html_add += '<div class="col-sm-2">&nbsp;</div>';
			html_add += '</div>	';
			html_add += '</div>	';
			html_add += '<div class="col-sm-2"><a href="javascript:void(0);" class="delete_dist btn btn-danger pull-right" rel="'+current_outlet+'">x</a></div>';
			html_add += '<div class="col-sm-12">';
			html_add += '<h3 style="margin-top:0px;">Location</h3>';
			html_add += '</div>';		
			html_add += '<div class="col-sm-5">';
			html_add += '	<label>&nbsp;</label>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Country: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<input aria-required="true" disabled class="form-control" id="station_country_id" required="required" name="country_id" value="Malaysia" type="text">';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">State: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '			<select class="form-control station_states" rel="'+current_outlet+'" id="station_states'+current_outlet+'" name="state_idst[]">';
			html_add += '				<option value="">Choose Option</option>';
			html_add += '			</select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">City: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control station_cities" rel="'+current_outlet+'" id="station_cities'+current_outlet+'" name="city_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Area: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control" id="station_areas'+current_outlet+'" rel="'+current_outlet+'" name="area_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-5 control-label">Postcode /Zip Code: </label>';
			html_add += '						<div class="col-sm-7">';
			html_add += '							<input type="text" name="zipcode[]" class="form-control" required="" value="">		';							
			html_add += '						</div>';
			html_add += '					</div>		';		
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">Address</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line1[]" class="form-control" value="" >';
			html_add += '						</div>	';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line2[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line3[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line4[]" class="form-control" value="">';
			html_add += '						</div>	';
			html_add += '					</div>		';	
			html_add += '</div>';
			html_add += '<div class="col-sm-7">';
			html_add += '	<div id="map-container'+current_outlet+'" class="custom-container" style="width:575px; height:435px;">';
			html_add += '		  <div id="map-canvas'+current_outlet+'" style="width: 540px; height: 400px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden;"></div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';			
			html_add += '<div class="row" id="property">';
			html_add += '			<div class="col-sm-12">';
			html_add += '<input id="geoip_lat'+current_outlet+'" name="geoip_lats[]" value="0" type="hidden">';
			html_add += '<input id="geoip_lon'+current_outlet+'" name="geoip_lons[]" value="0" type="hidden">';					
			html_add += '<div class="form-group">';			
			html_add += '	<label for="shop_size" class="col-sm-2 control-label">Capacity</label>';
			html_add += '	<div class="col-sm-1">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="capacity[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Parcel</label>';
			html_add += '	<div class="col-sm-1">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="parcel[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';	
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Container</label>';
			html_add += '	<div class="col-sm-1">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="container[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';				
			html_add += '<div class="form-group">';
			html_add += '	<label for="contact_property" class="col-sm-2 control-label">Halal</label>';
			html_add += '	<div class="col-sm-1">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="halal[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '<div class="row" id="business">';
			html_add += '	<div class="col-sm-12">';
			html_add += '		<div class="form-group">';
			html_add += '		<div class="col-sm-2">';
			html_add += '				&nbsp;';
			html_add += '		</div>';
			html_add += '		<div class="col-sm-4">';
			html_add += '				&nbsp;';
			html_add += '		</div>';			
			html_add += '		<div class="col-sm-6">';
			html_add += '				<a href="javascript:void(0);" class="add_outlet btn btn-info pull-right">+</a>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '	</div>';						
			$("#outlets").append(html_add);
			var cloneStates = $("#station_states0 > option").clone();
			var cloneBussiness = $("#outlet_business0 > option").clone();
			var cloneDelivery = $("#delivery_business0 > option").clone();
			$('#station_states'+current_outlet).html(cloneStates);
			$('#outlet_business'+current_outlet).html(cloneBussiness);
			$('#delivery_business'+current_outlet).html(cloneDelivery);
			$('#station_states'+current_outlet).select2();
			$('#station_cities'+current_outlet).select2();
			$('#station_areas'+current_outlet).select2();
			$('#outlet_business'+current_outlet).select2();
			$('#delivery_business'+current_outlet).select2();
		
				$('#station_states' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_cities' +current_outlet).html(responseData);
									document.getElementById('station_cities' +current_outlet).disabled = false;
								}
								else {
									$('#station_cities' +current_outlet).empty();
									$('#select2-station_cities'+current_outlet+'-container').empty();
									document.getElementById('station_cities'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_cities'+current_outlet+'-container').empty();
						$('#station_cities'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});

				$('#station_cities' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$(this).siblings('span.select2').removeClass('errorBorder');
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_areas' +current_outlet).html(responseData);
									document.getElementById('station_areas' +current_outlet).disabled = false;
								}
								else {
									$('#station_areas0').empty();
									$('#select2-station_areas'+current_outlet+'-container').empty();
									document.getElementById('station_areas'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_areas'+current_outlet+'-container').empty();
						$('#station_areas'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});		
				
				var city_value = $("#station_cities"+current_outlet+" option:selected").text();
				var state_value = $("#station_states"+current_outlet+" option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat" +current_outlet).val();
				var lot_value = $("#geoip_lon" +current_outlet).val();

				var mapOptions = {
					zoom: 12,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[current_outlet] = new google.maps.InfoWindow({
					content: contentString
				});

				map[current_outlet] = new google.maps.Map(document.getElementById('map-canvas' +current_outlet), mapOptions);

				marker[current_outlet] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[current_outlet]
				});

				infowindow[current_outlet].open(map[current_outlet], marker[current_outlet]);				
		
	});	
	
	$('body').on('click', '.delete_outlet', function() {
		var outlet = $(this).attr('rel');
		$("#oulet_" + outlet).remove();
		//alert(outlet);
	});
	
	$('body').on('click', '.delete_dist', function() {
		var outlet = $(this).attr('rel');
		$("#dist_" + outlet).remove();
		//alert(outlet);
	});	
	
    $('#station_states0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#station_states0 option:selected').text();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_cities0').html(responseData);
						document.getElementById('station_cities0').disabled = false;
                    }
                    else {
                        $('#station_cities0').empty();
                        $('#select2-station_cities0-container').empty();
						document.getElementById('station_cities0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-station_cities0-container').empty();
            $('#station_cities0').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#station_cities0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#station_cities0 option:selected').text();
            $(this).siblings('span.select2').removeClass('errorBorder');
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_areas0').html(responseData);
						document.getElementById('station_areas0').disabled = false;
                    }
                    else {
                        $('#station_areas0').empty();
                        $('#select2-station_areas0-container').empty();
						document.getElementById('station_areas0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-station_areas0-container').empty();
            $('#station_areas0').html('<option value="" selected>Choose Option</option>');
        }
    });	
	
	var map = new Array();
	var infowindow  = new Array();
	var marker  = new Array();

	var map_container = $("#map-container0");
	var map_canvas = $("#map-canvas0");

	$("#station-open-channel").DataTable();

	function initialize() {

		//var title_value = $("#title").attr('placeholder');
		var street_value = $("#street").attr('placeholder');
		var city_value = $("#station_cities0 option:selected").text();
		var state_value = $("#station_states0 option:selected").text();
		//var station_country_id = $("#station_country_id option:selected").text();
		

		var lat_value = $("#geoip_lat0").val();
		var lot_value = $("#geoip_lon0").val();

		var mapOptions = {
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: new google.maps.LatLng(lat_value, lot_value)
		};

		var contentString = city_value + '<br>';+ state_value;

		infowindow[0] = new google.maps.InfoWindow({
			content: contentString
		});

		map[0] = new google.maps.Map(document.getElementById('map-canvas0'), mapOptions);

		marker[0] = new google.maps.Marker({
			position: new google.maps.LatLng(lat_value, lot_value),
			map: map[0]
		});

		infowindow[0].open(map[0], marker[0]);
	}

	function changeMarkerLocation(current) {

		var street = $("#street").val();
		var city = $("#station_cities"+current+" option:selected").text();
		var state = $("#station_states"+current+" option:selected").text();
		var county = $("#station_country_id option:selected").text();

		var address = city + ',' + state + ',' + "Malaysia";

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (data, status) {
			if (status == "OK") {
				var suggestion = data[0];
				var location = suggestion.geometry.location;
				console.debug(location);
				$("#geoip_lat"+current).val(location.lat());
				$("#geoip_lon"+current).val(location.lng());			
				var latLng = new google.maps.LatLng(location.lat(), location.lng());

				marker[current].setPosition(latLng);
				map[current].setCenter(latLng);
			}
		});
	}

	function changeInfoWindowContent(current) {
		
		var street = $("#street").val();
		var city = $("#station_cities"+current+" option:selected").text();
		var state = $("#station_states"+current+" option:selected").text();
		var county = $("#station_country_id option:selected").text();

		var address = city + ',' + state + ',' + "Malaysia";

		var contentString = city + ',' + state + ',' + "Malaysia" + '<br><br>';

		infowindow[current].setContent(contentString);
	}

	function getFinalWidgetCode(map) {
		
		
		var street = $("#street").val().replace(/'/g, "\\'");;
		var city = $("#station_cities0 option:selected").text().replace(/'/g, "\\'");
		var state = $("#station_states0 option:selected").text().replace(/'/g, "\\'");
		var county = $("#station_country_id option:selected").text().replace(/'/g, "\\'");

		var center = map.getCenter();
		var lat = center.lat();
		var lon = center.lng();

		var mapType = map.getMapTypeId();
		var mapTypeStr = "";

		switch (mapType) {
			case "roadmap":
				mapTypeStr = "google.maps.MapTypeId.ROADMAP";
				break;
			case "satellite":
				mapTypeStr = "google.maps.MapTypeId.SATELLITE";
				break;
			case "hybrid":
				mapTypeStr = "google.maps.MapTypeId.HYBRID";
				break;
			case "terrain":
				mapTypeStr = "google.maps.MapTypeId.TERRAIN";
				break;
		}

		$.ajaxSetup({
			async: false
		});

		var hashId = '';
		var finalWidgetCode = '';

		/*var lbCode = "<a href='http://maps-generator.com/'>Maps Generator</a>\n";
		$.get('/google-maps-authorization/code.js').success(function (data) {
			if(data != null && data != '' && data != 'Something Went Wrong!') {
				lbCode = data;
				regExpMatches = data.match(/id=(.*)'/i);
				hashId = regExpMatches[1];
			}
		});

		var finalWidgetCode = "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'><\/script>" +
			"<div style='overflow:hidden;height:" + height + "px;width:" + width + "px;'><div id='gmap_canvas' style='height:" + height + "px;width:" + width + "px;'></div>" +
			"<style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>" +
			lbCode +
			"<script type='text/javascript'>function init_map(){" +
			"var myOptions = {" +
			"zoom:" + zoom + ",center:new google.maps.LatLng(" + lat + "," + lon + ")," +
			"mapTypeId: " + mapTypeStr + "};" +
			"map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);" +
			"marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(" + lat + "," + lon + ")});" +
			"infowindow = new google.maps.InfoWindow({" +
			"content:'" + street + "<br>" + city + "<br>';" +
			"});" +
			"google.maps.event.addListener(marker, 'click', function(){" +
			"infowindow.open(map,marker);" +
			"});" +
			"infowindow.open(map,marker);" +
			"}" +
			"google.maps.event.addDomListener(window, 'load', init_map);" +
			"<\/script>";

		// send to server post request with finalWidgetCode
		if(hashId != '')
		{
			$.post('/save-widget-code', { uniqid: hashId, code: finalWidgetCode })
			 .success(function (data) {
				//
			});
		}*/

		return finalWidgetCode;
	}

	google.maps.event.addDomListener(window, 'load', initialize);

	//initSliders(map, marker);

	$("#street").change(function () {
		changeMarkerLocation();
		changeInfoWindowContent();
	});


	$("#station_cities0").change(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});

	$("#station_states0").change(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});

	$("#station_country_id").change(function () {
		changeMarkerLocation();
		changeInfoWindowContent();
	});



	function changeMapType(map, mapTypeId) {
		map.setMapTypeId(mapTypeId);
	}

	function changeMapZoom(map, zoom) {
		zoom = zoom * 1;
		map.setZoom(zoom);
	}
});
