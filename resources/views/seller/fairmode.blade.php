@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$i = 1;
?>
@section("content")
	@include('common.sellermenu')
<style>
    .tab-pane{
        margin-top: 4em;
    }

	.top-margin{
		margin-top: -30px;
	}
	
	table#notproduct_details_table
    {
      /*  table-layout: fixed;*/
        max-width: none;
        width: auto;
        min-width: 100%;
    }
	
    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
	.aproducts{
		width: 100% !important;
	}
	.no-sort{
		width: 20px !important;
	}
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class='cart-info'></strong>
            </div>
			<input type="hidden" value="{{$selluser->id}}" id="selluserid" />
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12"><h2>Location Management</h2></div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
								<li id="tb-list-product" class="active">
								<a href="#fair-locations" data-toggle="tab">
								Location</a></li>
								<li ><a href="#location" data-toggle="tab">Branch</a></li>
								<li ><a href="#consignment" data-toggle="tab">
									A/C No.
								</a></li>
								</ul>
							</div>
						</div>
                    {{--ENDS  --}}
					<input type="hidden" value="{{$selluser->id}}" id="msell_id" />
					<div id="dashboard" style="padding-top:0" class="row panel-body " >
						<div class="tab-content top-margin" style="margin-top:-50px">
							<div class="tab-pane fade in active" id="fair-locations">
								@include('seller.fair.fair-locations')
							</div>	
							
							<div id="consignment" class="tab-pane fade">
								<h3>Consignment Account Details
								<small class="pull-right">

								<a href="javascript:void(0)" 
									style="color:white"
									id="cacct_add">
								<div class="sellerbutton pull-right" id=''
								style="padding-top:30px;background-color:#d9534f">
									<span style="margin-top:15px;">
										+A/C No
									</span>
								</div>
								</a>
								
								</small>
								</h3>
							@include("seller.caiman.cacctno")
							</div>
							{{-- BRANCH--}}
							<div id="location" class="tab-pane fade">
								@include("seller.caiman.branch")
								
							</div>
							{{-- BRANCH ENDS --}}					
						</div>
					</div>

				</div>
            </div>
        </div>
    </section>


</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p class="text-danger">Are you sure to permanently delete the location?</p>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary delete_location" >Yes</button>
        <input type="hidden" id="activelocationid">
      </div>
    </div>

  </div>
