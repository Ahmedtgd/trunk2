@extends('common.default')
@section('content')
<br>
<h1>NinjaVan WebHook Simulation</h1>
<input type="text" name="new_weight" id="new_weight"
	placeholder="Enter New Weight">
<input type="text" name="tracking_id1" id="tracking_id1"
	placeholder="Enter Tracking ID">
<button id="parcelweight" type="button" class="btn btn-primary"
	rel="parcel_weight">Parcel Weight</button><br>

<input type="text" name="new_size" id="new_size"
	placeholder="Enter New Size">
<input type="text" name="tracking_id2" id="tracking_id2"
	placeholder="Enter Tracking ID">
<button id="parcelsize" type="button" class="btn btn-primary"
	rel="parcel_size">Parcel Size</button><br>

<input type="text" name="porder_id" id="porder_id" 
	placeholder="Enter nporder_id">
<input type="text" name="tracking_id" id="tracking_id"
	placeholder="Enter Tracking ID">
<button id="ppickup" type="button" class="btn btn-primary"
	rel="pickup">Pending Pickup</button><br>

<input type="text" name="porder_id2" id="porder_id2" 
	placeholder="Enter nporder_id">
<input type="text" name="tracking_id3" id="tracking_id3"
	placeholder="Enter Tracking ID">
<button id="spickup" type="button" class="btn btn-primary"
	rel="pickup">Successful Pickup</button><br>

<input type="text" name="porder_id5" id="porder_id5"
	placeholder="Enter nporder_id">
<input type="text" name="tracking_id5" id="tracking_id5"
	placeholder="Enter Tracking ID">
<input type="text" name="fpickup_comment" id="fpickup_comment"
	placeholder="Enter Comments">
<button id="fpickup" type="button" class="btn btn-primary"
	rel="fpickup">Pickup Fail</button><br>

<input type="text" name="porder_id7" id="porder_id7"
	placeholder="Enter nporder_id">
<input type="text" name="tracking_id7" id="tracking_id7"
	placeholder="Enter Tracking ID">
<input type="text" name="rts_comment" id="rts_comment"
	placeholder="Enter Comments">
<button id="rts" type="button" class="btn btn-primary"
	rel="rts">Return to Sender</button><br>
 
<input type="text" name="porder_id6" id="porder_id6"
	placeholder="Enter nporder_id">
<input type="text" name="tracking_id6" id="tracking_id6"
	placeholder="Enter Tracking ID">
<input type="text" name="presched_comment" id="presched_comment"
	placeholder="Enter Comments">
<!--
<input type="radio" name="presched"
	style="width:50px;transform:scale(1.5);vertical-align:middle"
	value="dfailed1">D.Failed 1</input>
<input type="radio" name="presched"
	style="width:50px;transform:scale(1.5);vertical-align:middle"
	value="dfailed2">D.Failed 2</input>
<input type="radio" name="presched"
	style="width:50px;transform:scale(1.5);vertical-align:middle"
	value="dfailed3">D.Failed 3</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
-->
<button id="presched" type="button" class="btn btn-primary"
	rel="presched">Pending Reschedule</button><br>
 
 
<div class=row">
<div class="col-sm-7" style="padding-left:0;padding-right:0;padding-top:5px;padding-bottom:5px">
<input type="text" name="porder_id3" id="porder_id3" 
	placeholder="Enter nporder_id">
<input type="text" name="name" id="name" placeholder="Enter Name">
<input type="text" name="nric" id="nric" placeholder="Enter NRIC">
<input type="text" name="tracking_id4" id="tracking_id4"
	placeholder="Enter Tracking ID">
</div>

<div class="col-sm-2" style="padding-top:4px">
<select id="signature_uri">
    <option selected="selected"
		value="http://www.sqci.biz/ws_signature.png">Squid</option>
	<option value="http://www.sqci.biz/agrande_signature.png">Ari</option>
	<option value="http://www.sqci.biz/blee_signature.png">Bruce</option>
	<option value="http://www.sqci.biz/dali_signature.png">Dali</option>
	<option value="http://www.sqci.biz/sy_signature.png">SY</option>
	<option value="http://www.sqci.biz/taylor_signature.png">Taylor</option>
	<option value="http://www.sqci.biz/picasso_signature.png">Pic</option>
	<option value="http://www.sqci.biz/ysc_signature.png">Chin</option>
