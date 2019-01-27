@extends('common.default')
@section('extra-links')
    <link rel="stylesheet" type="text/css" href="{{asset('css/productbox.css')}}" )>
    <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script>
    <style>
        /*SMM*/
        .productbox {
            margin-right: 0px;
        }

        .selected {
            border: 1px green solid;
        }

        thead tr td.special_price_row {
            padding: 0px;
            font-size: 12px;
        }

        /*SMM ENDS*/

        hr {
            border-top-color: #5F6879;
            margin-top: 0px;

        }

        .priceTable thead tr th,
        .priceTable tbody tr td {
            padding: 0px;
            border: 0px;
            font-size: 12px;
        }

        .priceTable thead tr th {
            padding-bottom: 5px;
        }

        .list-inline {
            margin-top: 10px;
        }

        .showAlert {
            padding: 2px 5px;
            font-size: 12px;
            border-radius: 20px;
        }

        .product-name {
            font-weight: bold;
            @if(Auth::check())
                       border-bottom: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
            @else
                       padding-top: 9px;
        @endif
        }

        .qty-area {
            padding-top: 7px;
            padding-bottom: 7px;
            border-bottom: 1px solid #ccc;
        }

        .tier-price {
            padding-top: 4px;
            padding-bottom: 0px;
            height: 100px;
            overflow: hidden;
        }

        .tier-price div p {
            padding-bottom: 0px;
            margin-bottom: 2px;
            font-size: 12px;
            font-weight: bold;
        }

        .productName {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-price {
            font-weight: bold;
            padding-top: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .popover {
            width: 16%;
        }

        @media (max-width: 321px) {
            .popover {
                width: 70%;
            }
        }

        .popover-content {
            padding: 9px 25px;
        }

        .popover-title {
            padding: 9px 10px;
        }

        .cat-img {
            padding: 0px;
            min-height: 220px;
        }

        .cat-img img {
            height: 200px !important;
        }

        .list-inline li {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            text-align: center;
            padding-top: 2px;
        }

        .save {
            background: red;
            color: #fff;
            padding-left: 7px;
            border-radius: 20px;
            padding-right: 7px;
            padding-bottom: 3px;
        }

        .p-box-content {
            padding: 0px 8px 0px 8px;
        }

        button.btn-xs {
            padding: 4px 5px !important;
        }

        {{-- stop --}}
		.col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }

        @media (min-width: 768px) {
            .col-sm-15 {
                width: 20%;
                float: left;
            }
        }

        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }

        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }

        .btn-subcat {
            border: none;
            background: #fff;
            padding-left: 0px;
        }
    </style>
@stop