</div>
{{-- // --}}
<div class="modal fade" id="consignment_pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:80% !important;">
    <div class="modal-content">
      <div class="modal-header">
      	<h4 class="head_seller">Tracking And Stock Take Report By Location 
      	<small>
      		<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	</small>
      	</h4>
        
      </div>
      <style>
      .seller_con_table_css{
        width:100%;
      }
                </style>
      <div class="modal-body">
		<div class="">

		<table class="seller_con_table_css">
			<tr>
				<td>Total Report</td>
				<td id="totalreport"></td>
				<td id="location"><span style="padding-left: 0px;">Name</span></td>
			</tr>
			<tr>
				<td>Total Stock In </td>
				<td id="totaltrackoutin"></td>
				<td id="totaluser">Total User<span style="padding-left: 18px;">Name</span></td>
			</tr>
			<tr>
				<td>Total Stock Out</td>
				<td id="totaltrackoutout"></td>
				<td id="lost">Lost Case<span style="padding-left: 18px;">Name</span></td>
			</tr>
		</table>
		</div>
		<div class="clearfix"></div>
		
		<table class="table table-bordered" id="consignment-open-channel">
			<thead style="background: #6666ff; color: white;font-family: sans-serif;">
				<tr class="tr_class_css">
					<th class="text-center">No</th>
					<th class="text-center">Report No</th>
					<th class="text-center">Type</th>
					<th class="text-center">Last Date</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cacct_show_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

		<h3>Consignment Account Number List<small> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></small></h3>
      </div>
   
      <div class="modal-body">
			<table class="table table-bordered table-striped" style="width:100% !important;">
				<thead>
					<tr class="bg-caiman">
						<th class="text-center">No.</th>
						<th class="text-center">Consignment Account Number</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody id="cacctno_content">
				</tbody>
			</table>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="show_products_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:90% !important;">
    <div class="modal-content">
      <div class="modal-header">
      	<h3>
      		Product Distribution by Location
        	<small><button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></small>
        </h3>
      </div>
   
      <div class="modal-body" >
			<table class="table table-bordered" style="width:100% !important;"
			id="product_table">
				<thead>
					<tr class="bg-caiman">
						<th class="text-center">No.</th>
						<th class="text-center">Product&nbsp;ID</th>
						<th class="text-left">Product Name</th>
						<th class="text-center">Qty</th>
					</tr>
				</thead>
				<tbody id="product_content">
					
				</tbody>
			</table>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="show_staffs_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:60% !important;">
    <div class="modal-content">
      <div class="modal-header">
      	<h3>
      		Staff Distribution by Location
      		<small>
      			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		</small>
      	</h3>
        
      </div>
   
      <div class="modal-body">
			<table class="table table-bordered" style="width:100% !important;"
			id="staff_table" 
			>
				<thead>
					<tr class="bg-caiman text-center">
						<th class="text-center">No.</th>
						<th class="text-center">Staff&nbsp;ID</th>
						<th class="text-center">Name</th>
						<th class="text-center">Roles</th>
					</tr>
				</thead>
				<tbody id="staff_content">
					
				</tbody>
			</table>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal_m" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            
            <div class="modal-body">

                <div id="myBody">
                <h3>Role Assignment</h3>
                	<div class="row">
					@foreach($memberroles as $memberrole)
						<div class="col-sm-6">
						<p><input type="checkbox" class="memberchek" rel="{{$memberrole->id}}" /> {{$memberrole->description}}</p>
						</div>
					@endforeach
					</div>
					<div class="row">
					{{-- <a class='btn btn-primary saveroles pull-right' href='javascript:void(0)' > Save</a> --}}
					
					<input type="hidden" value="0" id="user_idrole" />
                	</div>
					<hr/>
					<h3>Branch Assignment</h3>
					<div class="row">
					@foreach($ulocations as $location)
						<div class="col-sm-6">
						<p><input type="checkbox" class="memberlocation" rel="{{$location->id}}" /> {{$location->location}}</p>
						</div>
					@endforeach
					</div>
					<div class="row">
					<a class='btn btn-primary saveroles pull-right' href='javascript:void(0)' > Save</a>
					<br/>
					<br/>
                	</div>
					
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 
</div>
	<div class="modal fade" id="LocAddressModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Location Address</h4>
				</div>
				<div class="modal-body" style="height: 460px;">
					<div class="col-sm-2">Country</div><div class="col-sm-10"><select id="location_country" disabled><option>Malaysia</option></select></div>
					<div class="clearfix"></div>
					<br>
					<div class="col-sm-2">State</div><div class="col-sm-10"><select id="location_state"></select></div>
					<div class="clearfix"></div>
					<br>
					
					<div class="col-sm-2">City</div><div class="col-sm-10"><select id="location_city"></select></div>
					<div class="clearfix"></div>
					<br>
					<div class="col-sm-2">Area</div><div class="col-sm-10"><select id="location_area"></select></div>
					<div class="clearfix"></div>
					<br>
					<div class="col-sm-2">Line 1</div><div class="col-sm-10"><input type="text" class="form-control" id="location_line1" value="" /></div>
					<div class="col-sm-2">Line 2</div><div class="col-sm-10"><input type="text" class="form-control" id="location_line2" value="" /></div>
					<div class="col-sm-2">Line 3</div><div class="col-sm-10"><input type="text" class="form-control" id="location_line3" value="" /></div>
					<div class="col-sm-2">Line 4</div><div class="col-sm-10"><input type="text" class="form-control" id="location_line4" value="" /></div>
					<div class="clearfix"></div>
					<br>
					<div class="col-sm-2">Zip Code</div><div class="col-sm-10"><input type="text" class="form-control" id="location_postcode" value="" /></div>
					<input type="hidden" value="0" id="location_address_id" />
					<input type="hidden" value="0" id="location_id" />
					<div class="col-sm-12">
						<br>
						<a href="javascript:void(0);" class="btn btn-primary save_address pull-right">Save</a>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>	
	<script>
	 var edit_mode="";
		function resetLocationList(data){
			var html = "";
			console.log("Reset");
			var location = data.data;
			console.log(location);
		//	product_table.destroy();
			var i = 1;
			html += '<table class="table table-bordered" width="100%" id="location_details_table">';
			html += '	<thead >';
			html += '	<tr class="bg-location">';
			html += '		<th class="text-center no-sort bsmall" width="20px" style="width: 20px !important;">No</th>';
			html += '		<th class="text-center" >Company&nbsp;Name</th>';
			html += '		<th class="text-center" >Address</th>';

			html += '		<th class="text-center">Branch</th>';
			//html += '		<th class="text-center">Location</th>';

			html += '		<th style="width: 15%;" class="text-center">Location Code</th>';
			html += '		<th class="text-center">Consignment A/C No</th>';


			html += '		<th class="text-center bsmall">&nbsp;</th>';
			html += '	</tr>';
			html += '	</thead><tbody>';


        



			if (typeof location != 'undefined'){
			for(var jk = 0; jk < location.length; jk++){
				html += '<tr>';
				html += '<td class="text-center">'+ i +'</td>';
				
				html += '<td class="text-center"><input type="text" value="'+location[jk].company_name+'" class="location_company_input" style="display: none;" id="location_company'+location[jk].id+'" rel="'+location[jk].id+'" /><span rel="'+location[jk].id+'" class="location_company" rel-type="'+location[jk].type+'"  id="location_company_span'+location[jk].id+'">&nbsp;'+ location[jk].company_name +'&nbsp;</span></td>';

			/*	html += '<td class="text-center"><input type="text" value="'+location[jk].branch_name+'" class="location_branch_input" style="display: none;" id="location_branch'+location[jk].id+'" rel="'+location[jk].id+'" /><span rel="'+location[jk].id+'" class="location_branch" id="location_branch_span'+location[jk].id+'">&nbsp;'+ location[jk].branch_name +'&nbsp;</span>';
				*/

				html += '<td class="text-center"><a href="javascript:void(0)" class="locationaddress" rel="'+ location[jk].address_id +'" idrel="'+ location[jk].address_id +'">Address</a></td>';
				html += '<td class="text-center"><input type="text" value="'+location[jk].location+'" class="location_loc_input" style="display: none;" id="location_loc'+location[jk].id+'" rel="'+location[jk].id+'" /><span rel="'+location[jk].id+'" class="location_loc" id="location_loc_span'+location[jk].id+'">&nbsp;'+ location[jk].location +'&nbsp;</span></td>';
				
				
					if (location[jk].code == null) {

						html += '<td><input id="locationcode'+location[jk].id+'"  type="text" class="form-control" value="" onblur="fairlocationcode('+location[jk].id+')" name=""></td>';


					} else {

						html += '<td><input id="locationcode'+location[jk].id+'"  type="text" class="form-control" value="'+location[jk].code+'" onblur="fairlocationcode('+location[jk].id+')" name=""></td>';

					}

				html += ' <td style="text-align: center;"><a  href="{{URL::to('/')}}/seller/fairmode/accno/'+location[jk].id+'" rel="'+location[jk].id+'">Account No</a></td>';

				html += '<td class="text-center"><a  href="javascript:void(0);" class="btn btn-danger show_delete_modal" style="border-radius:5px" rel="'+ location[jk].id +'"><i class="fa fa-times"></i></a></td>';
				html += '</tr>';
				i++;
			}
			html += '</tbody></table>';	
			thetable = $("#thetable").html(html);
				$('#location_details_table').DataTable({
				"order": [],
				"scrollX":true,
				"columnDefs": [
					{ "targets": "no-sort", "width": "120px", "orderable": false },
					{ "targets": "large", "width": "120px" },
					{ "targets": "bsmall", "width": "20px" },
					{ "targets": "smallestest", "width": "55px" },
					{ "targets": "medium", "width": "95px" },
					{ "targets": "xlarge", "width": "280px" }
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});			
			}
		}
    //    $('#auto_link_table').dataTable().fnDestroy();
		$(document).ready(function(){
				$('#location_details_table').DataTable({
				"order": [],
				"scrollX":true,
				"columnDefs": [
					{ "targets": "no-sort", "width": "120px", "orderable": false },
					{ "targets": "large", "width": "120px" },
					{ "targets": "bsmall", "width": "20px" },
					{ "targets": "smallestest", "width": "55px" },
					{ "targets": "medium", "width": "95px" },
					{ "targets": "xlarge", "width": "280px" }
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});
		
		$(document).delegate( '#location_state', "change",function (event) {
			var val = $(this).val();
			if (val != "") {
				var text = $('#location_state option:selected').text();
				//$('#states_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/city',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#location_city').html(responseData);
							document.getElementById('location_city').disabled = false;
						}
						else {
							$('#location_city').empty();
							$('#select2-location_city-container').empty();
							document.getElementById('location_city').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-location_city-container').empty();
				$('#location_city').html('<option value="" selected>Choose Option</option>');
			}
		});
		
		$(document).delegate( '#location_city', "change",function (event) {
			var val = $(this).val();
			if (val != "") {
				var text = $('#location_city option:selected').text();
				//$('#states_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/area',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#location_area').html(responseData);
							document.getElementById('location_area').disabled = false;
						}
						else {
							$('#location_area').empty();
							$('#select2-location_area-container').empty();
							document.getElementById('location_area').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-location_area-container').empty();
				$('#location_area').html('<option value="" selected>Choose Option</option>');
			}
		});
		
		 $(document).delegate( '.locationaddress', "click",function (event) {
			 var id=$(this).attr("idrel");
			 var address_id=$(this).attr("rel");
				$.ajax({
					type: "get",
					url: JS_BASE_URL + '/locationaddress',
					data: {
						id: id,
						address_id: address_id
					},
					dataType:'json',
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						console.log(responseData);
						var states = responseData.states;
						
						if (typeof states != 'undefined'){
							if (states.length > 0){
								var html = "<option value=''>Choose Option</option>";
								for(var jk = 0; jk < states.length; jk++){
									html += "<option value='"+states[jk].id+"'>"+states[jk].name+"</option>";
								}
								console.log(html);
								$('#location_state').html(html);
							} else {
								$('#location_state').empty();
								$('#select2-location_state-container').empty();
								$('#location_state').html('<option value="" selected>Choose Option</option>');
								$('#location_state').select2();
							}
						} else {
							console.log("undefined");
							$('#location_state').empty();
							$('#select2-location_state-container').empty();
							$('#location_state').html('<option value="" selected>Choose Option</option>');
							$('#location_state').select2();
						}
						
						var cities = responseData.cities;
						
						if (typeof cities != 'undefined'){
							if (cities.length > 0){
								var html = "";
								for(var jk = 0; jk < cities.length; jk++){
									html += "<option value='"+cities[jk].id+"'>"+cities[jk].name+"</option>";
								}
								console.log(html);
								$('#location_city').html(html);
							} else {
								$('#location_city').empty();
								$('#select2-location_city-container').empty();
								$('#location_city').html('<option value="" selected>Choose Option</option>');
								$('#location_city').select2();
							}
						} else {
							console.log("undefined");
							$('#location_city').empty();
							$('#select2-location_city-container').empty();
							$('#location_city').html('<option value="" selected>Choose Option</option>');
							$('#location_city').select2();
						}
						
						var areas = responseData.areas;
						
						if (typeof areas != 'undefined'){
							if (areas.length > 0){
								var html = "";
								for(var jk = 0; jk < areas.length; jk++){
									html += "<option value='"+areas[jk].id+"'>"+areas[jk].name+"</option>";
								}
								console.log(html);
								$('#location_area').html(html);
							} else {
								$('#location_area').empty();
								$('#select2-location_area-container').empty();
								$('#location_area').html('<option value="" selected>Choose Option</option>');
								$('#location_area').select2();
							}
						} else {
							console.log("undefined");
							$('#location_area').empty();
							$('#select2-location_area-container').empty();
							$('#location_area').html('<option value="" selected>Choose Option</option>');
							$('#location_area').select2();
						}
                    
						$("#location_line1").val(responseData.line1);
						$("#location_line2").val(responseData.line2);
						$("#location_line3").val(responseData.line3);
						$("#location_line4").val(responseData.line4);
						$("#location_postcode").val(responseData.postcode);
						$("#location_address_id").val(responseData.address_id);
						$("#location_id").val(responseData.location_id);
						$("#LocAddressModal").modal("show");
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});				 
		 });
		 
		 $(document).delegate( '.save_address', "click",function (event) {
			 var _this=$(this);
			 _this.html("Saving...");
			 var data = new FormData();
			 var city_id = $("#location_city").val();
			 var area_id = $("#location_area").val();
			 var line1 = $("#location_line1").val();
			 var line2 = $("#location_line2").val();
			 var line3 = $("#location_line3").val();
			 var line4 = $("#location_line4").val();
			 var postcode = $("#location_postcode").val();
			 var address_id = $("#location_address_id").val();
			 var location_id = $("#location_id").val();
			 var data = {
				 city_id: city_id,
				 area_id: area_id,
				 line1: line1,
				 line2: line2,
				 line3: line3,
				 line4: line4,
				 postcode: postcode,
				 address_id: address_id,
				 location_id: location_id,
			 }
			 
			 $.ajax({
					type: "post",
					url: JS_BASE_URL + '/savelocationaddress',
					data: data,
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						toastr.info('Location Address successfully saved!');
						$("#LocAddressModal").modal("toggle");
						_this.html("Save");
						$.ajax({
							url: '{{ route('getlocations') }}',
							cache: false,
							method: 'GET',
							data: {user_id: $('#selluserid').val()},
							dataType: 'json',
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resetLocationList(result);
							},
							error: function (responseData, textStatus, errorThrown) {
								resetLocationList("");	
							}
						});	
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
			});
		 });
		 $(document).delegate( '.show_delete_modal', "click",function (event) {
		 	$("#activelocationid").val($(this).attr("rel"));
		 	$("#deleteModal").modal("show");
		 });
		 $(document).delegate( '.delete_location', "click",function (event) {
		// $(".delete_payment").on("click",function(){
				$("#deleteModal").modal("hide");
				var obj=$(this);
				var id=$("#activelocationid").val();
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/deletelocation',
					data: {
						id: id
					},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						console.log("responseData",responseData);
						if (responseData.status=="OK") {
							toastr.info('Location successfully deleted!');
							$.ajax({
								url: '{{ route('getlocations') }}',
								cache: false,
								method: 'GET',
								data: {user_id: $('#selluserid').val()},
								dataType: 'json',
								success: function(result, textStatus, errorThrown) {
									console.log(result);
									resetLocationList(result);
								},
								error: function (responseData, textStatus, errorThrown) {
									resetLocationList("");	
								}
							});	
						}else{
							toastr.error("This location cannot be deleted.");
						}
						
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});	
		 });	
		 
		$(document).delegate( '.addLocation', "click",function (event) {
				var id=$("#selluserid").val();
				var _obj=$(this);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/addlocation',
					data: {
						user_id: id
					},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {

						if (responseData.status=="failure" && responseData.short_message=="ae") {
							toastr.warning("Location already exists!");
							return;
						}else{
							toastr.info('Location successfully added!');
						$.ajax({
							url: '{{ route('getlocations') }}',
							cache: false,
							method: 'GET',
							data: {user_id: id},
							dataType: 'json',
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resetLocationList(result);
							},
							error: function (responseData, textStatus, errorThrown) {
								resetLocationList("");	
							}
						});	
						}
						
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});	
		 }); 
		
		$(document).delegate( '.addWarehouse', "click",function (event) {
				var id=$("#selluserid").val();
				var _obj=$(this);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/addwarehouse',
					data: {
						user_id: id
					},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData.status=="failure" && responseData.short_message=="ae") {
							toastr.warning("Warehouse already exists!");
							return;
						}else{
							toastr.info('Warehouse successfully added!');
						$.ajax({
							url: '{{ route('getlocations') }}',
							cache: false,
							method: 'GET',
							data: {user_id: id},
							dataType: 'json',
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resetLocationList(result);
							},
							error: function (responseData, textStatus, errorThrown) {
								resetLocationList("");	
							}
						});	
						}
						
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});	
		 });
		$(document).delegate( '.location_company_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = objThis.val();
			var company = $("#location_company" + id).val();
			raw_url="/location_company";
			
			$.ajax({
					url: JS_BASE_URL + '/location_company',
					cache: false,
					method: 'POST',
					data: {id: id, company: company,type:edit_mode},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						$("#location_company" + id).hide();
						
						$("#location_company_span" + id).text(company);
					
						$("#location_company_span" + id).show();
				
					}
			});		
		});

		$(document).delegate( '.location_branch_input', "blur",function (event) {
			var objThis = $(this);
		
			var id = objThis.attr('rel');
			var value = objThis.val();
			var branch = $("#location_branch" + id).val();
			$.ajax({
					url: JS_BASE_URL + '/location_branch',
					cache: false,
					method: 'POST',
					data: {id: id,branch:branch},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();

						$("#location_branch" + id).hide();
						
						$("#location_branch_span" + id).text(branch);
					
						$("#location_branch_span" + id).show();
					}
			});		
		});
		
		$(document).delegate( '.location_loc', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#location_loc" + id).show();
		});		
		
		$(document).delegate( '.location_loc_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = objThis.val();
			var location = $("#location_loc" + id).val();
			$.ajax({
					url: JS_BASE_URL + '/location_loc',
					cache: false,
					method: 'POST',
					data: {id: id, location: location},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						if (result.status=="failure" && result.short_message=="ae") {
							toastr.warning("Branch already exists. Please make sure the branch name is unique!");
						}else{
							$("#location_loc" + id).hide();
							$("#location_loc_span" + id).text(location);
							$("#location_loc_span" + id).show();
						}
						
					}
			});		
		});
		
		$(document).delegate( '.location_loc', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#location_loc" + id).show();
		});	

		$(document).delegate( '.location_company', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			edit_mode=objThis.attr('rel-type');
			$("#location_company" + id).show();
		});	

		$(document).delegate( '.location_branch', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#location_branch" + id).show();
		});			
						
	
	$(".dataTables_empty").attr("colspan","100%");
	$(window).resize();
	$(window).trigger('resize');
	//
});