</select>
</div>
<div class="col-sm-2">
<button id="sdelivery" type="button" class="btn btn-primary"
	rel="delivery">Successful Delivery</button><br>
</div>
</div>



<br><br><br><br>
 
<script type="text/javascript">
$(document).ready(function(){
	$('#parcelsize').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id1').val(),
			"status":"Parcel Size",
			"shipper_order_ref_no":"a0448973",
			"timestamp":d.toISOString(),
			"order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
			"previous_size":"2",
			"new_size":$('#new_size').val(), "tracking_id":$('#tracking_id2').val() }
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/parcelsize",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	}); 

	$('#parcelweight').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id4').val(),
			"status":"Parcel Weight",
			"shipper_order_ref_no":"a0448973",
			"timestamp":d.toISOString(),
			"order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
			"previous_weight":"2",
			"new_weight":$('#new_weight').val(),
			"tracking_id":$('#tracking_id1').val()
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/parcelweight",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});

 	$('#ppickup').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id').val(),
			"status":"Pending Pickup",
			"shipper_order_ref_no":$('#porder_id').val(),
			"timestamp":d.toISOString(),
			"id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
			"tracking_id":$('#tracking_id').val()
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/ppickup",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});
 

  	$('#spickup').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id2').val(),
			"status":"Successful Pickup",
			"previous_status":"Parcel Nearly Exploded",
			"shipper_order_ref_no":$('#porder_id2').val(),
			"timestamp":d.toISOString(),
			"order_id":"297d3f46-3135-4a3b-ba0f-a2b46b73eaad",
			"tracking_id":$('#tracking_id3').val(),
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/spickup",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});  

   	$('#sdelivery').click(function(){
		var d = new Date();
		var pod = {
			"type": "SUBSTITUTE",
			"name":$('#name').val(),
			"identity_number":$('#nric').val(),
			"contact": "0122936511",
			"uri":$('#signature_uri').val(),
			"left_in_safe_place": false
		}
		var pp = {
			"shipper_id":$('#shipper_id3').val(),
			"status":"Successful Pickup",
			"previous_status":"Parcel Nearly Exploded",
			"shipper_order_ref_no":$('#porder_id3').val(),
			"timestamp":d.toISOString(),
			"order_id":"297d3f46-3135-4a3b-ba0f-a2b46b73eaad",
			"tracking_id":$('#tracking_id4').val(),
			"pod":pod
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/sdelivery",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});      

   	$('#fpickup').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id5').val(),
			"status":"Pickup Fail",
			"previous_status":"Parcel Nearly Exploded",
			"shipper_order_ref_no":$('#porder_id5').val(),
			"timestamp":d.toISOString(),
			"order_id":"297d3f46-3135-4a3b-ba0f-a2b46b73eaad",
			"tracking_id":$('#tracking_id5').val(),
			"comments":$('#fpickup_comment').val()
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/fpickup",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});  

   	$('#presched').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id6').val(),
			"status":"Pending Reschedule",
			"previous_status":"Pickup Fail",
			"shipper_order_ref_no":$('#porder_id6').val(),
			"timestamp":d.toISOString(),
			"id":"297d3f46-3135-4a3b-ba0f-a2b46b73eaad",
			"tracking_id":$('#tracking_id6').val(),
			"comments":$('#presched_comment').val()
			//"delivery_failed":$('input[name=presched]:checked').val()
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/presched",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});  

   	$('#rts').click(function(){
		var d = new Date();
		var pp = {
			"shipper_id":$('#shipper_id7').val(),
			"status":"Return to Sender",
			"previous_status":"Parcel Nearly Exploded",
			"shipper_order_ref_no":$('#porder_id7').val(),
			"timestamp":d.toISOString(),
			"order_id":"297d3f46-3135-4a3b-ba0f-a2b46b73eaad",
			"tracking_id":$('#tracking_id7').val(),
			"comments":$('#rts_comment').val()
		}
		$.ajax({
			type:'POST',
			url:JS_BASE_URL+"/nv/rts",
			data: JSON.stringify(pp),
			success:function(r){
				toastr.info(r.long_message);
			}
		});
	});   


});
</script>
<br>


@stop
