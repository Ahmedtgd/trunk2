
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
</style>
<?php //echo '<pre>'; print_r($states); die(); ?>
	<h2>Staff Details</h2>
	<div class="">
		<div class="panel-heading" style="padding:0px">
			<div class="col-sm-12">
				<div class="col-sm-3">
					
					<input class="form-control" type="text" id="searchUserID" name="name" placeholder="User Id" onKeyDown="if(event.keyCode==13) staffSearch();">
				</div>
				<div class="col-sm-3">
					<input class="form-control" id="searchEmail" type="email" name="email" placeholder="Email" onkeyup = 'staffSearch();'>
					<label id="email-forgot-error" class="error" for="email" style="display:none">Invalid Email</label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" id="searchName" name="name" placeholder="Name" onKeyDown="if(event.keyCode==13) staffSearch();">
				</div>
				<!-- <div class="col-sm-3">
					<input class="form-control" type="text" name="name" placeholder="Name">
				</div> -->
				<!-- <div class="col-sm-3">
					<button class="btn btn-primary" onclick="staffSearch();">search</button>
				</div> -->
				<!-- <div class="col-sm-3"> -->
			</div>
		</div>
	</div>
	<div id="dashboard" class="panel-body" style="padding:0px" >
		<!-- <div class="tab-content top-margin" style="margin-top:-30px"> -->
			<!-- CUSTOMER LIST -->
			<?php //$e=1;?>
			<form id="addstaffdetail">
				<div class="col-sm-12" style="padding-top:30px" >
					 <div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Name *</label>
							<div class="col-sm-8 col-lg-8">
								<input type="hidden" name="member_id" id="member_id">
								<input class="form-control" type="text" id="name" name="name" placeholder="Name">
							</div>
						</div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Address 1 *</label>
							<div class="col-sm-8 col-lg-8">
								<input class="form-control" type="text" name="address_line1" id="address_line1" placeholder="Address 1">
							</div>
						</div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Address 2 *</label>
							<div class="col-sm-8 col-lg-8">
								<input class="form-control" type="text" name="address_line2" id="address_line2" placeholder="Address 2">
							</div>
						</div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Address 3*</label>
							<div class="col-sm-8 col-lg-8">
								<input class="form-control" type="text" name="address_line3" id="address_line3" placeholder="Address 3"></input>
							</div>
						</div>
					</div>
					<div class="form-group row single-input">
						<div class="col-sm-12 col-lg-12">
							<label class='col-sm-4 col-lg-4'>country *</label>
							<div class="col-sm-8 col-lg-8">
								<select  id='countrySelect' class='form-control' required name='country'>
									<option>choose country</option>
									@foreach($countries as $country)
									<option value='{!! $country->code !!}'>{!! $country->name !!}</option>
									@endforeach
								</select>
							 </div>
						</div>
					</div>
					<div class="form-group row single-input">
						<div class="col-sm-12 col-lg-12">
							<label class='col-sm-4 col-lg-4'>state *</label>
							<div class="col-sm-8 col-lg-8">
								<select disabled='true' id='stateSelect' class='form-control' required name='state'>
									<option>choose state</option>

								</select>
							</div>
						</div>
					</div>
					<div class="form-group row single-input">
						<div class="col-sm-12 col-lg-12">
							<label class='col-sm-4 col-lg-4'>city *</label>
							<div class="col-sm-8 col-lg-8">
								<select disabled='true' id='citySelect' class='form-control' required name='city'>
									<option>choose city</option>

								</select>
							</div>
						 </div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Designation *</label>
							<div class="col-sm-8 col-lg-8">
								<select class='form-control' id='designation' required name='designation'>
									<option>choose designation</option>
									@foreach($occupations as $occupation)
										<option value='{!! $occupation->id !!}'>{!! $occupation->name !!}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Mobile No*</label>
							<div class="col-sm-8 col-lg-8">
								<input class="form-control" id="mobile_no" type="text" name="mobile_no" placeholder="Mobile No">
							</div>
						</div>
					</div>
					<div class="row single-input form-group">
						<div class="col-sm-12 col-lg-12">
							<label class="col-sm-4 col-lg-4">Alternate Email *</label>
							<div class="col-sm-8 col-lg-8">
								<input class="form-control" id="alt_email" type="text" name="alt_email" placeholder="Alternate Email">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Confirm</button>
						 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</form>
	</div>
<script>
	path = window.location.href;
	var target_path;
	target_path = '{{url("/")}}/';

	$('#countrySelect').on('change',function(){
	country_code = $(this).val();
	url = target_path+'state';
	$.post(url, {code:country_code}, function(data){
		$('#stateSelect').prop('disabled', false);
		if (data != "") {
			$('#stateSelect').html(data);
		}
		else {
			$('#stateSelect').empty();
		}
	});
})
$('#stateSelect').on('change', function () {
	var val = $(this).val();
	if (val != "") {
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/city',
			data: {id: val},
			success: function (responseData) {
				$('#citySelect').prop('disabled', false);
				if (responseData != "") {
					$('#citySelect').html(responseData);
				}
				else {
					$('#citySelect').empty();
				}
			},
			error: function (responseData) {
				alert(errorThrown);
			}
		});
	}
	else {
		$('#cities').html('<option value="" selected>Choose Option</option>');
	}
});


$('#addstaffdetail').submit(function(){
	// alert("in submit");
	event.preventDefault();
	var data = $('#addstaffdetail').serialize();
	// console.log(data);

	$.ajax({
			type: "post",
			url: JS_BASE_URL + '/seller/member/save_staff_detail',
			data: data,
			success: function (responseData) {
			   
			},
			error: function (responseData) {
				alert(errorThrown);
			}
		});


});

// function searchEmail(e)
// {
// 	console.log(e);
// 	console.log(e.key);
// }

function staffSearch(){

	var email = $('#searchEmail').val();
	var userId = $('#searchUserID').val();
	var name = $('#searchName').val();

	if(email != '' && !validateEmail2(email))
	{
		return false;
	}
	
	// if(validateEmail2(email))
	// {
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/seller/member/search_staff_detail',
			data: {email:email,userid:userId,name:name},
			success: function (data) {
			   console.log(data.member.id);
			   console.log(data.nstaff);
			   if(data.member != '')
			   {
					$('#member_id').val(data.member.id);
					$('#searchUserID').val(data.member.user_id);
					$('#searchName').val(data.member.name);
					$('#searchEmail').val(data.member.email);
			   }
			   if(data.nstaff != '')
			   {
					$('#name').val(data.nstaff.name);
					$('#address_line1').val(data.nstaff.address_line1);
					$('#address_line2').val(data.nstaff.address_line2);
					$('#address_line3').val(data.nstaff.address_line3);
					$('#countrySelect').val(data.country_code);
					$("#countrySelect" ).trigger( "change" );
					$('#stateSelect').val(data.nstaff.state_id);
					$("#stateSelect" ).trigger( "change" );
					$('#citySelect').val(data.nstaff.city_id);
					$('#designation').val(data.nstaff.designation_id);
					$('#mobile_no').val(data.nstaff.mobile_no);
					$('#alt_email').val(data.nstaff.alt_email);
			   }

			   // getdata(data.id);
			},
			error: function (responseData) {
				alert(errorThrown);
			}
		});
	// }
	// else {
		// $("#email-forgot-error").text("Invalid format email");
		// $("#email-forgot-error").css("color", "red");
		// $("#forgotemail").addClass("error");
		// $("#email-forgot-error").css("display", "block");
		// $("#overlay_spinner_email_forgot").css("display", "none");
	// }
	
}

function validateEmail2(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}	


</script>