</script>
<script>	
	var types = {treport:"Tracking Report", tin:"Stock In", tout:"Stock Out", tou:"Stock Out", smemo:"Sales Memo", stocktake:"Stock Take"};
	
	$(document).ready(function(){
		var pdb=$("#product_table").DataTable({
						'autoWidth':false,
						"columnDefs": [
							{"targets": 'no-sort', "orderable": false, },
							{"targets": "medium", "width": "80px" },
							{"targets": "bmedium", "width": "10px" },
							{"targets": "large",  "width": "120px" },
							{"targets": "approv", "width": "180px"},
							{"targets": "blarge", "width": "200px"},
							{"targets": "bsmall",  "width": "20px"},
							{"targets": "clarge", "width": "250px"},
							{"targets": "xlarge", "width": "300px" }
						]
						});
		$(document).delegate( '.saveroles', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole").val();
			/*var isstaff = 0;
			var isadmin = 0;
			if($('#staff').prop('checked')){
				isstaff = 1;
			}
			if($('#adminstaff').prop('checked')){
				isadmin = 1;
			}*/
			var data={};
			var countdata = 0
			$('.memberchek').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
			
			var locationdata={};
			var countdata = 0
			$('.memberlocation').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    locationdata[key]=true;
					countdata++;
                } else {
					locationdata[key]=false;
				}
            });

			$.ajax({	
				type: "POST",
				data: {data: data,locationdata:locationdata},
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole").val(userid);
					$("#myModal_m").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		$(document).delegate( '.member_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					
					var roles = data.asroles;
					var locations=data.locations;
					if (typeof roles != 'undefined'){
						$.each(roles, function(index, value) {
							//console.log(index);
							//console.log(value);
							if(value == 1){
								$(".memberchek[rel="+index+"]").prop('checked',true);
							} else {
								$(".memberchek[rel="+index+"]").prop('checked',false);
							}
						}); 
					}
					console.log(data);
					if (typeof locations != 'undefined'){
						$('.memberlocation').prop('checked',false);
						$.each(locations, function(index, value) {
							console.log(index,value.location_id);
							$(".memberlocation[rel="+value.location_id+"]").prop('checked',true);
							
						}); 
					}
					$("#user_idrole").val(userid);
					$("#myModal_m").modal('show');
					//obj.html("Send");

				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});	
		$(document).delegate( '.show_products', "click",function (event) {
	/*	$(".show_products").click(function(){*/
			var url="{{url('branch/products',$selluser->id)}}";
			var data={
				branch_id:$(this).attr("rel-branch")
			};
			$.ajax({
				url:url,
				data:data,
				type:"POST",
				success:function(r){
					pdb.clear();
					if (r.status=="success") {

						data=r.data
						var table="";
						var index=1;
						for (var i =0; i < data.length; i++) {
							r=data[i];
							//console.log(r);
							//JS_BASE_URL="https://opensupermall.com";
							pdb.rows.add($(`
							<tr>
							   <td class="text-center">`+index+`</td>
							   <td>
							   	

							   <a
							   target="_blank"
							   href="`+JS_BASE_URL+"/productconsumer/"+r.product_id+`"
							   >`+r.nproduct_id+`</a></td>
							   <td>
							   	<img 
							   style='height:30px;width:30px;object-fit:"contain"'
							   src="`+JS_BASE_URL+`/images/product/`+r.product_id+`/thumb/`+r.thumb_photo+`"/>
							   `+

							   r.name+`</td>
							   <td class="tex">`+r.quantity+`
							   </td>

							</tr>
							`)).draw();
							index++;

						}
						$("#product_content").empty();
						//console.log(table);
//						pdb.clear();
						$("#product_content").append(table);
						pdb.draw();
						$("#show_products_modal").modal("show");
					}else{
						toastr.warning("No data was found!");
					}
					
				},
				error:function(){toastr.warning("Failed to connect to server.")}
			})
			
		});
		$(document).delegate( '.show_staffs', "click",function (event) {
		/*$(".show_staffs").click(function(){
*/			var url="{{url('branch/users')}}";
			var data={
				branch_id:$(this).attr("rel-branch")
			};
			$.ajax({
				url:url,
				data:data,
				type:"POST",
				success:function(r){
					if (r.status=="success") {
						data=r.data
						var table="";
						var index=1;
						for (var i =0; i < data.length; i++) {
							r=data[i];

							table+=`
							<tr>
							   <td class="text-center">`+index+`</td>
							   <td class="text-center">`+r.member_id+`</td>
							   <td class="text-center">`+r.name+`</td>
							   <td class="text-center">
							   <a class='member_role' rel=`+r.user_id+`>Roles</a></td>

							</tr>
							`;
							index++;

						}
						$("#staff_content").empty();
						$("#staff_content").append(table);
						$("#staff_table").DataTable();
						$("#show_staffs_modal").modal("show");
					}else{
						toastr.warning("No data was found!");
					}
					
				},
				error:function(){toastr.warning("Failed to connect to server.")}
			})
			
		});
				var c_table = $('#consignment-open-channel').DataTable({
						'autoWidth':false,
						"columnDefs": [
							{"targets": 'no-sort', "orderable": false, },
							{"targets": "medium", "width": "80px" },
							{"targets": "bmedium", "width": "10px" },
							{"targets": "large",  "width": "120px" },
							{"targets": "approv", "width": "180px"},
							{"targets": "blarge", "width": "200px"},
							{"targets": "bsmall",  "width": "20px"},
							{"targets": "clarge", "width": "250px"},
							{"targets": "xlarge", "width": "300px" }
						]
				});				
		
				var table = $('#supplier-open-channel').DataTable({
				'scrollX':true,
				'bScrollCollapse': true,
                'scrollX':true,
                'autoWidth':false,
				"columnDefs": [
					{"targets": 'no-sort', "orderable": false, },
					{"targets": "medium", "width": "80px" },
					{"targets": "bmedium", "width": "10px" },
					{"targets": "large",  "width": "120px" },
					{"targets": "approv", "width": "180px"},
					{"targets": "blarge", "width": "200px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px" }
				]
			});
			$(".dataTables_empty").attr("colspan","100%");
			
			$(document).delegate( '.getstockid', "click",function (event) {
				var id = $(this).attr("rel");
				$.ajax({
					url: JS_BASE_URL + '/seller/consignmentvalue/{{$selluser->id}}',
					cache: false,
					method: 'get',
					dataType: 'json',
					data: {id: id},
					success: function(result) {
						//console.log(result.lists);
						c_table
						.clear()
						.draw();
						$('#totalreport').text(result.treports);
						$('#location').find('span').text(result.locations);
						$('#totaltrackoutin').text(result.tin);
						$('#totaluser').find('span').text(result.tusers);
						$('#totaltrackoutout').text(result.tout);
						$('#totalsalesmemo').text(result.treport);
						$('#lost').find('span').text(result.lcase);
						$("#consignment_pop").modal('show');
						
						var type = "";
						for(var ii = 0; ii < result.data.length; ii++){
							if(typeof(types[result.data[ii].ttype]) == undefined || types[result.data[ii].ttype] == null){
								type = "";
							} else {
								type = types[result.data[ii].ttype];
							}
							
							var rowNode = c_table.row.add(["<p align='center'>" + (ii+1) + "</p>","<p align='center'>" + result.data[ii].no + "</p>","<p align='center'>" + type + "</p>","<p align='center'>" + result.data[ii].date_created + "</p>"]).draw();
							$( rowNode )
							.css( 'text-align', 'center');
						}
						$(".no-footer").css("width","100%");
					}
				});	
			});		

			/**/
			
			/**/	
			
		});
		
	</script>
@stop

