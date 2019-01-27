@section('extra-links')
	<link rel="stylesheet" type="text/css" media="all" href="{{asset('css/bootstrap-timepicker.min.css')}}">
	<script type="text/javascript" src="{{asset('js/bootstrap-timepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.number.min.js')}}"></script>
@endsection
@section('css')
	#timeslots-tbl {
		margin-top: 50px;
	}
	#timeslots-tbl thead {
		background: #ededed;
	}
@endsection
<div class="modal_loading"></div>
<div class="row">
    <div class="col-sm-12" style="margin-bottom:20px">
        {!!Form::open(array('route'=>'create_new_voucher_v1.post','id'=>'formVoucherv1','class'=>'form-horizontal form-wrp','files'=>true))!!}
            <div id="pinformation" class="">
                <div class="col-sm-12"><h1>Add Voucher V1</h1>
                    <div hidden="" class="col-md-5 alert alert-danger" id="errors_voucherv1">There are some errors on
                        page
                    </div>
                    <div hidden="" class="col-md-5 alert alert-success" id="success_voucherv1">Voucher Added
                        Successfully
                    </div>
                </div>
                <div class="col-sm-4 thumbnail" id='thumbnail'>
                    <div class="product-photo">
                        <img class="img-responsive"  id="imagePreviewVoucherv1"
						style="object-fit:cover;object-position:center top" src="#" alt="" />
                        <div class="inputBtnSection">
                            {!! Form::text('voucher_photo_txtv1',null,['class'=>'disableInputField text-center','id'=>'uploadFilev1','placeholder'=>'Add Voucher Photo','disabled'=>'disabled']) !!}
                            <label class="fileUpload">
                                {!! Form::file('voucher_photov1',['class'=>'upload','id'=>'uploadBtnVoucherv1', 'required']) !!}
                                <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                            </label>
                        </div>
                    </div>
                </div> {{-- End of thumbnail --}}
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="productNamev1" id="productNamev1" class="form-control">
                            <span class=" text-danger" id="errors_voucher_productv1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Brand</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="Brandv1" id="Brandv1">
                                <option value="" selected disabled>select one</option>
                                @foreach($getBrand as $Brand)
                                    <option value="{{$Brand->id}}">{{$Brand->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="errors_voucher_brandv1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="categoryIdv1" id="categoryIdv1">
                                <option selected value="" disabled>select one</option>
                                @foreach($getCategory as $category)
                                    <option value="{{$category->id}}">{{$category->description}}</option>
                                @endforeach
                            </select>
                            <span class=" text-danger" id="errors_voucher_categoryv1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sub Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="subCategoryIdv1" id="subCategoryIdv1">
                                <option value=""></option>
                            </select>
                            <span class="text-danger" id="errors_voucher_sub_categoryv1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            {!! Form::text('OShopname',$oshop, array('class' => 'form-control','readonly'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('short_descriptionv1', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('short_descriptionv1', null, array('class' => 'form-control', 'rows' => '4','id'=>'short_descriptionv1', 'required'))!!}
                        </div>
                    </div>
                </div>
			<div class="clearfix"></div>
            <hr>
	            <?php $months = array('January', 'February', 'March',
					'April', 'May', 'June', 'July', 'August', 'September',
					'October', 'November', 'December'); ?>

	            <!-- Begin timeslot table -->
				<p>Select Month</p>
				<div class="row col-md-3">
	            <select id="months" class="form-control">
		            <?php $i = 1; ?>
					<?php foreach ($months as $month): ?>
						<option value="<?php echo $i ++ ?>">
						<?php echo $month ?></option>
					<?php endforeach ?>
				</select>
				</div>
	            <table class="table table-striped" id="timeslots-tbl">
					<thead>
						<tr>
							<th width="150">
								<p>Day of Month</p>
								<select id="day" class="form-control">
								<?php for ( $i = 1; $i <= 31; $i ++): ?>
									<option value="<?php echo $i ?>">
									<?php echo $i ?></option>
								<?php endfor ?>
								</select>
							</th>
							<th>
								<p>Start Time</p>
								<input type="text" id="time-start" class="form-control">
							</th>
							<th>
								<p>End Time</p>
								<input type="text" id="time-end" class="form-control">
							</th>
							<th>
								<p>Price</p>
								<div class="input-group">
									<div class="input-group-addon">MYR</div>
									<input type="text" id="price" class="form-control"></input>
								</div>
							</th>
							<th>
								<p>Qty Left</p>
								<input class="form-control" id="qty" type="text">
							</th>
							<th>
								<p>&nbsp;</p>
								<a href="javascript:void(0)" id="add-item" class="btn btn-success"> + Add Item</a>
							</th>
						</tr>
					</thead>
					<tbody id="items"></tbody>
				</table>
				<script type="text/javascript">
					$(document).ready(function () {
						
						$('#price').number(true, 2, '.', '');
						$('#qty').number(true, null);
						var startTime = '0:00', endTime = '0:15';
						
						var timepickerOptions = {
							format: 'H:mm', 
							showMeridian: false,
							defaultTime: false
						};
						
						$('#time-start, #time-end').timepicker(timepickerOptions);
						
						
						var dayRow = function (item) {
							return '<tr data-id="' + item.id + '" data-day="' + item.day + '">\
										<td>' + item.day + '</td>\
										<td><input class="time-start timepicker row-inputs form-control" value="' + item.time_start + '"></td>\
										<td><input class="time-end timepicker row-inputs form-control" value="' + item.time_end + '"></td>\
										<td>\
											<div class="input-group">\
												<div class="input-group-addon">MYR</div>\
												<input class="price row-inputs form-control" value="' + item.price + '">\
											</div>\
										</td>\
										<td><input class="qty row-inputs form-control" value="' + item.qty + '"></td>\
										<td><a class="remove-item btn btn-danger" href="javascript:void(0)"> - Remove</a></td>\
									</tr>';
						};
						
						// Current selected month
						var current_month = '1';
						
						var months = {
							"1": [],
							"2": [],
							"3": [],
							"4": [],
							"5": [],
							"6": [],
							"7": [],
							"8": [],
							"9": [],
							"10": [],
							"11": [],
							"12": []
						};
						
						$('#months').change(function () {
							current_month = $(this).val();
							var itemTpl = [];
							
							$.each(months[current_month], function (index, item) {
								itemTpl.push(dayRow(item));
							});
							
							var month_days = new Date(2000, parseInt(current_month), 0).getDate();
							
							$('#day').html('');
							for (i = 1; i <= month_days; i ++) {
								$('#day').append('<option value="' + i + '">' + i + '</option>');
							}
							$('#day').select2().trigger('change');
							
							resetDates();
							$('#items').html(itemTpl.join(''));
							$('.price').number(true, 2, '.', '');
							$('.qty').number(true, null);
							$('#items .timepicker')
							.timepicker(timepickerOptions)
							.on('changeTime.timepicker', function () {
								$(this).focus();
							});
						});
						
						// Id of the row
						var idx = 0;
						$('#add-item').click(function () {
							var item = {
								id: idx ++,
								day: $('#day').val(),
								time_start: $('#time-start').val(),
								time_end: $('#time-end').val(),
								price: $('#price').val(),
								qty: $('#qty').val()
							};
							
							// No time? Too bad. You can't go further.
							if (item.time_start == '' || item.time_end == '') {
								toastr.error('Please fill the time fields');
								return;
							}
							
							// MomentJS times.
							var ts = moment(item.time_start, 'HH:mm');
							var te = moment(item.time_end, 'HH:mm');
							
							// Time Start after Time End? Seriously? Stop it!
							if (ts.isAfter(te)) {
								toastr.error('The start time cannot be after end time');
								return;
							}
							
							if (item.price == '') {
								toastr.error('Please fill the price field');
								return;
							}
							
							if (item.qty == '' || item.qty < 1) {
								toastr.error('Please fill the quantity field');
								return;
							}
							
							months[current_month].push(item);
							toastr.success('The timeslot was created successfully');
							
							$('#items').append(dayRow(item));
							resetDates(true);
							$('#items .timepicker')
							.timepicker(timepickerOptions)
							.on('changeTime.timepicker', function () {
								$(this).focus();
							});
							$('.price').number(true, 2, '.', '');
							$('.qty').number(true, null);
							$.post('table-test.php', months);
						});
						
						$('#items').on('click', '.remove-item', function () {
							var $row = $(this).closest('tr'),
								id = $row.data('id'),
								month_data = months[current_month];
							
							for (var i in month_data) {
								if (month_data[i].id == id) months[current_month].splice(i, 1);
							}
							$row.remove();
							resetDates();
							toastr.success('The row was deleted successfully');
						});
						
						// This variable holds the old values of an existing item
						var old = {};
						
						$('#items').on('click', '.row-inputs', function () {
							var $row = $(this).closest('tr');
							old.id = $row.data('id');
							old.day = $row.data('day');
							old.time_start = $row.find('.time-start').val();
							old.time_end = $row.find('.time-end').val();
							old.price = $row.find('.price').val();
							old.qty = $row.find('.qty').val();
						})

						$('#items').on('blur', '.row-inputs', function () {
							//var $row = $(this).closest('tr'), id = $row.data('id'), day = $row.data('day'), item = {}, has_errors = false;
							var $row = $(this).closest('tr'), day = $row.data('day'), id = $row.data('id'), has_errors = false;
							
							/*item.id = id;
							item.day = day;
							item.time_start = $row.find('.time-start').val();
							item.time_end = $row.find('.time-end').val();
							item.price = $row.find('.price').val();
							item.qty = $row.find('.qty').val();*/
							var item = {
								id : id,
								day : day,
								time_start : $row.find('.time-start').val(),
								time_end : $row.find('.time-end').val(),
								price : $row.find('.price').val(),
								qty : $row.find('.qty').val()
							};
							
							var prev = months[current_month][0], next = months[current_month][(months[current_month].length - 1)];
				
							for (var i = 0; i < months[current_month].length; i ++) {
							
								if (months[current_month][i].id == item.id) {
								
									if (months[current_month][(i - 1)] !== undefined) prev = months[current_month][(i - 1)];
									if (months[current_month][(i + 1)] !== undefined) next = months[current_month][(i + 1)];
									
									break;
								}
							}
							
							// No time? Too bad. You can't go further.
							if (item.time_start == '' || item.time_end == '') {
								toastr.error('Please fill the time fields. The old values will be used instead.');
								has_errors = true;
							}

							/*for (var i in months[current_month]) {
								if (months[current_month][i].id != item.id) {
									if (months[current_month][i].time_start != item.time_start) {
										has_errors = true;
										toastr.error('This timeslot is already present in the table. The old values will be used instead. Doublecheck the data to continue.');
									}
								}
							}*/
						
							// MomentJS times.
							var ts = moment(item.time_start, 'HH:mm'), te = moment(item.time_end, 'HH:mm');
							
							// Previous & Next time rows
							var pt = moment(prev.time_end, 'HH:mm'), nt = moment(next.time_start, 'HH:mm');
							
							if (prev.id != item.id) {
								if (ts.isBefore(pt)) {
									has_errors = true;
									toastr.error('This timeslot has already been taken. The old values will be used instead.');
								}
							}
							
							if (next.id != item.id) {
								if (te.isAfter(nt)) {
									has_errors = true;
									toastr.error('This timeslot has already been taken. The old values will be used instead.');
								}
							}
							
							// Time Start after Time End? Seriously? Stop it!
							if (ts.isAfter(te)) {
								toastr.error('The start time cannot be after end time. The old values will be used instead.');
								has_errors = true;
							}
							
							
							if (item.price == '') {
								toastr.error('Please fill the price field. The old values will be used instead.');
								has_errors = true;
							}
							
							if (item.qty == '') {
								toastr.error('Please fill the quantity field. The old values will be used instead.');
								has_errors = true;
							}
							
							if (has_errors) {
								$row.find('.time-start').val(old.time_start);
								$row.find('.time-end').val(old.time_end);
								$row.find('.price').val(old.price);
								$row.find('.qty').val(old.qty);
								return;
							}
							
							for (var i in months[current_month]) {
								if (months[current_month][i].id == item.id) {
									months[current_month][i] = item;
								}
							}
						});

						var resetDates = function (resetDay) {
							var rd = resetDay || false;
							//var startTime = '0:00';
							//var endTime = '0:15';
							
							if (months[current_month][(months[current_month].length - 1)] !== undefined) {
								var maxRow = months[current_month][(months[current_month].length - 1)];
								startTime = moment(maxRow.time_end, 'HH:mm')
											.add(15, 'minutes')
											.format('H:mm')
											.toString();
								endTime = moment(startTime, 'HH:mm')
										.add(15, 'minutes')
										.format('H:mm')
										.toString();
							}
							
							if (rd) $('#day').val(1);
							$('#time-start').val(startTime);
							$('#time-end').val(endTime);
							$('#price').val('');
							$('#qty').val('');
						};
					
					});
				</script>
				<!-- End timeslot table -->
				<div class="clearfix"></div>
                    <div id="voucher" class="row">
                        <div class="col-sm-12">
                            <h4>Applicable To</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <input type="radio" class="validity" value="wyear" name="validity">
                                <label for="checkbox2">
                                    Whole Year
                                </label>
                            </div>
                            <div class="">
                                <input checked="" type="radio" class="validity" value="wmonth" name="validity">
                                <label for="checkbox2">
                                    Whole Month
                                </label>
                            </div>
                            <div class="">
                                <label for="checkbox2">
                                    <input type="radio" class="validity" value="wweek" name="validity">

                                    Whole Week
                                </label>
                            </div>

                            <div class="">
                                <label for="checkbox2">
                                    <input type="radio" class="validity" value="wkdays" name="validity">

                                    Weekdays Only
                                </label>
                            </div>
							
                            <div class="">
                                <label for="checkbox2">
                                    <input type="radio" class="validity" value="wkends" name="validity">

                                    Weekends Only
                                </label>
                            </div>							
                          <!--   <div class="table_voucher_timeslot">
                                <label for="checkbox2">

                                    <input type="radio" class="" value="wkends" name="validity">
                                    Whole Week
                                </label>
                            </div>
                        </div> -->
                    </div>
                </div>	
				<div class="clearfix"></div>				
				<!--- address start-->
				<div class="col-sm-6">
					<h3>Locations</h3>
					@if(is_null($outlets))
						<p style="color:red;">No outlets found</p>
					@else
						@foreach($outlets as $outlet)
							<div class="input-group">
								<input type="checkbox" class="markerclick" rel="{{$outlet->spid}}" id="{{$outlet->spid}}" value="{{$outlet->spid}}" name="outletsv1[]"> {{$outlet->biz_name}}
							</div>
							<p style="display:none;" id="address_{{$outlet->spid}}">
								{{$outlet->line1}}@if(!is_null($outlet->line2) && $outlet->line2 != "") ,{{$outlet->line2}} @endif @if(!is_null($outlet->line3) && $outlet->line3 != "") ,{{$outlet->line3}} @endif @if(!is_null($outlet->line4) && $outlet->line4 != "") ,{{$outlet->line4}} @endif
								<br>
								@if(!is_null($outlet->postcode) && $outlet->postcode != ""){{$outlet->postcode}} @endif
								@if(!is_null($outlet->city_name) && $outlet->city_name != "")@if(!is_null($outlet->postcode) && $outlet->postcode != "") , @endif{{$outlet->city_name}} @endif
							</p>
							<p style="display:none;" id="addressm_{{$outlet->spid}}">
								@if(!is_null($outlet->postcode) && $outlet->postcode != ""){{$outlet->postcode}} @endif
								@if(!is_null($outlet->city_name) && $outlet->city_name != "")@if(!is_null($outlet->postcode) && $outlet->postcode != "") , @endif{{$outlet->city_name}} @endif
							</p>
						@endforeach
					@endif
				</div>				
				<div class="col-sm-6">
					<div id="map-containerv" class="custom-container pull-right" style="width:575px; height:435px;">
                              <div id="map-canvasv" style="width:540px; height:400px;">
                              </div>
                     </div>
				</div>
	<!--- address end-->
            
				
				<div class="clearfix"></div>
                <hr>	

				<div id="product" class="row">
					<div class="col-xs-12">
						<h2>Voucher Details</h2>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-12">
						{!! Form::textarea('voucher_detailsv1', null, array('class' => 'form-control','id'=>'info-detailsv1'))!!}
					</div>
					<div class="clearfix"> </div>
				</div>	
				<div class="clearfix"></div>
                <div class="row">
					@if(is_null($outlets))
						<p style="color:red;" class="text-right">Can't add voucher</p>
					@else
						<div class="col-sm-12 text-right"><input type="submit" class="btn btn-green" id="submit_v1" value="Submit"></div>
					@endif
                </div>
       </div>
	   {!!Form::close()!!}
   </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	
	var mapv;
	$(".markerclick").click(function (e) {
		var addressid = $(this).attr('rel');
		console.log(addressid);
		var address = $("#addressm_" + addressid).text();
		console.log(address);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (data, status) {
			if (status == "OK") {
				var suggestion = data[0];
				var location = suggestion.geometry.location;
				console.debug(location);
				var latLng = new google.maps.LatLng(location.lat(), location.lng());
				marker = new google.maps.Marker({
					position: latLng,
					map: mapv
				});	
				mapv.setCenter(latLng);
			} else{
				console.log(status);
			}
		});			

    });	
		
		var map_container = $("#map-containerv");
		var map_canvas = $("#map-canvasv");

		function initialize() {

			var mapOptions = {
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(0, 0)
			};

			infowindow = new google.maps.InfoWindow({
				content: ""
			});

			mapv = new google.maps.Map(document.getElementById('map-canvasv'), mapOptions);

			infowindow.open(mapv);
		}
	
		
		google.maps.event.addDomListener(window, 'load', initialize);
	
		$('body').on('dp.change', '.time_hours_to', function() {
		//$(".time_hours_to").on("dp.change", function(e) {
		//	console.log("To validation");
			var rel =  $(this).attr('rel');
			$("#error_t_t" + rel).hide();
			$("#submit_v1").attr("disabled",false);
			var fromval = $("#time_hours_f" + rel).data('date');
			var myval = $(this).data('date');
			if(fromval ==  myval){
				$("#error_t_t" + rel).text("Please, select a valid time");
				$("#error_t_t" + rel).show();
				$("#submit_v1").attr("disabled",true);
			} else {
			//	console.log("Different");
				var fromvalarr = fromval.split(" ");
				var myvalarr = myval.split(" ");
				//console.log(fromvalarr);
				//console.log(myvalarr);
				if(fromvalarr[1] == myvalarr[1]){
				//	console.log("same");
					fromvalarrhrs = fromvalarr[0].split(":");
					myvalarrhrs = myvalarr[0].split(":");
					if(fromvalarrhrs[0] == "12"){
						fromvalarrhrs[0] = "00";
					}
					if(myvalarrhrs[0] == "12"){
						myvalarrhrs[0] = "00";
					}					
					if(fromvalarrhrs[0] == myvalarrhrs[0]){
						if(parseInt(fromvalarrhrs[1]) > parseInt(myvalarrhrs[1])){
							$("#error_t_t" + rel).text("Please, select a valid time");
							$("#error_t_t" + rel).show();
							$("#submit_v1").attr("disabled",true);
						}
					} else {
						if(parseInt(fromvalarrhrs[0]) > parseInt(myvalarrhrs[0])){
							$("#error_t_t" + rel).text("Please, select a valid time");
							$("#error_t_t" + rel).show();
							$("#submit_v1").attr("disabled",true);							
						}
					}
				} else {
					//console.log("different");
					if(fromval[1] == "PM" && myvalarr[1] == "AM"){
						$("#error_t_t" + rel).text("Please, select a valid time");
						$("#error_t_t" + rel).show();
						$("#submit_v1").attr("disabled",true);							
					}
				} 
			}
		});
		
		$(".time_hours_to").datetimepicker({
			format: 'h:mm A', 
		});	
	
		$('body').on('dp.change', '.time_hours', function() {
		//$(".time_hours").on("dp.change", function(e) {
			//alert("fasfsadf");
			var rel =  $(this).attr('rel');
			if(rel != "0"){	
				var past_rel = parseInt(rel) - 1;
				$("#error_t_f" + rel).hide();
				$("#submit_v1").attr("disabled",false);
				var fromval = $("#time_hours_t" + past_rel).data('date');
				var myval = $(this).data('date');
				if (fromval != null){
					if(fromval ==  myval){
						$("#error_t_f" + rel).text("Please, select a valid time");
						$("#error_t_f" + rel).show();
						$("#submit_v1").attr("disabled",true);
					} else {
					//	console.log("Different");
						var fromvalarr = fromval.split(" ");
						var myvalarr = myval.split(" ");
						//console.log(fromvalarr);
						//console.log(myvalarr);
						if(fromvalarr[1] == myvalarr[1]){
						//	console.log("same");
							fromvalarrhrs = fromvalarr[0].split(":");
							myvalarrhrs = myvalarr[0].split(":");
							if(fromvalarrhrs[0] == "12"){
								fromvalarrhrs[0] = "00";
							}
							if(myvalarrhrs[0] == "12"){
								myvalarrhrs[0] = "00";
							}						
							if(fromvalarrhrs[0] == myvalarrhrs[0]){
								if(parseInt(fromvalarrhrs[1]) > parseInt(myvalarrhrs[1])){
									$("#error_t_f" + rel).text("Please, select a valid time");
									$("#error_t_f" + rel).show();
									$("#submit_v1").attr("disabled",true);
								}
							} else {
								if(parseInt(fromvalarrhrs[0]) > parseInt(myvalarrhrs[0])){
									$("#error_t_f" + rel).text("Please, select a valid time");
									$("#error_t_f" + rel).show();
									$("#submit_v1").attr("disabled",true);							
								}
							}
						} else {
							//console.log("different");
							if(fromval[1] == "PM" && myvalarr[1] == "AM"){
								$("#error_t_f" + rel).text("Please, select a valid time");
								$("#error_t_f" + rel).show();
								$("#submit_v1").attr("disabled",true);							
							}
						} 
					}
				} else {
					$("#error_t_t" + past_rel).text("Please, select a valid time");
					$("#error_t_t" + past_rel).show();
					$("#submit_v1").attr("disabled",true);					
				}				
			} 
			$("#error_t_t" + rel).hide();
			$("#submit_v1").attr("disabled",false);
			var fromval = $(this).data('date');
			var myval = $("#time_hours_t" + rel).data('date');
			//console.log(myval);
			if (myval != null){
				if(fromval ==  myval){
					$("#error_t_t" + rel).text("Please, select a valid time");
					$("#error_t_t" + rel).show();
					$("#submit_v1").attr("disabled",true);
				} else {
				//	console.log("Different");
					var fromvalarr = fromval.split(" ");
					var myvalarr = myval.split(" ");
					//console.log(fromvalarr);
					//console.log(myvalarr);
					if(fromvalarr[1] == myvalarr[1]){
					//	console.log("same");
						fromvalarrhrs = fromvalarr[0].split(":");
						myvalarrhrs = myvalarr[0].split(":");
						if(fromvalarrhrs[0] == "12"){
							fromvalarrhrs[0] = "00";
						}
						if(myvalarrhrs[0] == "12"){
							myvalarrhrs[0] = "00";
						}						
						if(fromvalarrhrs[0] == myvalarrhrs[0]){
							if(parseInt(fromvalarrhrs[1]) > parseInt(myvalarrhrs[1])){
								$("#error_t_t" + rel).text("Please, select a valid time");
								$("#error_t_t" + rel).show();
								$("#submit_v1").attr("disabled",true);
							}
						} else {
							if(parseInt(fromvalarrhrs[0]) > parseInt(myvalarrhrs[0])){
								$("#error_t_t" + rel).text("Please, select a valid time");
								$("#error_t_t" + rel).show();
								$("#submit_v1").attr("disabled",true);							
							}
						}
					} else {
						//console.log("different");
						if(fromval[1] == "PM" && myvalarr[1] == "AM"){
							$("#error_t_t" + rel).text("Please, select a valid time");
							$("#error_t_t" + rel).show();
							$("#submit_v1").attr("disabled",true);							
						}
					} 
				}
			}			
		});
		$(".time_hours").datetimepicker({
			format: 'h:mm A', 
		});	
		
		$("#datepicker-in2").datetimepicker({
			inline: true,
			format: "YYYY-MM-DD"
		});	
		$("#datepicker-in2").on("dp.change", function(e) {
			var datev1 = new Date($("#datepicker-in2").data('date'));
			console.log(datev1);
			var datev1string = datev1.toDateString();
			var datearrv1 = datev1string.split(" ");
			var selected_datefv1 = datearrv1[1] + " " + datearrv1[2] + ", " + datearrv1[3];
			$("#selected_datefv1").val(selected_datefv1)
			$(".datev1").val(selected_datefv1)			
			$("#selected_datev1").val($("#datepicker-in2").data('date'));	
			console.log($("#datepicker-in2").data('date'));
        });        
		$(".addTimeSlot").on('click', function () {
			//console.log("addTimeSlot");
            var datef = $("#selected_datefv1").val();
			var trk = $('.tableTimeSlot tr').length;
			var k = parseInt(trk) - 1;
            var data4 = "<tr>" +
                    "<td width='10'><input type='text' name='bookingDate[]' class='form-control' disabled value='" + datef + "'></td>" +
                    "<td width='30'><div class='input-group'><span class='input-group-addon'>From</span>" +
                    "<input type='text'  name='fromTime[]' id='time_hours_f" + k + "' rel='" + k + "' class='form-control time_hours'></div><span style='color:red; font-size: 10px; display:none;' id='error_t_f" + k + "'></span></td>" +
                    "<td width='30'><div class='input-group'><span class='input-group-addon'>To</span>" +
                    "<input type='text' name='toTime[]' id='time_hours_t" + k + "' rel='" + k + "' class='form-control time_hours_to'></div><span style='color:red; font-size: 10px; display:none;' id='error_t_t" + k + "'></span></td>" +
                    "<td width='30'><div class='input-group'><span class='input-group-addon'>MYR</span>" +
                    "<input type='text' name='price[]' id='price_" + k + "'class='calInput myr-price form-control' ></div></td>" +
                    "<td width='10'><input type='text' id='qty_" + k + "' name='qtyOrdered[]' class='form-control' ></td>" +
					"<td width='10'>"+
					"<a href='javascript:void(0);' class='text-danger'><i class='fa fa-minus-circle deleteTimeSlot'></i></a></td>" +
                    "</tr>";
            $(".tableTimeSlot").append(data4);
            row = k;
			$(".time_hours_to").datetimepicker({
				format: 'h:mm A', 
			});	
		
			$(".time_hours").datetimepicker({
				format: 'h:mm A', 
			});
			$('input.myr-price').number(true, 2);
            k++;
        });
		
		$(".table_voucher_timeslot").on("click", ".deleteTimeSlot", function () {
			$(this).parent().parent().parent().remove();


		});		

        $('#uploadBtnVoucherv1').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        $("#imagePreviewVoucherv1").attr("src",this.result);
                        //$("#imagePreviewVoucher").css("background-repeat", "round");
                    }
                }
            });
	
        $("#categoryIdv1").on('change', function (e) {

            var categoryId = $('select[name=categoryIdv1]').val();
            var loader = $('.loader');
            var batchOption = $('#subCategoryIdv1');
            $.ajax({
                url: 'selectCategoryWiseSubCategory/' + categoryId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    loader.show();
                },
                success: function (data) {
                    batchOption.empty();
                    batchOption.append('<option value="" selected disabled>Please select</option>');
                    $.each(data, function (index, value) {
                        batchOption.append('<option value="' + value.id + '">' + value.description + '</option>');
                    });
                    loader.hide();
                },
                error: function (data) {
                    alert('error occurred! Please Check');
                    loader.hide();
                }
            });

        });	
	
		$("#minusretailv1").click(function (e) {
			var val = $("#retailv1").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#retailv1").val(val);
			} else {
				$("#retailv1").val(newval);
			}
		});
		
		$("#plusretailv1").click(function (e) {
			var val = $("#retailv1").val();
			var newval = parseInt(val) + 1;
			$("#retailv1").val(newval);
		});	
		$('#retailv1').number(true, 2);
		$("#minusdiscountedv1").click(function (e) {
			var val = $("#discountedv1").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#discountedv1").val(val);
			} else {
				$("#discountedv1").val(newval);
			}
		});

		$("#plusdiscountedv1").click(function (e) {
			var val = $("#discountedv1").val();
			var newval = parseInt(val) + 1;
			$("#discountedv1").val(newval);
		});	
		$('#discountedv1').number(true, 2);
		$("#minusvalidityv1").click(function (e) {
			var val = $("#validityv1").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#validityv1").val(val);
			} else {
				$("#validityv1").val(newval);
			}
		});

		$("#plusvalidityv1").click(function (e) {
			var val = $("#validityv1").val();
			var newval = parseInt(val) + 1;
			$("#validityv1").val(newval);
		});	

		$("#minusvoucherv1").click(function (e) {
			var val = $("#voucherv1").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#voucherv1").val(val);
			} else {
				$("#voucherv1").val(newval);
			}
		});

		$("#plusvoucherv1").click(function (e) {
			var val = $("#voucherv1").val();
			var newval = parseInt(val) + 1;
			$("#voucherv1").val(newval);
		});	

		$("#minusqtyv1").click(function (e) {
			var val = $("#qtyv1").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#qtyv1").val(val);
			} else {
				$("#qtyv1").val(newval);
			}
		});

		$("#plusqtyv1").click(function (e) {
			var val = $("#qtyv1").val();
			var newval = parseInt(val) + 1;
			$("#qtyv1").val(newval);
		});			
	
        $("#formVoucherv1").submit(function (e) {

            $("body").addClass("loading");

            $("#errors_voucherv1").hide();
            $("#success_voucherv1").hide();
            $("#errors_voucher_productv1").html('');
            $("#errors_voucher_brandv1").html('');
            $("#errors_voucher_timeslotv1").html('');
            $("#errors_voucher_categoryv1").html('');
            $("#errors_voucher_sub_categoryv1").html('');
            $("#errors_voucher_retail_pricev1").html('');
            $("#errors_voucher_addressv1").html('');
            $("#error_zipv1").html('');
            $("#error_cityv1").html('');
            $("#error_statev1").html('');


            e.preventDefault();
            var form = $('#formVoucherv1')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
			//console.log(formData);
            $.ajax({
                url: $('#formVoucherv1').attr('action'),
                data: formData,
                type: "POST",
                datatype: "JSON",
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    $('#productNamev1').val('');
                    $('select').val('');
                    $("#success_voucherv1").show();
                    $("#errors_voucherv1").hide();
                    $("body").removeClass("loading");
					window.scrollTo(0, document.body.scrollHeight);
                },
                error: function (response) {
					console.log(response);
                    $("body").removeClass("loading");
                    $("#success_voucherv1").hide();
                    $("#errors_voucherv1").show();
                    /*if (response.responseJSON.productName !="") {
                     $("#errors_voucher").html('<p>Product name is required</p>');
                     }*/
                    $("#errors_voucher_product").html(response.responseJSON.productName);
                    $("#errors_voucher_brandv1").html(response.responseJSON.Brand);
                    $("#errors_voucher_categoryv1").html(response.responseJSON.categoryId);
                    $("#errors_voucher_sub_categoryv1").html(response.responseJSON.subCategoryId);
                    $("#errors_voucher_retail_pricev1").html(response.responseJSON.retail_price);
                    $("#errors_voucher_addressv1").html(response.responseJSON.address);
                    $("#errors_voucher_timeslotv1").html(response.responseJSON.timeslot);
					$("#error_statev1").html(response.responseJSON.state);
					$("#error_cityv1").html(response.responseJSON.city);
					$("#error_zipv1").html(response.responseJSON.zip_code);
					//$("#error_country").html(response.responseJSON.country);
					window.scrollTo(0, document.body.scrollHeight);
                }

            })

        });    
	
	$('#info-detailsv1').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
    });		
	
    $('#states_v').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#states_v option:selected').text();
                    $('#states_v_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#cities_voucher').html(responseData);

                            }
                            else {
                                $('#cities_voucher').empty();
                                $('#select2-cities_voucher-container').empty();
                             document.getElementById('cities_voucher').disabled = true;
                            }
                             document.getElementById('areas_voucher').disabled = true;   
                            document.getElementById('cities_voucher').disabled = false;
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-cities_voucher-container').empty();
                    $('#cities_voucher').html('<option value="" selected>Choose Option</option>');
                }
            });
			$('#cities_voucher').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#cities_voucher option:selected').text();
                    $('#cities_voucher_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#areas_voucher').html(responseData);
                                document.getElementById('areas_voucher').disabled = false;
                            }
                            else {
                                $('#areas_voucher').empty();
                                $('#select2-areas_voucher-container').empty();
                                document.getElementById('areas_voucher').disabled = false;
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-areas_voucher-container').empty();
                    $('#areas_voucher').html('<option value="" selected>Choose Option</option>');
                }
            });
 });			
</script>