@def $currency = \App\Models\Currency::where('active',1)->first()->code;
@section('content')

    <div class="container">
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
        {{-- ^ No need maybe? --}}
        <div class="row">
            <div id="retail_product_content" class="col-md-12">
                <div id="content-retail" class='content-tab hidden'>
                    <div class="col-sm-12" style="margin-bottom:10px">
                        <div class="row">
                            <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">Retail</h2>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>

                <div id="content-B2B" class='content-tab hidden'>


                </div>
                <div id="content-voucher" class='content-tab'>
                    <div class="col-sm-12" style="margin-bottom:20px">
						@if($voucher_data['voucher_product']->segment=='v2')
							<H2>Ordenary Voucher</H2>
							@if($voucher_data['voucher_product']->photo_2 == '')
								<div class="col-md-9" style="background-color: #D7E748;min-height: 220px">
							@else
							<div class="col-md-9" style="min-height: 220px;">
							<div style="min-height: 220px;background-size:cover;
									position: absolute;
										top: 0;
										left: 0;
										width: 100%;
										height: 100%;
										opacity : 0.4;
										z-index: -1;						
										background-position: center top;
										background-image: url('{{asset('/')}}images/product/{{$voucher_data['voucher_product']->id}}/{{$voucher_data['voucher_product']->photo_2}}');"></div>							
							@endif
							<p>
								<span class="col-md-3" >Price</span>
								<span class="col-md-3" >{{$currency->code or 'MYR'}} {{number_format(($voucher_data['voucher_product']->retail_price)/100,2)}} /pax</span>
								<span class="col-md-6" >Voucher ID: [{{str_pad($voucher_data['voucher']->id, 10, '0', STR_PAD_LEFT)}}]</span>
							</p>
							<p>
								<span class="col-md-3" >Description</span>
								<span class="col-md-9" >{{$voucher_data['voucher_product']->description}}</span>
							</p>		
							<p>
								<span class="col-md-3" >Category</span>
								<span class="col-md-3" >{{$voucher_data['voucher_category']->description}}</span>
								<span class="col-md-3" >Sub Category</span>
								<span class="col-md-3" >{{$voucher_data['voucher_subcategory']->description}}</span>								
							</p>	
							<p>
								<span class="col-md-3" >Quantity</span>
								<span class="col-md-3" >{{$voucher_data['voucher']->unit}}/person</span>							
							</p>							
							</div>
							<div class="col-md-3" style="min-height: 220px;">
								<div style="min-height: 220px;background-size:cover;
									position: absolute;
										top: 0;
										left: 0;
										width: 100%;
										height: 100%;
										z-index: -1;						
										background-position: center top;
										background-image: url('{{asset('/')}}images/product/{{$voucher_data['voucher_product']->id}}/{{$voucher_data['voucher_product']->photo_1}}');"></div>							
							</div>						
						@else	
							<H2>Scheduled Voucher</H2>
								<div class="col-sm-3">
								<div class="thumbnail">
									<img src="{{asset('/')}}images/product/{{$voucher_data['voucher_product']->id}}/{{$voucher_data['voucher_product']->photo_1}}" title="product-image" class="img-responsive">
								</div>							
								</div>
								<div class="col-md-9">
									<br>
									<p>
										<span class="col-md-3" ><strong>Name</strong></span>
										<span class="col-md-9" >{{$voucher_data['voucher_product']->name}}</span>
									</p>
									<br>
									<p>
										<span class="col-md-3" ><strong>Category</strong></span>
										<span class="col-md-9" >{{$voucher_data['voucher_category']->description}}</span>								
									</p>	
									<br>
									<p>
										<span class="col-md-3" ><strong>Sub Category</strong></span>
										<span class="col-md-9" >{{$voucher_data['voucher_subcategory']->description}}</span>								
									</p>
									<br>							
									<p>
										<span class="col-md-3" ><strong>Description</strong></span>
										<span class="col-md-9" >{{$voucher_data['voucher_product']->description}}</span>
									</p>
								</div>
								<div class="clearfix"></div>
								<div class='col-sm-3'>
									<div class="form-group">
										<div class="row">
											<div class="col-md-8">
												<div id="datetimepicker12"></div>
											</div>
										</div>
									</div>
									<?php 
										$today = date('Y-m-d');
										$myyear = date('Y');
										$maxdate = "2050-12-12";
										$weekdays = false;
										$weekends = false;
										$date = new DateTime();
										$mydate = $date->modify('this week +6 days');	
										$wweek= $mydate->format('Y-m-d');
										if($voucher_data['voucher']->validity == 'wyear'){
											$maxdate =  date("Y-m-t", strtotime($myyear . "-12-12"));
										} else if($voucher_data['voucher']->validity == 'wmonth'){
											$maxdate =  date("Y-m-t", strtotime($today));
										} else if($voucher_data['voucher']->validity == 'wweek'){
											$maxdate = $wweek;
										} else if($voucher_data['voucher']->validity == 'wkdays'){
											$weekdays = true;
										} else if($voucher_data['voucher']->validity == 'wkends'){
											$weekends = true;
										}
									?>
									<script type="text/javascript">
										$(function () {
											$('#datetimepicker12').datetimepicker({
												inline: true,
												minDate: '{{$today}}',
												maxDate: '{{$maxdate}}',
												@if($weekdays)
												daysOfWeekDisabled: [0, 6],
												@endif
												@if($weekends)
												daysOfWeekDisabled: [1,2,3,4,5],
												@endif										
												format: 'DD/MM/YYYY'
											});
										});
									</script>
								</div>
								<script type="text/javascript">
								/*	$(function() {              
									   // Bootstrap DateTimePicker v4
									   $('#datetimepicker4').datetimepicker({
											 format: 'DD/MM/YYYY'
									   });
									});   */   
								</script>
								<div class="col-md-9">
									<h3>Time Slot</h3>
									<div class="table-responsive">
										<table width="100%" id="buyvouchertable" class="table table-striped table-bordered">
											<thead>
											<tr>
												<td width="5%">&nbsp;</td>
												<td width="25%">Date</td>
												<th width="20%">From</th>
												<th width="20%">To</th>
												<th width="15%">Price</th>
												<th width="10%">Qty&nbsp;Left</th>
												<th width="25%">Qty</th>
											</tr>
											</thead>
											<tbody>
											@if(!empty($voucher_data['voucher_timeslots']))
												@foreach($voucher_data['voucher_timeslots'] as $i)
													<tr>
														<td><input type="radio" rel="{{$i->id}}" value="{{$i->id}}" name="timeslotv1"></td>
														<td>{{date("d M y",strtotime($i->booking))}}</td>
														<td>{{date("H:i",strtotime($i->from))}}</td>
														<td>{{date("H:i",strtotime($i->to))}}</td>
														<td>{{number_format($i->price/100,2)}}</td>
														<td>{{$i->qty_ordered}}</td>
														<td><input type="text"></td>
													</tr>
												@endforeach
											@else
												<p>No time slot found</p>
											@endif
											</tbody>

										</table>
									</div>
								</div>
						@endif
						 <div class="col-md-12">
							<div class="col-md-4">
								<h3 >Locations</h3>
								@if(!is_null($voucher_data['voucher_outlets']))
									@foreach($voucher_data['voucher_outlets'] as $outlet)
										<div class="input-group">
											<input type="radio" class="markerclick" id="{{$outlet->spid}}" rel="{{$outlet->spid}}" value="{{$outlet->spid}}" name="outletv2"> {{$outlet->biz_name}}
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
							<div class="col-md-8">
								<div id="map-containerv" class="custom-container pull-right" style="width:575px; height:435px;">
										  <div id="map-canvasv" style="width:540px; height:400px;">
										  </div>
								 </div>							
								<p id="display_address" style="margin-top:50px;">		
								</p>
							</div>
						</div>
						<br>	
                        <div class="col-md-12">
                            <button class="btn btn-success">Order</button>
                        </div>						
                    </div>
                    <br style="margin-bottom:20px"/>
                </div>
                {{-- V --}}
                <div class="col-md-12">

                </div>
                {{-- col-md-11 --}}

            </div>
        </div>
       </div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>	   
<link type="text/css" href="{{url('')}}/bootstrap-timepicker-gh/css/bootstrap-timepicker.min.css"/>
<script type="text/javascript" src="{{url('')}}/bootstrap-timepicker-gh/js/bootstrap-timepicker.js"></script>
<script>
$(document).ready(function () {
	var mapv;
	$(".markerclick").click(function (e) {
		var addressid = $(this).attr('rel');
	//	console.log(addressid);
		var address = $("#addressm_" + addressid).text();
	//	console.log(address);
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
	
	$('#buyvouchertable').DataTable({
		 "columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{"targets": "medium", "width": "80px"},
				{"targets": "bmedium", "width": "100px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "approv", "width": "180px"}, //Approval buttons
				{"targets": "blarge", "width": "200px"}, // *Names
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
			]
	});	
	
	$('input:radio[name=outletv2]').change(function () {
		var sid = $(this).attr('rel');
		//alert()
		$("#display_address").html($("#address_" + sid).html());
	});
});
</script>
@stop
